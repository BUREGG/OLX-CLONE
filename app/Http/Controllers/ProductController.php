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
use App\Services\GeoCodeService;
use App\Services\UserService;

class ProductController extends Controller
{
    public function DisplayAllProduct()
    {
        $products = Product::with('images', 'product_users')->get();
        return view('product', ['products' => $products]);
    }
    public function category($id)
    {
        $category = Category::where('id', $id)->with('children')->firstOrFail();
        $categoryId = $category->children->pluck('id')->toArray();
        $categoryId[] = $category->id;
        $products = Product::whereIn('category_id', $categoryId)->get();

        return view('category', ['products' => $products]);
    }

    public function myproducts()
    {
        $products = Product::with('images')->get();
        return view('myaccount', ['products' => $products],);
    }
    public function myfavorite()
    {
        $products = Product::all();
        $products->load('images');
        return view('favorite', ['products' => $products],);
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
        return redirect()->back();
    }

    public function store(Request $request, GeoCodeService $geoCodeService)
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
        $product->address = $geoCodeService->reverseGeocode($product);
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


    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
        }
        return redirect()->back();
    }
}
