# JWTAuth plugin for Lovata.Buddies and RainLab.User*
*RainLab.User support will be added soon.

This plugin adds to your application functionality to authenticate with JWT tokens easily, no additional settings or code required.

## Requirements

- PHP 7.4 and higher
- October CMS v2 and higher

## Installation

1. Install plugin via terminal in your enviroment:
```bash
php artisan plugin:install ReaZzon.JWTAuth
```

2. Generate JWT Secret:
```bash
php artisan jwt:secret
```

## Middleware

To use JWT Middleware, put `ResolveUser` middleware in your routes. Example below:

```php
Route::group(['middleware' => [\ReaZzon\JWTAuth\Http\Middlewares\ResolveUser::class]], function () {

  // Routes only for authenticated users
  
});
```

or 

```php
Route::get('account', function () {

   // Logic that should be available only for authenticated users
   
})->middleware(\ReaZzon\JWTAuth\Http\Middlewares\ResolveUser::class);
```

## Routes

- **POST** `/jwt/login` - Login route
- **POST** `/jwt/register` - Registration route
- **POST** `/jwt/activate` - Activation route (if activation set to mail)
- **POST** `/jwt/refresh` - Refresh route

## Suggestions, Ideas, Issues, Bugs


We are open to your suggestions and ideas in public repository of this plugin [GitHub](https://github.com/FlusherDock1/JWTAuth)


---
© 2021, Nick Khaetsky and Vladimir Pyankov under the [MIT license](https://opensource.org/licenses/MIT).

Russian October CMS comminuty [OctoClub](https://octoclub.ru/).
