<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['domain' => 'api.'.env('STORE_DOMAIN')], function() {

	/*
	|--------------------------------------------------------------------------
	| Session Group (Accessing user session)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'session'], function() {

		
		
	});

	/*
	|--------------------------------------------------------------------------
	| Static Group (Non-dynamic resources)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'static'], function() {

		Route::get('tags', 'TagController@getTags');
		Route::get('tags/catalog', 'TagController@getTagsCatalog');
		Route::get('tags/item', 'TagController@getTagsItem');

		Route::get('types', 'TypeController@getTypes');
		Route::get('type/{type}', 'TypeController@getType');

	});

	/*
	|--------------------------------------------------------------------------
	| Storage Group (Accessing file storage)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'storage'], function() {

		Route::get('images', 'ImageController@getImages');
		Route::post('images', 'ImageController@postImage');
		Route::delete('images/{path}', 'ImageController@deleteImage')->where(['path' => '.*']);

		Route::get('inventory', 'InventoryImageController@getImages');
		Route::get('inventory/{item_id}', 'InventoryImageController@getItemImages');
		
	});
});

// OLD ROUTES
// // Session Info
// Route::group(['prefix' => 'session'], function() {
// 	Route::get('/', 'SessionController@getSession');
// 	Route::get('/cart', 'SessionController@getCart');
// 	Route::post('/cart-item', 'SessionController@addCartItem');
// 	Route::delete('/cart', 'SessionController@getTags');
// });

// // Authentication
// Route::group(['prefix' => 'auth'], function() {
// 	Route::get('login', 'Auth\AuthController@getLogin');
// 	Route::post('login', 'Auth\AuthController@postLogin');
// 	Route::get('logout', 'Auth\AuthController@getLogout');
// });

// /*
//  | The admin panel is accessable from domain/admin
//  */
// Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
	
// 	Route::get('/', function() { return view('admin.home'); });
// 	Route::get('user', function() { return Auth::user(); });

// 	// USER
// 	Route::post('/register', 'Admin\UsersController@register');
// 	Route::get('/users', 'Admin\UsersController@getUsers');
// 	Route::post('/users/privilege', 'Admin\UsersController@changePrivilege');

// 	// USER_TODOS
// 	Route::resource('todos', 'Admin\TodosController', ['except' => ['edit', 'create']]);

// 	// INVOICES
// 	Route::get('/invoices/cart/{invoice_id}', 'Admin\InvoicesController@getCart'); // TODO, wrap into resources
// 	Route::post('/invoices/email', 'Admin\InvoicesController@sendEmail');
// 	Route::resource('invoices', 'Admin\InvoicesController', ['except' => ['edit', 'create']]);
// 	Route::resource('invoices-cart', 'Admin\InvoicesCartController', ['except' => ['edit', 'create']]);
	
// 	// INVENTORY
// 	Route::resource('inventory', 'Admin\InventoryController', ['except' => ['edit', 'create']]);

// 	// PAGES
// 	Route::patch('/pages', 'Admin\PagesController@updateAll');
// 	Route::post('/page', 'Admin\PagesController@postPage');
// 	Route::get('/page/{id}', 'Admin\PagesController@getPage');
// 	Route::get('/upload', 'Admin\PagesController@getUploadedFiles');
// 	Route::post('/upload', 'Admin\PagesController@uploadFile');
// 	Route::delete('/upload', 'Admin\PagesController@deleteFile');
// 	Route::post('/upload/directory', 'Admin\PagesController@createDirectory');
// 	Route::delete('/upload/directory', 'Admin\PagesController@deleteDirectory');
// 	Route::resource('pages', 'Admin\PagesController', ['except' => ['edit', 'create']]);

// 	// CATALOGS
// 	Route::patch('/catalogs', 'Admin\CatalogsController@updateAll');
// 	Route::resource('catalogs', 'Admin\CatalogsController', ['except' => ['edit', 'create']]);

// 	// CUSTOMERS
// 	Route::resource('customers', 'Admin\CustomersController', ['except' => ['edit', 'create']]);

// 	// DATATABLES
// 	Route::get('/datatables/invoices', 'DatatablesController@getInvoices');
// 	Route::get('/datatables/activeinvoices', 'DatatablesController@getActiveInvoices');
// 	Route::get('/datatables/archivedinvoices', 'DatatablesController@getArchivedInvoices');
// 	Route::get('/datatables/inventory', 'DatatablesController@getInventory');

// 	// UPLOADS
// 	Route::post('/inventory/pic-upload', 'Admin\InventoryController@uploadPics'); // TODO, move to upload controller
// });

// Route::group(['prefix' => 'api'], function() {
// 	Route::get('/settings', 'PublicController@getSettings');
// 	Route::get('/page/{page}', 'PublicController@getPage')->where(['page' => '.*']);
// 	Route::get('/catalog', 'PublicController@getCatalogs');
// 	Route::post('/catalog', 'PublicController@searchCatalogs');
// 	Route::get('/catalog/{catalog}', 'PublicController@getCatalog');
// 	Route::post('/catalog/{catalog}', 'PublicController@searchCatalog');
// 	Route::get('/item/{item}', 'PublicController@getItem');
// 	Route::post('/search/item-tags', 'PublicController@searchItemsTags');
// 	Route::post('/search/items', 'PublicController@searchItems');
// 	Route::post('/test/cart', 'PublicController@testCart');
// 	Route::post('/submit/invoice', 'PublicController@submitInvoice');
// });

// Route::get('/', function() { return redirect('home'); });
// Route::get('/{path}', 'PublicController@getHome')->where(['path' => '.*']);