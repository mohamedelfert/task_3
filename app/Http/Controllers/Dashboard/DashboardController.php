<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = trans('site.dashboard');
        $products_count = Product::count();
        $categories_count = Category::count();
        $users_count = User::whereRoleIs('admin')->count();

        $products = Product::latest()->paginate(10);

        return view('dashboard.welcome',compact('title','products_count','categories_count','users_count','products'));
    }
}
