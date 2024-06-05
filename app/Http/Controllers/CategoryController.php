<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function getCategory()
   {
      $products = Product::orderBy('views', 'desc')->take(3)->get();
      $categories = Category::root()->get();
      return view('welcome', [
         'categories' => $categories,
         'products' => $products
   ]);
   }
}
