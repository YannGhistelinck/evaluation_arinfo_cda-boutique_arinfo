@extends('layouts.app')
@section('title')
    Détails de l'article
@endsection

@section('content')


    <main class="fullVerticalContainer">

        <article class="productDetail">
            <div class="productDetail__images">
                @foreach($images->where('product_id', $product->id) as $image)
                    <img src="/storage/uploads/{{$image->fileName}}" alt='description' class="productDetail__images__image"/>
                @endforeach
            </div>
            <div class="productDetail__details">
                <h2>{{ $product->productName }}</h2>
                <div>{{ $product->price}}€ @if($product->size_id !== 1 and $product->size_id !== 2)<br/> Taille : {{ $sizes->where('id', $product->size_id)->first()->sizeName }}@endif </div>
                <p>{{ $product->productDescription }}</p>
                
                
                @if(Auth::user() and $product->stock>0)
                    @if($product->stock<6)
                        <p class="stockWarning">Plus que {{ $product->stock }} en stock !</p>
                    @endif
                    <form action="{{ route('orders.update', $order) }}" method="post" class="productDetail__details__form">
                        @csrf
                        @method('PUT')
            
                        <div class="input">
                            {{-- <label for="product_quantity">Quantité</label> --}}
                            <input required type="number" min="1" max="{{$product->stock}}" step="1" value="1" class="form-control" name="product_quantity" id="product_quantity" autocomplete="off">
                        </div>
                        
                        <div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                        
                        <div>
                            <input type="hidden" name="query" value="addProductToCart">
                        </div>
                        
            
                        <button type="submit" class="btn">Ajouter au panier</button>
            
                    </form>
                @elseif($product->stock == 0)
                    <p  class="outOfStock">RUPTURE DE STOCK</p>
                @else
                    <p>Connectez-vous ou créez un compte pour pouvoir commander cet article.</p>
                @endif
                
            </div>
        </article>
        
        <article class="recommendations">
            <h2 class="recommendations__title">Autres articles que vous pourriez aimer</h2>
            <div class="recommendations__products">
                @foreach($products as $product)
                    <a href="{{route('products.show', $product)}}">
                        <div>
                            @include('components.shopArticle', array('product'=>$product, 'admin'=>0, 'sizes'=>$sizes, 'products'=> $products, 'images' => $images))
                        </div>
                    </a>
                @endforeach
            </div>
            
            </article>

    </main>
    <script>
        function increment(){
            document.getElementById('product_quantity').value=parseInt(input.value)+1;
        }

    </script>

@endsection