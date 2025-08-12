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
use App\Http\Controllers\VideoPage\VideoPageController;
use App\Livewire\AllResponse;
use App\Livewire\CampaignComponent;
use App\Livewire\EspConnector;
use App\Livewire\FolderComponent;
use App\Livewire\FolderShowComponent;
use App\Livewire\ShowCampaign;
use App\Livewire\SingleResponse;
use Illuminate\Support\Facades\Route;

// --- AYRSHARE SERVICE TEST ROUTES (for development/testing only) ---
use App\Services\AyrshareService;

// Route::prefix('ayrshare-test')->group(function () {
    // Create a profile
    Route::get('create-profile', function (AyrshareService $ayrshare) {
        $title = 'TestProfile_' . uniqid();
        $result = $ayrshare->createProfile($title);
        return response()->json($result);
    });

    // Generate JWT linking URL (requires profileKey param)
    Route::get('generate-jwt', function (AyrshareService $ayrshare) {
        $profileKey = request('profileKey');
        $result = $ayrshare->generateJwtUrl($profileKey);
        return response()->json($result);
    });

    // List all profiles
    Route::get('list-profiles', function (AyrshareService $ayrshare) {
        $result = $ayrshare->listProfiles();
        return response()->json($result);
    });

    // List connected social accounts for a profile (requires profileKey param)
    Route::get('profile-socials', function (AyrshareService $ayrshare) {
        $profileKey = request('profileKey');
        $result = $ayrshare->getProfileSocialAccounts($profileKey);
        return response()->json($result);
    });

    // Post to social (requires profileKey param)
    Route::post('post', function (AyrshareService $ayrshare) {
        $profileKey = request('profileKey');
        $body = [
            'post' => 'Test post from AyrshareService',
            'platforms' => ['twitter'], // Change to your connected platform
            // 'mediaUrls' => ['https://example.com/video.mp4'],
        ];
        $result = $ayrshare->postToSocial($profileKey, $body);
        return response()->json($result);
    });

    // Delete a post (requires profileKey and postId param)
    Route::delete('delete-post', function (AyrshareService $ayrshare) {
        $profileKey = request('profileKey');
        $postId = request('postId');
        $result = $ayrshare->deletePost($profileKey, $postId);
        return response()->json($result);
    });

    // Get post status (requires profileKey and postId param)
    Route::get('post-status', function (AyrshareService $ayrshare) {
        $profileKey = request('profileKey');
        $postId = request('postId');
        $result = $ayrshare->getPostStatus($profileKey, $postId);
        return response()->json($result);
    });

    // Unlink a social account (requires profileKey and platform param)
    Route::delete('unlink-social', function (AyrshareService $ayrshare) {
        $profileKey = request('profileKey');
        $platform = request('platform');
        $result = $ayrshare->unlinkSocialAccount($profileKey, $platform);
        return response()->json($result);
    });

    // Delete a profile (requires profileKey and title param)
    Route::delete('delete-profile', function (AyrshareService $ayrshare) {
        $profileKey = request('profileKey');
        $title = request('title');
        $result = $ayrshare->deleteProfile($profileKey, $title);
        return response()->json($result);
    });
// });
// --- END AYRSHARE SERVICE TEST ROUTES ---


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




    Route::prefix('video-page')->name('video-page.')->group(function () {
        Route::resource('campaigns', VideoPageController::class);
        Route::get('campaigns/{campaign}/preview', [VideoPageController::class, 'preview'])->name('campaigns.preview');
        Route::get('campaigns/{campaign}/preview/iframe', [VideoPageController::class, 'previewIframe'])->name('campaigns.preview.iframe');
        Route::post('campaigns/{campaign}/send-now', [VideoPageController::class, 'sendNow'])->name('campaigns.send-now');
        
        // Import Routes
        Route::post('campaigns/import/video-campaigns', [VideoPageController::class, 'importFromVideoCampaigns'])->name('campaigns.import.video');
        Route::post('campaigns/import/excel', [VideoPageController::class, 'importFromExcel'])->name('campaigns.import.excel');
        
        // Template Routes
        Route::get('campaigns/{campaign}/templates', [VideoPageController::class, 'templates'])->name('campaigns.templates');

    });
});

// Tracking Routes (public)
Route::get('email/tracking/view', [TrackingController::class, 'view'])->name('email.tracking.view');
Route::post('email/tracking/reply', [\App\Http\Controllers\Email\TrackingController::class, 'reply'])->name('email.tracking.reply');

Route::get('/email/campaigns/{campaign}/embed', [\App\Http\Controllers\Email\EmailCampaignController::class, 'embed'])->name('email.campaigns.embed');

