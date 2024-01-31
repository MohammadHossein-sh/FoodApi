<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Auth

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::prefix('users')->group(function () {
        Route::get('/list', [UserController::class, "index"])->middleware('check_admin');
        Route::get('/{user}', [UserController::class, "show"]);
        Route::delete('/{user}', [UserController::class, "destroy"]);
        Route::put('/update', [UserController::class, "update"]);
        Route::patch('/update', [UserController::class, "update"]);
    });

    Route::prefix('address')->group(function () {
        Route::post('/', [AddressController::class, "store"]);
        Route::post('deletes/{address}', [AddressController::class, "restore"]);
        Route::get('/', [AddressController::class, "index"]);
        Route::put('/{id}', [AddressController::class, "update"]);
        Route::patch('/{id}', [AddressController::class, "update"]);
        Route::delete('/{address}', [AddressController::class, "destroy"]);
        Route::get('/{address}', [AddressController::class, "show"]);
        Route::get('/deletes', [AddressController::class, "deleted"]);
    });

    Route::group(['middleware' => ['check_admin']], function () {
        Route::get('products/deletes/', [ProductController::class, "deletes"]);
        Route::get('products/deletes/{product}', [ProductController::class, "restore"])->withTrashed();
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
 
        Route::get('categories/deletes', [CategoryController::class, "deleted"]);
        Route::post('categories/deletes/{category}', [CategoryController::class, "restore"])->withTrashed();
        Route::get('users/deletes/', [UserController::class, "deletes"]);
        Route::post('users/deletes/{user}', [UserController::class, "restore"])->withTrashed();
        Route::post('categories', [CategoryController::class, "store"]);
        Route::delete('categories/{category}', [CategoryController::class, "destroy"]);
        Route::put('categories/{category}', [CategoryController::class, "update"]);
        Route::patch('categories/{category}', [CategoryController::class, "update"]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('categories', [CategoryController::class, "index"]);
Route::get('categories/{category}', [CategoryController::class, "show"]);


Route::get('categories/{category}/children', [CategoryController::class, 'children']);
Route::get('categories/{category}/parent', [CategoryController::class, 'parent']);
