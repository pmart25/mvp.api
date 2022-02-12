<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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

use App\Http\Controllers\AuthController;
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');