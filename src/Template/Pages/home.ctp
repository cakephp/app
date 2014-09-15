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
use Cake\Validation\Validation;

$this->layout = false;

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= $cakeDescription ?>:
		<?= $this->fetch('title') ?>
	</title>
	<?= $this->Html->meta('icon') ?>
	<?= $this->Html->css('normalize.css') ?>
	<?= $this->Html->css('foundation.min.css') ?>
	<?= $this->Html->css('cake3.css') ?>
</head>
<body class="home">
	<header>
		<div class="header-image">
			<?= $this->Html->image('http://cakephp.org/img/cake-logo.png'); ?>
			<h1> Get the ovens ready</h1>
		</div>
	</header>
	<div id="container">
		
		<div id="content">
			<div class="row">
				<?php
				if (Configure::read('debug')):
					Debugger::checkSecurityKeys();
				endif;
				?>
				<p id="url-rewriting-warning" style="background-color:#e32; color:#fff;display:none">
					URL rewriting is not properly configured on your server.
					1) <a target="_blank" href="http://book.cakephp.org/3.0/en/installation/url-rewriting.html" style="color:#fff;">Help me configure it</a>
					2) <a target="_blank" href="http://book.cakephp.org/3.0/en/development/configuration.html#general-configuration" style="color:#fff;">I don't / can't use URL rewriting</a>
				</p>

				<div class="row">
					<div class="columns large-5 platform checks">
						<p>
						<?php
							if (version_compare(PHP_VERSION, '5.4.16', '>=')):
								echo '<span class="success">Your version of PHP is 5.4.16 or higher.</span>';
							else:
								echo '<span class="problem">Your version of PHP is too low. You need PHP 5.4.16 or higher to use CakePHP.</span>';
							endif;
						?>
						</p>
						<p>
						<?php
							if (extension_loaded('mbstring')):
								echo '<span class="success">Your version of PHP has the mbstring extension loaded.</span>';
							else:
								echo '<span class="problem">Your version of PHP does NOT have the mbstring extension loaded.</span>';
							endif;
						?>
						</p>
						<p>
						<?php
							if (extension_loaded('mcrypt')):
								echo '<span class="success">Your version of PHP has the mcrypt extension loaded.</span>';
							else:
								echo '<span class="problem">Your version of PHP does NOT have the mcrypt extension loaded.</span>';
							endif;
						?>
						</p>
						<p>
						<?php
							if (extension_loaded('intl')):
								echo '<span class="success">Your version of PHP has the intl extension loaded.</span>';
							else:
								echo '<span class="problem">Your version of PHP does NOT have the intl extension loaded.</span>';
							endif;
						?>
						</p>	
					</div>
					<div class="columns large-6 filesystem checks">
						<p>
							<?php
								if (is_writable(TMP)):
									echo '<span class="success">Your tmp directory is writable.</span>';
								else:
									echo '<span class="problem">Your tmp directory is NOT writable.</span>';
								endif;
							?>
						</p>
						<p>
							<?php
								if (is_writable(LOGS)):
									echo '<span class="success">Your logs directory is writable.</span>';
								else:
									echo '<span class="problem">Your logs directory is NOT writable.</span>';
								endif;
							?>
						</p>
						<p>
							<?php
								$settings = Cache::config('_cake_core_');
								if (!empty($settings)):
									echo '<span class="success">';
										echo 'The <em>'. $settings['className'] . 'Engine</em> is being used for core caching. To change the config edit config/app.php';
									echo '</span>';
								else:
									echo '<span class="problem">';
										echo 'Your cache is NOT working. Please check the settings in config/app.php';
									echo '</span>';
								endif;
							?>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="columns large-12  database checks">
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
						<p>
							<?php
								if ($connected):
									echo '<span class="success">CakePHP is able to connect to the database.</span>';
								else:
									echo '<p class="problem">';
										echo 'CakePHP is NOT able to connect to the database.';
										echo '<br /><br />';
										echo $errorMsg;
									echo '</p>';
								endif;
							?>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="columns large-6">
						<h3>Editing this Page</h3>
						<ul>
							<li>To change the content of this page, edit: src/Template/Pages/home.ctp.</li>
							<li>You can also add some CSS styles for your pages at: webroot/css/.</li>
						</ul>
					</div>
					<div class="columns large-6">
						<h3>Getting Started</h3>
						<ul>
							<li><a target="_blank" href="http://book.cakephp.org/3.0/en/">CakePHP 3.0 Docs</a></li>
							<li><a target="_blank" href="http://book.cakephp.org/3.0/en/tutorials-and-examples/blog/blog.html">The 15 min Blog Tutorial</a></li>
						</ul>
						<p>
					</div>
				</div>

				<hr/>
				<div class="row">
					<div class="columns large-12">
						<h3 class="">More about Cake</h3>
						<p>
							CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Front Controller and MVC.
						</p>
						<p>
							Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.
						</p>

						<ul>
							<li><a href="http://cakefoundation.org/">Cake Software Foundation</a>
							<ul><li>Promoting development related to CakePHP</li></ul></li>
							<li><a href="http://www.cakephp.org">CakePHP</a>
							<ul><li>The Rapid Development Framework</li></ul></li>
							<li><a href="http://book.cakephp.org/3.0/en/">CakePHP Documentation</a>
							<ul><li>Your Rapid Development Cookbook</li></ul></li>
							<li><a href="http://api.cakephp.org/3.0/">CakePHP API</a>
							<ul><li>Quick Reference</li></ul></li>
							<li><a href="http://bakery.cakephp.org">The Bakery</a>
							<ul><li>Everything CakePHP</li></ul></li>
							<li><a href="http://plugins.cakephp.org">CakePHP plugins repo</a>
							<ul><li>A comprehensive list of all CakePHP plugins created by the community</li></ul></li>
							<li><a href="https://groups.google.com/group/cake-php">CakePHP Google Group</a>
							<ul><li>Community mailing list</li></ul></li>
							<li><a href="irc://irc.freenode.net/cakephp">irc.freenode.net #cakephp</a>
							<ul><li>Live chat about CakePHP</li></ul></li>
							<li><a href="https://github.com/cakephp/">CakePHP Code</a>
							<ul><li>For the Development of CakePHP Git repository, Downloads</li></ul></li>
							<li><a href="https://github.com/cakephp/cakephp/issues">CakePHP Issues</a>
							<ul><li>CakePHP issues and pull requests</li></ul></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<footer>
		</footer>
	</div>
</body>
</html>
