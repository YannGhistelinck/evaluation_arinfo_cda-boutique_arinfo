@php
    $productsWithValidPromotion = $products->filter(function ($product) {
        return $product->promotion_id !== null && $product->promotion->startAt <= now()->format('Y-m-d') && $product->promotion->endAt >= now()->format('Y-m-d');
    });
@endphp


<div class="menu">
    <div class="menu__mainMenu">
        <p onclick="display('product0')" class="menu__mainMenu__item underline">Tous les articles</p>

        @foreach($categories as $category)
            @if($products->where('category_id', $category->id)->where('stock', '>', 0)->count()>0)
                <p onclick="display('product{{$category->id}}')" class="menu__mainMenu__item underline">{{$category->categoryName}}</p>
            @endif
        @endforeach
        @if($productsWithValidPromotion->count() > 0)
            <p onclick="display('productPromo')" class="menu__mainMenu__item">Promotions</p>
        @endif
    </div>
    <div class="menu__subMenu hidden">
        sous-menu
    </div>
</div>