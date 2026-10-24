<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\View;

use App\View\AppView;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Core\PluginInterface;
use Cake\Database\Connection;
use Cake\Database\Driver\Sqlite;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\TestSuite\TestCase;
use DebugKit\DebugKitPlugin;

/**
 * Welcome-page rendering and diagnostic failure states.
 */
class WelcomePageTest extends TestCase
{
    /**
     * @var array<string, string>
     */
    protected array $connectionAliases = [];

    protected ?PluginInterface $debugKit = null;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        Configure::write('debug', true);
        $this->connectionAliases = ConnectionManager::aliases();
        $plugins = Plugin::getCollection();
        $this->debugKit = $plugins->has('DebugKit') ? $plugins->get('DebugKit') : null;
        $plugins->remove('DebugKit');
        ConnectionManager::setConfig('welcome_default', [
            'className' => Connection::class,
            'driver' => Sqlite::class,
            'database' => ':memory:',
        ]);
        ConnectionManager::alias('welcome_default', 'default');
    }

    /**
     * @inheritDoc
     */
    public function tearDown(): void
    {
        foreach (['default', 'debug_kit'] as $name) {
            ConnectionManager::dropAlias($name);
            if (isset($this->connectionAliases[$name])) {
                ConnectionManager::alias($this->connectionAliases[$name], $name);
            }
        }
        ConnectionManager::drop('welcome_default');
        ConnectionManager::drop('welcome_debug_kit');
        Plugin::getCollection()->remove('DebugKit');
        if ($this->debugKit !== null) {
            Plugin::getCollection()->add($this->debugKit);
        }
        parent::tearDown();
    }

    /**
     * A real connection renders successfully without the optional plugin.
     *
     * @return void
     */
    public function testConnectedWithoutDebugKit(): void
    {
        $html = (new AppView())->render('Pages/home');

        $this->assertStringContainsString('Connected to your database.', $html);
        $this->assertStringContainsString('Optional. Enable DebugKit in config/plugins.php.', $html);
        $this->assertStringNotContainsString('Connection details', $html);
        $this->assertStringNotContainsString('milligram', $html);
        $this->assertStringNotContainsString('https://cakephp.org/v2/img/', $html);
    }

    /**
     * The standalone page still supports the standard view blocks.
     *
     * @return void
     */
    public function testViewBlocks(): void
    {
        $view = new AppView();
        $view->assign('title', 'Custom welcome');
        $view->assign('meta', '<meta name="description" content="Custom description">');
        $view->assign('css', '<style>.custom { color: red; }</style>');
        $view->assign('script', '<script src="/custom.js"></script>');
        $html = $view->render('Pages/home');

        $this->assertStringContainsString('<title>Custom welcome</title>', $html);
        $this->assertStringContainsString('<meta name="description" content="Custom description">', $html);
        $this->assertStringContainsString('<style>.custom { color: red; }</style>', $html);
        $this->assertStringContainsString('<script src="/custom.js"></script>', $html);
    }

    /**
     * Driver exception attributes are escaped rather than rendered as markup.
     *
     * @return void
     */
    public function testDatabaseFailureIsEscaped(): void
    {
        $this->failingConnection('welcome_default');
        $html = (new AppView())->render('Pages/home');

        $this->assertStringContainsString('Check Datasources in config/app_local.php.', $html);
        $this->assertStringContainsString('Connection details', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(&quot;connection&quot;)&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<script>alert("connection")</script>', $html);
    }

    /**
     * DebugKit retains the actual exception and separately renders trusted help.
     *
     * @return void
     */
    public function testDebugKitFailureIsEscaped(): void
    {
        Plugin::getCollection()->add(new DebugKitPlugin());
        $this->failingConnection('welcome_debug_kit');
        ConnectionManager::alias('welcome_debug_kit', 'debug_kit');
        $html = (new AppView())->render('Pages/home');

        $this->assertStringContainsString('Check the DebugKit database configuration.', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(&quot;connection&quot;)&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<script>alert("connection")</script>', $html);
        $this->assertStringContainsString('https://book.cakephp.org/debugkit/', $html);
    }

    /**
     * DebugKit's successful connection is also reported.
     *
     * @return void
     */
    public function testDebugKitConnected(): void
    {
        Plugin::getCollection()->add(new DebugKitPlugin());
        ConnectionManager::setConfig('welcome_debug_kit', [
            'className' => Connection::class,
            'driver' => Sqlite::class,
            'database' => ':memory:',
        ]);
        ConnectionManager::alias('welcome_debug_kit', 'debug_kit');
        $html = (new AppView())->render('Pages/home');

        $this->assertStringContainsString('Loaded for development.', $html);
        $this->assertStringContainsString('Connected to its database.', $html);
        $this->assertStringNotContainsString('Connection details', $html);
    }

    /**
     * Production mode rejects the page before opening a connection.
     *
     * @return void
     */
    public function testProductionDoesNotConnect(): void
    {
        Configure::write('debug', false);
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->never())->method('getDriver');
        ConnectionManager::drop('welcome_default');
        ConnectionManager::setConfig('welcome_default', $connection);

        $this->expectException(NotFoundException::class);
        (new AppView())->render('Pages/home');
    }

    /**
     * Configure a driver that fails with unsafe exception text.
     *
     * @param string $name Connection name.
     * @return void
     */
    protected function failingConnection(string $name): void
    {
        $driver = $this->createMock(Sqlite::class);
        $driver->expects($this->once())->method('connect')->willThrowException(new MissingConnectionException([
            'driver' => 'Sqlite',
            'message' => '<script>alert("connection")</script>',
        ]));
        $connection = $this->createMock(Connection::class);
        $connection->expects($this->once())->method('getDriver')->willReturn($driver);
        ConnectionManager::drop($name);
        ConnectionManager::setConfig($name, $connection);
    }
}
