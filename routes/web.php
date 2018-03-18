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

Route::resources([
    'posts' => 'PostController'
]);

Route::get('/{year?}/{month?}/{day?}', function () {

    $posts = \App\Post::where('template_id', 1)->orderBy('date', 'desc');
    $all = clone $posts;
    if (request()->year) {
        $posts->where(\DB::raw('DATE_FORMAT(date, "%Y")'), request()->year);
    }
    if (request()->month) {
        $posts->where(\DB::raw('DATE_FORMAT(date, "%m")'), request()->month);
    }
    if (request()->day) {
        $posts->where(\DB::raw('DATE_FORMAT(date, "%d")'), request()->day);
    }
    if (request()->ajax()) {
        return $posts->paginate(20);;
    } else {
        return view('welcome')
            ->with(['dates' => $all])
            ->with(['posts' => $posts->paginate(20)]);
    }
})->name('welcome');
