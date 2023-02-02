<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## **Social Login**

in this fresh installed version 9.50 of laravel are following implemented:

- Laravel Auth / Login-System with Vue and vite
- made possible social login using laravel/socialite
- Social logins are done only for github and gitlab
- it can be easily extended for other platforms as well 
- have a look at https://socialiteproviders.netlify.com/about.html

> This package is used for educational purposes only
>  
> Use at your own risk.

### **Installing using CLI** 
```bash
$ git clone https://github.com/anwari786/laravel-social-login.git test-laravel

$ cd test-laravl

$ composer install

$ php artisan migrate:fresh

$ npm install & npm run dev

```

## Some useful code snippets of this project.


### taken from Socialite-Providers Website
```php
//config/services.php
'github' => [
    'client_id' => env('GITHUB_KEY'),
    'client_secret' => env('GITHUB_SECRET'),
    'redirect' => env('GITHUB_REDIRECT_URI')
],
```
### Add necessary  actions for providers in LoginController
```php
//LoginController

/**
 * Social Login action
 * @param mixed $provider
 * @return mixed
 */
public function redirectToProvider($provider)
{

    if(!empty($provider)){

        return Socialite::driver($provider)->redirect();
    }

    return redirect()->route('login');
    
}

/**
 * Callback for provider of Social Login 
 * @param mixed $provider
 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
 */
public function handleProviderCallback($provider)
{
    try {

        $oauthUser = Socialite::driver($provider)->user();

    } catch (\Exception $e) {

        return redirect()->route('login');
    }

    $oauthUser = $this->findOrCreateUser($oauthUser, $provider);

    Auth::login($oauthUser, true);

    return redirect($this->redirectTo);
}


/**
 * find an existing User/SocialAuth User, otherwise create one.
 * If user logs with same email from different providers, 
 * email should be modifed cause email in user table is unique.
 * @param mixed $oauthUser
 * @param mixed $provider
 * @return mixed
 */
public function findOrCreateUser($oauthUser, $provider)
{
    $existingOAuth = SocialAuth::where('provider_name', $provider)
        ->where('provider_id', $oauthUser->getId())
        ->first();

    if ($existingOAuth) {
        return $existingOAuth->user;
    } else {
        //check User for provider_id and provider_name if exist
        $user = User::where('provider_id', $oauthUser->getId())
                    ->where('provider_name', $provider)
                    ->first();

        if (!$user) {
            //check User only for email if exist
            $user = User::whereEmail($oauthUser->getEmail())->first();

            //modify email if exist cause it should be unique
            $email = (!$user) ? $oauthUser->getEmail() : $provider.'_'.$oauthUser->getEmail();

            $user = User::create([
                'email' => $email,
                'name' => $oauthUser->getName(),
                'provider_name' => $provider,
                'provider_id' => $oauthUser->getId(),
            ]);
        }

        $user->oauth()->create([
            'provider_id' => $oauthUser->getId(),
            'provider_name' => $provider,
            'avatar' => $oauthUser->getAvatar(),
        ]);

        return $user;
    }
}
```

### Add Routes to web.php
```php
<?php
//web.php
Route::get('auth/{provider}', [LoginController::class, 'redirectToProvider'])->name('to_provider');

Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);

```







## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
