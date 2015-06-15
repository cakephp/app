			<div class="cls-content-sm panel">
				<div class="panel-body">
					<p class="pad-btm">Enter your email address to recover your password. </p>
					<?= $this->Flash->render() ?>
					 <?= $this->Form->create() ?>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
								  <?= $this->Form
								  			->input('username',['label'			=> false,
								  								'class'			=>'form-control',
								  								'required' 		=> true ,
								  								'autofocus' 	=> true ,
								  								'placeholder' 	=> 'Email address' 
								  								])
								  ?>
							</div>
						</div>
						<div class="form-group text-right">
							  <?= $this->Form
								  			->button('Reset Password',[ 'class' =>'btn btn-success text-uppercase',
								  										'type' 	=> 'submit' ,
								  								])
								  ?>

						</div>
					 <?= $this->Form->end() ?>
				</div>
			</div>
			<div class="pad-ver">
				<a href="<?= $this->Url->Build(['action'=>'login']) ?>" class="btn-link mar-rgt">Back to Login</a>
			</div>