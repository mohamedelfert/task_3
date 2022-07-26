<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%')
                ->orWhereTranslationLike('description', '%' . $request->search . '%');

        })->paginate(10);

        return response()->json(
            [
                'status' => true,
                'message' => 'Success',
                'products' => $products,
            ], 201);
    }

    public function store(Request $request)
    {
        $rules = [
            'name_ar' => 'required|unique:products',
            'name_en' => 'required|unique:products',
            'description_ar' => 'required|unique:products',
            'description_en' => 'required|unique:products',
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

        $product = Product::create($data);

        return response()->json(
            [
                'status' => true,
                'message' => 'Success',
                'products' => $product,
            ], 201);
    }

    public function update(Request $request)
    {
        $rules = [
            'name_ar' => 'required|unique:products,name_ar,' . $request->id,
            'name_en' => 'required|unique:products,name_en,' . $request->id,
            'description_ar' => 'required',
            'description_en' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'sometimes|nullable|image|mimes:png,jpg,jpeg,gif',
        ];

        $validate = Validator::make(request()->all(), $rules);
        if ($validate->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Error',
                    'errors' => $validate->errors(),
                ], 401);
        }

        $data = $request->except(['image']);

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/products_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();
        }

        $product = Product::find($request->id);
        $product->update($data);
        return response()->json(
            [
                'status' => true,
                'message' => 'Success',
                'products' => $product,
            ], 201);
    }
}
