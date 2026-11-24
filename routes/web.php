<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ru')->name('site.root');

Route::get('/{locale}/{page?}', [SiteController::class, 'show'])
    ->where([
        'locale' => 'ru|en|uz',
        'page' => 'about|production|products|contact|news',
    ])
    ->name('site.page');
