<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\News_Url_Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PDFController;

//Rute utama
Route::get('/', [News_Url_Controller::class, 'showdulu'])->name('home');

Route::get('landing', [News_Url_Controller::class, 'landing'])->name('info.landing');
Route::get('landingprod', [News_Url_Controller::class, 'landingprod'])->name('info.landingprod');;
Route::get('/download-pdf', [News_Url_Controller::class, 'downloadPDF'])->name('download.pdf');
Route::get('/preview-pdf', [News_Url_Controller::class, 'previewPDF'])->name('preview.pdf');

Route::get('/showindexprod', [News_Url_Controller::class, 'showindexprod'])->name('cari.showindexprod');
Route::get('/showindex', [News_Url_Controller::class, 'showindexurl'])->name('cari.showindexurl');
Route::get('/showdetail/{id}/{title}/{urlslug}', [News_Url_Controller::class, 'showdetail'])->name('cari.showdetail');

Route::get('/caridulu', [News_Url_Controller::class, 'showdulu'])->name('caridulu');
Route::post('/', [News_Url_Controller::class, 'searchdulu'])->name('cari.searchdulu');
Route::post('/caridulu', [News_Url_Controller::class, 'searchduluprod'])->name('cari.searchduluprod');
Route::get('/caridulu/reset', function () {
    Session::forget('search_keyword'); // Menghapus session 'search_keyword'
    Session::forget('news_url_id');
    Session::forget('url_slug');
    return redirect()->route('home'); // Mengarahkan kembali ke halaman '/home'
})->name('caridulu.reset');
Route::get('/tambahkomen', [News_Url_Controller::class, 'addcomment'])->name('cari.tambahkomen')->middleware('check.token');
Route::post('/simpankomen', [News_Url_Controller::class, 'simpankomenbaru'])->name('cari.simpankomenbaru');

//Product
Route::post('product', [News_Url_Controller::class, 'storeproduct'])->name('product.store');
Route::get('product/{id}/{product_slug}', [News_Url_Controller::class, 'showproduct'])->name('product.show');
Route::get('addnewproduct', [News_Url_Controller::class, 'addnewproduct'])->middleware('check.token');
Route::post('simpannewproduct', [News_Url_Controller::class, 'simpannewproduct']);
Route::get('create', [News_Url_Controller::class, 'createproduct'])->name('product.create');
Route::post('product/{id}/save-url', [News_Url_Controller::class, 'saveProductUrl'])->name('product.save.url');

//Route::get('cari/addnewurl', [News_Url_Controller::class, 'addnewurlbaru']);
Route::get('/addnewurlbaru', [News_Url_Controller::class, 'addnewurlbaru'])->middleware('check.token');
Route::post('simpannewurlbaru', [News_Url_Controller::class, 'simpannewurlbaru']);

Route::get('/metadata', [News_Url_Controller::class, 'fetchMetadata']);
// Route for displaying the form
Route::get('/input-url', [News_Url_Controller::class, 'showForm'])->name('input.form');

// Route for handling form submission and displaying metadata
Route::post('/fetch-metadata', [News_Url_Controller::class, 'showMetadata'])->name('fetch.metadata');


// Route to show comments and their replies for a specific news URL
Route::get('/news/{newsId}/comments', [News_Url_Controller::class, 'showCommentsWithReplies'])->name('news.comments');
// Route to save a reply to a specific comment
Route::post('/comments/{commentId}/reply', [News_Url_Controller::class, 'saveCommentReply'])->name('comments.reply');

//tambah liked dan viewed
// Route::post('caridulu/like/{id}/{title}', [News_Url_Controller::class, 'addLike'])->name('news.like');
Route::post('/like/{id}', [News_Url_Controller::class, 'addLike'])->name('news.like')->middleware('check.token');
Route::post('/likeprod/{id}', [News_Url_Controller::class, 'addLikeproduct'])->name('product.like')->middleware('check.token');
Route::post('/increment-qr-count-generated/{id}', [News_Url_Controller::class, 'incrementQrCountGenerated'])->name('product.incrementQrCountGenerated');
Route::post('/increment-qr-code/{id}', [News_Url_Controller::class, 'incrementQrCodeScanned'])->name('increment.qr.code');
//route login dan register
Route::get('/register', [News_Url_Controller::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [News_Url_Controller::class, 'register'])->name('register');
Route::get('/login', [News_Url_Controller::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [News_Url_Controller::class, 'login'])->name('login');
Route::get('/logout', [News_Url_Controller::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [News_Url_Controller::class, 'showuser'])->name('profile.show');
    Route::post('/profile/update', [News_Url_Controller::class, 'updateuser'])->name('profile.update');
});

Route::get('/caridulu/news/{id}/comments', [News_Url_Controller::class, 'fetchComments'])->name('news.comments.fetch');

//feedback session
Route::get('/feedback', [News_Url_Controller::class, 'indexfeed'])->name('feedback.index');
Route::post('/feedback/{id}/vote', [News_Url_Controller::class, 'vote'])->name('feedback.vote')->middleware('check.token');
Route::post('/feedback/{id}/comment', [News_Url_Controller::class, 'commentfeed'])->name('feedback.comment');
Route::post('/feedback', [News_Url_Controller::class, 'storefeedback'])->name('feedback.store');
Route::get('/feedback/create', [News_Url_Controller::class, 'createfeedback'])->name('feedback.create');
//DASHBOARD
Route::get('/admin-login', [News_Url_Controller::class, 'showLoginFormAdmin'])->name('admin.login');
Route::post('/admin-login', [News_Url_Controller::class, 'authenticate'])->name('admin.authenticate');
//oute::get('/mydashboard', [News_Url_Controller::class, 'authenticate'])->middleware('auth')->name('mydashboard');
//Route::get('/mydashboard', [News_Url_Controller::class, 'mydashboard'])->middleware('auth')->name('mydashboard');
// Route::get('/dashboard/users', [UserController::class, 'usersindex'])->name('users.index');
Route::get('/dashboard/users', [UserController::class, 'listUsers'])->name('dashboard.users');
Route::get('/dashboard/newscomments', [News_Url_Controller::class, 'showNewsWithComments'])->name('dashboard.news.comments');
Route::get('/dashboard/users/profile', [UserController::class, 'userProfile'])->name('dashboard.userprofile');
Route::get('/dashboard/products', [News_Url_Controller::class, 'indexprod'])->name('dashboard.products');
Route::get('/dashboard/productscari', [News_Url_Controller::class, 'indexprodcari'])->name('dashboard.productscari');
Route::get('/dashboard/feedback-detail', [News_Url_Controller::class, 'indexFeedback'])->name('dashboard.feedback-detail');

Route::get('/dashboard/news-chart', [News_Url_Controller::class, 'newsChart'])->name('dashboard.news_chart');
Route::get('/dashboard/comment-chart', [News_Url_Controller::class, 'commentChart'])->name('dashboard.comment_chart');
Route::get('/dashboard/fourchart', [News_Url_Controller::class, 'fourChart'])->name('dashboard.fourchart');
Route::get('/charts/yearly', [News_Url_Controller::class, 'loadYearlyData'])->name('dashboard.fourchartyearly');
Route::get('/dashboard/user-growth', [News_Url_Controller::class, 'userGrowth'])->name('dashboard.userGrowth');


