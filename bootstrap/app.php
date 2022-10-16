<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades(
    true,
    [

    ]
);

$app->withEloquent();

$app->alias('cache', Illuminate\Cache\CacheManager::class);

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');
$app->configure('auth');
$app->configure('cors');
$app->configure('hashids');
$app->configure('helo');
$app->configure('localization');
$app->configure('mail');
$app->configure('permission');
$app->configure('query-builder');
$app->configure('repository');
$app->configure('services');
$app->configure('setting');
$app->configure('swagger-lume');

$app->alias('mail.manager', Illuminate\Mail\MailManager::class);
$app->alias('mail.manager', Illuminate\Contracts\Mail\Factory::class);

$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware(
    [
        App\Http\Middleware\LocalizationMiddleware::class,
    ]
);

$app->routeMiddleware(
    [
        'auth' => App\Http\Middleware\Authenticate::class,
        'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role' => Spatie\Permission\Middlewares\RoleMiddleware::class,
        'client' => Laravel\Passport\Http\Middleware\CheckClientCredentials::class,
        'throttle' => GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware::class,
    ]
);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\AppServiceProvider::class);
$app->register(Coderello\SocialGrant\Providers\SocialGrantServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
$app->register(GrahamCampbell\Throttle\ThrottleServiceProvider::class);
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Laravel\Socialite\SocialiteServiceProvider::class);
$app->register(Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class);
$app->register(Spatie\Fractal\FractalServiceProvider::class);
$app->register(Spatie\Permission\PermissionServiceProvider::class);
$app->register(SwaggerLume\ServiceProvider::class);
$app->register(Spatie\QueryBuilder\QueryBuilderServiceProvider::class);

if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
    $app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
}
if (class_exists('Spatie\LaravelRay\RayServiceProvider')) {
    $app->register('Spatie\LaravelRay\RayServiceProvider');
}
if (class_exists('BeyondCode\HeloLaravel\HeloLaravelServiceProvider')) {
    $app->register('BeyondCode\HeloLaravel\HeloLaravelServiceProvider');
}

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group(
    [
        'namespace' => 'App\Http\Controllers',
    ],
    function (Laravel\Lumen\Routing\Router $router) use ($app) {
        require __DIR__.'/../routes/web.php';
    }
);

return $app;
