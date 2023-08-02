<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return
            response()->json([

                'products' =>   Product::paginate()

            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {

        $image_name = time() . '.' . $request->image->extension();
        $request->image->storeAs('images', $image_name);


        Product::create([

            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_name
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Product has been created successfully'

        ]);
    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {



        $product->update($request->validated());
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


    public function assignProduct(Product $product, User $user)
    {

       $check_assigned =  User::wherehas('products',function($q) use($user){

       $q->where('user_id',$user->id);

        });

        if($check_assigned){


            return response()->json([
                'success' => false,
                'message' => 'Procut is already assigned to user',
    
                'user product' => $product
            ]);
        } 
        


        $user->products()->save($product);



        return response()->json([
            'success' => true,
            'message' => 'Product has been assigned to the desired User',

            'user product' => $product
        ]);
    }
}
