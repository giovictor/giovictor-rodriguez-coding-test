<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'numeric',
            'limit' => 'numeric',
        ]);

        $page = $request->has('page') ? $request->input('page') : '1';
        $limit = $request->has('limit') ? $request->input('limit') : '10';

        $totalProductsCount = Product::count();
        $noOfPages = $totalProductsCount / $limit;
        $products = Product::offset(($page - 1) * $limit)->limit($limit);

        return response()->json([
            'page'  => $page,
            'limit' => $limit,
            'total' => $totalProductsCount,
            'pageTotal' => count($products->get()),
            'noOfPages' => $noOfPages,
            'data'  => $products->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
