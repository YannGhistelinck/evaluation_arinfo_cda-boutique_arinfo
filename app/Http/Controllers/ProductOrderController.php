<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductOrder;

class ProductOrderController extends Controller
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
    public function destroy(Request $request)
    {

        /**
         * I can't get the $product_order by the usual method
         * The delete form send an empty content
         * So i choose to get the $product_order->id of the pivot table in the path of the delete form request
         * Not a good method but it works
         */

        
         //have to secure the controller testing the user id or the admin role ...

        $id = basename($request->getPathInfo());

        $product_order = ProductOrder::find($id);

        if ($product_order) {

            $product_order->delete();
            return redirect()->back()->with('message', 'Article supprimé du panier');
        } else {

            return redirect()->back()->with('error', 'Article non trouvé dans le panier');
        }
    }
}
