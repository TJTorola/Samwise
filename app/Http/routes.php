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
	Route::get('catalogs', 'CatalogsController@index');
	Route::group(['prefix' => 'catalog'], function() {

		Route::post('/', 'CatalogsController@store');
		Route::get('{catalog}', 'CatalogsController@show');
		Route::patch('{catalog}', 'CatalogsController@update');
		Route::delete('{catalog}', 'CatalogsController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Customers Group (Keep those customers happy)
	|--------------------------------------------------------------------------
	*/
	Route::get('customers', 'CustomersController@index');
	Route::group(['prefix' => 'customer'], function() {

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

		Route::post('invoice/{invoice}', 'EmailController@invoice');

	});

	/*
	|--------------------------------------------------------------------------
	| Images Group (Manage store images)
	|--------------------------------------------------------------------------
	*/
	Route::get('images', 'ImagesController@index');
	Route::group(['prefix' => 'image'], function() {

		Route::post('/', 'ImagesController@store');
		Route::delete('/', 'ImagesController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Invoices Group (View/Modify customer invoices)
	|--------------------------------------------------------------------------
	*/
	Route::get('invoices', 'InvoicesController@index');
	Route::group(['prefix' => 'invoice'], function() {

		Route::post('/', 'InvoicesController@store');
		Route::get('{invoice}', 'InvoicesController@show');
		Route::patch('{invoice}', 'InvoicesController@update');
		Route::delete('{invoice}', 'InvoicesController@destroy');

		Route::get('{invoice}/cart', 'InvoicesController@indexItems');
		Route::get('{invoice}/items', 'InvoicesController@indexItems');
		Route::post('{invoice}/item', 'InvoicesController@storeItem');

		Route::get('{invoice}/payments', 'InvoicesController@indexPayments');
		Route::post('{invoice}/payment', 'InvoicesController@storePayment');

	});

	/*
	|--------------------------------------------------------------------------
	| Invoice Items Group (Control the cart)
	|--------------------------------------------------------------------------
	*/

	Route::get('invoice-items', 'InvoiceItemsController@index');
	Route::group(['prefix' => 'invoice-item'], function() {

		Route::get('{invoiceItem}', 'InvoiceItemsController@show');
		Route::patch('{invoiceItem}', 'InvoiceItemsController@update');
		Route::delete('{invoiceItem}', 'InvoiceItemsController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Items Group (Control the inventory)
	|--------------------------------------------------------------------------
	*/
	Route::get('inventory', 'ItemsController@index');
	Route::get('items', 'ItemsController@index');
	Route::group(['prefix' => 'item'], function() {

		Route::post('/', 'ItemsController@store');
		Route::get('{item}', 'ItemsController@show');
		Route::get('{item}/admin', 'ItemsController@showAdmin'); // ->middleware('auth:inventory')
		Route::patch('{item}', 'ItemsController@update');
		Route::delete('{item}', 'ItemsController@destroy');

		Route::get('{item}/variants', 'ItemsController@indexVariants');
		Route::post('{item}/variant', 'ItemsController@storeVariant');

		Route::get('{item}/images', 'ItemsController@indexImages');
		Route::post('{item}/image', 'ItemsController@storeImage');
		Route::patch('{item}/image', 'ItemsController@updateImage');
		Route::delete('{item}/image', 'ItemsController@destroyImage');

	});

	/*
	|--------------------------------------------------------------------------
	| Item Variants Group (Control the inventory stock)
	|--------------------------------------------------------------------------
	*/
	Route::get('item-variants', 'ItemVariantsController@index');
	Route::group(['prefix' => 'item-variant'], function() {

		Route::get('{itemVariant}', 'ItemVariantsController@show');
		Route::patch('{itemVariant}', 'ItemVariantsController@update');
		Route::delete('{itemVariant}', 'ItemVariantsController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Pages Group (Modify indevidual pages)
	|--------------------------------------------------------------------------
	*/
	Route::get('pages', 'PagesController@index');
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

		Route::post('/', 'SettingsController@store');
		Route::get('{setting}', 'SettingsController@show');
		Route::patch('{setting}', 'SettingsController@update');
		Route::delete('{setting}', 'SettingsController@destroy');

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
	Route::get('{path}', 'AdminController@home')->where(['path' => '.*']);

});


/*
|--------------------------------------------------------------------------
| Storefront Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function() { return redirect('home'); });
Route::get('/{path}', 'StoreController@home')->where(['path' => '.*']);
