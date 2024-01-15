@if($product->productStatus == 0)
<div class="adminProduct adminProduct--draft">
@else
    <div class="adminProduct">
@endif


        @if($product->productStatus == 0)
            @if($images->where('product_id', $product->id)->count() == 0)
                <p class="btn btn-warning">Ajoutez au moins une image au produit pour le publier</p>
            @else
                <form action="{{ route('products.update', $product) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="productStatus">
                    <button type="submit" class="btn btn-primary align-self-center">Publier l'article</button>
        
                </form>
            @endif
            
        @elseif($product->productStatus == 1)
            <form action="{{ route('products.update', $product) }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="productStatus">
                <button type="submit" class="btn btn-danger align-self-center">Déplacer vers brouillons</button>
    
            </form>
        @endif
    <h5>{{ $product->productName }}</h5>
    @if($product->promotion_id >1)
        <p>Promotion : {{ $product->promotion->promotionValue }}{{ $product->promotion->promotionType->promotionType }}</p>
    @endif
    <div class="adminProduct__details">
        @if($product->stock)
            <p>Quantité : {{ $product->stock }}</p>
        @endif
        <p>Prix : {{ $product->price }}</p>
        @if($size)
            <p>Taille : {{ $size }}</p>
        @endif
    </div>
    <div class="adminProduct__details">
        @if($product->category_id)
            <p>Catégorie : {{ $product->category_id }}</p>
        @endif
        @if($product->sub_category_id)
            <p>Sous-catégorie : {{ $product->sub_category_id }}</p>
        @endif
    </div>
    <div class="adminProduct__details">
        @if($product->collection_id)
            <p>Collection : {{ $product->collection_id }}</p>
        @endif
    </div>
    <div class="adminProduct__images">
        @foreach($images as $image)
        <div class="adminProduct__images__image">
            <form action="{{ route('images.destroy', $image) }}" method="post">
                @csrf
                @method('delete')

                <button type="submit" class="btn btn-danger" >Suppr</button>
            </form>
            <img src="/storage/uploads/{{$image->fileName}}" alt="{{$product->productName}}" class="adminProduct__images__image__img"/>
        </div>
        
        @endforeach
    </div>
    <button class="btn btn-primary" onclick="openModal('editImageModal{{$product->id}}')">Ajouter des images</button>
    <p><b>Description : </b><br/>{{$product->productDescription}}</p>

    <button class="btn btn-success" onclick="openModal('editProductModal{{$product->id}}')">Modifier</button>
        
    
        
</div>







{{-- UPDATE MODAL ONLY FOR ADMIN ON ADMIN PAGE  --}}

<div id="editProductModal{{$product->id}}" class="modal">
    <div class="modal-content d-flex align-items-center">
        <div class="modal-content-top">
            <form action="{{ route('products.destroy', $product) }}" method="post">
                @csrf
                @method('delete')
    
                <button type="submit" class="btn btn-danger" >Supprimer l'article</button>
            </form>
            <span class="close align-self-end" onclick="closeModal()">&times;</span>
        </div>
       

        <h2>Modifier la fiche du produit</h2>

        <form action="{{ route('products.update', $product) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group mb-2">
                <label for="productName">Nom</label>
                <input required type="text" class="form-control" value="{{$product->productName}}" name="productName" id="productName">
            </div>
            <div class="form-group mb-2">
                <label for="productDescription">Description</label>
                <textarea type="text" class="form-control" placeholder="Description du produit" name="productDescription" id="productDescription">{{$product->productDescription}}</textarea>
            </div>
        
            <div class="form-group mb-2">
                <label for="stock">Quantités</label>
                <input required type="number" value="{{$product->stock}}" min="0" class="form-control" name="stock" id="stock">
            </div>
        
            <div class="form-group mb-2">
                <label for="price">Prix</label>
                <input required type="number" value="{{$product->price}}" min="0" step="0.01" class="form-control" name="price" id="price">
            </div>
        
            <div class="form-group mb-2">
                <label for="promotion_id">Le produit est en promotion ?</label>
                <select value=null class="form-control" name="promotion_id" id="promotion_id">
                    @if($product->promotion_id === null )
                        <option value=""></option>
                    @else
                        <option value=""></option>
                    @endif
                    @foreach($promotions as $promotion)
                        @if($product->promotion_id === $promotion->id)
                            <option value="{{ $promotion->id}}" selected>{{ $promotion->promotionName }}</option>
                        @endif
                        <option value="{{ $promotion->id}}">{{ $promotion->promotionName }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mb-2">
                <label for="size_id">Taille</label>
                <select required class="form-control" name="size_id" id="size_id">
                    @foreach($sizes as $size)
                        @if($size->id == $product->size_id)
                            <option value="{{ $size->id}}" selected>{{ $size->sizeName }}</option>
                        @else
                            <option value="{{ $size->id}}">{{ $size->sizeName }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mb-2">
                <label for="category_id">Catégorie</label>
                <select required class="form-control" name="category_id" id="category_id">
                    @foreach($categories as $category)
                        @if($product->category_id === $category->id)
                            <option value="{{ $category->id}}" selected>{{ $category->categoryName }}</option>
                        @endif
                        <option value="{{ $category->id}}">{{ $category->categoryName }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mb-2">
                <label for="sub_category_id">Sous-catégorie</label>
                <select class="form-control" name="sub_category_id" id="sub_category_id">
                    @foreach($subCategories as $subCategory)
                        @if($product->subCategory_id === $subCategory->id)
                            <option value="{{ $subCategory->id}}" selected>{{ $subCategory->subCategoryName }}</option>
                        @endif
                        <option value="{{ $subCategory->id}}">{{ $subCategory->subCategoryName }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mb-2">
                <label for="collection_id">Ajouter l'article à une collection ?</label>
                <select class="form-control" name="collection_id" id="collection_id">
                    @foreach($collections as $collection)
                        @if($product->collection_id === $collection->id)
                            <option value="{{ $collection->id}}" selected>{{ $collection->collectionName }}</option>
                        @endif
                        <option value="{{ $collection->id}}">{{ $collection->collectionName }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn btn-success align-self-center">Valider</button>
            
        </form>
        
    </div>
</div>
{{-- UPDATE MODAL ONLY FOR ADMIN ON ADMIN PAGE  --}}


{{-- STORE IMAGES MODAL ONLY FOR ADMIN ON ADMIN PAGE  --}}

<div id="editImageModal{{$product->id}}" class="modal">
    <div class="modal-content d-flex align-items-center">
        
        <span class="close align-self-end" onclick="closeModal()">&times;</span>

        <h2>Ajouter des images</h2>

        <form action="{{ route('images.store', $product) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="form-group mb-2">
                <label for="images">Images</label>
                <input required type="file" class="form-control" name="images[]" id="images" multiple>
            </div>
            
            <div class="form-group mb-2">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </div>
            

            <button type="submit" class="btn btn-success align-self-center">Valider</button>

        </form>
        
    </div>
</div>
{{-- STORE IMAGES MODAL ONLY FOR ADMIN ON ADMIN PAGE  --}}
