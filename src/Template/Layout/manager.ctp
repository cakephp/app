<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | <?= $this->fetch('title') ?></title>
        <?= $this->Html->css('bootstrap.min') ?>
        <?= $this->Html->css('admin/n/nifty.min') ?>
        <?= $this->Html->css('font-awesome.min') ?>
        <?= $this->Html->css('admin/n/nifty-demo.min') ?>
        <?= $this->Html->css('admin/n/pace.min') ?>
        <?= $this->Html->script('admin/n/pace.min') ?>
    </head>
    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
    <body>
        <div id="container" class="effect mainnav-lg">

            <!--NAVBAR-->
            <!--===================================================-->
            <header id="navbar">
                <div id="navbar-container" class="boxed">
                    <!--Brand logo & name-->
                    <!--================================-->
                    <div class="navbar-header">
                        <a href="index.html" class="navbar-brand">
                        <!--img src="img/logo.png" alt="Nifty Logo" class="brand-icon"-->
                        <?=
                        $this->Html->image("logo.png", [
                        "alt" => "Logo",
                        "class" => "brand-icon"
                        ])
                        ?>
                        <div class="brand-title">
                            <span class="brand-text">Nifty</span>
                        </div>
                        </a>
                    </div>
                    <!--================================-->
                    <!--End brand logo & name-->
                    <!--Navbar Dropdown-->
                    <!--================================-->
                    <div class="navbar-content clearfix">
                        <ul class="nav navbar-top-links pull-left">
                            <!--Navigation toogle button-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="tgl-menu-btn">
                                <a class="mainnav-toggle" href="#">
                                <i class="fa fa-navicon fa-lg"></i>
                                </a>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End Navigation toogle button-->
                            <!--Messages Dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                <i class="fa fa-envelope fa-lg"></i>
                                <span class="badge badge-header badge-warning">9</span>
                                </a>
                                <!--Message dropdown menu-->
                                <div class="dropdown-menu dropdown-menu-md with-arrow">
                                    <div class="pad-all bord-btm">
                                        <p class="text-lg text-muted text-thin mar-no">You have 3 messages.</p>
                                    </div>
                                    <div class="nano scrollable">
                                        <div class="nano-content">
                                            <ul class="head-list">

                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                    <div class="media-left">
                                                        <img src="<?= 'http://www.gravatar.com/avatar/'.md5($user['username']) ?>" alt="Profile Picture" class="img-circle img-sm">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-nowrap">Andy sent you a message</div>
                                                        <small class="text-muted">15 minutes ago</small>
                                                    </div>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <!--Dropdown footer-->
                                    <div class="pad-all bord-top">
                                        <a href="#" class="btn-link text-dark box-block">
                                        <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Messages
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End message dropdown-->
                            <!--Notification dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                <i class="fa fa-bell fa-lg"></i>
                                <span class="badge badge-header badge-danger">5</span>
                                </a>
                                <!--Notification dropdown menu-->
                                <div class="dropdown-menu dropdown-menu-md with-arrow">
                                    <div class="pad-all bord-btm">
                                        <p class="text-lg text-muted text-thin mar-no">You have 3 messages.</p>
                                    </div>
                                    <div class="nano scrollable">
                                        <div class="nano-content">
                                            <ul class="head-list">
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#">
                                                    <div class="clearfix">
                                                        <p class="pull-left">Database Repair</p>
                                                        <p class="pull-right">70%</p>
                                                    </div>
                                                    <div class="progress progress-sm">
                                                        <div style="width: 70%;" class="progress-bar">
                                                            <span class="sr-only">70% Complete</span>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#">
                                                    <div class="clearfix">
                                                        <p class="pull-left">Upgrade Progress</p>
                                                        <p class="pull-right">10%</p>
                                                    </div>
                                                    <div class="progress progress-sm">
                                                        <div style="width: 10%;" class="progress-bar progress-bar-warning">
                                                            <span class="sr-only">10% Complete</span>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </li>

                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                    <div class="media-left">
                                                        <span class="icon-wrap icon-circle bg-primary">
                                                        <i class="fa fa-comment fa-lg"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-nowrap">New comments waiting approval</div>
                                                        <small class="text-muted">15 minutes ago</small>
                                                    </div>
                                                    </a>
                                                </li>

                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                    <span class="badge badge-success pull-right">90%</span>
                                                    <div class="media-left">
                                                        <span class="icon-wrap icon-circle bg-danger">
                                                        <i class="fa fa-hdd-o fa-lg"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-nowrap">HDD is full</div>
                                                        <small class="text-muted">50 minutes ago</small>
                                                    </div>
                                                    </a>
                                                </li>

                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                    <div class="media-left">
                                                        <span class="icon-wrap bg-info">
                                                        <i class="fa fa-file-word-o fa-lg"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-nowrap">Write a news article</div>
                                                        <small class="text-muted">Last Update 8 hours ago</small>
                                                    </div>
                                                    </a>
                                                </li>

                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                    <span class="label label-danger pull-right">New</span>
                                                    <div class="media-left">
                                                        <span class="icon-wrap bg-purple">
                                                        <i class="fa fa-comment fa-lg"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-nowrap">Comment Sorting</div>
                                                        <small class="text-muted">Last Update 8 hours ago</small>
                                                    </div>
                                                    </a>
                                                </li>

                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                    <div class="media-left">
                                                        <span class="icon-wrap bg-success">
                                                        <i class="fa fa-user fa-lg"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="text-nowrap">New User Registered</div>
                                                        <small class="text-muted">4 minutes ago</small>
                                                    </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--Dropdown footer-->
                                    <div class="pad-all bord-top">
                                        <a href="#" class="btn-link text-dark box-block">
                                        <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Notifications
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End notifications dropdown-->
                        </ul>
                        <ul class="nav navbar-top-links pull-right">
                            <!--User dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li id="dropdown-user" class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                                <span class="pull-right">
                                <img class="img-circle img-user media-object" src="<?= 'http://www.gravatar.com/avatar/'.md5($user['username']) ?>" alt="Profile Picture">
                                </span>
                                <div class="username hidden-xs"><?= $user['first_name'].' '.$user['last_name'] ?></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
                                    <!-- Dropdown heading  -->
                                    <div class="pad-all bord-btm">
                                        <p class="text-lg text-muted text-thin mar-btm">750Gb of 1,000Gb Used</p>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: 70%;">
                                                <span class="sr-only">70%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- User dropdown menu -->
                                    <ul class="head-list">
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-user fa-fw fa-lg"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                            <span class="badge badge-danger pull-right">9</span>
                                            <i class="fa fa-envelope fa-fw fa-lg"></i> Messages
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                            <span class="label label-success pull-right">New</span>
                                            <i class="fa fa-gear fa-fw fa-lg"></i> Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-question-circle fa-fw fa-lg"></i> Help
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-lock fa-fw fa-lg"></i> Lock screen
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Dropdown footer -->
                                    <div class="pad-all text-right">
                                        <a href="<?= $this->Url->Build(['controller' => 'Users','action' => 'logout']) ?>" class="btn btn-primary">
                                        <i class="fa fa-sign-out fa-fw"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End user dropdown-->
                        </ul>
                    </div>
                    <!--================================-->
                    <!--End Navbar Dropdown-->
                </div>
            </header>
            <!--===================================================-->
            <!--END NAVBAR-->
            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                    <?= $this->fetch('content') ?>
                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->
                <!--MAIN NAVIGATION-->
                <!--===================================================-->
                <nav id="mainnav-container">
                    <div id="mainnav">
                        <!--Menu-->
                        <!--================================-->
                        <div id="mainnav-menu-wrap">
                            <div class="nano">
                                <div class="nano-content">
                                    <ul id="mainnav-menu" class="list-group">

                                        <!--Category name-->
                                        <li class="list-header">Navigation</li>

                                        <!--Menu list item-->
                                        <li>
                                            <a href="index.html">
                                            <i class="fa fa-dashboard"></i>
                                            <span class="menu-title">
                                            <strong>Tableau de bord</strong>
                                            <span class="label label-success pull-right">Top</span>
                                            </span>
                                            </a>
                                        </li>

                                        <!--Menu list item-->
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-th"></i>
                                            <span class="menu-title">
                                            <strong>Utilisateur</strong>
                                            </span>
                                            <i class="arrow"></i>
                                            </a>

                                            <!--Submenu-->
                                            <ul class="collapse">
                                                <li><a href="#">Collapsed Navigation</a></li>
                                            </ul>
                                        </li>

                                        <li class="list-divider"></li>

                                        <!--Category name-->
                                        <li class="list-header">Components</li>

                                        <!--Menu list item-->
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-briefcase"></i>
                                            <span class="menu-title">Branches</span>
                                            <i class="arrow"></i>
                                            </a>

                                            <!--Submenu-->
                                            <ul class="collapse">
                                                <li>
                                                    <a href="<?= $this->Url->build(['controller' => 'Rooms','action' =>'index' ]) ?>">
                                                    Chambres & suites
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= $this->Url->build(['controller' => 'Restauration','action' =>'index' ]) ?>">
                                                    Restauration
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= $this->Url->build(['controller' => 'Services','action' =>'index' ]) ?>">
                                                    Services
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= $this->Url->build(['controller' => 'Offers','action' =>'index' ]) ?>">
                                                    Offres spéciale
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="list-divider"></li>

                                        <!--Category name-->
                                        <li class="list-header">Extra</li>

                                        <!--Menu list item-->
                                        <li>
                                            <a href="#">
                                            <i class="fa fa-plug"></i>
                                            <span class="menu-title">
                                            Miscellaneous
                                            <span class="label label-mint pull-right">New</span>
                                            </span>
                                            </a>

                                            <!--Submenu-->
                                            <ul class="collapse">
                                                <li><a href="misc-calendar.html">Calendar</a></li>
                                                <li><a href="misc-maps.html">Google Maps</a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                    <!--Widget-->
                                    <!--================================-->
                                    <div class="mainnav-widget">
                                        <!-- Show the button on collapsed navigation -->
                                        <div class="show-small">
                                            <a href="#" data-toggle="menu-widget" data-target="#demo-wg-server">
                                            <i class="fa fa-desktop"></i>
                                            </a>
                                        </div>
                                        <!-- Hide the content on collapsed navigation -->
                                        <div id="demo-wg-server" class="hide-small mainnav-widget-content">
                                            <ul class="list-group">
                                                <li class="list-header pad-no pad-ver">Server Status</li>
                                                <li class="mar-btm">
                                                    <span class="label label-primary pull-right">15%</span>
                                                    <p>CPU Usage</p>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar progress-bar-primary" style="width: 15%;">
                                                            <span class="sr-only">15%</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="mar-btm">
                                                    <span class="label label-purple pull-right">75%</span>
                                                    <p>Bandwidth</p>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar progress-bar-purple" style="width: 75%;">
                                                            <span class="sr-only">75%</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pad-ver"><a href="#" class="btn btn-success btn-bock">View Details</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--================================-->
                                    <!--End widget-->
                                </div>
                            </div>
                        </div>
                        <!--================================-->
                        <!--End menu-->
                    </div>
                </nav>
                <!--===================================================-->
                <!--END MAIN NAVIGATION-->
            </div>

            <!-- FOOTER -->
            <!--===================================================-->
            <footer id="footer">
                <!-- Visible when footer positions are fixed -->
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <div class="show-fixed pull-right">
                    <ul class="footer-list list-inline">
                        <li>
                            <p class="text-sm">SEO Proggres</p>
                            <div class="progress progress-sm progress-light-base">
                                <div style="width: 80%" class="progress-bar progress-bar-danger"></div>
                            </div>
                        </li>
                        <li>
                            <p class="text-sm">Online Tutorial</p>
                            <div class="progress progress-sm progress-light-base">
                                <div style="width: 80%" class="progress-bar progress-bar-primary"></div>
                            </div>
                        </li>
                        <li>
                            <button class="btn btn-sm btn-dark btn-active-success">Checkout</button>
                        </li>
                    </ul>
                </div>
                <!-- Visible when footer positions are static -->
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <div class="hide-fixed pull-right pad-rgt">Currently v2.2</div>
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <p class="pad-lft">&#0169; 2015 Your Company</p>
            </footer>
            <!--===================================================-->
            <!-- END FOOTER -->
            <!-- SCROLL TOP BUTTON -->
            <!--===================================================-->
            <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
            <!--===================================================-->
        </div>
        <!--===================================================-->
        <!-- END OF CONTAINER -->
        <!--JAVASCRIPT-->
        <!--=================================================-->
        <!--jQuery [ REQUIRED ]-->
        <?= $this->Html->script('libs/jquery-2.1.1.min') ?>
        <!--BootstrapJS [ RECOMMENDED ]-->
        <?= $this->Html->script('libs/bootstrap.min') ?>
        <!--Fast Click [ OPTIONAL ]-->
        <?= $this->Html->script('admin/n/fastclick.min') ?>

        <!--Nifty Admin [ RECOMMENDED ]-->
        <?= $this->Html->script('admin/n/nifty.min') ?>
        <?= $this->fetch('switchery') ?>
        <?= $this->fetch('dataTables') ?>
        <?= $this->fetch('summernote') ?>
        <?= $this->fetch('dropzone') ?>
        <?= $this->fetch('wizard') ?>
    </body>
</html>