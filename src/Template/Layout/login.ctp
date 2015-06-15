<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | <?= $this->fetch('title') ?></title>
        <!--STYLESHEET-->
        <!--=================================================-->
        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <?= $this->Html->css('bootstrap.min') ?>
        <!--Nifty Stylesheet [ REQUIRED ]-->
        <?= $this->Html->css('admin/n/nifty.min') ?>

        <!--Font Awesome [ OPTIONAL ]-->
        <?= $this->Html->css('font-awesome.min') ?>
        <?= $this->Html->css('admin/n/pace.min') ?>
        <?= $this->Html->script('admin/n/pace.min') ?>
    </head>
    <body>
        <div id="container" class="cls-container">
        <!--===================================================-->
        <div class="cls-header cls-header-lg">
            <div class="cls-brand">
                <a class="box-inline" href="/">
                    <span class="brand-title">Nifty <span class="text-thin">Admin</span></span>

                </a>
            
            </div>
        </div>
        <div class="cls-content">
                  
                  <?= $this->fetch('content') ?>
            </div>
        </div>


        <!--JAVASCRIPT-->
        <!--=================================================-->
        <!--jQuery [ REQUIRED ]-->
        <?= $this->Html->script('libs/jquery-2.1.1.min') ?>
        <!--BootstrapJS [ RECOMMENDED ]-->
        <?= $this->Html->script('libs/bootstrap.min') ?>
        <!--Nifty Admin [ RECOMMENDED ]-->
        <?= $this->Html->script('admin/n/nifty.min') ?>
    </body>
</html>