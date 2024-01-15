<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Size;
use App\Models\User;
use App\Models\Order;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductOrder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if(Auth::user()->role_id == 2){
            $request->validate([
                'productName' =>'required|max:40',
                'productDescription' => 'required',
                'price' => "nullable",
                'stock'=> 'nullable',
                'category_id'=> 'nullable',
                'sub_category_id' => 'nullable',
                'size_id' => 'required',
                'collection_id' => 'nullable',
                'promotion_id' => 'nullable'
            ]);

            Product::create([
                'productName' => $request->productName,
                'productDescription' => $request->productDescription,
                'price' => $request->price,
                'stock'=> $request->stock,
                'category_id'=> $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'size_id' => $request->size_id,
                'collection_id' => $request->collection_id,
                'promotion_id' => $request->promotion_id
            ]);

            $message = 'Le produit "'.$request->productName.'" a bien été créé';

            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with(['erreur', 'Accès non autorisé']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $sizes = Size::all();
        $images = Image::all();
        // $images = Image::where('product_id', $product->id)->get();


        

        $user = Auth::user();
        $order = Order::where('order_status_id', 1)->where('user_id', $user->id)->first();
        $products = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();


        return view ('product.index', ['product' => $product, 'order' => $order], compact('sizes', 'images', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if(Auth::user()->role_id == 2){

            if($request->status === "productStatus"){
                if($product->productStatus == 0){
                    $product->productStatus = 1;
                    $message = 'le produit "'.$product->productName.'" est bien publié dans la boutique';
                }else{
                    $product->productStatus = 0;
                    $message = 'le produit "'.$product->productName.'" a été déplacé de la boutique vers les brouillons';
                }
                $product->save();

                return redirect()->back()->with('message', $message);
            }else{
                $request->validate([
                    'productName' =>'required|max:40',
                    'productDescription' => 'required',
                    'price' => "nullable",
                    'stock'=> 'nullable',
                    'category_id'=> 'nullable',
                    'sub_category_id' => 'nullable',
                    'size_id' => 'required',
                    'collection_id' => 'nullable',
                    'promotion_id' => 'nullable'
                ]);
                $message = 'Le produit "'.$product->productName.'" a bien été modifié';

                $product->productName = $request->input('productName');
                $product->productDescription = $request->input('productDescription');
                $product->price = $request->input('price');
                $product->stock = $request->input('stock');
                $product->category_id = $request->input('category_id');
                $product->sub_category_id = $request->input('sub_category_id');
                $product->size_id = $request->input('size_id');
                $product->collection_id = $request->input('collection_id');
                $product->promotion_id = $request->input('promotion_id');

                $product->save();

                return redirect()->back()->with('message', $message);
            }
        }else{
            return redirect()->back()->with(['erreur', 'Accès non autorisé']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(Auth::user()->role_id == 2){
            

            $images = Image::where('product_id', $product->id)->get();

            $products_orders = ProductOrder::where('product_id', $product->id)->get();


            foreach($images as $image){
                $fileLink = 'public/uploads/'.$image->fileName;

                if(Storage::exists($fileLink)){
                    Storage::delete($fileLink);
                }else{
                    return redirect()->back()->with(['erreur', 'Suppression de la photo impossible, image introuvable']);
                }

                $image->delete();
            }


            foreach($products_orders as $product){
                $product->delete();
            }

            $product->delete();
            // WARNING if i delete a product link this, it will also be deleted for the orders with status in progress, sent and delivered !
            return redirect()->back()->with('message', "L'article a bien été supprimé de la base de données, et de tous les paniers ainsi que ses images");
            

        }else{
            return redirect()->back()->with(['error' => "Suppression de l'article impossible, vous n'avez pas les autorisations nécessaires"]);
        }
    }
}
