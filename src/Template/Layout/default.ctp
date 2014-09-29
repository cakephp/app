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

$appName = 'CakePHP';
$appTitle = $appName . ' · Rapid Development Framework';
$appUrl = 'http://cakephp.org/';

?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?> 
	<title><?= $this->fetch('title') ?>: <?= $appTitle ?></title>
	<?= $this->Html->meta('icon') ?> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?= $this->Html->css('cake')?> 
	<?php /* <!-- Optional rapid LESS development -->
	<link rel="stylesheet/less" type="text/css" href="/css/cake.less" />
	<?= $this->Html->script('less.min') ?> 
	<!-- */ ?> <!-- -->
	<?= $this->fetch('meta'), $this->fetch('css'), $this->fetch('script') ?> 
</head>
<!--[if lte IE 9]><body id="top" class="ie9"><![endif]--><!--[if gt IE 9]><!-->
<body id="top"><!--<![endif]-->
<header>
	<h1>
		<?= $this->fetch('title') ?> 
		<?= $this->Html->link(
				$this->Html->image('cake.logo.png', ['title' => $appTitle, 'alt' => $appName . ' Logo']),
				$appUrl,
				['target' => '_blank', 'escape' => false]) . "\n" ?>
	</h1>
</header>
<main><?= $this->Flash->render() ?><?= $this->fetch('content') ?></main>
<footer>
	<nav>
		<h6><?= $appName ?> <?= __('Ressources') ?></h6>
		<ul>
			<li><?= $this->Html->link('Book', 'http://book.cakephp.org/3.0', ['target' => '_blank']) ?></li>
			<li><?= $this->Html->link('API', 'http://api.cakephp.org/3.0', ['target' => '_blank']) ?></li>
			<li><?= $this->Html->link('Chat', 'irc://chat.freenode.net/cakephp', ['target' => '_blank']) ?></li>
			<li><?= $this->Html->link('Groups', 'https://groups.google.com/forum/#!forum/cake-php', ['target' => '_blank']) ?></li>
			<li><?= $this->Html->link('GitHub', 'http://github.com/cakephp', ['target' => '_blank']) ?></li>
			<li><?= $this->Html->link('YouTube', 'https://www.youtube.com/user/CakePHP', ['target' => '_blank']) ?></li>
			<li><?= $this->Html->link(__('▲'), '#top', ['title' => __('Top')]) ?></li>
		</ul>
	</nav>
	<p><?= $this->Html->link(
				$this->Html->image('cake.logo.png', ['title' => $appTitle, 'alt' => $appName . ' Logo']) . $appTitle,
				$appUrl,
				['target' => '_blank', 'escape' => false])
	?></p>
</footer>
<style type="text/css">
	@import url('http://fonts.googleapis.com/css?family=Open+Sans:400|Ubuntu:400,500,400italic,500italic|Ubuntu+Mono:400,700,400italic,700italic&subset=latin,latin-ext,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese');
</style>
</body>
</html>
