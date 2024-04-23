<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function getCategory()
   {
      $categories = Category::root()->get();
      return view('welcome', ['categories' => $categories]);
   }

}
