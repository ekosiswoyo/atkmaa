<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

// ============================ DATA SATUAN ==============================================
Route::get('/satuan', 'SatuanController@index');
Route::post('/satuan', 'SatuanController@insert');
Route::delete('/satuan/destroy/{id}',['uses' => 'SatuanController@destroy']);
Route::get('/satuan/{id}/edit', 'SatuanController@edit');
Route::post('/satuan/{id}', 'SatuanController@update');


// ============================ DATA BARANG ==============================================
Route::get('/barang', 'BarangController@index');
Route::post('/barang', 'BarangController@insert');
Route::delete('/barang/destroy/{id}',['uses' => 'BarangController@destroy']);
Route::get('/barang/{id}/edit', 'BarangController@edit');
Route::post('/barang/{id}', 'BarangController@update');


// ============================ DATA GUDANG ==============================================
Route::get('/gudang', 'GudangController@index');
Route::post('/gudang', 'GudangController@insert');
Route::delete('/gudang/destroy/{id}',['uses' => 'GudangController@destroy']);
Route::get('/gudang/{id}/edit', 'GudangController@edit');
Route::post('/gudang/{id}', 'GudangController@update');


// ============================ DATA TRANSAKSI TAMBAH STOK GA==============================================
Route::get('/trans', 'TransController@index');
// Route::get('/trans/{id}', 'TransController@all');

Route::post('/trans/copyall', 'TransController@copyall');
Route::get('/trans/{id}/edit', 'TransController@edit');
Route::post('/trans/{id}', 'TransController@update');

Route::get('/transcab/{id}/editcab', 'TransController@editcab');
Route::post('/transcab/{id}', 'TransController@updatecab');



// ============================ DATA TRANSAKSI TAMBAH STOK CAB ==============================================
Route::get('/transcab', 'TransController@indexcab');
// Route::get('/trans/{id}', 'TransController@all');
Route::get('/trans/{id}/edit', 'TransController@edit');
Route::post('/trans/{id}', 'TransController@update');
Route::post('/trans/copyall', 'TransController@copyall');