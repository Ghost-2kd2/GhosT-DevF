<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

//<----------------------------AUTH CONTROLLER--------------------------->
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/sample', [AuthController::class, 'sample']);
});
//<----------------------------ADMIN CONTROLLER-------------------------->
Route::group([
    'middleware' => 'api',
    'prefix' => 'admin',

], function ($router) {
    //<---------------------------MAIN ROUTES----------------------------->
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::post('/refresh', [AdminController::class, 'refresh']);
    Route::get('/user-profile', [AdminController::class, 'userProfile']);
    // //<-------------------------LIST ROUTES------------------------------->
    // Route::post('/index', [AdminController::class, 'index']);
    // Route::post('/productList', [AdminController::class, 'productList']);
    // //<-------------------------product ROUTES------------------------------>
    // Route::post('/addproduct', [AdminController::class, 'addproduct']);
    // Route::post('/productImages', [AdminController::class, 'productImages']);
    // Route::post('/getproduct', [AdminController::class, 'getproduct']);
    // Route::post('/updateproduct', [AdminController::class, 'updateproduct']);
    // Route::post('/deleteproduct', [AdminController::class, 'deleteproduct']);
    // //<------------------------CATEGORY ROUTES---------------------------->
    // Route::post('/addCat', [AdminController::class, 'addCat']);
    // Route::post('/getCat', [AdminController::class, 'getCat']);
    // Route::post('/updateCat', [AdminController::class, 'updateCat']);
    // Route::post('/deleteCat', [AdminController::class, 'deleteCat']);
    // //<------------------------SUB_CATEGORY ROUTES------------------------>
    // Route::post('/addSubCat', [AdminController::class, 'addSubCat']);
    // Route::post('/getSubCat', [AdminController::class, 'getSubCat']);
    // Route::post('/updateSubCat', [AdminController::class, 'updateSubCat']);
    // Route::post('/deleteSubCat', [AdminController::class, 'deleteSubCat']);

    // //<------------------------TERTIARY_CATEGORY ROUTES------------------------>
    // Route::post('/addTerCat', [AdminController::class, 'addTerCat']);
    // Route::post('/getTerCat', [AdminController::class, 'getTerCat']);
    // Route::post('/updateTerCat', [AdminController::class, 'updateTerCat']);
    // Route::post('/deleteTerCat', [AdminController::class, 'deleteTerCat']);
    // //.............................................................................//
    // Route::post('/addMassProduct', [AdminController::class, 'addMassProduct']);

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'product',

], function ($router) {
    //<-------------------------CRUD ROUTES------------------------------->
    Route::post('/index', [ProductController::class, 'index']);
    Route::post('/productList', [ProductController::class, 'productList']);
    //<-------------------------PRODUCT ROUTES------------------------------>
    Route::post('/addproduct', [ProductController::class, 'addproduct']);
    Route::post('/productImages', [ProductController::class, 'productImages']);
    Route::post('/getproduct', [ProductController::class, 'getproduct']);
    Route::post('/updateproduct', [ProductController::class, 'updateproduct']);
    Route::post('/deleteproduct', [ProductController::class, 'deleteproduct']);
    //<------------------------CATEGORY ROUTES---------------------------->
    Route::post('/addCat', [ProductController::class, 'addCat']);
    Route::post('/getCat', [ProductController::class, 'getCat']);
    Route::post('/updateCat', [ProductController::class, 'updateCat']);
    Route::post('/deleteCat', [ProductController::class, 'deleteCat']);
    //<------------------------SUB_CATEGORY ROUTES------------------------>
    Route::post('/addSubCat', [ProductController::class, 'addSubCat']);
    Route::post('/getSubCat', [ProductController::class, 'getSubCat']);
    Route::post('/updateSubCat', [ProductController::class, 'updateSubCat']);
    Route::post('/deleteSubCat', [ProductController::class, 'deleteSubCat']);
    //<------------------------TERTIARY_CATEGORY ROUTES------------------------>
    Route::post('/addTerCat', [ProductController::class, 'addTerCat']);
    Route::post('/getTerCat', [ProductController::class, 'getTerCat']);
    Route::post('/updateTerCat', [ProductController::class, 'updateTerCat']);
    Route::post('/deleteTerCat', [ProductController::class, 'deleteTerCat']);
    //.............................................................................//
    Route::post('/addMassProduct', [ProductController::class, 'addMassProduct']);
    Route::post('/samp', [ProductController::class, 'samp']);
    Route::post('/sample', [ProductController::class, 'sample']);

});