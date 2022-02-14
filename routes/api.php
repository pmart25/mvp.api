<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

    return Product::all();
});


Route::get('products/{id}', function($id) {

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








//Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
Route::post('register', [RegisterController::class,'register']);




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




Route::group(['middleware' => 'auth:sanctum'], function() {
    // list all post
    Route::post('deposit/{amountMoney}', [UserController::class, 'deposit']);
    Route::post('buy/{productId}', [UserController::class, 'buy']);
    Route::post('updateamountproduct/{amountProduct}', [ProductController::class,'updateAmountProduct']);  //post


});

 
Route::resource('category', CategoryController::class)->only(['index','store','show','update','destroy']);

