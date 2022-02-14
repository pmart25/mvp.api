<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

   // id, $productName, $amountAvailable, $cost, $sellerId

    use HasFactory;

    
    
    protected $fillable = ['productName', 'amountAvailable', 'sellerId'];


    public static function amountAvailable($productId) {

        return Product::where('id',  $productId)->select('amountAvailable')->first()->amountAvailable;
   

    }


    public static function createProduct($productName, $amountAvailable, $cost, $sellerId) {

        Product::insert([
               'productName'=> $productName,
               'amountAvailable'=> $amountAvailable,
               'cost'=> $cost,
               'sellerId'=> $sellerId,
               'created_at'=> now(),
               'updated_at'=> now(),
           ]);

    }


    public static function buyProduct($productId) {


        $productAmount = self::amountAvailable($productId);
        $newProductAmount = $productAmount-1;
        return Product::where('id',  $productId)->update(['amountAvailable' => $newProductAmount]);
    }

    public static function deleteProduct($productId) {

        
        Product::where( 'id' , $productId)->delete();

    }


    public static function updateAmountProduct($productId, $amountAvailable ) {

        
        Product::where( 'id' , $productId)->update(['amountAvailable' => $amountAvailable]);
       

    }
}
