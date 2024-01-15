@extends('layouts.app')
@section('title')
    Mon panier
@endsection

@section('content')


    <main class="verticalContainer">

        <h2 class="cartTitle">Mon panier</h2>

        

        <table class="cartTable">
            <thead class="cartTable__head">
                <tr>
                    <th scope="col">Article</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Prix unitaire</th>
                    <th scope="col">Prix</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="cartTable__body">
                @php
                    $totalPrice = 0
                    
                @endphp
                
                @foreach($products_orders as $product_order)
                    @php
                        $img = $images->where('product_id', $product_order->product->id)->first();
                    @endphp
                    
                    <tr class="cartTable__body__line">
                        <td class="cartTable__body__line__productName">
                            <img src="/storage/uploads/{{$img->fileName}}" alt="{{$product_order->product->productName}}" class="cartTable__body__line__img"/>
                            <p>{{ $product_order->product->productName }}</p>
                        </td>
                        <td>{{$product_order->quantity}}</td>
                        <td>
                            @php
                                $newPrice = null
                            @endphp
                            
                            @if($product_order->product->promotion_id !== null and $product_order->product->promotion->startAt<now() and $product_order->product->promotion->endAt>now())
                                @php
                                    $price = $product_order->product->price;
                                    $promotion = $product_order->product->promotion->promotionValue;
                                @endphp
                                <del class="cartHoldPrice">{{ $product_order->product->price }}€</del>
                                
                                @if($product_order->product->promotion->promotionType->promotionType === "%")
                                    @php
                                        $newPrice = $price -($price*$promotion/100)
                                    @endphp
                                    <span>{{ $newPrice }}€</span>
                                @elseif($product_order->product->promotion->promotionType->promotionType === "€")
                                    @php
                                        $newPrice = $price-$promotion
                                    @endphp
                                @endif
                                
                            @else
                                {{ $product_order->product->price }}€
                            @endif
                        </td>
                        <td class="cartTable__body__line__subTotal">
                            @if($newPrice !== null)
                                <del class="cartHoldPrice">{{ $product_order->product->price*$product_order->quantity }}€</del>
                                {{ $newPrice*$product_order->quantity }}€
                                @php
                                    $totalPrice = $totalPrice + ($newPrice*$product_order->quantity);
                                @endphp

                            @else
                                {{ $product_order->product->price*$product_order->quantity }}€
                                @php
                                    $totalPrice = $totalPrice + ($product_order->product->price*$product_order->quantity);
                                @endphp
                            @endif
                            
                        </td>
                        <td>
                            <form action="{{ route('products_orders.destroy', $product_order) }}" method="post">
                                @csrf
                                @method('delete')
                
                                <button type="submit" class="btn btn-danger"><img src="/icons/delete.svg" alt="bouton de suppression" class="deleteProductButton"/></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr >
                    <td></td>
                    <td></td>
                    <div class="cartTable__body__line--total">
                        <td><b>Total</b></td>
                        <td>{{ $totalPrice }}€</td>
                    </div>
                    
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <form action="{{ route('orders.update', $order) }}" method="post" class="orderForm">
            @csrf
            @method('PUT')

            <input type="hidden" name="status_id" value="2"/>

            <button type="submit" class="btn">Commander mes articles</button>
        </form>

    </main>

@endsection