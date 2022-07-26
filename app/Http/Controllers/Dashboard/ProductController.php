<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:products_read'])->only('index');
        $this->middleware(['permission:products_create'])->only('create');
        $this->middleware(['permission:products_update'])->only('edit');
        $this->middleware(['permission:products_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $title = trans('site.products');
        $categories = Category::all();

        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->where('name_ar', 'LIKE', '%' . $request->search . '%')
                ->orWhere('name_en', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description_ar', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description_en', 'LIKE', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(10);

        return view('dashboard.products.index', compact('title', 'categories', 'products'));
    }

    public function create()
    {
        $title = trans('site.products');
        $categories = Category::all();
        return view('dashboard.products.create', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name_ar' => 'required|unique:products',
            'name_en' => 'required|unique:products',
            'description_ar' => 'required',
            'description_en' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'sometimes|nullable|image|mimes:png,jpg,jpeg,gif',
        ];

        $request->validate($rules);

        $data = $request->except(['image']);

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/products_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();
        }

        Product::create($data);
        session()->flash('success', trans('site.data_added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        $title = trans('site.products');
        $categories = Category::all();
        return view('dashboard.products.edit', compact('title', 'product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name_ar' => 'required|unique:products,name_ar,' . $product->id,
            'name_en' => 'required|unique:products,name_en,' . $product->id,
            'description_ar' => 'required',
            'description_en' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'sometimes|nullable|image|mimes:png,jpg,jpeg,gif',
        ];

        $request->validate($rules);

        $data = $request->except(['image']);

        if ($request->image) {
            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/products_images/' . $product->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/products_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();
        }

        $product->update($data);
        session()->flash('success', trans('site.data_updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/products_images/' . $product->image);
        }

        $product->delete();
        session()->flash('success', trans('site.data_deleted_successfully'));
        return redirect()->back();
    }
}
