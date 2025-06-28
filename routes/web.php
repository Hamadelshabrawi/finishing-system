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
use App\Http\Controllers\ProductNoteController;
use App\Http\Controllers\ProductFileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductItemConsumptionController;
use App\Http\Controllers\SupplierController;

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
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/timeline-data', [HomeController::class, 'getTimelineData']);
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('my-tasks');

    // Task Routes
    Route::prefix('projects/{project}')->group(function () {
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });
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

// Product routes
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Authenticated routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/export/{id}/{lang?}', [ProjectController::class, 'exportProject'])->name('projects.export');

        // Profile routes
        Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/{user}', [ProfileController::class, 'store'])->name('profile.store');
        Route::delete('/profile/{user}', [ProfileController::class, 'destroy'])->name('profile.destroy');

            // product items routes
            Route::prefix('products/{product}')->group(function () {
                Route::get('items', [ProductItemController::class, 'index'])->name('product.items.index');
                Route::post('items', [ProductItemController::class, 'store'])->name('product.items.store');
                Route::put('items/{item}', [ProductItemController::class, 'update'])->name('product.items.update');
                Route::delete('items/{item}', [ProductItemController::class, 'destroy'])->name('product.items.destroy');

                // product notes routes
                Route::get('note', [ProductNoteController::class, 'show'])->name('product.note.show');
                Route::post('note', [ProductNoteController::class, 'store'])->name('product.note.store');
                Route::put('note', [ProductNoteController::class, 'update'])->name('product.note.update');
                Route::delete('note', [ProductNoteController::class, 'destroy'])->name('product.note.destroy');

                // product files routes
                Route::post('files', [ProductFileController::class, 'store'])->name('products.files.store');
                Route::delete('files/{file}', [ProductFileController::class, 'destroy'])->name('products.files.destroy');
                Route::get('files/{file}', [ProductFileController::class, 'show'])->name('products.files.show');
                Route::get('files/{file}/download', [ProductFileController::class, 'download'])->name('products.files.download');

                // final finishes routes
                Route::get('final-finish', [FinalFinishController::class, 'show'])->name('products.final-finish.show');
                Route::get('final-finish/create', [FinalFinishController::class, 'create'])->name('products.final-finish.create');
                Route::post('final-finish/create', [FinalFinishController::class, 'store'])->name('products.final-finish.store');
                Route::get('final-finish/edit', [FinalFinishController::class, 'edit'])->name('products.final-finish.edit');
                Route::put('final-finish/edit', [FinalFinishController::class, 'update'])->name('products.final-finish.update');
                Route::delete('final-finish', [FinalFinishController::class, 'destroy'])->name('products.final-finish.destroy');
            });
            Route::put('final-finish/edit', [FinalFinishController::class, 'update'])->name('products.final-finish.update');
            Route::delete('final-finish', [FinalFinishController::class, 'destroy'])->name('products.final-finish.destroy');

        // Admin routes (using Spatie permissions)
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

        // Client routes
        Route::resource('projects', ProjectController::class);
        Route::resource('clients', ClientController::class);
        Route::get('clients/search', [ClientController::class, 'search'])->name('clients.search');

        // Items routes
        Route::resource('items', ItemController::class);
        Route::get('/items/data', [ItemController::class, 'data'])->name('items.data');
        Route::get('items/{item}/purchases/create', [ItemPurchaseController::class, 'create'])->name('item_purchases.create');
        Route::get('items/{item}/purchases/{purchase}/edit', [ItemPurchaseController::class, 'edit'])->name('item_purchases.edit');
        Route::post('items/{item}/purchases', [ItemPurchaseController::class, 'store'])->name('item_purchases.store');
        Route::put('items/{item}/purchases/{purchase}', [ItemPurchaseController::class, 'update'])->name('item_purchases.update');
        Route::delete('items/{item}/purchases/{purchase}', [ItemPurchaseController::class, 'destroy'])->name('item_purchases.destroy');
        Route::post('items/{item}/consume', [ItemPurchaseController::class, 'consume'])->name('item_purchases.consume');

        // Supplier routes
        Route::resource('suppliers', SupplierController::class);
        Route::get('suppliers/{supplier}/outsources', [SupplierController::class, 'supplierOutsources'])->name('suppliers.outsources');

        // outsources routes
        Route::get('outsources/{product}', [OutsourceController::class, 'index'])->name('product.outsources.index');
        Route::post('outsources', [OutsourceController::class, 'store'])->name('product.outsources.store');
        Route::post('outsources/{outsource}', [OutsourceController::class, 'update'])->name('product.outsources.update');
        Route::delete('outsources/{outsource}', [OutsourceController::class, 'destroy'])->name('product.outsources.destroy');
        Route::get('outsources/create', [OutsourceController::class, 'create'])->name('product.outsources.create');
        Route::get('outsources/{outsource}/edit', [OutsourceController::class, 'edit'])->name('product.outsources.edit');

        Route::get('purchases/create', [ItemPurchaseController::class, 'create'])->name('item.purchases.create');
        Route::post('purchases', [ItemPurchaseController::class, 'store'])->name('item.purchases.store');
        Route::get('purchases/{purchase}/edit', [ItemPurchaseController::class, 'edit'])->name('item.purchases.edit');
        Route::put('purchases/{purchase}', [ItemPurchaseController::class, 'update'])->name('item.purchases.update');
        Route::delete('purchases/{purchase}', [ItemPurchaseController::class, 'destroy'])->name('item.purchases.destroy');
        Route::post('purchases/consume', [ItemPurchaseController::class, 'consume'])->name('item.purchases.consume');

        // products routes
        Route::resource('products', ProductController::class);
        Route::prefix('products/{product}')->group(function () {
            Route::get('items/consume', [ProductItemConsumptionController::class, 'create'])->name('products.items.consume.create');
            Route::post('items/consume', [ProductItemConsumptionController::class, 'store'])->name('products.items.consume.store');
        });

        Route::get('/config', [EmailController::class, 'config'])->name('email.config');
        Route::post('/config', [EmailController::class, 'updateConfig'])->name('email.config.update');
        Route::get('/send', [EmailController::class, 'sendForm'])->name('email.send');
        Route::post('/send', [EmailController::class, 'sendEmail'])->name('email.send.submit');
        Route::get('/email', [EmailController::class, 'create'])->name('email.form');
        Route::post('/email/send', [EmailController::class, 'send'])->name('email.send');
        Route::post('/email/project', [ProjectController::class, 'sendProjectEmail'])->name('projects.email');
        Route::get('/logs', [EmailController::class, 'logs'])->name('email.logs');
    });

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
});
