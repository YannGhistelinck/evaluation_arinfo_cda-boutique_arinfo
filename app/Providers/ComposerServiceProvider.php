<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        

        view::composer('layouts/app', function($view){
            if(Auth::user()){

                $order = null;
                if($user = Auth::user()){
                $existingCart = Order::where('order_status_id', 1)->where('user_id', $user->id)->first();

                    if(!$existingCart){
                        $order = Order::create([
                            'user_id' => $user->id,
                            'order_status_id' => 1
                        ]);
                    }else{
                        $order = Order::where('order_status_id', 1)->where('user_id', $user->id)->first();
                    }
                }
                $order = Order::where('order_status_id', 1)->where('user_id', Auth::user()->id)->first();
                $view->with('orderCart', $order);
            }
            
            
        });
        
        
    }
}
