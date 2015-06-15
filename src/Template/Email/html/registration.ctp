<div id="page-content">
    <div class="panel">
        <div class="panel-body">
            <!-- GENERAL -->
            <!--===================================================-->
            <h3 class="pad-all bord-btm text-thin">Bonjour <?= $first_name.' '.$last_name ?></h3>
            <div id="demo-gen-faq" class="panel-group accordion">
                <div class="bord-no pad-top">

                    <!-- Question -->
                    <div class="text-semibold pad-hor text-lg">  
                        Activation de Compte et vérification d'email
                    </div>

                    <!-- Answer -->
                    <div id="demo-gen-faq1" class="collapse in">
                        <div class="pad-all">
                            Vous avez créé un compte *.com avec votre * inscription . * est juste un de plusieurs éléments du décor glorieux apportés à vous par le peuple joyeux au Automattic . Cliquez sur le bouton ci-dessous pour activer votre compte .
                        </div>
                        <div class="cls-content">
                        <div class="cls-content-sm" style="min-width: 210px;">
                            <a href="<?= $this->Url->Build(['controller'=>'Users', 'action' => 'active', $username],true) ?>" class="btn btn-primary btn-lg btn-block" type="button" >
                                <i class="fa fa-chevron-right fa-fw"></i> activer votre compte
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>