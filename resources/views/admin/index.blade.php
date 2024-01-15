@extends('layouts.app')
@section('title')
    Administration
@endsection

@section('content')

    <main class="fullVerticalContainer">
        <h2>Espace administration</h2>

        <article class="inProgressOrders">
            <h3>Commandes en cours</h3>

            @if($orders->where('order_status_id', '>', 1 )->where('order_status_id', '<', 4)->count()>0)
                @foreach( $orders->where('order_status_id', 2) as $order)
                    <div class="inProgressOrders__order">
                        <h4>commande n°{{ $order->id }}</h4>
                        <p>Commandée le {{$order->updated_at}}</p>
                        
                        <form action="{{ route('orders.update', $order) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-2">
                                <input required type="hidden"  value="3" name="status_id">
                            </div>

                            <button type="submit" class="btn btn-warning align-self-center">Expédier cette commande</button>

                        </form>
                    </div>
                @endforeach
                    
                    
                @foreach( $orders->where('order_status_id', 3) as $order)
                    <div class="inProgressOrders__order">
                        <h4>commande n°{{ $order->id }}</h4>
                        <p>Commandée le {{$order->updated_at}}</p>
                        <form action="{{ route('orders.update', $order) }}" method="post">
                            @csrf
                            @method('PUT')
    
                            <div class="form-group mb-2">
                                <input required type="hidden"  value="4" name="status_id">
                            </div>
    
                            <button type="submit" class="btn btn-success align-self-center">Commande livrée</button>
    
                        </form>
                    </div>
                    
                @endforeach
            @else
                <p>Il n'y a pas de commandes en cours de préparation ni en cours d'expédition...
            @endif
        </article>
        
        <article class="parameters">
            <h3 class="parameters__title">Paramètres</h3>
            <div class="parameterContainer">
                <div class="parameterContainer__menu">
                    <div onclick="showParameter('products')">Produits</div>
                    <div onclick="showParameter('categories')">Catégories</div>
                    <div onclick="showParameter('subCategories')">Sous-catégories</div>
                    <div onclick="showParameter('collections')">Collections</div>
                    <div onclick="showParameter('promotions')">Promotions</div>
                    <div onclick="showParameter('others')">Paramètres avancés</div>
                </div>


                {{-- PRODUCTS --}}
                <div id="products" class="parameterContainer__content">
                    <button class="btn btn-success" onclick="openModal('newProductModal')">
                        Créer un produit
            
                    </button>
                    <div id="newProductModal" class="modal">
                        <div class="modal-content d-flex align-items-center">
                            
                            <span class="close align-self-end" onclick="closeModal()">&times;</span>
                            <h2>Créer produit</h2>
            
            
                            <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
            
            
                                <div class="form-group mb-2">
                                    <label for="productName">Nom</label>
                                    <input required type="text" class="form-control" placeholder="Nom" name="productName" id="productName">
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="productDescription">Description</label>
                                    <textarea type="text" class="form-control" placeholder="Description du produit" name="productDescription" id="productDescription"></textarea>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="stock">Quantités</label>
                                    <input required type="number" value=null min="0" class="form-control" name="stock" id="stock">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="price">Prix</label>
                                    <input required type="number" value=null min="0" step="0.01" class="form-control" name="price" id="price">
                                </div>

                                <div class="form-group mb-2">
                                    <label for="promotion_id">Le produit est en promotion ?</label>
                                    <select value=null class="form-control" name="promotion_id" id="promotion_id">
                                        <option value="" selected></option>
                                        @foreach($promotions as $promotion)
                                            <option value="{{ $promotion->id}}">{{ $promotion->promotionName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="size_id">Taille</label>
                                    <select required class="form-control" name="size_id" id="size_id">
                                        @foreach($sizes as $size)
                                            @if($size->id == 1)
                                                <option value="{{ $size->id}}" selected>{{ $size->sizeName }}</option>
                                            @else
                                                <option value="{{ $size->id}}">{{ $size->sizeName }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="category_id">Catégorie</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="" selected></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id}}">{{ $category->categoryName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="sub_category_id">Sous-catégorie</label>
                                    <select class="form-control" name="sub_category_id" id="sub_category_id">
                                        <option value="" selected></option>
                                        @foreach($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id}}">{{ $subCategory->subCategoryName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="collection_id">Ajouter l'article à une collection ?</label>
                                    <select class="form-control" name="collection_id" id="collection_id">
                                        @foreach($collections as $collection)
                                            <option value="{{ $collection->id}}">{{ $collection->collectionName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            
                                <button type="submit" class="btn btn-success align-self-center">Enregistrer le brouillon</button>
                            </form>
            
            
                        </div>
                    </div>

                    <h4>Articles en attente de publication</h4> 
                    
                        <div class="adminProductContainer">
                            @foreach($products->where('productStatus', 0) as $product)
                                <div>
                                    @include('components.adminProduct', array('product'=>$product, 'admin'=>1, 'size'=>$sizes->where('id', $product->size->sizeName)->first(), 'images'=>$images->where('product_id', $product->id)))
                                </div>
                            @endforeach
                        </div>
                        
                        
                        
                        
                    <h4>Articles en ligne</h4> 
                    
                        <div class="adminProductContainer">
                            @foreach($products->where('productStatus', 1) as $product)
                                <div>
                                    @include('components.adminProduct', array('product'=>$product, 'admin'=>1, 'size'=>$sizes->where('id', $product->size->sizeName)->first(), 'images'=>$images->where('product_id', $product->id)))
                                </div>
                            @endforeach
                        </div>



                    
                </div>
                {{-- PRODUCTS --}}
                


                
                {{-- CATEGORIES --}}
                <div id="categories" class="hidden" class="parameterContainer__content">
                    <h4>Catégories</h4> 
                    <button class="btn btn-success" onclick="openModal('newCategoryModal')">
                        Créer une catégorie
            
                    </button>
                    <div id="newCategoryModal" class="modal">
                        <div class="modal-content d-flex align-items-center">
                            
                            <span class="close align-self-end" onclick="closeModal()">&times;</span>
                            <h2>Créer une catégorie</h2>
            
            
                            <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
            
            
                                <div class="form-group mb-2">
                                    <label for="categoryName">Nom de la catégorie</label>
                                    <input required type="text" class="form-control" placeholder="Nom" name="categoryName" id="categorName">
                                </div>
                            
                                <button type="submit" class="btn btn-success align-self-center">Valider</button>
                            </form>
            
            
                        </div>
                    </div>


                    
                    <div>

                        @foreach($categories as $category)
                            <div>
                                {{ $category->categoryName }}
                                <button class="m-4 p-2 border-top border-bottom nav-link action" onclick="openModal('editCategoryModal{{$category->id}}')">Modifier</button>


                                <div id="editCategoryModal{{$category->id}}" class="modal">
                                    <div class="modal-content d-flex align-items-center">
                                        
                                        <span class="close align-self-end" onclick="closeModal()">&times;</span>

                                        <h2>Modifier la catégorie</h2>

                                        <form action="{{ route('categories.update', $category) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group mb-2">
                                                <label for="categoryName">Modifier la catégorie</label>
                                                <input required type="text" class="form-control" value="{{$category->categoryName}}" name="categoryName" id="categoryName">
                                            </div>

                                            <button type="submit" class="btn btn-success align-self-center">Valider</button>

                                        </form>
                                        
                                    </div>
                                </div>
                                <form action="{{ route('categories.destroy', $category) }}" method="post">
                                    @csrf
                                    @method('delete')
                    
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                            
                        
                </div>
                {{-- CATEGORIES --}}




                {{-- SUB-CATEGORIES --}}
                <div id="subCategories" class="hidden" class="parameterContainer__content">
                    <h4>Sous-catégories</h4> 
                    <button class="btn btn-success" onclick="openModal('newSubCategoryModal')">
                        Créer une sous-catégorie
            
                    </button>
                    <div id="newSubCategoryModal" class="modal">
                        <div class="modal-content d-flex align-items-center">
                            
                            <span class="close align-self-end" onclick="closeModal()">&times;</span>
                            <h2>Créer une sous-catégorie</h2>
            
            
                            <form action="{{route('subcategories.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
            
            
                                <div class="form-group mb-2">
                                    <label for="subCategoryName">Nom de la sous-catégorie</label>
                                    <input required type="text" class="form-control" placeholder="Nom" name="subCategoryName" id="subCategorName">
                                </div>
                            
                                <button type="submit" class="btn btn-success align-self-center">Valider</button>
                            </form>
            
            
                        </div>
                    </div>


                    
                    <div>

                        @foreach($subCategories as $subCategory)
                        
                            <div>
                                {{ $subCategory->subCategoryName }}
                                <button class="m-4 p-2 border-top border-bottom nav-link action" onclick="openModal('editSubCategoryModal{{$subCategory->id}}')">Modifier</button>


                                <div id="editSubCategoryModal{{$subCategory->id}}" class="modal">
                                    <div class="modal-content d-flex align-items-center">
                                        
                                        <span class="close align-self-end" onclick="closeModal()">&times;</span>

                                        <h2>Modifier la sous-catégorie</h2>

                                        <form action="{{ route('subcategories.update', $subCategory) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group mb-2">
                                                <label for="subCategoryName">Modifier la sous-catégorie</label>
                                                <input required type="text" class="form-control" value="{{$subCategory->subCategoryName}}" name="subCategoryName" id="subCategoryName">
                                            </div>

                                            <button type="submit" class="btn btn-success align-self-center">Valider</button>

                                        </form>
                                        
                                    </div>
                                </div>
                                <form action="{{ route('subcategories.destroy', $subCategory) }}" method="post">
                                    @csrf
                                    @method('delete')
                    
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- SUB-CATEGORIES --}}



                {{-- COLLECTIONS --}}
                <div id="collections" class="hidden">
                    <h4>Collections</h4> 
                    <button class="btn btn-success" onclick="openModal('newCollectionModal')">
                        Créer une collection
            
                    </button>
                    <div id="newCollectionModal" class="modal">
                        <div class="modal-content d-flex align-items-center">
                            
                            <span class="close align-self-end" onclick="closeModal()">&times;</span>
                            <h2>Créer une collection</h2>
            
            
                            <form action="{{route('collections.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
            
            
                                <div class="form-group mb-2">
                                    <label for="collectionName">Nom de la collection</label>
                                    <input required type="text" class="form-control" placeholder="Nom" name="collectionName" id="collectionName">
                                </div>
                            
                                <button type="submit" class="btn btn-success align-self-center">Valider</button>
                            </form>
            
            
                        </div>
                    </div>

                    <div>

                        @foreach($collections as $collection)
                        
                            <div>
                                {{ $collection->collectionName }}
                                <button class="m-4 p-2 border-top border-bottom nav-link action" onclick="openModal('editCollectionModal{{$collection->id}}')">Modifier</button>


                                <div id="editCollectionModal{{$collection->id}}" class="modal">
                                    <div class="modal-content d-flex align-items-center">
                                        
                                        <span class="close align-self-end" onclick="closeModal()">&times;</span>

                                        <h2>Modifier la collection</h2>

                                        <form action="{{ route('collections.update', $collection) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group mb-2">
                                                <label for="collectionName">Modifier la collection</label>
                                                <input required type="text" class="form-control" value="{{$collection->collectionName}}" name="collectionName" id="collectionName">
                                            </div>

                                            <button type="submit" class="btn btn-success align-self-center">Valider</button>

                                        </form>
                                        
                                    </div>
                                </div>
                                <form action="{{ route('collections.destroy', $collection) }}" method="post">
                                    @csrf
                                    @method('delete')
                    
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                </div>
                {{-- COLLECTIONS --}}



                {{-- PROMOTIONS --}}
                <div id="promotions" class="hidden">
                    <h4>Promotions</h4> 

                    @foreach($promotions as $promotion)
                    {{ $promotion->promotionName }}
                    @endforeach
                    
                    <button class="btn btn-success" onclick="openModal('newPromotionModal')">
                        Créer une promotion
            
                    </button>
                    <div id="newPromotionModal" class="modal">
                        <div class="modal-content d-flex align-items-center">
                            
                            <span class="close align-self-end" onclick="closeModal()">&times;</span>
                            <h2>Créer une promotion</h2>
            
            
                            <form action="{{route('promotions.store')}}" method="post">
                                @csrf
                                @method('post')
            
            
                                <div class="form-group mb-2">
                                    <label for="promotionName">Nom de la promotion</label>
                                    <input required type="text" class="form-control" placeholder="Nom" name="promotionName" id="promotionName">
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="promotion_type">Type de réduction</label>
                                    <select required type="select" class="form-control" name="promotion_type_id" id="promotion_type_id">
                                        @foreach($promotionTypes as $promotionType)
                                            @if($promotionType->id === 1)
                                                <option value="1" selected>{{ $promotionType->promotionType }}</option>
                                            @else 
                                                <option value="{{$promotionType->id}}">{{ $promotionType->promotionType }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="promotionValue">Montant de la réduction</label>
                                    <input required type="number" class="form-control" value="15" min="0" step="0.5" name="promotionValue" id="promotionValue">
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="startAt">Date de début</label>
                                    <input required type="date" class="form-control" name="startAt" id="startAt">
                                </div>
                                
                                <div class="form-group mb-2">
                                    <label for="endAt">Date de fin</label>
                                    <input required type="date" class="form-control" value="null" name="endAt" id="endAt">
                                </div>
                            
                                <button type="submit" class="btn btn-success align-self-center">Valider</button>
                            </form>
            
            
                        </div>
                    </div>



                    <div>

                        @foreach($promotions as $promotion)
                        
                            <div>
                                
                                {{ $promotion->promotionName }}
                                <button class="m-4 p-2 border-top border-bottom nav-link action" onclick="openModal('editPromotionModal{{$promotion->id}}')">Modifier</button>


                                <div id="editPromotionModal{{$promotion->id}}" class="modal">
                                    <div class="modal-content d-flex align-items-center">
                                        
                                        <span class="close align-self-end" onclick="closeModal()">&times;</span>

                                        <h2>Modifier la promotion</h2>

                                        <form action="{{ route('promotions.update', $promotion) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group mb-2">
                                                <label for="collectionName">Modifier la promotion</label>
                                                <input required type="text" class="form-control" value="{{$promotion->promotionName}}" name="promotionName" id="promotionName">
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="promotion_type">Type de réduction</label>
                                                <select required type="select" class="form-control" name="promotion_type_id" id="promotion_type_id">
                                                    @foreach($promotionTypes as $promotionType)
                                                        @if($promotionType->id === $promotion->promotion_type_id)
                                                            <option value="{{$promotionType->id}}" selected>{{ $promotionType->promotionType }}</option>
                                                        @else 
                                                            <option value="{{$promotionType->id}}">{{ $promotionType->promotionType }}</option>
                                                        @endif
                                                    @endforeach
            
                                                </select>
                                            </div>
                                            
                                            <div class="form-group mb-2">
                                                <label for="promotionValue">Montant de la réduction</label>
                                                <input required type="number" class="form-control" value="{{$promotion->promotionValue}}" min="0" step="0.5" name="promotionValue" id="promotionValue">
                                            </div>
                                            
                                            <div class="form-group mb-2">
                                                <label for="startAt">Date de début</label>
                                                <input required type="date" class="form-control" value="{{$promotion->startAt}}" name="startAt" id="startAt">
                                            </div>
                                            
                                            <div class="form-group mb-2">
                                                <label for="endAt">Date de fin</label>
                                                <input required type="date" class="form-control" value="{{$promotion->endAt}}" name="endAt" id="endAt">
                                            </div>

                                            <button type="submit" class="btn btn-success align-self-center">Valider</button>

                                        </form>
                                        
                                    </div>
                                </div>
                                <form action="{{ route('promotions.destroy', $promotion) }}" method="post">
                                    @csrf
                                    @method('delete')
                    
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        @endforeach
                    </div>


                </div>
                {{-- PROMOTIONS --}}




                {{-- ADVENCED PARAMETERS --}}
                <div id="others" class="hidden">
                    <h4>Paramètres avancés</h4> 
                    <p> (tailles, types de promotions, status de commande)</p>
                    {{-- <div>
                        <h5>Tailles</h5>
                        <button class="btn btn-success" onclick="openModal('newSizeModal')">
                            Créer une taille
                
                        </button>
                        <div id="newSizeModal" class="modal">
                            <div class="modal-content d-flex align-items-center">
                                
                                <span class="close align-self-end" onclick="closeModal()">&times;</span>
                                <h2>Créer une taille</h2>
                
                
                                <form action="{{route('sizes.store')}}" method="post">
                                    @csrf
                                    @method('post')
                
                
                                    <div class="form-group mb-2">
                                        <label for="sizeName">taille</label>
                                        <input required type="text" class="form-control" placeholder="Nom" name="categoryName" id="categorName">
                                    </div>
                                
                                    <button type="submit" class="btn btn-success align-self-center">Valider</button>
                                </form>
                
                
                            </div>
                        </div>
    
    
                        
                        <div>
    
                            @foreach($categories as $category)
                                <div>
                                    {{ $category->categoryName }}
                                    <button class="m-4 p-2 border-top border-bottom nav-link action" onclick="openModal('editCategoryModal{{$category->id}}')">Modifier</button>
    
    
                                    <div id="editCategoryModal{{$category->id}}" class="modal">
                                        <div class="modal-content d-flex align-items-center">
                                            
                                            <span class="close align-self-end" onclick="closeModal()">&times;</span>
    
                                            <h2>Modifier la catégorie</h2>
    
                                            <form action="{{ route('categories.update', $category) }}" method="post">
                                                @csrf
                                                @method('PUT')
    
                                                <div class="form-group mb-2">
                                                    <label for="categoryName">Modifier la catégorie</label>
                                                    <input required type="text" class="form-control" value="{{$category->categoryName}}" name="categoryName" id="categoryName">
                                                </div>
    
                                                <button type="submit" class="btn btn-success align-self-center">Valider</button>
    
                                            </form>
                                            
                                        </div>
                                    </div>
                                    <form action="{{ route('categories.destroy', $category) }}" method="post">
                                        @csrf
                                        @method('delete')
                        
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            @endforeach
                        </div> --}}


                    </div>
                </div>
                {{-- ADVENCED PARAMETERS --}}



            </div>
            
        </article>


        <article>
            <h3>Commandes passées</h3>

            @if($orders->contains('order_status_id', 4))
                @foreach($orders->where('order_status_id', 4) as $order)
                    <div class="inProgressOrders__order">
                        <h4>commande n°{{ $order->id }}</h4>
                        <p>Commandée le {{$order->updated_at}}</p>
                
                    </div>
                    
                @endforeach
            @else
                <p>Aucune commande n'est terminée pour l'instant...</p>
            @endif
        </article>










    </main>


    <script src="{{asset('js/showParameters.js')}}"></script>

@endsection