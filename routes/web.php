<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentProviders\PaddleController;
use App\Http\Controllers\RoadmapController;
use App\Services\SessionService;
use App\Services\TenantCreationService;
use App\Services\UserDashboardService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
| If you want the URL to be added to the sitemap, add a "sitemapped" middleware to the route (it has to GET route)
|
*/

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('sitemapped');

Route::get('/dashboard', function (UserDashboardService $dashboardService) {
    return redirect($dashboardService->getUserDashboardUrl(Auth::user()));
})->name('dashboard')->middleware('auth');

Auth::routes();

Route::get('/plan/start', function (TenantCreationService $tenantCreationService, SessionService $sessionService) {
    if (!auth()->check()) {
        $sessionService->setCreateTenantForFreePlanUser(true);
    } else {
        $tenantCreationService->createTenantForFreePlanUser(auth()->user());
    }

    return redirect()->route('register');
})->name('plan.start');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    $user = $request->user();
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('registration.thank-you');
    }

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/phone/verify', function () {
    return view('verify.sms-verification');
})->name('user.phone-verify')
    ->middleware('auth');

Route::get('/phone/verified', function () {
    return view('verify.sms-verification-success');
})->name('user.phone-verified')
    ->middleware('auth');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/registration/thank-you', function () {
    return view('auth.thank-you');
})->middleware('auth')->name('registration.thank-you');

Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect'])
    ->where('provider', 'google|github|facebook|twitter-oauth-2|linkedin-openid|bitbucket|gitlab')
    ->name('auth.oauth.redirect');

Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback'])
    ->where('provider', 'google|github|facebook|twitter-oauth-2|linkedin-openid|bitbucket|gitlab')
    ->name('auth.oauth.callback');

Route::get('/checkout/plan/{planSlug}', [
    App\Http\Controllers\SubscriptionCheckoutController::class,
    'subscriptionCheckout',
])->name('checkout.subscription');

Route::get('/checkout/convert-subscription/{subscriptionUuid}', [
    App\Http\Controllers\SubscriptionCheckoutController::class,
    'convertLocalSubscriptionCheckout',
])->name('checkout.convert-local-subscription');

Route::get('/already-subscribed', function () {
    return view('checkout.already-subscribed');
})->name('checkout.subscription.already-subscribed');

Route::get('/checkout/subscription/success', [
    App\Http\Controllers\SubscriptionCheckoutController::class,
    'subscriptionCheckoutSuccess',
])->name('checkout.subscription.success')->middleware('auth');

Route::get('/checkout/convert-subscription-success', [
    App\Http\Controllers\SubscriptionCheckoutController::class,
    'convertLocalSubscriptionCheckoutSuccess',
])->name('checkout.convert-local-subscription.success')->middleware('auth');

Route::get('/payment-provider/paddle/payment-link', [
    PaddleController::class,
    'paymentLink',
])->name('payment-link.paddle');

Route::get('/subscription/{subscriptionUuid}/change-plan/{planSlug}/tenant/{tenantUuid}', [
    App\Http\Controllers\SubscriptionController::class,
    'changePlan',
])->name('subscription.change-plan')->middleware('auth');

Route::post('/subscription/{subscriptionUuid}/change-plan/{planSlug}/tenant/{tenantUuid}', [
    App\Http\Controllers\SubscriptionController::class,
    'changePlan',
])->name('subscription.change-plan.post')->middleware('auth');

Route::get('/subscription/change-plan-thank-you', [
    App\Http\Controllers\SubscriptionController::class,
    'success',
])->name('subscription.change-plan.thank-you')->middleware('auth');

// blog
Route::controller(BlogController::class)
    ->prefix('/blog')
    ->group(function () {
        Route::get('/', 'all')->name('blog')->middleware('sitemapped');
        Route::get('/category/{slug}', 'category')->name('blog.category');
        Route::get('/{slug}', 'view')->name('blog.view');
    });

Route::get('/terms-of-service', function () {
    return view('pages.terms-of-service');
})->name('terms-of-service')->middleware('sitemapped');

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy')->middleware('sitemapped');

// Product checkout routes

Route::get('/buy/product/{productSlug}/{quantity?}', [
    App\Http\Controllers\ProductCheckoutController::class,
    'addToCart',
])->name('buy.product');

Route::get('/cart/clear', [
    App\Http\Controllers\ProductCheckoutController::class,
    'clearCart',
])->name('cart.clear');

Route::get('/checkout/product', [
    App\Http\Controllers\ProductCheckoutController::class,
    'productCheckout',
])->name('checkout.product');

Route::get('/checkout/product/success', [
    App\Http\Controllers\ProductCheckoutController::class,
    'productCheckoutSuccess',
])->name('checkout.product.success')->middleware('auth');

// roadmap

Route::controller(RoadmapController::class)
    ->prefix('/roadmap')
    ->group(function () {
        Route::get('/', 'index')->name('roadmap');
        Route::get('/i/{itemSlug}', 'viewItem')->name('roadmap.viewItem');
        Route::get('/suggest', 'suggest')->name('roadmap.suggest')->middleware('auth');
    });

// Invitations

Route::get('/invitations', [
    App\Http\Controllers\InvitationController::class,
    'index',
])->name('invitations')->middleware('auth');

// Invoice

Route::controller(InvoiceController::class)
    ->prefix('/invoice')
    ->group(function () {
        Route::get('/generate/{transactionUuid}', 'generate')->name('invoice.generate');
        Route::get('/preview', 'preview')->name('invoice.preview');
    });

// Functional Location Modal Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/am-functional-locations/{record}/view-modal', function ($record) {
        $location = \App\Models\AmFunctionalLocation::with(['parentLocation', 'childLocations', 'functionalLocationType', 'functionalLocationLifecycleState'])->findOrFail($record);
        return view('filament.dashboard.resources.am-functional-location.modals.view-modal', [
            'record' => $location
        ]);
    })->name('am-functional-location.view-modal');

    Route::get('/dashboard/am-functional-locations/{record}/edit-modal', function ($record) {
        $location = \App\Models\AmFunctionalLocation::findOrFail($record);
        return view('filament.dashboard.resources.am-functional-location.modals.edit-modal', [
            'record' => $location
        ]);
    })->name('am-functional-location.edit-modal');

    Route::post('/dashboard/am-functional-locations/{record}/update-modal', function (Illuminate\Http\Request $request, $record) {
        $location = \App\Models\AmFunctionalLocation::findOrFail($record);

        $validated = $request->validate([
            'functional_location' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'installation_date' => 'nullable|date',
            'am_parent_functional_location_id' => 'nullable|exists:am_functional_locations,id',
            'superior_functional_location' => 'nullable|string|max:255',
            'am_functional_location_type_id' => 'nullable|exists:am_functional_location_types,id',
            'am_functional_location_lifecycle_state_id' => 'nullable|exists:am_functional_location_lifecycle_states,id',
            'work_center' => 'nullable|string|max:255',
            'company_code' => 'nullable|string|max:255',
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');

        $location->update($validated);

        return response()->json(['success' => true, 'message' => 'Functional location updated successfully']);
    })->name('am-functional-location.update-modal');
});
