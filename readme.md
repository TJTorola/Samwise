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