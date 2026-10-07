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
 * @since         1.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\Controller;

use App\Test\TestApp\Application;
use Cake\Core\Configure;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * PagesControllerTest class
 */
class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * testDisplay method
     *
     * @return void
     */
    public function testDisplay(): void
    {
        Configure::write('debug', true);
        $this->get('/pages/home');
        $this->assertResponseOk();
        $this->assertResponseContains('CakePHP');
        $this->assertResponseContains('<html>');
    }

    /**
     * Test the named attribute route for the home page.
     *
     * @return void
     */
    public function testHome(): void
    {
        Configure::write('debug', true);
        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('CakePHP');
        $this->assertResponseContains('8.4.0 or higher');
        $this->assertSame('/', Router::url(['_name' => 'home']));
        $this->assertSame('/pages/home', Router::url(['_name' => 'pages', 'home']));
        $routes = Router::getRouteCollection()->named();
        $this->assertInstanceOf(DashedRoute::class, $routes['home']);
        $this->assertInstanceOf(DashedRoute::class, $routes['pages']);
    }

    /**
     * Test that fallback URLs are not connected.
     *
     * @return void
     */
    public function testNoFallbackRoutes(): void
    {
        Configure::write('debug', true);
        $this->get('/unrouted/index');
        $this->assertResponseCode(404);
        $this->assertResponseContains('Missing Route');
    }

    /**
     * Test that static pages do not accept POST requests, even with a CSRF token.
     *
     * @return void
     */
    public function testPostNotRouted(): void
    {
        $this->enableCsrfToken();
        $this->post('/pages/home');
        $this->assertResponseCode(404);
    }

    /**
     * Test that missing template renders 404 page in production
     *
     * @return void
     */
    public function testMissingTemplate(): void
    {
        Configure::write('debug', false);
        $this->get('/pages/not_existing');

        $this->assertResponseError();
        $this->assertResponseContains('Error');
    }

    /**
     * Test that missing template in debug mode renders missing_template error page
     *
     * @return void
     */
    public function testMissingTemplateInDebug(): void
    {
        Configure::write('debug', true);
        $this->get('/pages/not_existing');

        $this->assertResponseFailure();
        $this->assertResponseContains('Missing Template');
        $this->assertResponseContains('stack-frames');
        $this->assertResponseContains('not_existing.php');
    }

    /**
     * Test that wildcard routes retain nested page paths.
     *
     * @return void
     */
    public function testNestedMissingTemplateInDebug(): void
    {
        Configure::write('debug', true);
        $this->get('/pages/nested/not_existing');
        $this->assertResponseFailure();
        $this->assertResponseContains('nested/not_existing.php');
    }

    /**
     * Test directory traversal protection
     *
     * @return void
     */
    public function testDirectoryTraversalProtection(): void
    {
        $this->get('/pages/../Layout/ajax');
        $this->assertResponseCode(403);
        $this->assertResponseContains('Forbidden');
    }

    /**
     * Test that CSRF protection is applied to page rendering.
     *
     * @return void
     */
    public function testCsrfAppliedError(): void
    {
        $this->configApplication(Application::class, [CONFIG]);
        $this->post('/csrf-test', ['hello' => 'world']);

        $this->assertResponseCode(403);
        $this->assertResponseContains('CSRF');
    }

    /**
     * Test that CSRF protection is applied to page rendering.
     *
     * @return void
     */
    public function testCsrfAppliedOk(): void
    {
        Configure::write('debug', true);
        $this->configApplication(Application::class, [CONFIG]);
        $this->enableCsrfToken();
        $this->post('/csrf-test', ['hello' => 'world']);

        $this->assertResponseOk();
        $this->assertResponseNotContains('CSRF');
    }
}
