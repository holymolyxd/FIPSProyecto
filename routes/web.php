<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ApiJsController;

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

Route::get('/',[ContentController::class,'getHome'])->name('home');

Route::get('/login',[ConnectController::class,'getLogin'])->name('login');
Route::post('/login',[ConnectController::class,'postLogin'])->name('login');
Route::get('/logout',[ConnectController::class,'getLogout'])->name('logout');

Route::get('/authorize', [ConnectController::class,'signin'])->name('signin');
Route::get('/callback',[ConnectController::class,'callback'])->name('callback');

Route::get('/account/edit',[UserController::class,'getAccountEdit'])->name('account_edit');
Route::post('/account/edit/password',[UserController::class,'postAccountPassword'])->name('account_password_edit');
Route::post('/account/edit/info',[UserController::class,'postAccountInfo'])->name('account_info_edit');
Route::post('/account/edit/adress',[UserController::class,'postAccountAdress'])->name('account_adress_edit');
Route::post('/account/edit/venues',[UserController::class,'postAccountVenues'])->name('account_venues_edit');
Route::post('/account/edit/careers',[UserController::class,'postAccountCareers'])->name('account_careers_edit');
Route::post('/account/edit/semester',[UserController::class,'postAccountSemester'])->name('account_careers_edit');
Route::post('/account/edit/subject',[UserController::class,'postAccountSubject'])->name('account_subjects_edit');

Route::get('/posts', [PostController::class,'getMyPosts'])->name('my_post');
Route::get('/post/add', [PostController::class,'getPostAdd'])->name('post_add');
Route::post('/post/add', [PostController::class,'postPostAdd'])->name('post_add');
Route::post('/post/search', [PostController::class, 'postPostSearch'])->name('post_search');

Route::get('/post/{id}/{slug}', [PostController::class,'getPost'])->name('get_post');
Route::post('/post/{id}/{slug}/comments', [PostController::class,'postCommentPost'])->name('post_comments');
Route::put('/post/{id}/{slug}/{id_comment}/finish',[PostController::class,'FinishPost'])->name('post_finish');
Route::get('/user/{id}/{email}/posts', [PostController::class,'getUsersPosts'])->name('get_user_post');
Route::post('/user/{id}/{email}/posts/search',[PostController::class,'postUsersPostsSearch'])->name('post_user_search');
Route::get('/careers/{id}/{slug}/posts', [PostController::class, 'getCareersPosts'])->name('get_career_posts');
Route::post('/careers/{id}/{slug}/posts/search',[PostController::class,'postCareersPostsSearch'])->name('post_career_search');
Route::get('/subjects/{id}/{slug}/posts',[PostController::class,'getSubjectsPosts'])->name('get_subject_posts');
Route::post('/subjects/{id}/{slug}/posts/search',[PostController::class,'postSubjectsPostsSearch'])->name('post_subject_search');

//Ajax Api Routers
//Route::get('/fips/api/load/posts/{section}',[ApiJsController::class,'getPostSection']);
