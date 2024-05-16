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
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
    public function displayAllProduct()
    {
        $products = Product::where('is_active', true)->with('images', 'product_users')->get();
        return view('product', ['products' => $products]);
    }

    public function category($id)
    {
        $category = Category::where('id', $id)->with('children')->firstOrFail();
        $categoryId = $category->children->pluck('id')->toArray();
        $categoryId[] = $category->id;
        $products = Product::whereIn('category_id', $categoryId)->where('is_active', true)->get();
        return view('category', ['products' => $products]);
    }

    public function myProducts()
    {
        $products = Product::with('images')->get();
        return view('myaccount', ['products' => $products],);
    }

    public function myFavorite()
    {
        $products = Product::where('is_active',true)->with('images')->get();
        return view('favorite', ['products' => $products],);
    }

    public function productDetails($id)
    {
        $product = Product::where('id', $id)->with(['user','images'])->firstOrFail();
        $product->increment('views');
        return view('productdetails', ['product' => $product]);
    }

    public function favorite($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $user_id = auth()->id();
        ProductUser::firstOrCreate(['product_id' => $product->id, 'user_id' => $user_id]);
        return redirect()->back();
    }

    public function deleteFavorite($id)
    {
        $product = ProductUser::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
        if ($product) {
            $product->delete();
        }
        return redirect()->back();
    }
    public function status($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $product->is_active = !$product->is_active;
        $product->update();

        return redirect()->back()->with('status', 'product status updated!');
    }

    public function store(Request $request, GeoCodeService $geoCodeService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:250',
            'price' => 'required|numeric',
            'category' => 'required|numeric',
            'files.*.image' => 'required|file|mimes:jpeg,png,jpg,gif|max:1024'

        ]);
        $formattedDateTime = Carbon::now()->format('Y-m-d H:i:s');

        $user = Auth::user();
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->user_id = auth()->id();
        $product->latitude = $request->latitude;
        $product->refresh = $formattedDateTime;
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


    public function edit(Product $product)
    {
        return view('editproduct', [
            'product' => $product

        ]);
    }


    public function update(Product $product, Request $request)
    {
        
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'required',
                'string'
            ],
            'price' => [
                'required',
                'numeric'
            ],
            
        ]);

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
    ]);

        
        return redirect('myaccount')->with('status', 'ogłoszenie zaktualizowane');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back();
    }


    public function refresh(Product $product){
        $formattedDateTime = Carbon::now()->format('Y-m-d H:i:s');

        $product->update(['refresh' => $formattedDateTime]);

        return redirect('myaccount')->with('status', 'Ogłoszenie odświeżone');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', "%$search%")->get();

        return view('search', ['products' => $products]);
    }
    public function searchFiltr(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('lowestprice') && $request->filled('highestprice'), function ($query) use ($request) {
                return $query->whereBetween('price', [$request->lowestprice, $request->highestprice]);
            })
            ->with('images')
            ->get();
        return view('search', ['products' => $products]);
    }

    public function filtr(Request $request)
    {
        $products = Product::filter()
            ->when($request->filled('lowestprice') && $request->filled('highestprice'), function ($query) use ($request) {
                return $query->whereBetween('price', [$request->lowestprice, $request->highestprice]);
            })
            ->with(['images', 'product_users'])
            ->get();
        return view('product', ['products' => $products]);
    }

    public function filtrCategory(Request $request, $id)
    {
        $products = Product::filter()->where('category_id', $id)
            ->when($request->filled('lowestprice') && $request->filled('highestprice'), function ($query) use ($request) {
                return $query->whereBetween('price', [$request->lowestprice, $request->highestprice]);
            })
            ->with(['images', 'product_users'])
            ->get();
            return view('category', ['products' => $products,'id'=>$id]);
        }
}
