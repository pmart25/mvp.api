<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\Auth;

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


    public function updateAmountProduct($productId, $amountAvailable)
    {

        $user = auth()->user();
        if (strcmp($user->role, "seller") != 0) {  //if user role is not a buyer
            echo "User is not a seller. Only buyer sellers can update a stock number of Products.";
            return 0;

        }
        return Product::where( 'id' , $productId)->update(['amountAvailable' => $amountAvailable]);
    }
}
