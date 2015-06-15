                <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Blank page</h1>
                        <!--Searchbox-->
                        <div class="searchbox">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search..">
                                <span class="input-group-btn">
                                <button class="text-muted" type="button"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <!--Breadcrumb-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Library</a></li>
                        <li class="active">Data</li>
                    </ol>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End breadcrumb-->

                    <!--Page content-->
                    <!--===================================================-->


                    <!--Basic Toolbar-->
                    <!--===================================================-->
                    <div id="page-content">
                        

<div class="row">
<div class="panel">
					
								<!-- Circular Form Wizard -->
								<!--===================================================-->
								<div id="demo-step-wz" class="step-wz">
									<div class="wz-heading wz-w-label bg-success">
					
										<!--Progress bar-->
										<div class="progress progress-xs">
											<div style="width: 0%; margin: 0px 0%;" class="progress-bar progress-bar-dark"></div>
										</div>
					
										<!--Nav-->
										<ul class="wz-steps wz-icon-bw wz-nav-off text-lg">
											<li class="col-xs-4 active">
												<a data-toggle="tab" href="#demo-step-tab1" aria-expanded="true">
													<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
														<span class="wz-icon icon-txt text-bold">1</span>
														<i class="wz-icon-done fa fa-check"></i>
													</span>
													<small class="wz-desc box-block">Information de l'Offer</small>
												</a>
											</li>
											<li class="col-xs-4">
												<a data-toggle="tab" href="#demo-step-tab2" aria-expanded="false">
													<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
														<span class="wz-icon icon-txt text-bold">2</span>
														<i class="wz-icon-done fa fa-check"></i>
													</span>
													<small class="wz-desc box-block">charger les photos</small>
												</a>
											</li>

											<li class="col-xs-4">
												<a data-toggle="tab" href="#demo-step-tab3" aria-expanded="false">
													<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
														<span class="wz-icon icon-txt text-bold">4</span>
														<i class="wz-icon-done fa fa-check"></i>
													</span>
													<small class="wz-desc box-block">finir</small>
												</a>
											</li>
										</ul>
									</div>
					
									<!--Form-->
									

									<?= $this->Form->create($offerEntity,['class' => 'form-horizontal']) ?>
										<div class="panel-body">
											<div class="tab-content">
					
												<!--First tab-->
												<div id="demo-step-tab1" class="tab-pane active in">
													<div class="form-group">
														<label class="col-lg-2 control-label">titre</label>
														<div class="col-lg-10">
															    <?= 
												                 	$this->Form->input('name',['label'=> false,'class'=>'form-control','required' => true ,'autofocus' => true , 'placeholder' => 'Nom de Offre' ]) 
												                 ?> 
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-2 control-label">text:</label>
														<div class="col-lg-10">
															        <?= 
													                    $this->Form->textarea('description',['label'=> false,'class'=>'editor','autofocus' => true , 'placeholder' => 'Nom de Chambre' ]) 
													                    ?> 
														</div>
													</div>
												</div>
												<!--Second tab-->
												<div id="demo-step-tab2" class="tab-pane fade">
													<div class="form-group">
														<label class="col-lg-2 control-label">First name</label>
														<div class="col-lg-10">
															 <div action="/admin/photos/temps" class="dropzone"></div>
														</div>
													</div>
												</div>
												<!--Fourth tab-->
												<div id="demo-step-tab3" class="tab-pane mar-btm text-center">
													<h4>Thank you</h4>
													<p class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
												</div>
											</div>
										</div>
					
										<!--Footer button-->
										<div class="panel-footer text-right">
											<div class="box-inline">
												<button type="button" class="previous btn btn-mint disabled">Previous</button>
												<button type="button" class="next btn btn-mint" style="display: inline-block;">Next</button>
										
												  <?= 
                    $this->Form->button('<i class="fa fa-dot-circle-o"></i> Finish',['label'=> false,'class'=>'finish btn btn-mint','required' => true ,'autofocus' => true , 'escape' => false, 'style' => 'display: none;' ]) 
                 ?> 
											</div>
										</div>
												 <?= $this->Form->end() ?>
									 
								</div>
								<!--===================================================-->
								<!-- End Circular Form Wizard -->
					
							</div>
							</div>
<?= $this->Html->css('admin/summernote', ['block' => 'summernote']); ?>
<?= $this->Html->script('admin/summernote', ['block' => 'summernote']); ?>
<?= $this->Html->css('admin/dropzone', ['block' => 'dropzone']); ?>
<?= $this->Html->script('admin/dropzone', ['block' => 'dropzone']); ?>
<?= $this->Html->script('admin/n/bootstrap.wizard.min', ['block' => 'wizard']); ?>
