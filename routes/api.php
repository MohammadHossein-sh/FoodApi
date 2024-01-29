<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
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



Route::group(['middleware' => ['auth:sanctum']], function () {


    Route::get('categories/deletes', [CategoryController::class, "deleted"])->middleware('check_admin');
    Route::post('categories/deletes/{category}', [CategoryController::class, "restore"])->withTrashed()->middleware('check_admin');
    Route::get('users/deletes/', [UserController::class, "deletes"])->middleware('check_admin');
    Route::post('users/deletes/{user}', [UserController::class, "restore"])->withTrashed()->middleware('check_admin');
    Route::post('categories', [CategoryController::class, "store"])->middleware('check_admin');
    Route::delete('categories/{category}', [CategoryController::class, "destroy"])->middleware('check_admin');
    Route::put('categories/{category}', [CategoryController::class, "update"])->middleware('check_admin');
    Route::patch('categories/{category}', [CategoryController::class, "update"])->middleware('check_admin');

    Route::prefix('users')->group(function () {
        Route::get('/list', [UserController::class, "index"])->middleware('chek_admin');
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

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('categories', [CategoryController::class, "index"]);
Route::get('categories/{category}', [CategoryController::class, "show"]);


Route::get('categories/{category}/children', [CategoryController::class, 'children']);
Route::get('categories/{category}/parent', [CategoryController::class, 'parent']);
