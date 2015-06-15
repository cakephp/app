                  <div class="cls-content-lg panel">
                <div class="panel-body">
                    
                    <p class="pad-btm">Create an account</p>
                    <?= $this->Form->create($userEntity) ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                        <?= $this   ->Form
                                                    ->input('first_name',[  'label'=> false,
                                                                            'class'=>'form-control',
                                                                            'required' => true ,
                                                                            'autofocus' => true ,
                                                                            'placeholder' => 'Prenome'
                                                                             ]) ?> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group ">
                                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                            <?= $this   ->Form
                                                        ->input('username',[  'label'=> false,
                                                                            'class'=>'form-control',
                                                                            'required' => true ,
                                                                            'autofocus' => true ,
                                                                            'placeholder' => 'Email'
                                                                             ]) ?> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                              <?= $this ->Form
                                                        ->input('last_name',[  'label'=> false,
                                                                            'class'=>'form-control',
                                                                            'required' => true ,
                                                                            'autofocus' => true ,
                                                                            'placeholder' => 'Nome'
                                                                             ]) ?> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                              <?= $this ->Form
                                                        ->password('password',[  'label'=> false,
                                                                            'class'=>'form-control',
                                                                            'required' => true ,
                                                                            'autofocus' => true ,
                                                                            'placeholder' => 'Password'
                                                                             ]) ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 text-left checkbox">
                                <label class="form-checkbox form-icon">
                                    <?= $this   ->Form
                                                ->checkbox('agree',[ 'hiddenField' => false,
                                                                        'label'=> false,
                                                                        'checked'=> true
                                                                        ]); ?>
                                    I agree with the <a href="#" >Terms and Conditions</a>
                                </label>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group text-right">
                                          <?= $this->Form
                                            ->button('Sign Up',[ 'class' =>'btn btn-success text-uppercase',
                                                                        'type'  => 'submit' ,
                                                                ])
                                  ?>
                                </div>
                            </div>
                        </div>
                        <div class="mar-btm"><em>- or -</em></div>
                        <button class="btn btn-primary btn-lg btn-block" type="button">
                            <i class="fa fa-facebook fa-fw"></i> Sign Up with Facebook
                        </button>
                    <?= $this->Form->end() ?>
                
                    </div>
                </div>
                <div class="pad-ver">
                    Already have an account ? <a href="<?= $this->Url->Build(['action'=> 'login']) ?>" class="btn-link mar-rgt">Sign In</a>
                </div>