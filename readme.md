# Laravel URL Shortener

[Live Demo](https://hpvk.com/)

## Introduction
This is a URL shortener featuring a Laravel backend and a a Vue.js frontend.

It's main features are:
* Shorten links
* Dashboard with a graph
* Continuous integration with Github Actions
* Vue frontend interacting with the Laravel API
* Unit and integration tests for the core appication logic

## Installation

1. Clone this repository
```bash
git clone git@github.com:vankatwijk/hpvk-urlshortener-filetransfer-tempemail-laravel-vue.git
```

2. Install dependencies
```bash
composer install
```

3. Copy .env.example to .env
```bash
cp .env.example .env
```

4. Generate app key
```bash
php artisan key:generate
```

4. Set these keys in .env.
```bash
APP_URL
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
DB_TEST_DATABASE
DB_TEST_DATABASE_USERNAME
DB_TEST_DATABASE_PASSWORD
HASHIDS_SALT="Enter a random string here"
```
Note: SQLite not supported as the driver for tests.
 
5. Install dependencies
```bash
npm install
```

6. Compile dependencies
```bash
npm run dev
```

## Under the hood

This project uses the [hashids](https://github.com/vinkla/hashids)
library to generate unique strings from database ids.

[EncoderServiceProvider.php](https://github.com/eacdev/laravel-url-shortener/blob/master/app/Providers/EncoderServiceProvider.php)
```php
public function register()
{
    $this->app->singleton('encoder', function ($app) {
        return new Hashids(env('HASHIDS_SALT'), env('HASHIDS_MIN_LENGTH'));
    });
}
```

[Link.php](https://github.com/eacdev/laravel-url-shortener/blob/master/app/Link.php#L28)
```php
public function getShortAttribute()
{
    return app()->encoder->encode($this->id);
}

...

public function resolveRouteBinding($value)
{
    // Check if it's a hashid encoded short link
    if (count(app()->encoder->decode($value)) > 0) {
        $decodedId = app()->encoder->decode($value)[0];
        return $this->where('id', $decodedId)->first();
    }

    abort(404);
}
```

## Contributing
Pull requests are welcome. Please open an issue to discuss.

## License
[MIT](https://choosealicense.com/licenses/mit/)
