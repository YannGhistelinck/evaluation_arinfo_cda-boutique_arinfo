<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Collection;
use App\Models\Promotion;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $promotions = Promotion::all();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $products = Product::where('productStatus', 1)->get();
        $sizes = Size::all();
        $collections = Collection::all();
        $images = Image::all();

        return view('home', compact(
            'products', 
            'sizes', 
            'categories', 
            'subCategories', 
            'promotions', 
            'collections',
            'images'
        ));
    }
}
