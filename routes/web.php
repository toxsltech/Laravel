<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers;
use App\Models\User;

$proxy_url    = getenv('PROXY_URL');

if (!empty($proxy_url)) {
    URL::forceRootUrl($proxy_url);
}

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

Route::get('/', 'App\Http\Controllers\frontend\IndexController@index');
Route::get('/add-admin', 'App\Http\Controllers\frontend\AuthController@addAdmin');
Route::post('/add-admin', 'App\Http\Controllers\frontend\AuthController@saveAdmin');
Route::post('/login', 'App\Http\Controllers\frontend\AuthController@actionLogin');
Route::get('/signup', 'App\Http\Controllers\frontend\AuthController@signUp');
Route::post('/signup', 'App\Http\Controllers\frontend\AuthController@saveUser');
Route::view('/forgot-password', 'frontend.auth.forgot-password');
Route::post('/forgot-password', 'App\Http\Controllers\frontend\AuthController@forgotPassword');
Route::get('/password-reset/{token}', 'App\Http\Controllers\frontend\AuthController@resetPassword');
Route::post('/password-reset/{token}', 'App\Http\Controllers\frontend\AuthController@updateUserPassword');

Route::get('privacy-policy', 'App\Http\Controllers\frontend\UserController@privacyPolicy');
Route::get('term-condition', 'App\Http\Controllers\frontend\UserController@termCondition');
Route::get('our-mission', 'App\Http\Controllers\frontend\UserController@ourMission');

/*Facebook Login Route*/
Route::get('auth/facebook', 'App\Http\Controllers\frontend\AuthController@redirectToFacebook');
Route::get('auth/facebook/callback', 'App\Http\Controllers\frontend\AuthController@handleFacebookCallback');

/*Google Login Route*/
Route::get('auth/google', 'App\Http\Controllers\frontend\AuthController@redirectToGoogle');
Route::get('auth/google/callback', 'App\Http\Controllers\frontend\AuthController@handleGoogleCallback');

/*Contact Us Route */
Route::get('/contact-us', 'App\Http\Controllers\frontend\SiteController@contact');
Route::post('/contact-us', 'App\Http\Controllers\frontend\SiteController@contactUs');
Route::get('user/confirm-email/{id}', 'App\Http\Controllers\admin\UserController@confirmEmail');

Route::group([
    'middleware' => 'login'
], function () {
 
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
  return redirect('/')->with('success', 'Logout Succesfully');
   
});

Route::group([
    'middleware' => 'OnlyUser'
], function () {

Route::get('discover', 'App\Http\Controllers\frontend\UserController@disCover');    
Route::get('setting', 'App\Http\Controllers\frontend\SiteController@userSetting');
Route::get('profile-edit', 'App\Http\Controllers\frontend\SiteController@profileEdit');
Route::get('profile', 'App\Http\Controllers\frontend\SiteController@userProfile');
Route::get('travel-board', 'App\Http\Controllers\frontend\SiteController@travelBoard');
Route::get('notification', 'App\Http\Controllers\frontend\SiteController@notification');
Route::post('updateLatLog', 'App\Http\Controllers\frontend\UserController@updateLatLog');

Route::get('post-preview/{id}', 'App\Http\Controllers\frontend\SiteController@postPreview');
Route::get('discover/post-preview/{id}', 'App\Http\Controllers\frontend\SiteController@discoverPostPreview');
Route::get('view-travel/user_profile/{id}', 'App\Http\Controllers\frontend\SiteController@PostUserProfile');
Route::get('create', 'App\Http\Controllers\frontend\SiteController@create');
Route::post('tour-save', 'App\Http\Controllers\frontend\PostController@tourSave');
Route::get('tour-save/edit/{id}', 'App\Http\Controllers\frontend\PostController@tourEdit');
Route::post('tour-save/edit/{id}', 'App\Http\Controllers\frontend\PostController@tourUpdate');
Route::get('tour-exprience/delete/{id}', 'App\Http\Controllers\frontend\PostController@tourDelete');
Route::get('tour-image/delete/{id}', 'App\Http\Controllers\frontend\PostController@deleteImage');

Route::post('profile-update', 'App\Http\Controllers\frontend\UserController@profileUpdate');
Route::get('changePassword/{id}', 'App\Http\Controllers\frontend\UserController@userSetting');
Route::post('update-password', 'App\Http\Controllers\frontend\UserController@updatePassword');

Route::post('user/update-file/{id}', 'App\Http\Controllers\frontend\UserController@updateFile');
Route::get('user/confirm-email/{id}', 'App\Http\Controllers\admin\UserController@confirmEmail');

Route::get('bookmark-card','App\Http\Controllers\frontend\PostController@bookMarkCard');
Route::get('bookmark-card/remove','App\Http\Controllers\frontend\PostController@bookMarkCardRemove');
Route::get('user-follow/{id}','App\Http\Controllers\frontend\PostController@userFollow');
Route::get('user-unfollow/{id}','App\Http\Controllers\frontend\PostController@userUnfollow');
Route::get('user-post/follow/','App\Http\Controllers\frontend\PostController@followAjax');
Route::get('follower-list/{id}','App\Http\Controllers\frontend\PostController@userFollowList');
Route::get('post-preview/bookmark/{id}','App\Http\Controllers\frontend\PostController@previewBookMark');

/* Search Route */
Route::any('search','App\Http\Controllers\frontend\PostController@allSearch');
Route::any('search/experience','App\Http\Controllers\frontend\PostController@experienceSearch');
Route::any('search/location','App\Http\Controllers\frontend\PostController@locationSearch');

});

/* Admin Route */
Route::group([
    'prefix' => 'admin',
    'middleware' => 'OnlyAdmin'
], function () {
    
    Route::get('/dashboard', 'App\Http\Controllers\admin\UserController@index');
    
    Route::get('users', 'App\Http\Controllers\admin\UserController@all');
    Route::get('user/edit/{id}', 'App\Http\Controllers\admin\UserController@edit');
    Route::post('user/edit/{id}', 'App\Http\Controllers\admin\UserController@update');
    Route::post('user/delete', 'App\Http\Controllers\admin\UserController@delete');
    Route::view('user/add', 'admin.users.add');
    Route::post('user/add', 'App\Http\Controllers\admin\UserController@save');
    Route::get('user/{id}', 'App\Http\Controllers\admin\UserController@view');
    Route::get('/changePassword/{id}', 'App\Http\Controllers\admin\UserController@changePassword');
    Route::post('/changePassword/{id}', 'App\Http\Controllers\admin\UserController@updatePassword');
    Route::get('profile', 'App\Http\Controllers\admin\UserController@myProfile');
    Route::post('user/update-file/{id}', 'App\Http\Controllers\admin\UserController@updateFile');
    Route::get('user/type/{id}', 'App\Http\Controllers\admin\UserController@userBlockUnblock');
    Route::get('download', 'App\Http\Controllers\admin\UserController@exportUserData');
        
    /* Login History Routes */
    Route::get('login-history', 'App\Http\Controllers\admin\LoginHistoryController@all');
    Route::get('login-history/{id}', 'App\Http\Controllers\admin\LoginHistoryController@view');
    Route::post('login-history/delete', 'App\Http\Controllers\admin\LoginHistoryController@delete');
    
    /* Email Queue Routes */
    Route::get('email-queue', 'App\Http\Controllers\admin\EmailQueueController@all');
    Route::get('email-queue/{id}', 'App\Http\Controllers\admin\EmailQueueController@view');
    Route::get('email-queue/show/{id}', 'App\Http\Controllers\admin\EmailQueueController@show');
    Route::post('email-queue/delete', 'App\Http\Controllers\admin\EmailQueueController@delete');
    
    /* Static Pages */
    Route::get('page', 'App\Http\Controllers\admin\PagesController@all');
    Route::view('page/add', 'admin.pages.add');
    Route::post('page/add', 'App\Http\Controllers\admin\PagesController@save');
    Route::get('page/view/{id}', 'App\Http\Controllers\admin\PagesController@view');
    Route::get('page/edit/{id}', 'App\Http\Controllers\admin\PagesController@edit');
    Route::post('page/edit/{id}', 'App\Http\Controllers\admin\PagesController@editupdate');
    Route::post('page/delete', 'App\Http\Controllers\admin\PagesController@delete');
    
    /* Travel Records Routes */
    Route::get('travel-record', 'App\Http\Controllers\admin\TravelRecordController@all');
    Route::get('travel-record/{id}', 'App\Http\Controllers\admin\TravelRecordController@view');
    Route::post('travel-record/delete', 'App\Http\Controllers\admin\TravelRecordController@delete');
    Route::get('travel-record/state/{id}', 'App\Http\Controllers\admin\TravelRecordController@recordActiveInactive');
    Route::get('records/download', 'App\Http\Controllers\admin\TravelRecordController@export');   
    
    /* Static Pages */
    Route::get('age', 'App\Http\Controllers\admin\AgeController@all');
    Route::view('age/add', 'admin.age.add');
    Route::post('age/add', 'App\Http\Controllers\admin\AgeController@save');
    Route::get('age/view/{id}', 'App\Http\Controllers\admin\AgeController@view');
    Route::get('age/edit/{id}', 'App\Http\Controllers\admin\AgeController@edit');
    Route::post('age/edit/{id}', 'App\Http\Controllers\admin\AgeController@editupdate');
    Route::post('age/delete', 'App\Http\Controllers\admin\AgeController@delete');
    
    Route::get('user-feeds', 'App\Http\Controllers\admin\UserFeedsController@allFeed');
    Route::get('user-feeds/{id}', 'App\Http\Controllers\admin\UserFeedsController@viewFeed');
    Route::get('user-feeds/show/{id}', 'App\Http\Controllers\admin\UserFeedsController@showFeed');
    Route::post('user-feeds/delete', 'App\Http\Controllers\admin\UserFeedsController@deleteFeed');
    
    
  });
});
    