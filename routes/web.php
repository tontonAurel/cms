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

Route::get('/', function () {
    $posts = \App\Post::where('template_id', 1)->orderBy('date', 'desc')->paginate(1);
    if (request()->ajax()) {
        return response()->json([
            'html' => view('posts')->with(['posts' => $posts])->render(),
            'nextUrl' => $posts->nextPageUrl()
        ]);
    } else {
        return view('welcome')->with(['posts' => $posts]);
    }
});




Route::resources([
    'posts' => 'PostController'
]);