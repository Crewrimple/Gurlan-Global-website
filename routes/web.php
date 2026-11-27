<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContentBlockController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaAssetController;
use App\Http\Controllers\Admin\NewsPostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\AnalyticsConsentController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AuthController::class, 'create'])->middleware(['guest', 'secure-admin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'store'])->middleware(['guest', 'secure-admin', 'throttle:5,1'])->name('admin.authenticate');
Route::post('/admin/logout', [AuthController::class, 'destroy'])->middleware(['auth', 'secure-admin'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware(['secure-admin', 'auth', 'admin'])->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/content', [ContentBlockController::class, 'index'])->name('content.index');
    Route::put('/content', [ContentBlockController::class, 'update'])->name('content.update');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('news', NewsPostController::class)->except('show');
    Route::resource('team', TeamMemberController::class)->except('show');
    Route::resource('media', MediaAssetController::class)->only(['index', 'update']);
    Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{contactMessage}/read', [ContactMessageController::class, 'markRead'])->name('messages.read');
    Route::delete('/messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
});

Route::redirect('/', '/ru')->name('site.root');

Route::post('/analytics/consent', AnalyticsConsentController::class)
    ->middleware('throttle:20,1')
    ->name('site.analytics.consent');

Route::post('/{locale}/assistant', AssistantController::class)
    ->where('locale', 'ru|en|uz')
    ->middleware('throttle:12,1')
    ->name('site.assistant.store');

Route::post('/{locale}/contact', [SiteController::class, 'storeContact'])
    ->where('locale', 'ru|en|uz')
    ->middleware('throttle:6,1')
    ->name('site.contact.store');

Route::get('/{locale}/{page?}', [SiteController::class, 'show'])
    ->where([
        'locale' => 'ru|en|uz',
        'page' => 'about|production|products|contact|news',
    ])
    ->middleware('site-analytics')
    ->name('site.page');
