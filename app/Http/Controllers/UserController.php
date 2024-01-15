<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
       
        $user = Auth::user();
        
        $orders = Order::where('user_id', $user->id)->where('order_status_id', '>', 1)->get();
        return view('user/index', ['user' => $user], compact('orders'));
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
        //
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if( Auth::user()->id== $user->id){
            $request->validate([
                'firstname' => 'required|max:40',
                'lastname' => 'required|max:40',
                'email' => 'required',
            ]);

            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');

            $user->save();

            return redirect()->back()->with('message', 'Les modifications ont bien été enregistrées');
        }else{
            return redirect()->back()->with(['error' => "Modifications impossibles, vous n'avez pas les autorisations nécessaires pour modifier ce compte"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
       
        if(Auth::user()->id == $id){
            $user->delete();
            return redirect()->route('home')->with('message', 'Le compte a bien été supprimé');
        }else{
            return redirect()->back()->with(['error' => 'Suppression du compte impossible']);
        }
    }
}
