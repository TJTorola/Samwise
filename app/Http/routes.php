<?php

/*
|--------------------------------------------------------------------------
| API Routes (Laravel Resources)
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api'], function() {

	/**
	 * Authentication Middleware:
	 * auth
	 * auth:admin
	 * auth:catalogs
	 * auth:customers
	 * auth:inventory
	 * auth:invoices
	 * auth:pages
	 *
	 * Apply to groups, ex:
	 * Route::group(['prefix' => 'group', 'middleware' => 'auth'], function() {});
	 *
	 * Or routes, ex:
	 * Route::post('/', 'AuthController@login')->middleware('auth:admin');
	 */

	/*
	|--------------------------------------------------------------------------
	| Auth Group (Handling authentication)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'auth'], function() {

		Route::post('/', 'AuthController@login');
		Route::get('logout', 'AuthController@logout');
		Route::post('register', 'AuthController@register');

	});

	/*
	|--------------------------------------------------------------------------
	| Catalogs Group (Mix it up with the catalogs)
	|--------------------------------------------------------------------------
	*/
	Route::get('catalogs', 'CatalogsController@index')->middleware('auth:catalogs');
	Route::post('catalogs', 'CatalogsController@updateCollection')->middleware('auth:catalogs');
	Route::group(['prefix' => 'catalog'], function() {

		Route::post('/', 'CatalogsController@store')->middleware('auth:catalogs');
		Route::get('{catalog}', 'CatalogsController@show');
		Route::patch('{catalog}', 'CatalogsController@update')->middleware('auth:catalogs');
		Route::delete('{catalog}', 'CatalogsController@destroy')->middleware('auth:catalogs');

	});

	/*
	|--------------------------------------------------------------------------
	| Customers Group (Keep those customers happy)
	|--------------------------------------------------------------------------
	*/
	Route::get('customers', 'CustomersController@index')->middleware('auth:customers');
	Route::group(['prefix' => 'customer', 'middleware' => 'auth:customers'], function() {

		Route::post('/', 'CustomersController@store');
		Route::get('{customer}', 'CustomersController@show');
		Route::patch('{customer}', 'CustomersController@update');
		Route::delete('{customer}', 'CustomersController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Email Group (Send out pre-formatted emails)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'email'], function() {

		Route::post('invoice/{invoice}', 'EmailController@invoice')->middleware('auth:invoices');

	});

	/*
	|--------------------------------------------------------------------------
	| Images Group (Manage store images)
	|--------------------------------------------------------------------------
	*/
	Route::get('images', 'ImagesController@index')->middleware('auth:pages');
	Route::group(['prefix' => 'image', 'middleware' => 'auth:pages'], function() {

		Route::post('/', 'ImagesController@store');
		Route::delete('/', 'ImagesController@destroy');
		Route::post('directory', 'ImagesController@createDirectory');
		Route::delete('directory', 'ImagesController@deleteDirectory');

	});

	/*
	|--------------------------------------------------------------------------
	| Invoices Group (View/Modify customer invoices)
	|--------------------------------------------------------------------------
	*/
	Route::get('invoices', 'InvoicesController@index')->middleware('auth:invoices');
	Route::group(['prefix' => 'invoice', 'middleware' => 'auth:invoices'], function() {

		Route::post('/', 'InvoicesController@store');
		Route::get('{invoice}', 'InvoicesController@show');
		Route::patch('{invoice}', 'InvoicesController@update');
		Route::delete('{invoice}', 'InvoicesController@cancel');

		Route::get('{invoice}/cart', 'InvoicesController@indexItems');
		Route::get('{invoice}/items', 'InvoicesController@indexItems');
		Route::post('{invoice}/cart', 'InvoicesController@storeItems');
		Route::post('{invoice}/items', 'InvoicesController@storeItems');
		Route::post('{invoice}/item', 'InvoicesController@storeItem');

		Route::get('{invoice}/payments', 'InvoicesController@indexPayments');
		Route::post('{invoice}/payment', 'InvoicesController@storePayment');

	});

	Route::get('cancelled-invoices', 'InvoicesController@indexCancelled')->middleware('auth:invoices');
	Route::group(['prefix' => 'cancelled-invoice', 'middleware' => 'auth:invoices'], function() {

		Route::delete('{invoice}', 'InvoicesController@destroy');
		Route::patch('{invoice}', 'InvoicesController@restore');

	});

	/*
	|--------------------------------------------------------------------------
	| Invoice Items Group (Control the cart)
	|--------------------------------------------------------------------------
	*/

	Route::get('invoice-items', 'InvoiceItemsController@index')->middleware('auth:invoices');
	Route::group(['prefix' => 'invoice-item', 'middleware' => 'auth:invoices'], function() {

		Route::get('{invoiceItem}', 'InvoiceItemsController@show');
		Route::patch('{invoiceItem}', 'InvoiceItemsController@update');
		Route::delete('{invoiceItem}', 'InvoiceItemsController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Items Group (Control the inventory)
	|--------------------------------------------------------------------------
	*/
	Route::get('items', 'ItemsController@index');
	Route::group(['prefix' => 'item'], function() {

		Route::get('{item}', 'ItemsController@show');
		Route::patch('{item}', 'ItemsController@update');
		Route::delete('{item}', 'ItemsController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Offers Group (Control the offers)
	|--------------------------------------------------------------------------
	*/
	Route::get('offers', 'OffersController@index');
	Route::group(['prefix' => 'offer'], function() {

		Route::post('/', 'OffersController@store');
		Route::get('{offer}', 'OffersController@show');
		Route::get('{offer}/admin', 'OffersController@showAdmin'); // ->middleware('auth:inventory')
		Route::patch('{offer}', 'OffersController@update');
		Route::delete('{offer}', 'OffersController@destroy');

		Route::post('{offer}/item', 'OffersController@storeItem');
		Route::post('{offer}/image', 'OffersController@storeImage');
		Route::patch('{offer}/images', 'OffersController@updateImages');

	});

	/*
	|--------------------------------------------------------------------------
	| Pages Group (Modify indevidual pages)
	|--------------------------------------------------------------------------
	*/
	Route::get('pages', 'PagesController@index');
	Route::post('pages', 'PagesController@updateCollection');
	Route::group(['prefix' => 'page'], function() {

		Route::post('/', 'PagesController@store');
		Route::get('{page_slug}', 'PagesController@show')->where(['page_slug' => '.*']);
		Route::patch('{page}', 'PagesController@update');
		Route::delete('{page}', 'PagesController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Payments Group (Lets make some money)
	|--------------------------------------------------------------------------
	*/
	Route::get('payments', 'PaymentsController@index');
	Route::group(['prefix' => 'payment'], function() {

		Route::get('{payment}', 'PaymentsController@show');

	});

	/*
	|--------------------------------------------------------------------------
	| Self Group (Control yourself!)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'self', 'middleware' => 'auth'], function() {

		Route::get('/', 'SelfController@show');
		Route::get('todos', 'SelfController@indexTodos');
		Route::post('todo', 'SelfController@storeTodo');
		Route::delete('todo', 'SelfController@destroyTodo');

	});

	/*
	|--------------------------------------------------------------------------
	| Settings Group (Configure the system)
	|--------------------------------------------------------------------------
	*/
	Route::get('settings', 'SettingsController@index');
	Route::group(['prefix' => 'setting'], function() {

		Route::get('{setting}', 'SettingsController@show')->where(['setting' => '[a-z_/]+']);

	});

	/*
	|--------------------------------------------------------------------------
	| Store Group (Optimized storefront requests)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'store'], function() {

		Route::get('menus', 'StoreController@getMenus');
		Route::post('invoice', 'StoreController@postInvoice');

	});

	/*
	|--------------------------------------------------------------------------
	| Tags Group (Retrieve tags and tag usage)
	|--------------------------------------------------------------------------
	*/
	Route::get('tags', 'TagsController@index');

	/*
	|--------------------------------------------------------------------------
	| Types Group (Return static type data)
	|--------------------------------------------------------------------------
	*/
	Route::get('types', 'TypesController@index');
	Route::get('type/{type_name}', 'TypesController@show');

	/*
	|--------------------------------------------------------------------------
	| User Group (Handling admin users)
	|--------------------------------------------------------------------------
	*/
	Route::get('users', 'UsersController@index');
	Route::group(['prefix' => 'user'], function() {

		Route::post('/', 'UsersController@store');
		Route::get('{user}', 'UsersController@show');
		Route::patch('{user}', 'UsersController@update');
		Route::delete('{user}', 'UsersController@destroy');

	});
});

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function() {

	Route::get('/', 'AdminController@home');
	Route::get('/page/{id}', 'AdminController@editPage');
	Route::get('{path}', 'AdminController@home')->where(['path' => '.*']);

});


/*
|--------------------------------------------------------------------------
| Storefront Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function() { return redirect('home'); });
Route::get('/{path}', 'StoreController@home')->where(['path' => '.*']);
