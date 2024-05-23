<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function chart()
    {
        $user = Auth::user();

        $products = Product::where('user_id', $user->id)->get(['name', 'views']);


        return view('chart', compact('products'));
    }
}
