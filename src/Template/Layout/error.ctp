<?php

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div id="container">
        <div id="header">
            <h1><?= $this->Html->link($cakeDescription, 'http://cakephp.org') ?></h1>
        </div>
        <div id="content">
            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>
        </div>
        <div id="footer">
            <?= $this->Html->link(
                    $this->Html->image('cake.power.gif', ['alt' => $cakeDescription, 'border' => '0']),
                    'http://www.cakephp.org/',
                    ['target' => '_blank', 'escape' => false]
                )
            ?>
        </div>
    </div>
</body>
</html>
