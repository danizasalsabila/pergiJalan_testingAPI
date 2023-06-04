<?php

use App\Http\Controllers\API\AuthControllerOwnerBusiness;
use App\Http\Controllers\API\ReviewController;
use App\Models\OwnerBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DestinasiController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\AuthControllerUser;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//DESTINASI
Route::get('destinasi', [DestinasiController::class, 'index']);
Route::post('destinasi/store', [DestinasiController::class, 'store']);
Route::get('destinasi/{id}', [DestinasiController::class, 'show']);
Route::put('destinasi/update/{id}', [DestinasiController::class, 'update']);
Route::delete('destinasi/destroy/{id}', [DestinasiController::class, 'destroy']);
Route::get('destinasi/byowner/{id_owner}', [DestinasiController::class, 'showByIdOwner']);
//search Destinasi
// Route::get('destinasi/search/{name_destinasi}', [DestinasiController::class, 'search']);

Route::get('/search/destinasi', 'App\Http\Controllers\API\DestinasiController@search');
Route::get('/city/destinasi', 'App\Http\Controllers\API\DestinasiController@city');
Route::get('/category/destinasi', 'App\Http\Controllers\API\DestinasiController@category');


//TICKET
Route::get('ticket', function () {
    return \App\Models\Ticket::with('destinasi')->get();
});
Route::post('ticket', [TicketController::class, 'store']);
Route::get('ticket/{id}', [TicketController::class, 'show']);
Route::delete('ticket/destroy/{id}', [TicketController::class, 'destroy']);
Route::put('ticket/update/{id}', [TicketController::class, 'update']);

//REVIEW
Route::get('/rating/{id}', [ReviewController::class, 'getRating']);
Route::get('/rating/byowner/{id_owner}', [ReviewController::class, 'getRatingByIdOwner']);
Route::get('review', function () {
    return \App\Models\Review::with('destinasi')->get();
});
Route::post('review', [ReviewController::class, 'store']);
Route::get('review/{id}', [ReviewController::class, 'show']);
// Route::get('review/{id}', function () {
//     return \App\Models\Review::with('user')->get();
// });


//USER
// Route::post('register', 'App\Http\Controllers\API\AuthControllerUser@register');
// Route::post('login', 'App\Http\Controllers\API\AuthControllerUser@login');
// Route::post('logout', 'App\Http\Controllers\API\AuthControllerUser@logout');

// Route::post('register', 'App\Http\Controllers\API\AuthControllerUser@register');
// Route::post('login', 'App\Http\Controllers\API\AuthControllerUser@login');
// Route::middleware('auth:api')->post('logout', 'App\Http\Controllers\API\AuthControllerUser@logout');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthControllerUser::class, 'logout']);
});
Route::post('register', [AuthControllerUser::class, 'register']);
Route::post('login', [AuthControllerUser::class, 'login']);
Route::put('user/{id}', [AuthControllerUser::class, 'update']);
Route::get('user', [AuthControllerUser::class, 'index']);
Route::get('/email/user', 'App\Http\Controllers\API\AuthControllerUser@email');
Route::get('user/{id}', [AuthControllerUser::class, 'show']);


//OWNER BUSINESS USER
Route::post('owner/register', [AuthControllerOwnerBusiness::class, 'register']);
Route::post('owner/login', [AuthControllerOwnerBusiness::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('owner/logout', [AuthControllerOwnerBusiness::class, 'logout']);
});
Route::get('owner/{id}', [AuthControllerOwnerBusiness::class, 'show']);
Route::put('owner/{id}', [AuthControllerOwnerBusiness::class, 'update']);
Route::get('owner', [AuthControllerOwnerBusiness::class, 'index']);


