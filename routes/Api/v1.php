<?php

use App\Http\Controllers\ConnectDataBaseController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\ExternalDataBaseController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\DataEntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//routes for Graphs
Route::controller(ExternalDataBaseController::class)->prefix('databases')->as('databases.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/dataEntries/{external_data_base}', 'getDataEntries')->name('getDataEntries');
    Route::prefix('{external_data_base}')->group(function () {
        Route::delete('/', 'destroy')->name('destroy');
        Route::get('/', 'show')->name('show');
        Route::post('/', 'update')->name('update');
    });
});

//routes for Entries
Route::controller(EntryController::class)->prefix('entries')->as('entries.')->group(function () {
    Route::post('/', 'store')->name('store');
    Route::prefix('{entry}')->group(function () {
        Route::delete('/', 'destroy')->name('destroy');
        Route::put('/', 'update')->name('update');
        Route::get('/', 'show')->name('show');
    });
});

//routes for DataEntries
Route::controller(DataEntryController::class)->prefix('dataEntries')->as('dataEntries.')->group(function () {
    Route::post('/', 'update')->name('update');
    Route::post('/delete', 'delete')->name('delete');
});

//routes for Files
Route::controller(FileController::class)->prefix('files')->as('files.')->group(function () {
    Route::post('/', 'store')->name('store');
    Route::get('/', 'index')->name('index');
    Route::prefix('{file}')->group(function () {
        Route::get('/', 'show')->name('show');
    });
});

//routes for Mapping
Route::controller(MappingController::class)->prefix('entries')->as('entries.')->group(function () {
    Route::post('/mapping', 'store')->name('store');
});

//routes for Connect to DataBase
Route::controller(ConnectDataBaseController::class)->prefix('connections')->as('connections.')->group(function () {
    Route::post('/', 'downloadExternalTablesAsSqlFiles')->name('store');
    Route::post('/connect', 'connectToExternalDataBase')->name('connect');
});



