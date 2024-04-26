<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function DisplayAllProduct()
    {
        $product = Product::all();
        $product->load('images');
        return view('product', ['product' => $product]);
    }

    public function category($id)
    {
        $category = Category::where('id', $id)->firstOrFail();
        $category->load('products');

        return view('category', ['category' => $category]);
    }

    public function myproducts()
    {
        $product = Product::all();
        $product->load('images');
        return view('myaccount', ['product' => $product],);
    }
    public function myfavorite()
    {
        $product = Product::all();
        $product->load('images');
        //dd($product);
        return view('favorite', ['product' => $product],);
    }

    public function productDetails($id)
    {
        $product = Product::where('id', $id)->with('user')->firstOrFail();
        $product->load('images');

        //dd($product);
        return view('productdetails', ['product' => $product]);
    }
   
  public function favorite(Request $request){
 
   $product = Product::findOrFail($request->id);
   $item = $product->favoritesProducts;

   dd($item);
//    $product->favorite = !$product->favorite;
//    $product->load('');
//     dd($product);
//     $product->save();
//     return redirect('/product');
  }

    public function test()
    {
        $user = User::find(1);
        
foreach ($user->favouriteProducts as $role) {
    dd($role);
}
    }
  

    public function store(Request $request, GeoCodeController $geoCodeController)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|numeric',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:1024'
        ]);
        $user = Auth::user();
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->user_id = auth()->id();
        $product->latitude = $request->latitude;
        $product->longitude = $request->longitude;

        $product->address = $geoCodeController->reverseGeocode($product);
        $product->save();


        $image = new Image();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/images/'), $imageName);

            $image = new Image();
            $image->product_id = $product->id;
            $image->image = $imageName;
            $image->save();
        }
        //dd($product);
        return redirect('myaccount');
    }




    public function show(string $id)
    {
    }


    public function edit(string $id)
    {
    }


    public function update(Request $request, string $id)
    {
    }


    public function destroy(string $id)
    {
    }
}
