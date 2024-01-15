<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
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
                'promotionName' => 'required|max:40',
                'promotionValue' => 'required',
                'startAt' => 'required',
                'endAt' => 'nullable',
                'promotion_type_id' => 'required'
            ]);

            Promotion::create([
                'promotionName' => $request->promotionName,
                'promotionValue' => $request->promotionValue,
                'startAt' => $request->startAt,
                'endAt' => $request->endAt,
                'promotion_type_id' => $request->promotion_type_id
            ]);

            $message = 'La promotion "'.$request->promotionName.'" a bien été créée.';

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        if(Auth::user()->role_id == 2){
            $request->validate([
                'promotionName' => 'required|max:40',
                'promotionValue' => 'required',
                'startAt' => 'required',
                'endAt' => 'nullable',
                'promotion_type_id' => 'required'
            ]);


            $promotion->promotionName = $request->input('promotionName');
            $promotion->promotionValue = $request->input('promotionValue');
            $promotion->startAt = $request->input('startAt');
            $promotion->endAt = $request->input('endAt');
            $promotion->promotion_type_id = $request->input('promotion_type_id');



            return redirect()->back()->with('message', 'La promotion "'.$request->promotionName.'" a bien été modifiée');
        }else{
            return redirect()->back()->with(['erreur', 'Accès non autorisé']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        if(Auth::user()->role_id === 2){
            
            $message = 'La promotion "'.$promotion->promotionName.'" a bien été supprimée';
            $promotion->delete();
            
            return redirect()->back()->with('message', $message);
        }else{
            return redirect()->back()->with(['error' => 'Suppression de la promotion impossible']);
        }
    }
}
