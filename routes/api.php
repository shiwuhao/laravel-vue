<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//todo list
Route::get('/todos', function(){
   return \App\Todo::all();
})->middleware('api', 'cors');

Route::get('/todo/{id}', function($id){
    return \App\Todo::find($id);
})->middleware('api', 'cors');

// todo create
Route::post('/todo/create', function(Request $request){
    $data = ['body' => $request->body, 'computed' => 0];
    $todo = \App\Todo::create($data);
    return $todo;
})->middleware('api', 'cors');

Route::patch('/todo/{id}/completed', function($id){
   $todo = \App\Todo::find($id);
   $todo->completed = (int)!$todo->completed;
   $todo->save();
   return $todo;
})->middleware('api', 'cors');

Route::delete('/todo/{id}', function($id){
    $todo = \App\Todo::destroy($id);
    return $todo;
})->middleware('api', 'cors');

