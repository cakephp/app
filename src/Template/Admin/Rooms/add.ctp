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
    <?= $this->Form->create($roomEntity) ?>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Info</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="nf-email">
                    <span class="help-block">Nom de Chambre</span>
                </label>
                 <?= 
                 	$this->Form->input('name',['label'=> false,'class'=>'form-control','required' => true ,'autofocus' => true , 'placeholder' => 'Nom de Chambre' ]) 
                 ?> 
            </div>
            <div class="form-group">
                <label for="nf-email">
                    <span class="help-block">Nom de Chambre</span>
                </label>
                    <?= 
                    $this->Form->textarea('description',['label'=> false,'class'=>'editor','autofocus' => true , 'placeholder' => 'Nom de Chambre' ]) 
                    ?> 
            </div>
            <div class="from-group">
                <form action="/upload-target" class="dropzone"></form>
            </div>
        </div>
        <div class="panel-footer">
            
                <?= 
                    $this->Form->button('<i class="fa fa-dot-circle-o"></i> Submit',['label'=> false,'class'=>'btn btn-sm btn-primary','required' => true ,'autofocus' => true , 'escape' => false ]) 
                 ?> 
            <button class="btn btn-sm btn-danger" type="reset"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
   <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Photos</h3>
        </div>
        <div class="panel-body">
            <div class="form-group"> 
                <form action="/admin/photos/temps" class="dropzone"></form>
            </div>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>
<div id="page-content">
<?= $this->Html->css('admin/summernote', ['block' => 'summernote']); ?>
<?= $this->Html->script('admin/summernote', ['block' => 'summernote']); ?>
<?= $this->Html->css('admin/dropzone', ['block' => 'dropzone']); ?>
<?= $this->Html->script('admin/dropzone', ['block' => 'dropzone']); ?>