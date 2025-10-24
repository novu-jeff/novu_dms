<?php

use App\Http\Controllers\Api\DocumentManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Storage;


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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['api', 'client'])->group(function () {
    Route::get('documents', [DocumentManagementController::class, 'getDocumentsByYearAndMonth']);
});


Route::get('/getdocuments', [DocumentManagementController::class, 'index']);
Route::get('/getdocuments/{id}', [DocumentManagementController::class, 'show']);



Route::get('/files/{folder}/{filename}', function ($folder, $filename) {
    $path = "public/{$folder}/{$filename}";

    if (!Storage::exists($path)) {
        return response()->json(['message' => 'File not found'], 404);
    }

    return response()->file(storage_path("app/{$path}"));
});



