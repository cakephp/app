
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <p class="pad-btm">Sign In to your account</p>
                    <?= $this->Form->create() ?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                
                                <?= $this->Form->input('username',['label'=> false,'class'=>'form-control','required' => true ,'autofocus' => true , 'placeholder' => 'Email address' ]) ?> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                              <?= $this->Form->password('password',['label'=> false,'class'=>'form-control','required' => true , 'placeholder' => 'Mot de passe' ]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 text-left checkbox">
                                <label class="form-checkbox form-icon">
                                    <?= $this->Form->checkbox('remember',['hiddenField' => false,'label'=> false,'checked'=> false, 'id'=>'signup']); ?>
                                            se sevenir de moi
                                </label>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group text-right">
                                      <?= $this->Form
                                            ->button('Sign In',[ 'class' =>'btn btn-success text-uppercase',
                                                                        'type'  => 'submit' ,
                                                                ])
                                  ?>

                                </div>
                            </div>
                        </div>
                        <div class="mar-btm"><em>- or -</em></div>
                        <button class="btn btn-primary btn-lg btn-block" type="button">
                            <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                        </button>
                    <?= $this->Form->end() ?>
                </div>
            </div>
            <div class="pad-ver">
                <a href="<?= $this->Url->Build(['action'=> 'identify']) ?>" class="btn-link mar-rgt">Forgot password ?</a>
                <a href="<?= $this->Url->Build(['action'=> 'add']) ?>" class="btn-link mar-lft">Create a new account</a>
            </div>
        