<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Request $request){

        $user = auth()->user();

        $cartItems = \App\Models\Carts::where('user_id', $user->id)
            ->with('product') // Убедитесь, что у вас есть связь product в модели Carts
            ->get();

        return response()->json(['cart' => $cartItems]);
    }
}
