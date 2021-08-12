<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application web.
     *
     * @var string|null
     */
     protected $namespace = 'App\\Http\\Controllers\\Web';

    /**
     * The controller namespace for the application api.
     *
     * @var string|null
     */
     protected $apiNamespace = 'App\\Http\\Controllers\\Api';

    /**
     * Registering new api version
     *
     * @param $v
     * @return void
     */
     protected function registerApiVersion(string $v): void
     {
         $uv = strtoupper($v);

         Route::group([
             'middleware' => ['api', "api_version:{$v}"],
             'namespace'  => "{$this->apiNamespace}\\{$uv}",
             'prefix'     => "api/{$v}",
         ], function ($router) use ($v) {
             require base_path("routes/api/api_{$v}.php");
         });
     }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Here we will register 3 versions of our API
            // And apply $guard parameters to api_version middleware

            $this->registerApiVersion('v1');
            $this->registerApiVersion('v2');
            $this->registerApiVersion('v3');

            // And we keep this one for supporting web routes also
            // For now only / is supported,
            // Just to not show the blank page,
            // When you opening the project on browser

            Route::group([
                'middleware' => ['web'],
                'namespace'  => $this->namespace
            ], function ($router) {
                require base_path('routes/web.php');
            });
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
