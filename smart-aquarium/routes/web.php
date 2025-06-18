<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Services\FirebaseService;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

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

// Welcome page route
Route::get('/', [HomeController::class, 'index'])->name('welcome');

use App\Http\Controllers\FirebaseAuthController;

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('firebase-login', [FirebaseAuthController::class, 'handle'])->name('firebase.login');
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes (authenticated users)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/control', [DashboardController::class, 'control'])->name('control');
    
    // Views
    Route::middleware('auth')->group(function () {
        Route::get('/history', function () {
            $user = auth()->user();
            if ($user && $user->role === 'admin') {
                return view('history');
            } else {
                return view('history-user');
            }
        })->name('history');

        Route::get('/controls', function () {
            $user = auth()->user();
            if ($user && $user->role === 'admin') {
                return view('controls');
            } else {
                return view('controls-user');
            }
        })->name('controls');

        Route::get('/schedules', [DashboardController::class, 'schedules'])->name('schedules');
    });
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update-image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', \App\Http\Middleware\CheckRole::class . ':admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // User management routes
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

// Sensor Data
Route::get('/sensor-data', [DashboardController::class, 'sensorData'])->name('sensor.data');

// Firebase Test Route
Route::get('/firebase-test', function (FirebaseService $firebase) {
    $data = $firebase->getSensorData();
    return response()->json($data);
});

// Temporary routes for admin management
Route::get('/check-admin', function() {
    $admin = \App\Models\User::where('email', 'admin@admin.com')->first();
    if ($admin) {
        return response()->json([
            'exists' => true,
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => $admin->role
        ]);
    }
    return response()->json(['exists' => false]);
});

Route::get('/create-admin', function() {
    try {
        \App\Models\User::where('email', 'admin@admin.com')->delete();
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Admin user created successfully',
            'user' => [
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => $admin->role
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error creating admin user',
            'error' => $e->getMessage()
        ], 500);
    }
});

// Disable registration
Route::get('/register', function () {
    abort(404);
});
