<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    $response = \Illuminate\Support\Facades\Http::get('https://meme-api.com/gimme');
    $data = $response->json();
    $randomMemeHtml = '<img src="' . $data['url'] . '" alt="' . $data['title'] . '">';

    dd($randomMemeHtml);

});
