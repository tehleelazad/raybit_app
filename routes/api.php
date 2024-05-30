<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HttpController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::put('/update-data/{id}', [HttpController::class, 'updateData']);
Route::delete('/delete-data/{id}', [HttpController::class, 'deleteData']);

// Route::get('/data', [HttpController::class, 'getData']);
Route::get('/get-google-data', [HttpController::class, 'getData']);
// Route::post('/submit-data', [HttpController::class, 'submitData']);
Route::post('/submit-data', [HttpController::class, 'storeDataUsingGuzzle']);
Route::get('/make-request', [HttpController::class, 'makeRequest']);
Route::post('/make-post-request', [HttpController::class, 'makePostRequest']);



// Route::put('/update-post/{id}', [HttpController::class, 'updatePost']);
Route::put('/posts/{postId}', [HttpController::class, 'updateDataUsingGuzzle']);
Route::delete('/posts/{postId}', [HttpController::class, 'deleteDataUsingGuzzle']);
Route::post('store-datadb', [HttpController::class, 'storeData']);
Route::put('update-datadb/{id}', [HttpController::class, 'updateData']);
Route::delete('delete-datadb/{id}', [HttpController::class, 'deleteData']);