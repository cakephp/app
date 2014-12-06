<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Console;

use Composer\Script\Event;

/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */
class Installer {

/**
 * Does some routine installation tasks so people don't have to.
 *
 * @param \Composer\Script\Event $event The composer event object.
 * @return void
 */
	public static function postInstall(Event $event) {
		$io = $event->getIO();

		$rootDir = dirname(dirname(__DIR__));

		static::createAppConfig($rootDir, $io);

		// ask if the permissions on folders should be changed
		if ($io->isInteractive()) {
			do {
				$setFolderPermissions = $io->ask('<info>Set Folder Permissions ? (Default to Y)</info> [<comment>Y,n</comment>]? ', 'Y');
			} while (!in_array($setFolderPermissions, ['Y', 'y', 'N', 'n']));

			if (in_array($setFolderPermissions, ['Y', 'y'])) {
				static::setFolderPermissions($rootDir, $io);
			}
		}

		static::setSecuritySalt($rootDir, $io);
	}

/**
 * Create the config/app.php file if it does not exist.
 *
 * @param string $dir The application's root directory.
 * @param \Composer\IO\IOInterface $io IO interface to write to console.
 * @return void
 */
	public static function createAppConfig($dir, $io) {
		$appConfig = $dir . '/config/app.php';
		$defaultConfig = $dir . '/config/app.default.php';
		if (!file_exists($appConfig)) {
			copy($defaultConfig, $appConfig);
			$io->write('Created `config/app.php` file');
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
	public static function setFolderPermissions($dir, $io) {
		// Change the permissions on a path and output the results.
		$changePerms = function ($path, $perms, $io) {
			// Get current permissions in decimal format so we can bitmask it.
			$currentPerms = octdec(substr(sprintf('%o', fileperms($path)), -4));
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

		$worldWritable = bindec('0000000111');
		$walker($dir . '/tmp', $worldWritable, $io);
		$changePerms($dir . '/tmp', $worldWritable, $io);
		$changePerms($dir . '/logs', $worldWritable, $io);
	}

/**
 * Set the security.salt value in the application's config file.
 *
 * @param string $dir The application's root directory.
 * @param \Composer\IO\IOInterface $io IO interface to write to console.
 * @return void
 */
	public static function setSecuritySalt($dir, $io) {
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

}
