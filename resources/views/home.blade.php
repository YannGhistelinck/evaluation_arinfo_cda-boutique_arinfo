@extends('layouts.app')



@section('content')
    @include('components.menu')

    <div class="shopContainer">
        {{-- <aside class="shopContainer__filters">
            <h2>Filtrer</h2>
        </aside> --}}




        <div class="shopContainer__products">

            
            <div id='product0'>
                <div class="shopContainer__products__items">
                    @foreach($products->sortByDesc('stock') as $product)
                        <a href="{{route('products.show', $product)}}">
                            <div>
                                @include('components.shopArticle', array('product'=>$product, 'admin'=>0, 'sizes'=>$sizes, 'products'=> $products, 'images' => $images))
                            </div>
                        </a>
                        
                    @endforeach
                </div>

            </div>
            
            @foreach($categories as $category)
                <div id="product{{$category->id}}" class="hidden">
                    <div class="shopContainer__products__items">
                        @foreach($products->sortByDesc('stock')->where('category_id', $category->id) as $product)
                            <a href="{{route('products.show', $product)}}">
                                <div>
                                    @include('components.shopArticle', array('product'=>$product, 'admin'=>0, 'sizes'=>$sizes, 'products'=> $products, 'images' => $images))
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            @endforeach
            @php
                $productsWithValidPromotion = $products->filter(function ($product) {
                    return $product->promotion_id !== null && $product->promotion->startAt <= now()->format('Y-m-d') && $product->promotion->endAt >= now()->format('Y-m-d');
                });
            @endphp
            <div id='productPromo' class="hidden">
                <div class="shopContainer__products__items">
                    @foreach($productsWithValidPromotion as $product)
                        <a href="{{route('products.show', $product)}}">
                            <div>
                                @include('components.shopArticle', array('product'=>$product, 'admin'=>0, 'sizes'=>$sizes, 'products'=> $products, 'images' => $images))
                            </div>
                        </a>
                        
                    @endforeach
                </div>

            </div>

        </div>




        {{-- <aside class="shopContainer__cart">
            <h2>Panier</h2>
        </aside> --}}


    </div>

    

    <script>
        let previousDisplay = 'product0'
        function display(id){
            document.getElementById(previousDisplay).classList.toggle('hidden')
            document.getElementById(id).classList.toggle('hidden')
            previousDisplay = id
        }

        

    </script>
@endsection
