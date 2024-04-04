<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Request $request){

        $user = auth()->user();

        $cartItems = \App\Models\Cart::where('user_id', $user->id)
            ->with('product') // Убедитесь, что у вас есть связь product в модели Cart
            ->get();

        return response()->json(['cart' => $cartItems]);
    }
}
