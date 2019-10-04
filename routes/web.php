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
Route::get('/profile','HomeController@profile');
Route::post('/profile/{id}','HomeController@updateprofile');



// ============================ DATA SATUAN ==============================================
Route::get('/satuan', 'SatuanController@index');
Route::post('/satuan', 'SatuanController@insert');
Route::delete('/satuan/destroy/{id}',['uses' => 'SatuanController@destroy']);
Route::get('/satuan/{id}/edit', 'SatuanController@edit');
Route::post('/satuan/{id}', 'SatuanController@update');


// ============================ DATA BARANG ==============================================
Route::get('/barang', 'BarangController@index');
Route::get('/barangs', 'BarangController@indexs');
Route::get('/barangs/{id}', 'BarangController@details');
Route::post('/barang', 'BarangController@insert');
Route::delete('/barang/destroy/{id}',['uses' => 'BarangController@destroy']);
Route::get('/barang/{id}/edit', 'BarangController@edit');
Route::post('/barang/{id}', 'BarangController@update');
Route::post('/barangs/{id}', 'BarangController@insertcart');
Route::get('/cart', 'BarangController@carts');
Route::delete('/cart/destroy/{id}',['uses' => 'BarangController@destroycart']);
Route::get('/cart/{id}/edit', 'BarangController@editcart');

Route::get('/datacart', 'BarangController@datacart');
Route::post('/datacart/update', 'BarangController@datacartupdate');
Route::post('/confirms', 'BarangController@confirms');

Route::post('/confirmsorder', 'BarangController@confirmsorder');
Route::post('/cart/{id}', 'BarangController@updatecart');
Route::get('/cartall', 'BarangController@cartsall');

Route::get('/order-list', 'BarangController@orderlist');
Route::get('/order-list/{id}', 'BarangController@detailorderlist');
Route::get('/order/{status}/{date}/{id}', 'BarangController@detailorderpic');
Route::post('/order/update', 'BarangController@updateorder');

Route::get('/stockcab', 'BarangController@stockcab');
Route::get('/addstockbarang', 'BarangController@addstockbarang');
Route::get('/search','BarangController@search');

// ============================ DATA GUDANG ==============================================
Route::get('/gudang', 'GudangController@index');
Route::post('/gudang', 'GudangController@insert');
Route::delete('/gudang/destroy/{id}',['uses' => 'GudangController@destroy']);
Route::get('/gudang/{id}/edit', 'GudangController@edit');
Route::post('/gudang/{id}', 'GudangController@update');
Route::get('/data', 'GudangController@databarang');
Route::get('/data/{id}', 'GudangController@datacabang');
Route::post('/addtogudang', 'GudangController@addtogudang');
Route::get('/data/print/{id}', 'GudangController@makePDF');
Route::get('/datas/prints', 'GudangController@PDFAll');
Route::get('/lapbulstok', 'GudangController@lapbulstok');
Route::post('/lapbulstok', 'GudangController@lapbulstokpost');
Route::get('/lappemakaian', 'GudangController@lappemakaian');
Route::post('/lappemakaian', 'GudangController@lappemakaianpost');
Route::get('/cetaklapstokmasuk', 'GudangController@stokmasukPDF');
Route::delete('/delstokbarang/destroy/{id}',['uses' => 'GudangController@delstokbarang']);




// ============================ DATA TRANSAKSI TAMBAH STOK GA==============================================
Route::get('/trans', 'TransController@index');
Route::get('/addstock', 'TransController@addstock');
Route::post('/trans/copystock', 'TransController@copystock');
Route::post('/trans/stock', 'TransController@stock');
Route::get('/transaksiall', 'TransController@transaksiall');
// Route::get('/trans/{id}', 'TransController@all');

Route::post('/trans/copyall', 'TransController@copyall');
Route::get('/trans/{id}/edit', 'TransController@edit');
Route::post('/trans/{id}', 'TransController@update');

Route::get('/transcab/{id}/editcab', 'TransController@editcab');
Route::post('/transcab/{id}', 'TransController@updatecab');

Route::get('/usecab/{id}/usecab', 'TransController@usecab');
Route::post('/usecab/{id}', 'TransController@updateuse');

Route::get('/cabang/{id}/use', 'TransController@cabanguse');
Route::post('/cabang/{id}', 'TransController@cabangupdate');

Route::get('/cetak',  'TransController@makePDF');




// ============================ DATA TRANSAKSI TAMBAH STOK CAB ==============================================
Route::get('/transcab', 'TransController@indexcab');
// Route::get('/trans/{id}', 'TransController@all');
Route::get('/trans/{id}/edit', 'TransController@edit');
Route::post('/trans/{id}', 'TransController@update');
Route::post('/trans/copyall', 'TransController@copyall');