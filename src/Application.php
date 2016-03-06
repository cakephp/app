<?php
namespace App;

use Cake\Http\BaseApplication;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic, and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * You can include any other files your application needs to bootstrap
     * in a web context here.
     *
     * @return void
     */
    public function bootstrap()
    {
        require_once $this->configDir . '/bootstrap.php';
    }

    /**
     * Setup the middleware your application will use.
     *
     * @param \Cake\Http\MiddlewareStack $middleware The middleware stack to setup.
     * @return \Cake\Http\MiddlewareStack The updated middleware.
     */
    public function middleware($middleware)
    {
        // Catch any exceptions in the lower layers,
        // and make an error page/response
        $middleware->push(new ErrorHandlerMiddleware());

        // Handle plugin/theme assets like CakePHP normally does.
        $middleware->push(new AssetMiddleware());

        // Apply routing
        $middleware->push(new RoutingMiddleware());
        return $middleware;
    }
}
