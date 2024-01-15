<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
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
        if(Auth::user()->role_id === 2){
            $request->validate([
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'product_id' => 'required'
            ]);
            
            
            foreach($request->images as $data){
    
                $image = $data->getClientOriginalName();
                $fileToStore = time().'-'.$image;
                
                $data->storeAs('public/uploads', $fileToStore);
    
                Image::create([
                    'fileName'=> $fileToStore,
                    'product_id'=> $request->product_id
                ]);
            }
    
            return redirect()->back()->with('message','La ou les images ont bien été téléchargées');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $image = Image::find($id);
        
        
        if(Auth::user()->role_id === 2){

            $fileLink = 'public/uploads/'.$image->fileName;

            if(Storage::exists($fileLink)){
                Storage::delete($fileLink);
            }else{
                return redirect()->back()->with(['erreur', 'Suppression de la photo impossible, image introuvable']);
            }

            $image->delete();

            return redirect()->back()->with('message', "L'image a bien été supprimée");
        }else{
            return redirect()->back()->with(['error' => 'Suppression impossible']);
        }
    }
}
