<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\FinalFinishController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemPurchaseController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailService;
use App\Http\Controllers\OutsourceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductItemController;



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

Route::middleware(['auth'])->group(function() {
    Route::get('/', function () { return view('home');});
});
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);
    }
    return back();
})->name('language.switch');

Route::post('/projects/upload', [ProjectController::class, 'uploadFile'])->name('projects.upload');
Route::post('/projects/{project}/approval', [ProjectController::class, 'updateApproval'])->name('projects.approval');
Auth::routes();

Auth::routes(['register' => true]);

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/export/{id}', [ProjectController::class, 'exportProject'])->name('projects.export');
    Route::get('/email/{id}', [ProjectController::class, 'emailProject'])->name('projects.email');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/projects/{project}/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::delete('materials/{id}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::post('/projects/{project}/final-finish', [FinalFinishController::class, 'store'])->name('final-finishes.store');

    Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
    

    // Admin routes (using Spatie permissions)
    Route::middleware(['auth'])->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/admin/dashboard', function () {
                return view('admin.dashboard');
            })->name('admin.dashboard');
        });
        
        // Manager routes
        Route::middleware(['role:manager'])->group(function () {
            Route::get('/manager/dashboard', function () {
                return view('manager.dashboard');
            })->name('manager.dashboard');
        });
        
        // Technical routes
        Route::middleware(['role:technical'])->group(function () {
            Route::get('/technical/dashboard', function () {
                return view('technical.dashboard');
            })->name('technical.dashboard');
        });
    });
    
    // Client routes
    Route::middleware(['auth'])->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::resource('clients', ClientController::class);
    });

    // Items routes
    Route::resource('items', ItemController::class);
    Route::get('/items/data', [ItemController::class, 'data'])->name('items.data');
    Route::get('items/{item}/purchases/create', [ItemPurchaseController::class, 'create'])->name('item_purchases.create');
    Route::post('items/{item}/purchases', [ItemPurchaseController::class, 'store'])->name('item_purchases.store');
    Route::post('items/{item}/purchases', [ItemPurchaseController::class, 'store'])->name('item_purchases.store');
    Route::post('items/{item}/consume', [ItemPurchaseController::class, 'consume'])->name('item_purchases.consume');

    // outsources routes
    Route::resource('outsources', OutsourceController::class);

    // product items routes
    Route::prefix('products/{product}')->group(function () {
        Route::get('items', [ProductItemController::class, 'index'])->name('product.items.index');
        Route::post('items', [ProductItemController::class, 'store'])->name('product.items.store');
        Route::post('items/{item}', [ProductItemController::class, 'update'])->name('product.items.update');
        Route::delete('items/{item_id}', [ProductItemController::class, 'destroy'])->name('product.items.destroy');
    });

    // products routes
    Route::resource('products', ProductController::class);
    Route::resource('outsources', OutsourceController::class);

    Route::post('projects/{project}/outsources', [OutsourceController::class, 'store'])->name('outsources.store');
    Route::delete('outsources/{outsource}', [OutsourceController::class, 'destroy'])->name('outsources.destroy');
    Route::post('/general-note', [OutsourceController::class, 'general_note'])->name('general-note.store');


    // Email Configuration
        Route::get('/config', [EmailController::class, 'config'])->name('email.config');
        Route::post('/config', [EmailController::class, 'updateConfig'])->name('email.config.update');
        
        Route::get('/send', [EmailController::class, 'sendForm'])->name('email.send');
        Route::post('/send', [EmailController::class, 'sendEmail'])->name('email.send.submit');
        Route::get('/email', [EmailController::class, 'create'])->name('email.form');
        Route::post('/email/send', [EmailController::class, 'send'])->name('email.send');
        Route::post('/email/project', [ProjectController::class, 'sendProjectEmail'])->name('email.ProjectSend');
        Route::get('/logs', [EmailController::class, 'logs'])->name('email.logs');
});


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
});
