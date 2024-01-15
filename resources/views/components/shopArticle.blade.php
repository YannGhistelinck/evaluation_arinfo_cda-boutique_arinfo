<div class="shopProduct">

    
    @php
        $img = $images->where('product_id', $product->id)->first();
    @endphp
    @if($img !== null)
        <img src="/storage/uploads/{{$img->fileName}}" alt='description' class="shopProduct__image"/>
    @endif

    
    <div class="shopProduct__title">
        <div>
            @if($product->promotion_id !== null and $product->promotion->startAt <= now() and $product->promotion->endAt > now())
                <p>Promo -{{ $product->promotion->promotionValue }}{{$product->promotion->promotionType->promotionType}}</p>
            @endif
        </div>
        <p class="">{{ $product->productName }}</p>
    </div>
    
    
</div>