<?php


require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

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

$app->withFacades();

$app->withEloquent();

$app->configure('api');
$app->configure('auth');
$app->configure('cors');
$app->configure('hashids');
$app->configure('localization');
$app->configure('permission');
$app->configure('repository');
$app->configure('setting');

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
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    App\Http\Middleware\LocalizationMiddleware::class,
    Spatie\Cors\Cors::class,
]);

$app->routeMiddleware([
    'serializer' => Liyu\Dingo\SerializerSwitch::class,
    'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role' => Spatie\Permission\Middlewares\RoleMiddleware::class,
]);

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


$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\RepositoryServiceProvider::class);
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);
$app->register(Prettus\Repository\Providers\RepositoryServiceProvider::class);
$app->register(Spatie\Permission\PermissionServiceProvider::class);
$app->register(Vinkla\Hashids\HashidsServiceProvider::class);
$app->register(Spatie\Cors\CorsServiceProvider::class);
$app->register(Dingo\Api\Provider\LumenServiceProvider::class);
$app->register(Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class);

$app[Dingo\Api\Auth\Auth::class]->extend('passport', function ($app) {
    return $app[App\Providers\GuardServiceProvider::class];
});
$app[Dingo\Api\Exception\Handler::class]
    ->register(function (Spatie\Permission\Exceptions\RoleAlreadyExists $exception) {
        abort(422, $exception->getMessage());
    });
$app[Dingo\Api\Exception\Handler::class]
    ->register(function (Prettus\Validator\Exceptions\ValidatorException $exception) {
        throw new Dingo\Api\Exception\ValidationHttpException($exception->getMessageBag(), $exception);
    });
$app[Dingo\Api\Exception\Handler::class]
    ->register(function (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
        throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException($exception->getMessage(), $exception);
    });

if (class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
    $app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
}

/*
|--------------------------------------------------------------------------
| Dingo Routes
|--------------------------------------------------------------------------
|
*/

$api = $app[Dingo\Api\Routing\Router::class];

// Version 1
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\V1',
], function ($api) {
    require __DIR__ . '/../routes/v1/api.php';
});

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

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) use ($app) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
