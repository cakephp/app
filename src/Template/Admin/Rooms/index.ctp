                <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Rooms</h1>
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
                        <li><a href="#">Rooms</a></li>
                        <li class="active">List</li>
                    </ol>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End breadcrumb-->

                    <!--Page content-->
                    <!--===================================================-->


                    <!--Basic Toolbar-->
                    <!--===================================================-->
                    <div id="page-content">
                        
                    <div class="panel">
                    
                        <div class="panel-body">
                        <button id="demo-delete-row" class="btn btn-danger btn-labeled fa fa-times" disabled>Delete</button>
                        <a 
                            href="<?= $this->Url->Build(['action'=>'add']) ?>" 
                            title="" 
                            class="btn btn-primary btn-labeled fa fa-plus pull-right"
                            style="margin-top: 10px;"
                            >ajouter chamber ou suite</a>
                            <table id="demo-custom-toolbar" 
                                   data-toggle="table"
                                   data-url="/admin/rooms/getrooms.json"
                                   data-search="true"
                                   data-toolbar="#demo-delete-row"
                                   data-show-refresh="true"
                                   data-show-toggle="true"
                                   data-show-columns="true"
                                   data-sort-name="id"
                                   data-page-list="[5, 10, 20]"
                                   data-page-size="5"
                                   data-pagination="true" 
                                   data-show-pagination-switch="true"
                                   >
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true">ID</th>
                                        <th data-field="id" data-sortable="true" data-formatter="invoiceFormatter" >ID</th>
                                        <th data-field="name" data-sortable="true">Name</th>
                                        <th data-field="date" data-sortable="true" data-formatter="dateFormatter">Order date</th>
                                        <th data-field="amount" data-align="center" data-sortable="true" data-sorter="priceSorter">Balance</th>
                                        <th data-field="isactive" data-align="center" data-sortable="true" data-formatter="statusFormatter">Status</th>
                                        <th data-field="track" data-align="center" data-sortable="true" data-formatter="trackFormatter">Tracking Number</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    </div>
                    <!--===================================================-->
                    
                    
                    <!--===================================================-->
                    <!--End page content-->
<?= $this->Html->css('admin/n/bootstrap-table.min', ['block' => 'dataTables']); ?>
<?= $this->Html->script('admin/n/bootstrap-table.min', ['block' => 'dataTables']); ?>


