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

Route::get('landing', [News_Url_Controller::class, 'landing'])->name('info.landing');;
Route::get('/download-pdf', [News_Url_Controller::class, 'downloadPDF'])->name('download.pdf');
Route::get('/preview-pdf', [News_Url_Controller::class, 'previewPDF'])->name('preview.pdf');

Route::get('/showindexprod', [News_Url_Controller::class, 'showindexprod'])->name('cari.showindexprod');
Route::get('/showindex', [News_Url_Controller::class, 'showindexurl'])->name('cari.showindexurl');
Route::get('/showdetail/{id}/{title}/{urlslug}', [News_Url_Controller::class, 'showdetail'])->name('cari.showdetail');

Route::get('/caridulu', [News_Url_Controller::class, 'showdulu'])->name('caridulu');
Route::post('/', [News_Url_Controller::class, 'searchdulu'])->name('cari.searchdulu');
Route::get('/caridulu/reset', function () {
    Session::forget('search_keyword'); // Menghapus session 'search_keyword'
    Session::forget('news_url_id');
    Session::forget('url_slug');
    return redirect()->route('caridulu'); // Mengarahkan kembali ke halaman '/home'
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

// Route::post('increment-qr-count/{id}', [News_Url_Controller::class, 'incrementQrCount'])->name('increment.qr.count');








//Route::get('dosen', ['DosenController:class 'index']);
// Route::get('home', [News_Url_Controller::class, 'home']);
// Route::get('home/find', [News_Url_Controller::class, 'find']);
// Route::get('home/add', [News_Url_Controller::class, 'add']);
// Route::post('home/store', [News_Url_Controller::class, 'store']);
//join
// Route::get('home/newsurlcomments', [News_Url_Controller::class, 'newscommentsjoin']);
// Route::get('home/cari', [News_Url_Controller::class, 'cari']);
// Route::get('home/addnewurl', [News_Url_Controller::class, 'addnewurl']);
// Route::post('home/simpannewurl', [News_Url_Controller::class, 'simpannewurl']);

// Route::get('/cari/index', [News_Url_Controller::class, 'index']);
// Route::get('/cari/index', [News_Url_Controller::class, 'index'])->name('cari.index');
//Route::post('/caridulu', [News_Url_Controller::class, 'searchdulupost'])->name('cari.searchdulupost');

//ini yg asli jalan ok
// Route::get('/cari', [News_Url_Controller::class, 'show'])->name('cari');
// Route::post('/cari', [News_Url_Controller::class, 'search'])->name('cari.search');
// Route::get('/cari/searchurl', [News_Url_Controller::class, 'searchurlbaru'])->name('cari.searchurl');
// Route::get('cari/carisearch/{id}', [News_Url_Controller::class, 'searchById'])->name('cari.searchid');;

// Route::get('cari/tambahkomenbyid/', [News_Url_Controller::class, 'addcommentbyid'])->name('cari.tambahkomenbyid');;



//Route::get('cari/addnewurl', [News_Url_Controller::class, 'addnewurlbaru']);
Route::get('/addnewurlbaru', [News_Url_Controller::class, 'addnewurlbaru'])->middleware('check.token');
Route::post('simpannewurlbaru', [News_Url_Controller::class, 'simpannewurlbaru']);

// Route::get('/cari/reset', function () {
//     Session::forget('search_keyword'); // Menghapus session 'search_keyword'
//     Session::forget('news_url_id');
//     return redirect()->route('cari'); // Mengarahkan kembali ke halaman '/cari'
// })->name('cari.reset');


//versi google

Route::get('/metadata', [News_Url_Controller::class, 'fetchMetadata']);
// Route for displaying the form
Route::get('/input-url', [News_Url_Controller::class, 'showForm'])->name('input.form');

// Route for handling form submission and displaying metadata
Route::post('/fetch-metadata', [News_Url_Controller::class, 'showMetadata'])->name('fetch.metadata');


// Route to show comments and their replies for a specific news URL
Route::get('/news/{newsId}/comments', [News_Url_Controller::class, 'showCommentsWithReplies'])->name('news.comments');
// Route to save a reply to a specific comment
Route::post('/comments/{commentId}/reply', [News_Url_Controller::class, 'saveCommentReply'])->name('comments.reply');

// Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

//middleware
//Route::get('search', [SearchController::class, 'search'])->middleware(ValidateToken::class);

// //userlogin
// Route::get('/', [LoginController::class, 'login'])->name('login');
// Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

// Route::get('dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

// //Autentifikasi token
// Route::get('/enter-password', [UserController::class, 'showEnterPasswordForm'])->name('enter_password');
// Route::post('/verify-password', [UserController::class, 'verifyPassword'])->name('verify_password');
// Route::get('/', function () {
//     return view('welcome');
// });

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
// Route::get('/home', [News_Url_Controller::class, 'beranda2'])->name('home')->middleware('check.token');
// Route::get('/home2', [News_Url_Controller::class, 'beranda2'])->name('home2');
Route::get('/logout', [News_Url_Controller::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [News_Url_Controller::class, 'showuser'])->name('profile.show');
    Route::post('/profile/update', [News_Url_Controller::class, 'updateuser'])->name('profile.update');
});

Route::get('/caridulu/news/{id}/comments', [News_Url_Controller::class, 'fetchComments'])->name('news.comments.fetch');
