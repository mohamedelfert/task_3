<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_create'])->only('create');
        $this->middleware(['permission:categories_update'])->only('edit');
        $this->middleware(['permission:categories_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $title = trans('site.categories');
        $categories = Category::When($request->search, function ($q) use ($request) {

            return $q->where('name_ar', 'LIKE', '%' . $request->search . '%')
                ->orWhere('name_en', 'LIKE', '%' . $request->search . '%');

        })->latest()->paginate(10);
        return view('dashboard.categories.index', compact('title', 'categories'));
    }

    public function create()
    {
        $title = trans('site.categories');
        return view('dashboard.categories.create', compact('title'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name_ar' => 'required|unique:categories',
            'name_en' => 'required|unique:categories',
        ];
        $data = $this->validate($request, $rules);

        Category::create($data);
        session()->flash('success', trans('site.data_added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        $title = trans('site.categories');
        return view('dashboard.categories.edit', compact('title', 'category'));
    }

    public function update(Request $request, Category $category)
    {
        $rules = [
            'name_ar' => 'required|unique:categories,name_ar,' . $category->id,
            'name_en' => 'required|unique:categories,name_en,' . $category->id,
        ];
        $data = $this->validate($request, $rules);

        $category->update($data);
        session()->flash('success', trans('site.data_updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', trans('site.data_deleted_successfully'));
        return redirect()->back();
    }
}
