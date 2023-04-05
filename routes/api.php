<?php

use App\Http\Controllers\API\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DestinasiController;
use App\Http\Controllers\API\TicketController;

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
Route::get('destinasi',[DestinasiController::class, 'index']);
Route::post('destinasi/store', [DestinasiController::class, 'store']);
Route::get('destinasi/{id}', [DestinasiController::class, 'show']);
Route::get('destinasi/update/{id}', [DestinasiController::class, 'update']);
Route::delete('destinasi/destroy/{id}', [DestinasiController::class, 'destroy']);
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

//REVIEW
Route::get('review', function () {
    return \App\Models\Review::with('destinasi')->get();
});
Route::post('review', [ReviewController::class, 'store']);
Route::get('review/{id}', [ReviewController::class, 'show']);