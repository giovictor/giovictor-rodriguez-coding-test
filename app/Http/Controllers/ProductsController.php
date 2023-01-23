<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRequest $request)
    {
        $page = $request->has('page') ? $request->input('page') : '1';
        $limit = $request->has('limit') ? $request->input('limit') : '10';

        $totalProductsCount = Product::count();
        $noOfPages = ceil($totalProductsCount / $limit);
        $products = Product::offset(($page - 1) * $limit)->limit($limit);

        return response()->json([
            'page'  => $page,
            'limit' => $limit,
            'noOfPages' => $noOfPages,
            'total' => $totalProductsCount,
            'pageTotal' => count($products->get()),
            'data'  => $products->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $result = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ]);

        return response()->json([
            'message' => 'Product was created successfully.',
            'data' => $result
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price')
        ]);

        $result = Product::find($product->id);

        return response()->json([
            'message' => 'Product was updated successfully.',
            'data' => $result
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product was deleted successfully.'
        ], 200);
    }
}
