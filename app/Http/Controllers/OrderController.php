<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\Promotion;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class OrderController extends Controller
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
        // The order creation is made in HomeController's route --> home.index
        // (only for connected users)
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // $products_orders = ProductOrder::all();
        $images = Image::all();
        $products_orders = ProductOrder::where('order_id', $order->id)->get();

        // dd($products_orders);
        return view('order.index', ['order'=>$order, 'products_orders'=>$products_orders, 'images' => $images]);
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
    public function update(Request $request, Order $order)
    {
        
        

        if(Auth::user()->id == $order->user_id and $request->status_id == 2){

            $products_orders = ProductOrder::where('order_id', $order->id)->get();

            foreach($products_orders as $productOrder){

                $product = Product::where('id', $productOrder->product_id)->get()->first();
                $product->stock = $product->stock - $productOrder->quantity;
                $product->save();
            }
            

            $request->validate([
                'status_id' => 'required'
            ]);

            $order->order_status_id =$request->input('status_id');
            $order->save();

            return redirect()->route('utilisateur.index')->with('message', "La commande a bien été enregistrée, merci pour votre achat !");



        }elseif(Auth::user()->role_id == 2 and $request->status_id >= 3){

            $request->validate([
                'status_id' => 'required'
            ]);

            $order->order_status_id =$request->input('status_id');
            
            $order->update();
            
            return redirect()->back()->with('message', "Le statut de la commande a bien été modifiée");

            
        }elseif(Auth::user()->id == $order->user_id ){
            $request->validate([
                'product_id' => 'required',
                'product_quantity' => 'required|integer|min:1',
                'query' => 'required'
            ]);
    
            $product_id = $request->product_id;
            $quantity = $request->product_quantity;
    
            $order->products()->attach($product_id, ['quantity' => $quantity]);
    
            
    
            return redirect()->route('orders.show',  $order)->with('success', 'Produit ajouté au panier avec succès.');
        }else{
            return redirect()->back()->with(['error' => 'Modification de la commande impossible']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
