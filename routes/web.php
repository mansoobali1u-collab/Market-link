<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MarketController as AdminMarketController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\FavoriteController as CustomerFavoriteController;
use App\Http\Controllers\Customer\MarketController as CustomerMarketController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Farmer\DashboardController as FarmerDashboardController;
use App\Http\Controllers\Farmer\FarmerOrderController;
use App\Http\Controllers\Farmer\FarmerProfileController;
use App\Http\Controllers\Farmer\ProductController;
use App\Http\Controllers\Farmer\ReviewController as FarmerReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\ManageUsers;
use App\Models\CartItem;
use App\Models\Market;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\FarmerController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::view('/about', 'pages.about')->name('about');

Route::view('/contact', 'pages.contact')->name('contact');

Route::view('/terms', 'terms')->name('terms.show');

Route::view('/policy', 'policy')->name('policy.show');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    

    Route::get('/dashboard', function () {

        $role = auth()->user()->role;

        return match ($role) {

            'admin' => redirect()->route('admin.dashboard'),

            'farmer' => redirect()->route('farmer.dashboard'),

            'user' => view('customer.dashboard', [
                'marketCount' => Market::count(),
                'farmerCount' => User::where('role', 'farmer')->count(),
                'productCount' => Product::where(
                    'is_available',
                    true
                )->count(),

                'cartCount' => CartItem::where(
                    'user_id',
                    auth()->id()
                )->sum('quantity'),

                'orderCount' => Order::where(
                    'customer_id',
                    auth()->id()
                )->count(),

                'activeOrderCount' => Order::where(
                    'customer_id',
                    auth()->id()
                )->whereIn('status', ['pending', 'confirmed', 'ready'])
                    ->count(),

                'recentOrders' => Order::with('items')
                    ->where('customer_id', auth()->id())
                    ->latest()
                    ->take(5)
                    ->get(),
            ]),

            default => abort(403),
        };

    })->name('dashboard');


    

    Route::get('/notifications', [
        NotificationController::class,
        'index'
    ])->name('notifications.index');

    Route::get('/notifications/{id}/read', [
        NotificationController::class,
        'read'
    ])->name('notifications.read');

    Route::post('/notifications/read-all', [
        NotificationController::class,
        'markAllAsRead'
    ])->name('notifications.readAll');


    

    Route::middleware('role:farmer')
        ->prefix('farmer')
        ->name('farmer.')
        ->group(function () {


            Route::get('/dashboard', [
                FarmerDashboardController::class,
                'index'
            ])->name('dashboard');


            Route::get('/profile', [
                FarmerProfileController::class,
                'edit'
            ])->name('profile.edit');

            Route::put('/profile', [
                FarmerProfileController::class,
                'update'
            ])->name('profile.update');


            Route::get('/products', [
                ProductController::class,
                'index'
            ])->name('products.index');

            Route::get('/products/create', [
                ProductController::class,
                'create'
            ])->name('products.create');

            Route::post('/products', [
                ProductController::class,
                'store'
            ])->name('products.store');

            Route::get('/products/{product}/edit', [
                ProductController::class,
                'edit'
            ])->name('products.edit');

            Route::put('/products/{product}', [
                ProductController::class,
                'update'
            ])->name('products.update');

            Route::delete('/products/{product}', [
                ProductController::class,
                'destroy'
            ])->name('products.destroy');


            Route::get('/orders', [
                FarmerOrderController::class,
                'index'
            ])->name('orders.index');

            Route::get('/orders/{order}', [
                FarmerOrderController::class,
                'show'
            ])->name('orders.show');

            Route::patch('/orders/{order}/status', [
                FarmerOrderController::class,
                'updateStatus'
            ])->name('orders.status');


            Route::get('/reviews', [
                FarmerReviewController::class,
                'index'
            ])->name('reviews.index');

            Route::post('/reviews/{review}/respond', [
                FarmerReviewController::class,
                'respond'
            ])->name('reviews.respond');

        });


    

    Route::middleware('role:user')
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {


            Route::get('/markets', [
                CustomerMarketController::class,
                'index'
            ])->name('markets.index');

            Route::get('/markets/{market}', [
                CustomerMarketController::class,
                'show'
            ])->name('markets.show');


            Route::get('/products', [
                CustomerProductController::class,
                'index'
            ])->name('products.index');

            Route::get('/products/{product}', [
                CustomerProductController::class,
                'show'
            ])->name('products.show');
         Route::get('/farmers', [FarmerController::class, 'index'])
        ->name('farmers.index');
        Route::get('/farmers/{id}', [FarmerController::class, 'show'])
        ->name('farmers.show');

            Route::post('/products/{product}/reviews', [
                CustomerReviewController::class,
                'store'
            ])->name('reviews.store');


            Route::get('/favorites', [
                CustomerFavoriteController::class,
                'index'
            ])->name('favorites.index');

            Route::post('/products/{product}/favorite', [
                CustomerFavoriteController::class,
                'toggle'
            ])->name('favorites.toggle');

            Route::delete('/favorites/{product}', [
                CustomerFavoriteController::class,
                'destroy'
            ])->name('favorites.destroy');


            Route::get('/cart', [
                CustomerCartController::class,
                'index'
            ])->name('cart.index');

            Route::post('/cart/{product}', [
                CustomerCartController::class,
                'store'
            ])->name('cart.store');

            Route::put('/cart/{cartItem}', [
                CustomerCartController::class,
                'update'
            ])->name('cart.update');

            Route::delete('/cart/{cartItem}', [
                CustomerCartController::class,
                'destroy'
            ])->name('cart.destroy');


            Route::get('/checkout', [
                CustomerOrderController::class,
                'checkoutForm'
            ])->name('checkout');

            Route::post('/orders', [
                CustomerOrderController::class,
                'store'
            ])->name('orders.store');

            Route::get('/orders', [
                CustomerOrderController::class,
                'index'
            ])->name('orders.index');

            Route::get('/orders/{order}', [
                CustomerOrderController::class,
                'show'
            ])->name('orders.show');


            Route::post('/orders/{order}/cancel', [
                CustomerOrderController::class,
                'cancel'
            ])->name('orders.cancel');


            Route::get('/orders/{order}/edit', [
                CustomerOrderController::class,
                'editForm'
            ])->name('orders.edit');

            Route::put('/orders/{order}', [
                CustomerOrderController::class,
                'update'
            ])->name('orders.update');

        });


    

    Route::middleware(ManageUsers::class)
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {


            Route::get('/dashboard', [
                AdminDashboardController::class,
                'index'
            ])->name('dashboard');


            Route::get('/users', [
                UserController::class,
                'index'
            ])->name('users.index');

            Route::patch('/users/{user}/role', [
                UserController::class,
                'updateRole'
            ])->name('users.role');

            Route::delete('/users/{user}', [
                UserController::class,
                'destroy'
            ])->name('users.destroy');

            Route::post('/users/{user}/approve', [
                UserController::class,
                'approve'
            ])->name('users.approve');

            Route::post('/users/{user}/suspend', [
                UserController::class,
                'suspend'
            ])->name('users.suspend');

            Route::patch('/users/{user}/toggle-active', [
                UserController::class,
                'toggleActive'
            ])->name('users.toggle-active');


            Route::get('/categories', [
                AdminCategoryController::class,
                'index'
            ])->name('categories.index');

            Route::get('/categories/create', [
                AdminCategoryController::class,
                'create'
            ])->name('categories.create');

            Route::post('/categories', [
                AdminCategoryController::class,
                'store'
            ])->name('categories.store');

            Route::get('/categories/{category}/edit', [
                AdminCategoryController::class,
                'edit'
            ])->name('categories.edit');

            Route::put('/categories/{category}', [
                AdminCategoryController::class,
                'update'
            ])->name('categories.update');

            Route::delete('/categories/{category}', [
                AdminCategoryController::class,
                'destroy'
            ])->name('categories.destroy');


            Route::get('/products', [
                AdminProductController::class,
                'index'
            ])->name('products.index');

            Route::patch('/products/{product}/toggle-availability', [
                AdminProductController::class,
                'toggleAvailability'
            ])->name('products.toggle-availability');

            Route::delete('/products/{product}', [
                AdminProductController::class,
                'destroy'
            ])->name('products.destroy');


            Route::get('/markets', [
                AdminMarketController::class,
                'index'
            ])->name('markets.index');

            Route::get('/markets/create', [
                AdminMarketController::class,
                'create'
            ])->name('markets.create');

            Route::post('/markets', [
                AdminMarketController::class,
                'store'
            ])->name('markets.store');

            Route::get('/markets/{market}/edit', [
                AdminMarketController::class,
                'edit'
            ])->name('markets.edit');

            Route::put('/markets/{market}', [
                AdminMarketController::class,
                'update'
            ])->name('markets.update');

            Route::delete('/markets/{market}', [
                AdminMarketController::class,
                'destroy'
            ])->name('markets.destroy');


            Route::post('/logout', [
                AuthController::class,
                'logout'
            ])->name('logout');

        });

});
