<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\WeatherObservationController;
use App\Http\Controllers\PublicUser\PublicWeatherObservationController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckIfAdmin;
use App\Http\Middleware\CheckIfActive;
use App\Http\Controllers\Admin\WeatherObservationManagementController;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/reports/filter', [WelcomeController::class, 'getFilteredReports'])->name('reports.filter');
Route::get('/observation/{observation}', [WelcomeController::class, 'getObservationDetails'])->name('observation.details');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Admin OTP Verification Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('otp/verify', [OtpController::class, 'showOtpForm'])->name('otp.form');
    Route::post('otp/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
});

// Dynamic Dropdown for Stations
Route::get('/stations/by-region', [StationController::class, 'getStationsByRegion'])->name('stations.by-region');

// Admin Routes
Route::middleware(['auth', CheckIfAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Admin Profile Management
    Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/image', [AdminProfileController::class, 'updateImage'])->name('profile.updateImage');
    Route::delete('profile/image', [AdminProfileController::class, 'removeImage'])->name('profile.removeImage');
    
    // User Management
    Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::match(['post', 'patch'], 'users/{user}/approve', [UserManagementController::class, 'approve'])->name('users.approve');
    Route::delete('users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('users/stations/by-region', [UserManagementController::class, 'getStationsByRegion'])->name('users.stations.by-region');
    
    // Weather Observation Management
    Route::get('weather-observations', [WeatherObservationManagementController::class, 'index'])->name('weather-observations.index');
    Route::get('weather-observations/{observation}', [WeatherObservationManagementController::class, 'show'])->name('weather-observations.show');
    Route::patch('weather-observations/{observation}/approve', [WeatherObservationManagementController::class, 'approve'])->name('weather-observations.approve');
    Route::patch('weather-observations/{observation}/archive', [WeatherObservationManagementController::class, 'archive'])->name('weather-observations.archive');
    Route::patch('weather-observations/{observation}/flag', [WeatherObservationManagementController::class, 'flag'])->name('weather-observations.flag');
});

// User Routes
Route::middleware(['auth', CheckIfActive::class])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/image', [ProfileController::class, 'updateImage'])->name('profile.updateImage');
    Route::delete('profile/image', [ProfileController::class, 'removeImage'])->name('profile.removeImage');

    // Password Management
    Route::get('password/change', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change.form');
    Route::post('password/change', [ChangePasswordController::class, 'changePassword'])->name('password.change');

    // Weather Observations
    Route::get('weather-observation/create', [WeatherObservationController::class, 'create'])->name('weather.observation.create');
    Route::post('weather-observation', [WeatherObservationController::class, 'store'])->name('weather.observation.store');
    Route::get('weather-observation/{observation}', [WeatherObservationController::class, 'show'])->name('weather.observation.show');
});

// Public Weather Observation Routes
Route::prefix('public')->name('public.')->group(function () {
    Route::get('weather-observation', [PublicWeatherObservationController::class, 'create'])->name('weather.observation.create');
    Route::post('weather-observation', [PublicWeatherObservationController::class, 'store'])->name('weather.observation.store');
    Route::get('weather-observation/thank-you', [PublicWeatherObservationController::class, 'thankYou'])->name('weather.observation.thank-you');
});

// Redirect after login based on user role
Route::get('/home', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/weather-observations', [WeatherObservationController::class, 'index'])->name('weather.observations');
    Route::get('/weather-observation/create', [WeatherObservationController::class, 'create'])->name('weather.observation.create');
    Route::post('/weather-observation', [WeatherObservationController::class, 'store'])->name('weather.observation.store');
});