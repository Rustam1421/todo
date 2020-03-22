<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'HomeController@search')->name('search');

Route::get('/home/admin', 'HomeController@adminPageView')->name('adminPage')->middleware('role:admin');



Route::get('/home/category/{category}', 'HomeController@index')->name('category');

Route::get('/home/category/{category}', 'HomeController@index')->name('home.category');


Route::post('/addTodo', 'HomeController@addTodo')->name('add');
Route::delete('/todoDelete/{todo}', 'HomeController@destroy')->name('deleteTodo');

Route::get('/admin/{id}', 'HomeController@deleteUser')->name('deleteUser');



Route::put('/todo/{id}', 'HomeController@update')->name('update');
