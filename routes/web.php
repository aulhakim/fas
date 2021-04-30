<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Laravel\Socialite\Facades\Socialite;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'prevent-back-history'],function(){
    Route::get('/', [Home::class, 'index'])->name('home');
    Route::get('/blog/{id}', [Home::class, 'blogDetail']);
    Route::get('/category/{id}', [Home::class, 'blogByCategory']);
    Route::get('/login', [AuthController::class, 'showFormLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showFormRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::group(['middleware' => 'auth'], function () {
            Route::get('admin', [AdminController::class, 'index'])->name('admin');
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/admin/dashboard', [AdminController::class, 'index']);
            Route::get('/admin/category', [AdminController::class, 'category']);
            Route::get('/admin/getCategory', [AdminController::class, 'getCategory']);
            Route::get('getCategory', [AdminController::class, 'getCategory'])->name('admin.getCategory');
            Route::get('/admin/getCategoryById/{id}', [AdminController::class, 'getCategoryById']);
            Route::post('/admin/save_category', [AdminController::class, 'store']);
            Route::post('/admin/update_category', [AdminController::class, 'updateCategory']);
            Route::get('/deleteCategory/{id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
            Route::get('/admin/blog', [AdminController::class, 'blog']);
            Route::get('/admin/getblog', [AdminController::class, 'getBlog']);
            Route::get('/admin/blog/add', [AdminController::class, 'addBlog']);
            Route::post('/admin/blog/insert', [AdminController::class, 'storeBlog']);
            Route::get('/admin/blog/edit/{id}', [AdminController::class, 'editBlog']);
            Route::post('/admin/blog/update', [AdminController::class, 'updateBlog']);
            Route::get('/admin/blog/delete/{id}', [AdminController::class, 'deleteBlog']);
            Route::get('/admin/change-password', [AdminController::class, 'changePassword']);
            Route::post('/admin/do-change-password', [AdminController::class, 'doChangePassword']);
    });

});

// login google

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('signup.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('signup.facebook');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::get('/auth/github', [AuthController::class, 'redirectToGithub'])->name('signup.github');
Route::get('/auth/github/callback', [AuthController::class, 'handleGithubCallback']);


// Route::get('/auth/redirect', function () {
//     return Socialite::driver('google')->redirect();
// })->name('signup.google');

// Route::get('/auth/callback', function () {
//     $user = Socialite::driver('google')->user();

//     // $user->token
// });
 