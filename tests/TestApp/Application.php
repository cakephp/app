<?php
declare(strict_types=1);

namespace App\Test\TestApp;

use App\Application as BaseApplication;
use Cake\Routing\RouteBuilder;

/**
 * Application with a POST route used only for CSRF integration tests.
 */
class Application extends BaseApplication
{
    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        parent::routes($routes);

        $routes->post('/csrf-test', ['controller' => 'Pages', 'action' => 'display', 'home']);
    }
}
