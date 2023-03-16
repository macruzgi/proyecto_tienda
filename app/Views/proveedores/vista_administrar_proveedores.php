<div class="x_panel">
                  <div class="x_title">
                    <h2>Administraci&oacute;n de Proveedores</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
						  
						  <div id="overlay">
							  <!--overlay para cuando se está procesando el formulario y mustra un alerta de espere..-->
							  <div class="spinner"></div>
							  <div class="message">
							  <div class="spinner-border text-primary" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
							  Espere por favor...</div>
							</div>
						  <div class="alert alert-danger alert-dismissible" role="alert" style="display:none;" id="mensaje">
									<!--
									Aqui se veran los mensajes de error-->
						  </div>
						  <a class="btn btn-app" href="<?php echo base_url();?>/Vista_Agregar_Proveedor">
							<i class="fa fa-plus-square"></i> Agregar Proveedor
						  </a>
                            <div class="card-box table-responsive">
       
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" style="width: 100%;" role="grid" aria-describedby="datatable-buttons_info">
                      <thead>
                        <tr role="row">
							<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">NRC</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">C&oacute;digo</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Raz&oacute;n Social</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Tel&eacute;fono</th>
							
							
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Acci&oacute;n</th>
							
						</tr>
                      </thead>
					  <tbody>
							<?php 
								foreach($Traer_Datos as $Fila_Encontrada){
							?>
							<tr>
								<td><?php echo $Fila_Encontrada->id_proveedor;?></td>
								<td><?php echo $Fila_Encontrada->pro_nrc;?></td>
								<td><?php echo $Fila_Encontrada->pro_codigo;?></td>
								<td><?php echo $Fila_Encontrada->pro_razon_social;?></td>
								<td><?php echo $Fila_Encontrada->pro_telefono;?></td>
								<td>
									<div class="fa-hover col-md-3 col-sm-4  "><h3><a href="<?php echo base_url();?>/Vista_Editar_Poveedor/<?php echo $Fila_Encontrada->id_proveedor;?>" data-toggle="tooltip" data-placement="top" title data-original-title="Editar"><i class="fa fa-edit"></i></a></h3>
									</div>
									
								</td>
							</tr>
								<?php }?>
					  </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
                </div>