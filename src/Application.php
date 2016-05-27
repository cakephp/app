<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
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
