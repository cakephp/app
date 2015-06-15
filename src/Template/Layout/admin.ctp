<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

        <?= $this->Html->css('bootstrap') ?>
        <?= $this->Html->css('font-awesome') ?>
        <?= $this->Html->css('admin/style') ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    Admin
                </li>
                <li>
                    <a href="/admin">Tableau de Bord</a>
                </li>
                 <li>
                    <a href="<?= $this->Url->build(['controller' => 'Users','action' =>'index' ]) ?>">Users</a>
                </li>
                   <li>
                    <a  data-toggle="collapse" href="#collapse-branch" aria-expanded="false" aria-controls="collapseExample">
                        Branch
                    </a>
                    <div class="collapse" id="collapse-branch">
                         <ul>     
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
                    </div>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
            <div class="row top-bar">
                <div class="col-md-12">
                     <a href="#menu-toggle" class="link-more first header-btn glyphicon glyphicon-list" id="menu-toggle">
                              
                     </a>
                   <div class="nav navbar-right top-nav">
                 <div class="dropdownMenu">
                        <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop" hidefocus="true" style="outline: medium none;">Sort by filter</a>
                        <ul aria-labelledby="drop" role="menu" class="dropdown-menu">
                            <li role="presentation" class="first"><a href="#" tabindex="-1" role="menuitem" hidefocus="true" style="outline: medium none;">Date</a></li>
                            <li role="presentation"><a href="#" tabindex="-1" role="menuitem" hidefocus="true" style="outline: medium none;">Popularity</a></li>
                           
                            <li role="presentation" class="last">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-log-out"></i> Deconnétion', '/admin/users/logout' , ["escape" => false ,"tabindex" =>"-1", "role" => "menuitem", "hidefocus" =>true ,"style" => "outline: medium none;"]) ?>
                            </li>
                        </ul>
                    </div>

                </div>
                </div>

            </div>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                
                
                     <?= $this->fetch('content') ?>



            </div>
        </div>
    </div>
        <?= $this->Html->script('libs/jquery-1.10.0') ?>
        <?= $this->Html->script('libs/bootstrap.min') ?>
        
        <?= $this->fetch('dataTables') ?>
        <?= $this->fetch('summernote') ?>
        <?= $this->fetch('dropzone') ?>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    </script>

</body>

</html>