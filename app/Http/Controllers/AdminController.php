<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Collection;
use App\Models\Promotion;
use App\Models\Size;
use App\Models\PromotionType;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Image;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {

            if (Auth::check() && Auth::user()->role_id != 2) {

                return redirect('/')->with(['error' => "Vous n'avez pas les droits nécessaires pour accéder à cette page..."]);
            }

            return $next($request);
        });
    }



    public function index(User $user)
    {
        if(Auth::user()->role_id == 2){
            $categories = Category::all();
            $subCategories = SubCategory::all();
            $collections = Collection::all();
            $promotions = Promotion::all();
            $promotionTypes = PromotionType::all();
            $sizes = Size::all();
            $orders = Order::all();
            $orderStatuses = OrderStatus::all();
            $products = Product::all();
            $images = Image::all();
            $users = User::all();

            return view('admin/index', compact(
                'categories', 
                'subCategories', 
                'collections', 
                'promotions', 
                'promotionTypes',
                'sizes', 
                'orders', 
                'orderStatuses',
                'products',
                'images',
                'users'
            ));
        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
