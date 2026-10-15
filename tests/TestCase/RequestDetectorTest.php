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
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase;

use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use ErrorException;

/**
 * Tests the mobile and tablet detectors registered in config/bootstrap.php.
 */
class RequestDetectorTest extends TestCase
{
    protected const IPHONE_USER_AGENT = 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) '
        . 'AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1';

    protected const IPAD_USER_AGENT = 'Mozilla/5.0 (iPad; CPU OS 17_0 like Mac OS X) '
        . 'AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1';

    protected const DESKTOP_USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) '
        . 'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

    /**
     * Test the detectors read the User-Agent from the request environment.
     *
     * @return void
     */
    public function testDetectorsUseRequestEnvironment(): void
    {
        $phone = new ServerRequest(['environment' => ['HTTP_USER_AGENT' => self::IPHONE_USER_AGENT]]);
        $this->assertTrue($phone->is('mobile'));
        $this->assertFalse($phone->is('tablet'));

        $tablet = new ServerRequest(['environment' => ['HTTP_USER_AGENT' => self::IPAD_USER_AGENT]]);
        $this->assertTrue($tablet->is('mobile'));
        $this->assertTrue($tablet->is('tablet'));

        $desktop = new ServerRequest(['environment' => ['HTTP_USER_AGENT' => self::DESKTOP_USER_AGENT]]);
        $this->assertFalse($desktop->is('mobile'));
        $this->assertFalse($desktop->is('tablet'));
    }

    /**
     * Test the detectors follow a User-Agent header changed after construction.
     *
     * @return void
     */
    public function testDetectorsUseChangedHeader(): void
    {
        $request = new ServerRequest(['environment' => ['HTTP_USER_AGENT' => self::DESKTOP_USER_AGENT]]);
        $request = $request->withHeader('User-Agent', self::IPHONE_USER_AGENT);

        $this->assertTrue($request->is('mobile'));
    }

    /**
     * Test the detectors handle array header values and non-string server params.
     *
     * @return void
     */
    public function testDetectorsWithArrayValues(): void
    {
        $request = new ServerRequest(['environment' => ['argv' => ['bin/cake'], 'argc' => 1]]);
        $request = $request->withHeader('User-Agent', [self::IPHONE_USER_AGENT])
            ->withHeader('Accept', ['text/html']);

        // Fail on "Array to string conversion" warnings instead of only reporting them.
        set_error_handler(function (int $severity, string $message): never {
            throw new ErrorException($message, 0, $severity);
        });
        try {
            $this->assertTrue($request->is('mobile'));
            $this->assertFalse($request->is('tablet'));
        } finally {
            restore_error_handler();
        }
    }

    /**
     * Test the detectors do not fail without a User-Agent.
     *
     * @return void
     */
    public function testDetectorsWithoutUserAgent(): void
    {
        $request = new ServerRequest();

        $this->assertFalse($request->is('mobile'));
        $this->assertFalse($request->is('tablet'));
    }
}
