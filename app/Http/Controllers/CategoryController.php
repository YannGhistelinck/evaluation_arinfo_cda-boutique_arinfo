<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        if(Auth::user()->role_id == 2){
            $request->validate([
                'categoryName' => 'required|max:40'
            ]);

            Category::create([
                'categoryName' => $request->categoryName
            ]);

            $message = 'La nouvelle catégorie "'.$request->categoryName.'" a bien été crée';
            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with(['erreur', 'Accès non autorisé']);
        }
        
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
    public function edit(Request $request, Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if(Auth::user()->role_id == 2){
            $request->validate([
                'categoryName' => 'required|max:40'
            ]);
            $message = 'La catégorie "'.$category->categoryName.'"a bien été modifiée par "'.$request->categoryName.'"';

            $category->categoryName = $request->input('categoryName');

            $category->save();

            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with(['erreur', 'Accès non autorisé']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if(Auth::user()->role_id == 2){
            $message = 'La catégorie "'.$category->categoryName.'" a bien été supprimée';
            $category->delete();
            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with(['erreur', 'Suppression de la catégorie impossible']);
        }
    }
}
