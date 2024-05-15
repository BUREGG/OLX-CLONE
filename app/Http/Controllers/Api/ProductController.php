<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Product::all();
        return ProductResource::collection(Product::all()); 

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $user_id=$request->user_id;
        $user = DB::table('users')->pluck('id');
        $category_id=$request->category_id;
        $category = DB::table('categories')->pluck('id');
        if($user->contains($user_id)&&($category->contains($category_id)))
        {
            $product = Product::create($request->all());
        return new ProductResource($product);
           
        }else
        {
            return response()->json([
                'Nie ma uzytkownika lub kategorii o takim ID'
            ]);
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // return $product;
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, UpdateProductRequest $request)

    {
        $userId = Auth::id();
        if($request->user()->hasRole('super-admin'))
        {
            $product->update($request->all());
            return new ProductResource($product);
        }
        else if($userId!=$product->user_id){
            return response()->json([
                'Nie mozna zaktualizować nie swojego produktu'
            ]);
        }else
        {
        $product->update($request->all());
        return new ProductResource($product);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Request $request)
    {
        $userId = Auth::id();
        if($request->user()->hasRole('super-admin')){
            $product->delete();
            return response()->json([
                'Usunięto produkt o id:' => $product->id
            ]); 
        }else if ($userId!=$product->user_id){
            return response()->json([
                'Nie mozna usunac nie swojego produktu'
            ]);
        }
        else
        {
        $product->delete();
        return response()->json([
            'Usunięto produkt o id:' => $product->id
        ]); 
    }

    }
    public function list()
    {
        return ProductResource::collection(Product::all());
    }
    public function myProducts()
    {
        $userId = Auth::id();
        return Product::where('user_id', $userId)->with('images')->get();
    }
}
