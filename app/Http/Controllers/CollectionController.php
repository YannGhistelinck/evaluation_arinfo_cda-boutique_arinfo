<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
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
        $request->validate([
            'collectionName' => 'required|max:40'
        ]);

        Collection::create([
            'collectionName' => $request->collectionName
        ]);

        $message = 'La collection "'.$request->collectionName.'" a bien été créée';

        return redirect()->back()->with('message', $message);
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
    public function edit(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'collectionName' => 'required|max:40'
        ]);
        
        $message = 'La collection "'.$collection->collectionName.'" a bien été modifiée en "'.$request->collectionName;

        $collection->collectionName = $request->input('collectionName');

        $collection->save();

        

        return redirect()->back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        if(Auth::user()->role_id == 2){
            $message = 'La collection "'.$collection->collectionName.'" a bien été supprimée';
            $collection->delete();
            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with(['erreur', 'Suppression de la collection impossible']);
        }
    }
}
