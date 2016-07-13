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
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Console;

use Composer\Script\Event;
use Exception;

/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */
class Installer
{

    /**
     * Does some routine project creation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     */
    public static function postCreateProjectCmd(Event $event)
    {        
        static::createAppConfig($event);
        static::setSecuritySalt($event);
        // if a composer.lock is given, create-project will trigger an install
        // if no composer.lock is given, create-project will trigger an update
        // see:
        // https://getcomposer.org/doc/articles/scripts.md#command-events
        // https://getcomposer.org/doc/03-cli.md#create-project
        // https://github.com/composer/composer/issues/5079#issuecomment-197940603
        // https://github.com/composer/composer/issues/5066#issuecomment-197006540
    }

    /**
     * Does some routine update tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     */
    public static function postUpdateCmd(Event $event)
    {
        static::createTmpLogsFoldersAndSetPermissions($event);

        if (class_exists('\Cake\Codeception\Console\Installer')) {
            \Cake\Codeception\Console\Installer::customizeCodeceptionBinary($event);
        }        
    }

    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     */
    public static function postInstallCmd(Event $event)
    {
        static::createTmpLogsFoldersAndSetPermissions($event);
    }

    /**
     * Set the security.salt value in the application's config file.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     */
    public static function setSecuritySalt($event)
    {
        $dir = dirname(dirname(__DIR__));
        $io = $event->getIO();

        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $newKey = hash('sha256', $dir . php_uname() . microtime(true));
        $content = str_replace('__SALT__', $newKey, $content, $count);

        if ($count == 0) {
            $io->write('No Security.salt placeholder to replace.');
            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated Security.salt value in config/app.php');
            return;
        }
        $io->write('Unable to update Security.salt value.');
    }

    /**
     * Creates writable tmp and logs folders. Asks to set permissions to world read/writable.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @throws \Exception Exception raised by validator.
     * @return void
     */
    public static function createTmpLogsFoldersAndSetPermissions($event)
    {
        $io = $event->getIO();
        $rootDir = dirname(dirname(__DIR__));
        
        static::createWritableDirectories($rootDir, $io);

        // ask if the permissions should be changed
        if ($io->isInteractive()) {
            $validator = function ($arg) {
                if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                    return $arg;
                }
                throw new Exception('This is not a valid answer. Please choose Y or n.');
            };
            $setFolderPermissions = $io->askAndValidate(
                '<info>Set Folder Permissions for other to read/writeable ? (Default to Y)</info> [<comment>Y,n</comment>]? ',
                $validator,
                10,
                'Y'
            );

            if (in_array($setFolderPermissions, ['Y', 'y'])) {
                static::setFolderPermissions($rootDir, $io);
            }
        } else {
            static::setFolderPermissions($rootDir, $io);
        }
    }

    /**
     * Create the config/app.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createAppConfig($dir, $io)
    {
        $dir = dirname(dirname(__DIR__));
        $io = $event->getIO();

        $appConfig = $dir . '/config/app.php';
        $defaultConfig = $dir . '/config/app.default.php';
        if (!file_exists($appConfig)) {
            copy($defaultConfig, $appConfig);
            $io->write('Created `config/app.php` file');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createWritableDirectories($dir, $io)
    {
        $paths = [
            'logs',
            'tmp',
            'tmp/cache',
            'tmp/cache/models',
            'tmp/cache/persistent',
            'tmp/cache/views',
            'tmp/sessions',
            'tmp/tests'
        ];

        foreach ($paths as $path) {
            $path = $dir . '/' . $path;
            if (!file_exists($path)) {
                mkdir($path);
                $io->write('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setFolderPermissions($dir, $io)
    {
        // Change the permissions on a path and output the results.
        $changePerms = function ($path, $perms, $io) {
            // Get permission bits from stat(2) result.
            $currentPerms = fileperms($path) & 0777;
            if (($currentPerms & $perms) == $perms) {
                return;
            }

            $res = chmod($path, $currentPerms | $perms);
            if ($res) {
                $io->write('Permissions set on ' . $path);
            } else {
                $io->write('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir, $perms, $io) use (&$walker, $changePerms) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;

                if (!is_dir($path)) {
                    continue;
                }

                $changePerms($path, $perms, $io);
                $walker($path, $perms, $io);
            }
        };

        $worldWritable = 0007;
        $walker($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/logs', $worldWritable, $io);
    }
}
