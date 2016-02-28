<?php

/*
|--------------------------------------------------------------------------
| API Routes (Laravel Resources)
|--------------------------------------------------------------------------
*/

Route::group(['domain' => 'api.'.env('STORE_DOMAIN')], function() {

	/*
	|--------------------------------------------------------------------------
	| Auth Group (Handling authentication)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'auth'], function() {

		Route::post('login', 'AuthController@login');
		Route::get('logout', 'AuthController@logout');
		Route::post('register', 'AuthController@register');

	});

	/*
	|--------------------------------------------------------------------------
	| Cart Group (Viewing a user's cart)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'cart'], function() {

		Route::get('/', 'CartController@index');
		Route::post('/', 'CartController@store');
		Route::delete('/', 'CartController@clear');
		Route::patch('{item}', 'CartController@update');
		Route::delete('{item}', 'CartController@destroy');

		Route::post('test', 'CartController@test');
		
	});

	/*
	|--------------------------------------------------------------------------
	| Catalogs Group (Mix it up with the catalogs)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'catalogs'], function() {

		Route::get('/', 'CatalogsController@index');
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
	Route::group(['prefix' => 'customers'], function() {

		Route::get('/', 'CustomersController@index');
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
	| Inventory Group (Control the inventory)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'inventory'], function() {

		Route::get('/', 'InventoryController@index');
		Route::post('/', 'InventoryController@store');
		Route::get('{item}', 'InventoryController@show');
		Route::patch('{item}', 'InventoryController@update');
		Route::delete('{item}', 'InventoryController@destroy');
		
		Route::get('{item}/variants', 'ItemVariantsController@index');
		Route::post('{item}/variants', 'ItemVariantsController@store');
		Route::get('variants/{variant}', 'ItemVariantsController@show');
		Route::post('variants/{variant}', 'ItemVariantsController@update');
		Route::delete('variants/{variant}', 'ItemVariantsController@destroy');

		Route::get('{item}/images', 'InventoryImageController@show');
		Route::post('{item}/images', 'InventoryImageController@store');
		Route::delete('{item}/images', 'InventoryImageController@destroy');

	});

	/*
	|--------------------------------------------------------------------------
	| Invoices Group (View/Modify customer invoices)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'invoices'], function() {

		Route::get('/', 'InvoicesController@index');
		Route::post('/', 'InvoicesController@store');
		Route::get('{invoice}', 'InvoicesController@show');
		Route::patch('{invoice}', 'InvoicesController@update');
		Route::delete('{invoice}', 'InvoicesController@destroy');

		Route::get('{invoice}/cart', 'InvoicesCartController@index');
		Route::post('{invoice}/cart', 'InvoicesCartController@store');
		Route::get('cart/{item}', 'InvoicesCartController@show');
		Route::post('cart/{item}', 'InvoicesCartController@update');
		Route::delete('cart/{item}', 'InvoicesCartController@destroy');
		
	});

	/*
	|--------------------------------------------------------------------------
	| Pages Group (Modify indevidual pages)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'pages'], function() {

		Route::get('/', 'PagesController@index');
		Route::post('/', 'PagesController@store');
		Route::get('{page}', 'PagesController@show')->where(['page' => '.*']);
		Route::patch('{page}', 'PagesController@update');
		Route::delete('{page}', 'PagesController@destroy');
		
	});

	/*
	|--------------------------------------------------------------------------
	| Settings Group (Configure the system)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'settings'], function() {

		Route::get('/', 'SettingsController@index');
		Route::post('/', 'SettingsController@store');
		Route::get('{setting}', 'SettingsController@show');
		Route::patch('{setting}', 'SettingsController@patch');
		Route::delete('{setting}', 'SettingsController@destroy');
		
	});

	/*
	|--------------------------------------------------------------------------
	| Storage Group (Accessing file storage)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'storage'], function() {

		Route::get('/', 'ImageController@index');
		Route::post('/', 'ImageController@store');
		Route::delete('/', 'ImageController@destroy');
		
	});

	/*
	|--------------------------------------------------------------------------
	| User Group (Handling admin users)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'users'], function() {

		Route::get('/', 'UsersController@index');
		Route::get('{user}', 'UsersController@show');

		Route::get('whoami', 'UsersController@self');
		
	});

	/*
	|--------------------------------------------------------------------------
	| Tags Group (Retrieve tags and tag usage)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'tags'], function() {

		Route::get('/', 'TagsController@index');
		
	});

	/*
	|--------------------------------------------------------------------------
	| Todo Group (Handles user todos)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'todos'], function() {

		Route::get('/', 'TodosController@index');
		Route::post('/', 'TodosController@store');
		Route::delete('/', 'TodosController@destroy');
		
	});

	/*
	|--------------------------------------------------------------------------
	| Types Group (Return static type data)
	|--------------------------------------------------------------------------
	*/
	Route::group(['prefix' => 'types'], function() {

		Route::get('/', 'TypesController@index');
		Route::get('{type_name}', 'TypesController@show');
		
	});
});


/*
|--------------------------------------------------------------------------
| Search Routes (ElasticSearch Resources)
|--------------------------------------------------------------------------
*/

Route::group(['domain' => 'search.'.env('STORE_DOMAIN')], function() {

	Route::post('/item', 'SearchController@items');

});


/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/

Route::group(['domain' => 'admin.'.env('STORE_DOMAIN')], function() {

	Route::get('/', 'AdminController@home');

});


/*
|--------------------------------------------------------------------------
| Storefront Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function() { return redirect('home'); });
Route::get('/{path}', 'StoreController@home')->where(['path' => '.*']);