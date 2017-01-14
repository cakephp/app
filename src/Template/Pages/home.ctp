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
    throw new NotFoundException('Please replace src/Template/Pages/home.ctp with your own version.');
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
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
        <h1>Welcome to CakePHP 3.3 Red Velvet. Build fast. Grow solid.</h1>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning text-center">
                    <p>Please be aware that this page will not be shown if you turn off debug mode unless you replace src/Template/Pages/home.ctp with your own version.</p>
                </div>
                <?php Debugger::checkSecurityKeys(); ?>
                <div id="url-rewriting-warning" class="alert alert-warning text-center url-rewriting">
                    <p>
                        URL rewriting is not properly configured on your server.<br />
                        1) <a target="_blank" href="http://book.cakephp.org/3.0/en/installation.html#url-rewriting">Help me configure it</a><br />
                        2) <a target="_blank" href="http://book.cakephp.org/3.0/en/development/configuration.html#general-configuration">I don't / can't use URL rewriting</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Environment</h2>
                <ul>
                <?php if (version_compare(PHP_VERSION, '5.6.0', '>=')): ?>
                    <li class="success">Your version of PHP is 5.6.0 or higher (detected <?= PHP_VERSION ?>).</li>
                <?php else: ?>
                    <li class="problem">Your version of PHP is too low. You need PHP 5.6.0 or higher to use CakePHP (detected <?= PHP_VERSION ?>).</li>
                <?php endif; ?>

                <?php if (extension_loaded('mbstring')): ?>
                    <li class="success">Your version of PHP has the mbstring extension loaded.</li>
                <?php else: ?>
                    <li class="problem">Your version of PHP does NOT have the mbstring extension loaded.</li>;
                <?php endif; ?>

                <?php if (extension_loaded('openssl')): ?>
                    <li class="success">Your version of PHP has the openssl extension loaded.</li>
                <?php elseif (extension_loaded('mcrypt')): ?>
                    <li class="success">Your version of PHP has the mcrypt extension loaded.</li>
                <?php else: ?>
                    <li class="problem">Your version of PHP does NOT have the openssl or mcrypt extension loaded.</li>
                <?php endif; ?>

                <?php if (extension_loaded('intl')): ?>
                    <li class="success">Your version of PHP has the intl extension loaded.</li>
                <?php else: ?>
                    <li class="problem">Your version of PHP does NOT have the intl extension loaded.</li>
                <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2>Filesystem</h2>
                <ul>
                    <?php if (is_writable(TMP)): ?>
                        <li class="success">Your tmp directory is writable.</li>
                    <?php else: ?>
                        <li class="problem">Your tmp directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php if (is_writable(LOGS)): ?>
                        <li class="success">Your logs directory is writable.</li>
                    <?php else: ?>
                        <li class="problem">Your logs directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php $settings = Cache::config('_cake_core_'); ?>
                    <?php if (!empty($settings)): ?>
                        <li class="success">The <em><?= $settings['className'] ?>Engine</em> is being used for core caching. To change the config edit config/app.php</li>
                    <?php else: ?>
                        <li class="problem">Your cache is NOT working. Please check the settings in config/app.php</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="bar-bottom"></div>

        <div class="row">
            <div class="col-md-6">
                <h2>Database</h2>
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
                    <li class="success">CakePHP is able to connect to the database.</li>
                <?php else: ?>
                    <li class="problem">CakePHP is NOT able to connect to the database.<br /><?= $errorMsg ?></li>
                <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2>DebugKit</h2>
                <ul>
                <?php if (Plugin::loaded('DebugKit')): ?>
                    <li class="success">DebugKit is loaded.</li>
                <?php else: ?>
                    <li class="problem">DebugKit is NOT loaded. You need to either install pdo_sqlite, or define the "debug_kit" connection name.</li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="bar-bottom"></div>

        <div class="row">
            <div class="col-md-6">
                <h2>Editing this Page</h2>
                <ul>
                    <li class="cutlery">To change the content of this page, edit: src/Template/Pages/home.ctp.</li>
                    <li class="cutlery">You can also add some CSS styles for your pages at: webroot/css/.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2>Getting Started</h2>
                <ul>
                    <li class="book"><a target="_blank" href="http://book.cakephp.org/3.0/en/">CakePHP 3.0 Docs</a></li>
                    <li class="book"><a target="_blank" href="http://book.cakephp.org/3.0/en/tutorials-and-examples/bookmarks/intro.html">The 15 min Bookmarker Tutorial</a></li>
                    <li class="book"><a target="_blank" href="http://book.cakephp.org/3.0/en/tutorials-and-examples/blog/blog.html">The 15 min Blog Tutorial</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 more-cake">
                <h2>More about Cake</h2>
                <p>
                    CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Front Controller and MVC.
                    <br />
                    Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.
                </p>
            </div>
        </div>
        <div class="bar-bottom"></div>

        <div class="row links">
            <div class="col-md-4">
                <div class="icon support">P</div>
                <h2>Help and Bug Reports</h2>
                <ul>
                    <li class="cutlery"><a href="irc://irc.freenode.net/cakephp">irc.freenode.net #cakephp</a>
                        <br>Live chat about CakePHP
                    </li>
                    <li class="cutlery"><a href="https://github.com/cakephp/cakephp/issues">CakePHP Issues</a>
                        <br>CakePHP issues and pull requests
                    </li>
                    <li class="cutlery"><a href="http://discourse.cakephp.org/">CakePHP Forum</a>
                        <br>CakePHP official discussion forum
                    </li>
                    <li class="cutlery"><a href="https://groups.google.com/group/cake-php">CakePHP Google Group</a>
                        <br>Community mailing list
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="icon docs">r</div>
                <h2>Docs and Downloads</h2>
                <ul>
                    <li class="cutlery"><a href="http://api.cakephp.org/3.0/">CakePHP API</a>
                        <br>Quick Reference
                    </li>
                    <li class="cutlery"><a href="http://book.cakephp.org/3.0/en/">CakePHP Documentation</a>
                        <br>Your Rapid Development Cookbook
                    </li>
                    <li class="cutlery"><a href="http://bakery.cakephp.org/">The Bakery</a>
                        <br>Everything CakePHP
                    </li>
                    <li class="cutlery"><a href="http://plugins.cakephp.org/">CakePHP plugins repo</a>
                        <br>A comprehensive list of all CakePHP plugins created by the community
                    </li>
                    <li class="cutlery"><a href="https://github.com/cakephp/">CakePHP Code</a>
                        <br>For the Development of CakePHP Git repository, Downloads
                    </li>
                    <li class="cutlery"><a href="https://github.com/FriendsOfCake/awesome-cakephp">CakePHP Awesome List</a>
                        <br>A curated list of amazingly awesome CakePHP plugins, resources and shiny things.
                    </li>
                    <li class="cutlery"><a href="http://www.cakephp.org/">CakePHP</a>
                        <br>The Rapid Development Framework
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="icon training">s</div>
                <h2>Training and Certification</h2>
                <ul>
                    <li class="cutlery"><a href="http://cakefoundation.org/">Cake Software Foundation</a>
                        <br>Promoting development related to CakePHP
                    </li>
                    <li class="cutlery"><a href="http://training.cakephp.org/">CakePHP Training</a>
                        <br>Learn to use the CakePHP framework
                    </li>
                    <li class="cutlery"><a href="http://certification.cakephp.org/">CakePHP Certification</a>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
