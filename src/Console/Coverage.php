<?php
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

        exec('phpunit --log-junit ' . $coverageDir . '/coverage/unitreport.xml --coverage-html ' . $coverageDir . '/coverage --coverage-clover ' . $coverageDir . '/coverage/coverage.xml', $out, $status);

        if ($status !== 0) {
            $io->write("Command failed with status: $status \n");
        } else {
            $io->write("Coverage report succesfully created in $coverageDir");
        }
    }
}
