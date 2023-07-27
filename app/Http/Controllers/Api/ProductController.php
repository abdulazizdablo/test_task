<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
       

        $product = Product::create([

            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description
        ]);


        return response()->json([
          'success' => true,
          'message' => 'Product has been created successfully'
        
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description


        ]);
        return response()->json([
            'success' => true,
            'message' => 'Product has been updated succefully'
          
          ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();


        return response()->json([
            'success' => true,
            'message' => 'Product has been deleted successfully'
          
          ]);
    }


    public function assignProduct(Product $product,User $user){


        $user->associate($product);

        return response()->json([
'success' => true,
'message' => 'Product has been assigned to the desired User'


        ]);

    }
}
