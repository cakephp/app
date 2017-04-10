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
 * @since     3.4.2
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Console;

use Composer\Script\Event;

/**
 * Generate phpunit coverage reports
 */
class Coverage
{
    /**
     * Creates the phpunit coverage report
     *
     * Run `composer coverage -- <custom-directory>` to change the default output path
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     */
    public static function generateCoverage(Event $event)
    {
        $io = $event->getIO();
        $rootDir = dirname(dirname(__DIR__));
        $coverageDir = $rootDir . '/tmp/';

        if (isset($event->getArguments()[0])) {
            $coverageDir = $rootDir . '/' . $event->getArguments()[0];
        }
        $coverageDir = escapeshellarg($coverageDir);

        exec('phpunit --log-junit ' . $coverageDir . '/coverage/unitreport.xml --coverage-html ' . $coverageDir . '/coverage --coverage-clover ' . $coverageDir . '/coverage/coverage.xml', $out, $status);

        if ($status !== 0) {
            $io->write("Command failed with status: $status \n");
        } else {
            $io->write("Coverage report succesfully created in $coverageDir");
        }
    }
}
