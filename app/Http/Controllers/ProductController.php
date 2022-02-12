<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //


    public function index()
    {
        return Product::all();
    }
 
    public function show(Product $product)
    {
        return Product::find($id);
    }

    public function getData() {
        return 'hello';
    }

    public function getAmount($productId)
    {
        return Product::amountAvailable($productId);
    }


    public function createProduct($productName, $amountAvailable, $cost, $sellerId)
    {
        return Product::createProduct($productName, $amountAvailable, $cost, $sellerId);
    }

    public function deleteProduct($productId)
    {
        return Product::deleteProduct($productId);
    }
}
