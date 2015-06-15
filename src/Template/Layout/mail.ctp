<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>mail</title>
        <?= $this->Html->css('http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin') ?>
        <?= $this->Html->css('http://localhost:8765/css/bootstrap.min.css') ?>
        <?= $this->Html->css('http://localhost:8765/css/admin/n/nifty.min.css') ?>
        <?= $this->Html->css('http://localhost:8765/css/font-awesome.min.css') ?>
        <?= $this->Html->css('http://localhost:8765/css/admin/n/nifty-demo.min.css') ?>
        <?= $this->Html->css('http://localhost:8765/css/admin/n/pace.min.css') ?>
    </head>
    <body>
        <?= $this->fetch('content') ?>
    </body>
</html>