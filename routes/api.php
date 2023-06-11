<?php

use App\Http\Controllers\Api\bil_importController;
use App\Http\Controllers\Api\CategriesController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\Oder_detailController;
use App\Http\Controllers\Api\OderController;
use App\Http\Controllers\Api\product_informationController;
use App\Http\Controllers\Api\product_siezController;
use App\Http\Controllers\Api\product_size_colorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NewController;
use App\Http\Controllers\AuthController;
use App\Models\oder_detail;
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
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/order', [OderController::class, 'store']);


Route::get('/categorys', [CategriesController::class, 'index']);
Route::get('/categorys/{id}', [CategriesController::class, 'show']);
Route::get('/category_products/{id}', [CategriesController::class, 'getproduct']);


Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/product_cates/{id}', [ProductController::class, 'show_id']);
Route::get('/getsizes/{id}', [ProductController::class, 'getsize']);
Route::get('/getcolors/{id}', [ProductController::class, 'getcolor']);
Route::get('/new', [NewController::class, 'index']);
Route::get('/new/{id}', [NewController::class, 'show']);
Route::get('/new-home', [NewController::class, 'newHome']);

Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/home', [HomeController::class, 'index']);
//danh mục
    Route::get('/category', [CategriesController::class, 'index']);
    Route::get('/category/{id}', [CategriesController::class, 'show']);
Route::get('/category_product/{id}', [CategriesController::class, 'getproduct']);
Route::post('/category', [CategriesController::class, 'store']);
Route::put('/category/{id}', [CategriesController::class, 'update']);
Route::delete('/category/{id}', [CategriesController::class, 'destroy']);
//product
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/product_cates/{id}', [ProductController::class, 'show_id']);
Route::get('/getsize/{id}', [ProductController::class, 'getsize']);
Route::get('/getcolor/{id}', [ProductController::class, 'getcolor']);
Route::post('/create_size', [ProductController::class, 'create_size']);
Route::post('/create_color', [ProductController::class, 'create_color']);
Route::post('/product', [ProductController::class, 'store']);
Route::post('/product/{id}', [ProductController::class, 'update']);
Route::put('/edit_size/{id}', [ProductController::class, 'update_size']);
Route::put('/edit_color/{id}', [ProductController::class, 'update_color']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);
Route::delete('/delete_size/{id}', [ProductController::class, 'destroy_size']);
Route::delete('/delete_color/{id}', [ProductController::class, 'destroy_color']);

//size
Route::get('/size', [SizeController::class, 'index']);
Route::get('/size/{id}', [SizeController::class, 'show']);
Route::post('/size', [SizeController::class, 'store']);
Route::put('/size/{id}', [SizeController::class, 'update']);
Route::delete('/size/{id}', [SizeController::class, 'destroy']);
//color
Route::get('/color', [ColorController::class, 'index']);
Route::get('/color/{id}', [ColorController::class, 'show']);
Route::post('/color', [ColorController::class, 'store']);
Route::put('/color/{id}', [ColorController::class, 'update']);
Route::delete('/color/{id}', [ColorController::class, 'destroy']);

//color
Route::get('/product_size_color', [product_size_colorController::class, 'index']);
Route::get('/product_size_color/{id}', [product_size_colorController::class, 'show']);
Route::post('/product_size_color', [product_size_colorController::class, 'store']);
Route::put('/product_size_color/{id}', [product_size_colorController::class, 'update']);
Route::delete('/product_size_color/{id}', [product_size_colorController::class, 'destroy']);
///
Route::get('/bill_import', [bil_importController::class, 'index']);
Route::get('/bill_import/{id}', [bil_importController::class, 'show']);
Route::post('/bill_import', [bil_importController::class, 'store']);
Route::put('/bill_import/{id}', [bil_importController::class, 'update']);
Route::delete('/bill_import/{id}', [bil_importController::class, 'destroy']);

///customer
Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/customer/{id}', [CustomerController::class, 'show']);
Route::post('/customer', [CustomerController::class, 'store']);
Route::put('/customer/{id}', [CustomerController::class, 'update']);
Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);


Route::post('/new', [NewController::class, 'store']);
Route::put('/new/{id}', [NewController::class, 'update']);
Route::delete('/new/{id}', [NewController::class, 'destroy']);

Route::get('/order', [OderController::class, 'index']);
Route::get('/order/{id}', [OderController::class, 'show']);
Route::get('/order_details/{id}', [OderController::class, 'get_oder_detail']);
// Route::post('/order', [OderController::class, 'store']);
Route::delete('/order/{id}', [OderController::class, 'destroy']);
Route::get('/order_processing', [OderController::class, 'Order_processing']);
// cập nhật trạng thái đơn hàng
Route::put('/update_status_order/{id}', [OderController::class, 'updateStatus']);
Route::get('/order_detail', [Oder_detailController::class, 'index']);
});

