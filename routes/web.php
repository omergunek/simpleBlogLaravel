<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
  Route::get('giris','App\Http\Controllers\Back\AuthController@login')->name('login');
  Route::post('giris','App\Http\Controllers\Back\AuthController@loginPost')->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
	Route::get('panel','App\Http\Controllers\Back\Dashboard@index')->name('dashboard');

	Route::get('makaleler/silinenler','App\Http\Controllers\Back\ArticleController@trashed')->name('trashed.article');
	Route::get('/switch','App\Http\Controllers\Back\ArticleController@switch')->name('switch');
	Route::get('harddeletearticle/{id}','App\Http\Controllers\Back\ArticleController@hardDelete')->name('hard.delete.article');

	Route::get('/recoverarticle/{id}','App\Http\Controllers\Back\ArticleController@recover')->name('recover.article');

	Route::get('/kategoriler','App\Http\Controllers\Back\CategoryController@index')->name('category.index');

	Route::post('/kategoriler/create','App\Http\Controllers\Back\CategoryController@create')->name('category.create');

	Route::post('/kategoriler/update','App\Http\Controllers\Back\CategoryController@update')->name('category.update');

	Route::post('/kategoriler/delete','App\Http\Controllers\Back\CategoryController@delete')->name('category.delete');

	Route::get('/kategori/status','App\Http\Controllers\Back\CategoryController@switch')->name('category.switch');

	Route::get('/kategori/getData','App\Http\Controllers\Back\CategoryController@getData')->name('category.getdata');

	Route::get('cikis','App\Http\Controllers\Back\AuthController@logout')->name('logout');
	
});
Route::resource('admin/makaleler','App\Http\Controllers\Back\ArticleController')->middleware('isAdmin');

Route::get('admin/deletearticle/{id}','App\Http\Controllers\Back\ArticleController@delete')->name('delete.article');
Route::get('/','App\Http\Controllers\Front\Homepage@index')->name('homepage');
Route::get('sayfa','App\Http\Controllers\Front\Homepage@index');
Route::get('/kategori/{category}','App\Http\Controllers\Front\Homepage@category')->name('category');
Route::get('/blog/{slug}','App\Http\Controllers\Front\Homepage@single')->name('single');