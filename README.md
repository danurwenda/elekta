Laravel-Mongodb-AdminLTE integration.

1. [Usage](#1-usage)
2. [History](#2-history)

## 1. Usage
1. Git clone this project and enter the project directory

2. Install required modules
    ```
    composer install
    npm install
    ```
3. Run Laravel Mix script
    ```
    npm run dev
    ```
4. Create your .env file

5. Now, edit `config/adminlte.php` to configure the title, skin, menu, URLs etc.

## 2. History
This section will elaborate how this project and library were integrated.
> Note: only for Laravel 5.2 and higher
1. Create new laravel project
    ```
    laravel new projectname
    ```
2. Install Laravel-MongoDB library
    ```
    composer require jenssegers/mongodb
    ```
3. Add to service provider in `config/app.php`
    ```php
    Jenssegers\Mongodb\MongodbServiceProvider::class
    ```
4. Change your default database connection name in `config/database.php`
    
    ```php
    'default' => env('DB_CONNECTION','mongodb'),
    ```
    And add a new mongodb connection:
    
    ```php
    'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE'),
    ],
    ```
5. Since we're going to use Laravel's native Auth functionality, add this to service provider
    
    ```php
    'Jenssegers\Mongodb\Auth\PasswordResetServiceProvider',
    ```
6. Install AdminLTE wrapper for Laravel
    
    ```
    composer require jeroennoten/laravel-adminlte
    ```
7. Add to service providers list
    
    ```php
    JeroenNoten\LaravelAdminLte\ServiceProvider::class,
    ```
8. Publish the public assets:

    ```
    php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\ServiceProvider" --tag=assets
    ```
9. Use `make:adminlte` as the replacement for Laravel's `make:auth`
    
    ```
    php artisan make:adminlte
    ```

    This command should be used on fresh applications, just like the `make:auth` command

