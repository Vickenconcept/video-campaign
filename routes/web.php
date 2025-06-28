<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ESPController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\Email\EmailCampaignController;
use App\Http\Controllers\Email\TrackingController;
use App\Http\Controllers\Email\EmailFolderController;
use App\Livewire\AllResponse;
use App\Livewire\CampaignComponent;
use App\Livewire\EspConnector;
use App\Livewire\FolderComponent;
use App\Livewire\FolderShowComponent;
use App\Livewire\ShowCampaign;
use App\Livewire\SingleResponse;
use Illuminate\Support\Facades\Route;





Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
    Route::view('register/success', 'auth.success')->name('register.success');


    Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
    });
    Route::controller(PasswordResetController::class)->group(function () {
        Route::get('forgot-password', 'index')->name('password.request');
        Route::post('forgot-password', 'store')->name('password.email');
        Route::get('/reset-password/{token}', 'reset')->name('password.reset');
        Route::post('/reset-password', 'update')->name('password.update');
    });
});

Route::get('c/{uuid}/', ShowCampaign::class)->name('campaign.view');
Route::get('R/{uuid}/', SingleResponse::class)->name('response.single');
Route::get('thankyou', function () {
    return 'thankyou';
})->name('thankyou');


Route::middleware(['auth'])->group(function () {
    Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/home', function () {
        return view('dashboard');
    })->name('home');

    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    // Mark all notifications as read
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    Route::view('profile', 'profile')->name('profile');
    Route::post('profile/name', [ProfileController::class, 'changeName'])->name('changeName');
    Route::post('profile/password', [ProfileController::class, 'changePassword'])->name('changePassword');
    Route::resource('reseller', ResellerController::class);
    Route::view('tutorial', 'tutorial')->name('tutorial');

    // Email Campaign Routes
    Route::prefix('email')->name('email.')->group(function () {
        Route::resource('folders', EmailFolderController::class);
        Route::resource('campaigns', EmailCampaignController::class);
        Route::get('campaigns/{campaign}/preview', [EmailCampaignController::class, 'preview'])->name('campaigns.preview');
        Route::get('campaigns/{campaign}/preview/iframe', [EmailCampaignController::class, 'previewIframe'])->name('campaigns.preview.iframe');
        Route::post('campaigns/{campaign}/send-now', [EmailCampaignController::class, 'sendNow'])->name('campaigns.send-now');
        
        // Import Routes
        Route::post('campaigns/import/video-campaigns', [EmailCampaignController::class, 'importFromVideoCampaigns'])->name('campaigns.import.video');
        Route::post('campaigns/import/excel', [EmailCampaignController::class, 'importFromExcel'])->name('campaigns.import.excel');
        
        // Template Routes
        Route::get('campaigns/{campaign}/templates', [EmailCampaignController::class, 'templates'])->name('campaigns.templates');
        Route::get('campaigns/{campaign}/templates/{template}/preview', [EmailCampaignController::class, 'templatePreview'])->name('campaigns.template.preview');
        Route::get('campaigns/{campaign}/templates/{template}/preview/iframe', [EmailCampaignController::class, 'templatePreviewIframe'])->name('campaigns.template.preview.iframe');
        Route::post('campaigns/{campaign}/templates/apply', [EmailCampaignController::class, 'applyTemplate'])->name('campaigns.template.apply');
        
        // Tracking Routes
        Route::get('tracking/open', [TrackingController::class, 'open'])->name('tracking.open');
        
        Route::get('tracking/click', [TrackingController::class, 'click'])->name('tracking.click');
    });

    Route::get('folder', FolderComponent::class)->name('folder.index');
    Route::get('folder/{uuid}', FolderShowComponent::class)->name('folder.show');

    Route::get('campaign/{uuid}', CampaignComponent::class)->name('campaign.show');
    Route::get('response/{user_token?}', AllResponse::class)->name('response.index');


    Route::get('connect/esp', EspConnector::class)->name('esp.connect');
    Route::post('mail-chip/connect', [ESPController::class, 'connectMailchimp'])->name('mail-chip.connect');
    Route::post('get-response/connect', [ESPController::class, 'connectGetRespones'])->name('get-response.connect');
    Route::post('convert-kit/connect', [ESPController::class, 'connectCOnvertKit'])->name('convert-kit.connect');

    Route::view('/support', 'support')->name('support.index');
});

// Tracking Routes (public)
Route::get('email/tracking/view', [TrackingController::class, 'view'])->name('email.tracking.view');
Route::post('email/tracking/reply', [\App\Http\Controllers\Email\TrackingController::class, 'reply'])->name('email.tracking.reply');
