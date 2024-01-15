@extends('layouts.app')

@section('title')
    Mon Compte
@endsection

@section('content')

    <main class="container">
        <h1>Mon Compte</h1>

        <h3 class="pb-3">Modifier mes informations</h3>

        {{-- <div class="row mb-4">

            <form class="col-8 mx-auto" action="{{ route('users.update', $user) }}" method="POST">
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
                    <label for="pseudo">Changer de pseudo</label>
                    <input required type="text" class="form-control" placeholder="modifier" name="pseudo" value="{{ $user->pseudo }}" id="pseudo">

                </div>

                <div class="form-group">
                    <label for="description">Changer de description</label>
                    <textarea class="form-control" placeholder="modifier" name="description" id="description">{{ $user->description }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Changer d'image</label>
                    <input type="text" class="form-control" placeholder="modifier" name="image" value="{{ $user->image }}" id="image">
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>

            </form>

        </div> --}}


        {{-- <div class="row">
            <form action="{{route('users.destroy', $user)}}" method="POST" class="col-4 mx-auto">
                @csrf
                @method("delete")
                <button type="submit" class="btn btn-danger">Supprimer le compte</button>
            </form>
        </div> --}}


    </main>

@endsection