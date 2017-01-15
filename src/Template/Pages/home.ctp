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
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')):
    throw new NotFoundException(__d('cake_app', 'Please replace src/Template/Pages/home.ctp with your own version.'));
endif;

$cakeDescription = __d('cake_app', 'CakePHP: the rapid development PHP framework');
$cakeVersionName = 'CakePHP ' . (float)Configure::version() . ' Red Velvet';
$minimumPhpVersion = '5.5.9';
$cookbookBaseUrl = __d('cake_app', 'https://book.cakephp.org/3.0/en/');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('home.css') ?>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body>

    <header class="container">
        <div class="logo"><?= $this->Html->image('cake-logo.png') ?></div>
        <h1><?= __d('cake_app', 'Welcome to {0}. Build fast. Grow solid.', $cakeVersionName) ?></h1>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning text-center">
                    <p><?= __d('cake_app', 'Please be aware that this page will not be shown if you turn off debug mode unless you replace src/Template/Pages/home.ctp with your own version.') ?></p>
                </div>
                <?php Debugger::checkSecurityKeys(); ?>
                <div id="url-rewriting-warning" class="alert alert-warning text-center url-rewriting">
                    <p>
                        <?= __d('cake_app', 'URL rewriting is not properly configured on your server.') ?><br />
                        1) <a target="_blank" href="<?= $cookbookBaseUrl ?>installation.html#url-rewriting"><?= __d('cake_app', 'Help me configure it') ?></a><br />
                        2) <a target="_blank" href="<?= $cookbookBaseUrl ?>development/configuration.html#general-configuration"><?= __d('cake_app', "I don't / can't use URL rewriting") ?></a>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2><?= __d('cake_app', 'Environment') ?></h2>
                <ul>
                <?php if (version_compare(PHP_VERSION, $minimumPhpVersion, '>=')): ?>
                    <li class="success"><?= __d('cake_app', 'Your version of PHP is {0} or higher (detected {1}).', $minimumPhpVersion, PHP_VERSION)?></li>
                <?php else: ?>
                    <li class="problem"><?= __d('cake_app', 'Your version of PHP is too low. You need PHP {0} or higher to use CakePHP (detected {1}).', $minimumPhpVersion, PHP_VERSION) ?></li>
                <?php endif; ?>

                <?php if (extension_loaded('mbstring')): ?>
                    <li class="success"><?= __d('cake_app', 'Your version of PHP has the mbstring extension loaded.') ?></li>
                <?php else: ?>
                    <li class="problem"><?= __d('cake_app', 'Your version of PHP does NOT have the mbstring extension loaded.') ?></li>
                <?php endif; ?>

                <?php if (extension_loaded('openssl')): ?>
                    <li class="success"><?= __d('cake_app', 'Your version of PHP has the openssl extension loaded.') ?></li>
                <?php elseif (extension_loaded('mcrypt')): ?>
                    <li class="success"><?= __d('cake_app', 'Your version of PHP has the mcrypt extension loaded.') ?></li>
                <?php else: ?>
                    <li class="problem"><?= __d('cake_app', 'Your version of PHP does NOT have the openssl or mcrypt extension loaded.') ?></li>
                <?php endif; ?>

                <?php if (extension_loaded('intl')): ?>
                    <li class="success"><?= __d('cake_app', 'Your version of PHP has the intl extension loaded.') ?></li>
                <?php else: ?>
                    <li class="problem"><?= __d('cake_app', 'Your version of PHP does NOT have the intl extension loaded.') ?></li>
                <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2><?= __d('cake_app', 'Filesystem') ?></h2>
                <ul>
                    <?php if (is_writable(TMP)): ?>
                        <li class="success"><?= __d('cake_app', 'Your tmp directory is writable.') ?></li>
                    <?php else: ?>
                        <li class="problem"><?= __d('cake_app', 'Your tmp directory is NOT writable.') ?></li>
                    <?php endif; ?>

                    <?php if (is_writable(LOGS)): ?>
                        <li class="success"><?= __d('cake_app', 'Your logs directory is writable.') ?></li>
                    <?php else: ?>
                        <li class="problem"><?= __d('cake_app', 'Your logs directory is NOT writable.') ?></li>
                    <?php endif; ?>

                    <?php $settings = Cache::config('_cake_core_'); ?>
                    <?php if (!empty($settings['className'])): ?>
                        <li class="success"><?= __d('cake_app', 'The {0} is being used for core caching. To change the config edit config/app.php', $this->Html->tag('em', $settings['className'] . 'Engine')) ?></li>
                    <?php else: ?>
                        <li class="problem"><?= __d('cake_app', 'Your cache is NOT working. Please check the settings in config/app.php') ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="bar-bottom"></div>

        <div class="row">
            <div class="col-md-6">
                <h2><?= __d('cake_app', 'Database') ?></h2>
                <ul>
                <?php
                try {
                    $connection = ConnectionManager::get('default');
                    $connected = $connection->connect();
                } catch (Exception $connectionError) {
                    $connected = false;
                    $errorMsg = $connectionError->getMessage();
                    if (method_exists($connectionError, 'getAttributes')):
                        $attributes = $connectionError->getAttributes();
                        if (isset($errorMsg['message'])):
                            $errorMsg .= '<br />' . $attributes['message'];
                        endif;
                    endif;
                }
                ?>
                <?php if ($connected): ?>
                    <li class="success"><?= __d('cake_app', 'CakePHP is able to connect to the database.') ?></li>
                <?php else: ?>
                    <li class="problem"><?= __d('cake_app', 'CakePHP is NOT able to connect to the database.') ?><br /><?= $errorMsg ?></li>
                <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2><?= __d('cake_app', 'DebugKit') ?></h2>
                <ul>
                <?php if (Plugin::loaded('DebugKit')): ?>
                    <li class="success"><?= __d('cake_app', 'DebugKit is loaded.') ?></li>
                <?php else: ?>
                    <li class="problem"><?= __d('cake_app', 'DebugKit is NOT loaded. You need to either install pdo_sqlite, or define the "debug_kit" connection name.') ?></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="bar-bottom"></div>

        <div class="row">
            <div class="col-md-6">
                <h2><?= __d('cake_app', 'Editing this Page') ?></h2>
                <ul>
                    <li class="cutlery"><?= __d('cake_app', 'To change the content of this page, edit: src/Template/Pages/home.ctp.') ?></li>
                    <li class="cutlery"><?= __d('cake_app', 'You can also add some CSS styles for your pages at: webroot/css/.') ?></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2><?= __d('cake_app', 'Getting Started') ?></h2>
                <ul>
                    <li class="book"><a target="_blank" href="<?= $cookbookBaseUrl ?>"><?= __d('cake_app', 'CakePHP 3.0 Docs') ?></a></li>
                    <li class="book"><a target="_blank" href="<?= $cookbookBaseUrl ?>tutorials-and-examples/bookmarks/intro.html"><?= __d('cake_app', 'The 15 min Bookmarker Tutorial') ?></a></li>
                    <li class="book"><a target="_blank" href="<?= $cookbookBaseUrl ?>tutorials-and-examples/blog/blog.html"><?= __d('cake_app', 'The 15 min Blog Tutorial') ?></a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 more-cake">
                <h2><?= __d('cake_app', 'More about Cake') ?></h2>
                <p>
                    <?= __d('cake_app', 'CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Front Controller and MVC.') ?>
                    <br />
                    <?= __d('cake_app', 'Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.') ?>
                </p>
            </div>
        </div>
        <div class="bar-bottom"></div>

        <div class="row links">
            <div class="col-md-4">
                <div class="icon support">P</div>
                <h2><?= __d('cake_app', 'Help and Bug Reports') ?></h2>
                <ul>
                    <li class="cutlery"><a href="http://cakesf.herokuapp.com/"><?= __d('cake_app', 'CakePHP Slack') ?></a>
                        <br><?= __d('cake_app', 'CakePHP official Slack team') ?>
                    </li>
                    <li class="cutlery"><a href="irc://irc.freenode.net/cakephp"><?= __d('cake_app', 'irc.freenode.net #cakephp') ?></a>
                        <br><?= __d('cake_app', 'Live chat about CakePHP') ?>
                    </li>
                    <li class="cutlery"><a href="https://github.com/cakephp/cakephp/issues"><?= __d('cake_app', 'CakePHP Issues') ?></a>
                        <br><?= __d('cake_app', 'CakePHP issues and pull requests') ?>
                    </li>
                    <li class="cutlery"><a href="http://discourse.cakephp.org/"><?= __d('cake_app', 'CakePHP Forum') ?></a>
                        <br><?= __d('cake_app', 'CakePHP official discussion forum') ?>
                    </li>
                    <li class="cutlery"><a href="https://groups.google.com/group/cake-php"><?= __d('cake_app', 'CakePHP Google Group') ?></a>
                        <br><?= __d('cake_app', 'Community mailing list') ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="icon docs">r</div>
                <h2><?= __d('cake_app', 'Docs and Downloads') ?></h2>
                <ul>
                    <li class="cutlery"><a href="https://api.cakephp.org/3.0/"><?= __d('cake_app', 'CakePHP API') ?></a>
                        <br><?= __d('cake_app', 'Quick Reference') ?>
                    </li>
                    <li class="cutlery"><a href="<?= $cookbookBaseUrl ?>"><?= __d('cake_app', 'CakePHP Documentation') ?></a>
                        <br><?= __d('cake_app', 'Your Rapid Development Cookbook') ?>
                    </li>
                    <li class="cutlery"><a href="https://bakery.cakephp.org/"><?= __d('cake_app', 'The Bakery') ?></a>
                        <br><?= __d('cake_app', 'Everything CakePHP') ?>
                    </li>
                    <li class="cutlery"><a href="https://plugins.cakephp.org/"><?= __d('cake_app', 'CakePHP plugins repo') ?></a>
                        <br><?= __d('cake_app', 'A comprehensive list of all CakePHP plugins created by the community') ?>
                    </li>
                    <li class="cutlery"><a href="https://github.com/cakephp/"><?= __d('cake_app', 'CakePHP Code') ?></a>
                        <br><?= __d('cake_app', 'For the Development of CakePHP Git repository, Downloads') ?>
                    </li>
                    <li class="cutlery"><a href="https://github.com/FriendsOfCake/awesome-cakephp"><?= __d('cake_app', 'CakePHP Awesome List') ?></a>
                        <br><?= __d('cake_app', 'A curated list of amazingly awesome CakePHP plugins, resources and shiny things.') ?>
                    </li>
                    <li class="cutlery"><a href="https://cakephp.org/">CakePHP</a>
                        <br><?= __d('cake_app', 'The Rapid Development Framework') ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="icon training">s</div>
                <h2><?= __d('cake_app', 'Training and Certification') ?></h2>
                <ul>
                    <li class="cutlery"><a href="http://cakefoundation.org/"><?= __d('cake_app', 'Cake Software Foundation') ?></a>
                        <br><?= __d('cake_app', 'Promoting development related to CakePHP') ?>
                    </li>
                    <li class="cutlery"><a href="http://training.cakephp.org/"><?= __d('cake_app', 'CakePHP Training') ?></a>
                        <br><?= __d('cake_app', 'Learn to use the CakePHP framework') ?>
                    </li>
                    <li class="cutlery"><a href="http://certification.cakephp.org/"><?= __d('cake_app', 'CakePHP Certification') ?></a>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
