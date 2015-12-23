<?php
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Core\Plugin;

/**
 * Additional bootstrapping and configuration for CLI environments should
 * be put here.
 */

// Set the fullBaseUrl to allow URLs to be generated in shell tasks.
// This is useful when sending email from shells.
//Configure::write('App.fullBaseUrl', php_uname('n'));

// Set logs to different files so they don't have permission conflicts.
Configure::write('Log.debug.file', 'cli-debug');
Configure::write('Log.error.file', 'cli-error');

try {
    Plugin::load('Bake');
} catch (MissingPluginException $e) {
    // Do not halt if the plugin is missing
}
