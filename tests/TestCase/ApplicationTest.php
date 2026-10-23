<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase;

use App\Application;
use App\Middleware\HostHeaderMiddleware;
use Cake\Core\Configure;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * ApplicationTest class
 */
class ApplicationTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Test bootstrap in production.
     *
     * @return void
     */
    public function testBootstrap()
    {
        Configure::write('debug', false);
        $app = new Application(dirname(__DIR__, 2) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();

        $this->assertTrue($plugins->has('Bake'), 'plugins has Bake?');
        $this->assertFalse($plugins->has('DebugKit'), 'plugins has DebugKit?');
        $this->assertTrue($plugins->has('Migrations'), 'plugins has Migrations?');
    }

    /**
     * Test bootstrap add DebugKit plugin in debug mode.
     *
     * @return void
     */
    public function testBootstrapInDebug()
    {
        Configure::write('debug', true);
        $app = new Application(dirname(__DIR__, 2) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();

        $this->assertTrue($plugins->has('DebugKit'), 'plugins has DebugKit?');
    }

    /**
     * testMiddleware
     *
     * @return void
     */
    public function testMiddleware()
    {
        $app = new Application(dirname(__DIR__, 2) . '/config');
        $middleware = new MiddlewareQueue();

        $middleware = $app->middleware($middleware);

        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->current());
        $middleware->seek(1);
        $this->assertInstanceOf(HostHeaderMiddleware::class, $middleware->current());
        $middleware->seek(2);
        $this->assertInstanceOf(AssetMiddleware::class, $middleware->current());
        $middleware->seek(3);
        $this->assertInstanceOf(RoutingMiddleware::class, $middleware->current());
    }

    /**
     * Optional route files load alongside the controller attributes.
     *
     * @return void
     */
    public function testOptionalRouteConfiguration(): void
    {
        $configDir = TMP . 'route-configuration' . DS;
        mkdir($configDir);
        $routesFile = $configDir . 'routes.php';
        file_put_contents($routesFile, <<<'PHP'
<?php
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->get('/custom', ['controller' => 'Pages', 'action' => 'display', 'custom'], 'custom');
};
PHP);

        try {
            $application = new Application($configDir);
            $application->routes(Router::createRouteBuilder('/'));

            $this->assertSame('/custom', Router::url(['_name' => 'custom']));
            $this->assertSame('/', Router::url(['_name' => 'home']));
        } finally {
            unlink($routesFile);
            rmdir($configDir);
        }
    }

    /**
     * Controller attributes work without a routes configuration file.
     *
     * @return void
     */
    public function testRoutingWithoutConfigurationFile(): void
    {
        $configDir = TMP . 'route-configuration' . DS;
        mkdir($configDir);

        try {
            $application = new Application($configDir);
            $application->routes(Router::createRouteBuilder('/'));

            $this->assertSame('/', Router::url(['_name' => 'home']));
            $this->assertSame('/pages/home', Router::url(['_name' => 'pages', 'home']));
        } finally {
            rmdir($configDir);
        }
    }
}
