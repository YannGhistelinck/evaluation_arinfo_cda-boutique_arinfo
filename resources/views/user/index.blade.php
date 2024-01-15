@extends('layouts.app')

@section('title')
    Mon Compte
@endsection

@section('content')

    <main class="verticalContainer">
        <h1>Mon Compte</h1>

        <h2>Modifier mes informations</h2>

        <div class="row mb-4">

            
            <form class="col-8 mx-auto" action="{{ route('utilisateur.update', $user->id) }}" method="POST">
                @csrf

                @method('PUT')

                <div class="form-group">
                    <label for="firstname">Changer de prénom</label>
                    <input required type="text" class="form-control" placeholder="modifier" name="firstname" value="{{ $user->firstname }}" id="firstname">

                </div>
                
                <div class="form-group">
                    <label for="lastname">Changer de nom</label>
                    <input required type="text" class="form-control" placeholder="modifier" name="lastname" value="{{ $user->lastname }}" id="lastname">

                </div>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input required type="text" class="form-control" placeholder="modifier" name="email" value="{{ $user->email }}" id="email">

                </div>
                              
                <button type="submit" class="btn btn-primary">Valider</button>

            </form>

            

        </div> 
        <div>
            <form class=" mx-auto" action="{{ route('utilisateur.destroy', $user->id) }}" method="POST">
                @csrf

                @method('delete')

                <button type="submit" class="btn btn-danger">Supprimer mon compte</button>

            </form>

        </div>
        <div>
            <h2>Mes commandes en cours</h2>
            @if($orders->where('order_status_id', '<', 4))
                <ul>
                    @foreach($orders->where('order_status_id','<', 4) as $order)
                        @if($order->order_status_id == 2)
                            <li>Commande du {{ $order->created_at }} --> en cours de préparation</li>
                        @elseif($order->order_status_id == 3)
                        <li>Commande du {{ $order->created_at }} --> Expédiée le {{$order->updated_at}}</li>
                        @endif
                    @endforeach
                </ul>
            @else
            <p>Il n'y a pas de commande en cours d'expédition pour le moment...</p>
            @endif
            
        </div>
        
        <div>
            <h2>Commandes archivées</h2>
            @if($orders->where('order_status_id', 4))
                <ul>
                    @foreach($orders->where('order_status_id', 4) as $order)
                        <li>Commande du {{ $order->created_at }} --> Livrée le {{ $order->updated_at }}</li>
                    @endforeach
                </ul>
            @else
            <p>Il n'y a pas encore de commandes terminées</p>
            @endif
            
        </div>

    </main>

@endsection