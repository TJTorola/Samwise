# Samwise E-Commerce CMS

## Installation Process

1. `composer install`
2. `npm install`
3. Install Virtual Box
4. Install homestead with `php vendor/bin/homestead make`
5. Start up server with `vagrant up`
6. Set up default env variables `cp .env.example .env`
7. Generate a key for Laravel `php artisan key:generate`
8. Run Migrations with `php artisan migrate`
   * You need to tunnel into vagrant for this with `vagrant ssh`
9. Set up storefront enviroment in `\storefront`
10. Access dev site through `homestead.app`

## Frameworks and APIs

Samwise is built on Laravel/PHP in the backend with Elasticsearch for running search-as-you-type features, and Vue.js with Vuex and Vue Router to build a Single Page Application on the frontend. It also uses the Stripe and Easypost APIs for E-Commerce services.

## Storefront Example

View a launched storefront at [Pangolin4x4.com](https://www.pangoling4x4.com).

## Features

### Custom Store Items

Using interfaces generated off of custom-item schemas Samwise eases and abstracts customized item management. This allows for handling any type of item, from T-Shirts to used car parts on the same platform.

Example Schema:

```
"offer" => [
	"auto" => [
		"Application" => [
			[
				"name" => "sI",
				"type" => "boolean"
			],
			[
				"name" => "other_applications",
				"type" => "string",
				"hint" => "Comma separated list."
			],
			...
		],
		"Wheelbase" => [
			[
				"name" => "base_80",
				"display_name" => "80\"",
				"type" => "boolean"
			]
			...
		]
	]
],
'item' => [
	'auto' => [
		[
			"name" => "part_number",
			"display_name" => "Part Number(s)",
			"type" => "string",
			"hint" => "Comma separated list."
		],
		[
			"name" => "ss_part_number",
			"display_name" => "S/S Part Number(s)",
			"type" => "string",
			"hint" => "Comma separated list."
		]
		...
	]
]
```

Here we define two schema's, one for the parent `offer` model, and another for the child `item` model (Note: `offer`s have-many `item`s). Both define the type of `auto`. Notice the offer model allows for multiple catagories of additional info because as much information as possible should be relegated to the parent `offer` model.

The resulting panels are seen below.

**Offer-Panel:**

<img src="https://github.com/TJTorola/Samwise/raw/master/docs/readme_imgs/offer-panel.jpg" width="70%" />

**Item-Panel:**

<img src="https://github.com/TJTorola/Samwise/raw/master/docs/readme_imgs/item-panel.jpg" width="100%" />
