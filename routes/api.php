<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Product;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('products', function() {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Product::all();
});


Route::get('products/{id}', function($id) {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Product::find($id);
});



//products
Route::get('data', [ProductController::class,'getData']);
Route::get('products', [ProductController::class,'index']);
Route::get('products/{id}', [ProductController::class,'show']);
Route::get('productamount/{id}', [ProductController::class,'getAmount']);
Route::get('createproduct/{productName},{amountAvailable},{cost},{sellerId}', [ProductController::class,'createProduct']);  //post
//createproduct/lillipop,15,5,45 
Route::get('deleteproduct/{id}', [ProductController::class,'deleteProduct']);  //post
Route::post('updateamountproduct/{amountProduct}', [ProductController::class,'updateAmountProduct']);  //post



//users
Route::get('users', [UserController::class,'index']);
Route::get('users/{id}', [UserController::class,'show']);
Route::get('createuser/{userName},{email},{password},{deposit},{role}', [UserController::class,'createUser']);  //post
//createuser/user1,user1@test.com,user1!password,20,buyer 
//createuser/user2,user2@test.com,user2!password,20,seller



// test 


//login with user buyer

//Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
Route::post('register', [RegisterController::class,'register']);


//https://www.twilio.com/blog/build-restful-api-php-laravel-sanctum


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::get('/test', function() {
    if ( auth()->user() ) {
        $answer = "user is logged in";
    } else {
        $answer = "user not logged ";
    }
    return $answer." with Id: ".auth()->user()->id;
})->middleware('auth:sanctum');



Route::get ('getdeposit/{userId}', [User::class, 'getDeposit']);
Route::get ('reset/{userId}', [User::class, 'resetDeposit']);



//https://www.amezmo.com/laravel-hosting-guides/role-based-api-authentication-with-laravel-sanctum
Route::group(['middleware' => 'auth:sanctum'], function() {
    // list all post
    Route::post('deposit/{amountMoney}', [UserController::class, 'deposit']);
    Route::post('buy/{productId}', [UserController::class, 'buy']);
    Route::post('updateamountproduct/{amountProduct}', [ProductController::class,'updateAmountProduct']);  //post


});


//Implement /deposit endpoint so users with a “buyer” role can deposit only 5, 10, 20, 
//50 and 100 cent coins into their vending machine account (one coin at the time).  --> done 

//Implement /buy endpoint (accepts productId, amount of products) so users with a
//“buyer” role can buy a product (shouldn't be able to buy multiple different products
//at the same time) with the money they’ve deposited. API should return total they’ve
//spent, the product they’ve purchased and their change if there’s any (in an array of
//5, 10, 20, 50 and 100 cent coins)  --> done

//Implement /reset endpoint so users with a “buyer” role can reset their deposit back
//to 0 --> done

//Take time to think about possible edge cases and access issues that should be
//solved