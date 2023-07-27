<?php

namespace App\Http\Controllers\Dashboard\Product;

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
        $products = Product::all();

        return view('products.index',)->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {

        Product::create($request->validated());

        return redirect()->route('/products.index')->withMessage('Product has been created succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {

        $product->update($request->validated());

        return redirect()->route('products.index')->withMessage('Product has been updated succefully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $product->delete();

        return redirect()->route('products.index')->withMessage('Product has been deleted succefully');
    }


    public function assignProduct(Request $request, User $user)
    {

        $product = Product::where('name', $request->name)->first();

        if ($product) {

            $user->products()->save($product);
        }







        return  redirect()->route('/index')->withMessage('Product has been assigned to user successfully');
    }
}
