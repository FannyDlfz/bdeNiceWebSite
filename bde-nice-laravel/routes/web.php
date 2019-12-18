<?php
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
use Illuminate\Support\Facades\Route;
Route::get('/', 'HomeController@index')->name('home');
Route::resource('events-photos-published','EventPhotoController')     ->names('eventPhotos');
Route::resource('users', 'UserController')         ->names('users');
Route::get('login', 'UserController@login')            ->name('login');
Route::get('logout', 'UserController@logout')          ->name('logout');
Route::post('users/connect', 'UserController@connect') ->name('connection');
Route::get('articles/search', 'ArticleController@search') ->name('articles.search');
/* ==================== Route API pour autocompletion Articles ===================*/
Route::get('/api/articles', 'ArticleController@getAll')->name('articles.index');
Route::get('/articleByName', 'ArticleController@showArticlesName');
Route::get('events/search', 'EventController@search')     ->name('events.search');
Route::get('mails/validationMail', 'BasketController@submit')  ->name('mails.validationMail');
Route::get('events-photos/create/{id}', 'EventPhotoController@create')->where(array('id' => '[0-9]+'))->name('events-photos.create');
Route::resource('events',   'EventController')              ->names('events');
Route::resource('event-categories', 'EventCatController')   ->names('eventCategories');
Route::get('events/{id}/delete', 'EventController@destroy')     ->where(array('id' => '[0-9]+'))->name('events.get-delete');
Route::resource('articles', 'ArticleController')             ->names('articles');
Route::get('articles/{id}/delete', 'ArticleController@destroy')->where(array('id' => '[0-9]+'))->name('articles.get-delete');
Route::resource('articleCategories', 'ArticleCatController') ->names('articleCategories');
Route::resource('comments', 'CommentController')               ->names('comments');
Route::get('admin',             'AdminController@index')            ->name('admin');
Route::get('admin/events',      'AdminController@index_events')     ->name('admin.events');
Route::get('admin/events/list', 'AdminController@events_list_ajax') ->name('admin.events.list');
Route::get('admin/articles',      'AdminController@index_articles')     ->name('admin.articles');
Route::get('admin/articles/list', 'AdminController@articles_list_ajax') ->name('admin.articles.list');
Route::get('events/{id}/subscribe', 'EventController@subscribe')  ->where(array('id' => '[0-9]+'))->name('events.subscribe');
Route::get('events/{id}/unsubscribe', 'EventController@unsubscribe')->where(array('id' => '[0-9]+'))->name('events.unsubscribe');
Route::resource('basket', 'BasketController')->only(['show', 'update', 'submit'])->names('basket');
Route::delete('basket/{id}/remove-article', 'BasketController@removeArticle')->where(array('id' => '[0-9]+'))->name('basket.remove-article');
Route::get('basket/{id}/submit', 'BasketController@submit');/*->where(array('id' => '[0-9]+'))->name('basket.submit');*/
Route::post('/articles/search', 'ArticleController@search');
Route::post('/events/search', 'EventController@search');
Route::get('/legalMention', function() {return view('legalMention');}) ->name('legalMention');
Route::get('/event-photos/download', 'EventPhotoController@downloadImage')->name('event-photos.download');
Route::get('like/{id}', 'EventController@countLikes');
Route::get('likeEvent/{id}', 'EventController@likeEvent');
Route::post('/comment/validationMessage','EventController@report') ->name('events.report');
Route::get('/events/{id}/subscribers', 'EventController@getSubUsers') -> name('events.subs');
