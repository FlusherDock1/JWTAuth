# JWTAuth plugin for Lovata.Buddies and RainLab.User*
*RainLab.User support will be added soon.

This plugin adds to your application functionality to authenticate with JWT tokens easily, no additional settings or code required.

## Requirements

- PHP 7.4 and higher
- October CMS v2 and higher

## Installation


```bash
php artisan plugin:install ReaZzon.JWTAuth
```

## Middleware

To use JWT Middleware, put `ResolveUser` middleware in your routes. Example below:

```php
Route::group(['middleware' => [\ReaZzon\JWTAuth\Http\Middlewares\ResolveUser::class]], function () {

  // Routes only for authenticated users
  
});
```

## Suggestions, Ideas, Issues, Bugs


We are open to your suggestions and ideas in public repository of this plugin [GitHub](https://github.com/FlusherDock1/JWTAuth)


---
© 2021, Nick Khaetsky and Vladimir Pyankov under the [MIT license](https://opensource.org/licenses/MIT).

Russian October CMS comminuty [OctoClub](https://octoclub.ru/).
