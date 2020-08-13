# laravel-crypton
## Installation

Via Composer

``` bash
$ composer require chapdel/laravel-crypton
```

## Configuration

> If you are using `Laravel 5.5` or above you don't need to add the provider and alias.

If you are using `Laravel 5.4` or older add these in the `config/app.php`

```php
'providers' => [
    //...
    'Chapdel\CryptOn\CryptOnServiceProvider',
],
```
Add an environment veriable in the `.env` file

```env
CRYPTON_KEY=your-encryption-key
```

> **TIP:** You can easily generate an encryption key by running `php artisan key:generate` then copy the generated key. Then again run: `php artisan key:generate` to make the key used by crypton and the default application key different.

**WARNING: DO NOT USE THE SAME `APP_KEY` AND `CRYPTON_KEY`**

## Usage

Start off by adding a Middleware in the `app/Http/Kernel.php` file.

```php
$routeMiddleware = [
    'crypton' => \Chapdel\CryptOn\Middleware\CryptOnMiddleware::class,
];
```



Now, add this middleware to any api routes or groups.

Example:

```php
Route::middleware('crypton')->post('some-endpoint', function(Request $request) {
    return Post::paginate($request->per_page ? : 10);
});
```

That's it.

### Javascript adapter

[See Laravel Crypton](https://github.com/tzsk/laravel-crypton)
