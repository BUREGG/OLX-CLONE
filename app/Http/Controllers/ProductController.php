<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function DisplayAllProduct()
    {
        $product = Product::all();
        $product->load('images', 'product_users');
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
        return view('favorite', ['product' => $product],);
    }

    public function productDetails($id)
    {
        $product = Product::where('id', $id)->with('user')->firstOrFail();
        $product->load('images');
        return view('productdetails', ['product' => $product]);
    }

    public function favorite($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $user_id = auth()->id();
        ProductUser::firstOrCreate(['product_id' => $product->id, 'user_id' => $user_id]);
        return redirect('/product');
    }
    public function deletefavorite($id)
    {
        $product = ProductUser::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
        if ($product) {
            $product->delete();
        }
        return redirect('/product');
    }

    // public function test()
    // {
    //     $user = User::find(1);

    //     foreach ($user->favouriteProducts as $role) {
    //         dd($role);
    //     }
    // }


    public function store(Request $request, GeoCodeController $geoCodeController)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|numeric',
            'files.*.image' => 'required|file|mimes:jpeg,png,jpg,gif|max:1024'

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


        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach ($files as $file) {
                $imageName = Str::uuid() . '.' . $file->extension();
                $file->move(public_path('storage/images/'), $imageName);
                $image = new Image();
                $image->product_id = $product->id;
                $image->image = $imageName;
                $image->save();
            }
        }
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
