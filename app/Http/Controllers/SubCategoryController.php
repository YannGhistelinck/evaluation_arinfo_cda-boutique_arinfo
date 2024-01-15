<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
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
            'subCategoryName'=>'required|max:40'
        ]);

        SubCategory::create([
            'subCategoryName' => $request->subCategoryName
        ]);

        $message = 'La sous-catégorie "'.$request->subCategoryName.'"a bien été créée';

        return redirect()->back()->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        return view("admin/show", []);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $subCategory = SubCategory::find($id);

        $request->validate([
            'subCategoryName' => 'nullable|max:40'
        ]);
        
        $message = 'La sous-catégorie "'.$subCategory->subCategoryName.'" a bien été modifiée par "'.$request->subCategoryName.'"';

        $subCategory->subCategoryName = $request->input('subCategoryName');
        $subCategory->save();


        return redirect()->back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory, $id)
    {
        $subCategory = SubCategory::find($id);
        if(Auth::user()->role_id == 2){
            $message = 'La catégorie "'.$subCategory->subCategoryName.'" a bien été supprimée';
            $subCategory->delete();
            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with(['erreur', 'Suppression de la catégorie impossible']);
        }
    }
}
