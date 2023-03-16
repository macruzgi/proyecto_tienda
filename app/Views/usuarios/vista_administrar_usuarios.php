<div class="x_panel">
                  <div class="x_title">
                    <h2>Administraci&oacute;n de Usuarios</small></h2>
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
						  <a class="btn btn-app" href="<?php echo base_url();?>/Vista_Agregar_Usuario">
							<i class="fa fa-plus-square"></i> Agregar Usuario
						  </a>
                            <div class="card-box table-responsive">
       
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" style="width: 100%;" role="grid" aria-describedby="datatable-buttons_info">
                      <thead>
                        <tr role="row">
							<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Name: activate to sort column descending">C&oacute;digo usuario</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Usuario</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Tipo de usuario</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Nombre</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Acci&oacute;n</th>
							
						</tr>
                      </thead>
					  <tbody>
                         <?php 
							foreach($Traer_Ususuarios as $Usuario_Encontrado){
								$fafa = "fa-unlock";
								if($Usuario_Encontrado->estado == 0){
									$fafa = "fa-lock";
								}
						 ?>
						<tr role="row" class="odd">
                          <td><?php echo $Usuario_Encontrado->codigousuario;?></td>
						  <td><?php echo $Usuario_Encontrado->nombreusuario;?></td>
                          <td><?php echo $Usuario_Encontrado->tipousu_nombre;?></td>
						  <td><?php echo $Usuario_Encontrado->nombre;?></td>
						  <td>
							 <div class="fa-hover col-md-3 col-sm-4  ">
							 <h3><a href="<?php echo base_url();?>/Vista_Asignar_Permisos/<?php echo $Usuario_Encontrado->codigousuario;?>" data-toggle="tooltip" data-placement="top" title data-original-title="Permisos"><i class="fa fa-key"></i></a></h3>
							</div>
							<div class="fa-hover col-md-3 col-sm-4  ">
							<h3><a  href="<?php echo base_url();?>/Vista_Editar_Usuario/<?php echo $Usuario_Encontrado->codigousuario;?>" data-toggle="tooltip" data-placement="top" title data-original-title="Editar">
								<i class="fa fa-edit"></i> 
							  </a></h3>
							</div>
							<div class="fa-hover col-md-3 col-sm-4  ">
							  <h3><a href="#" onClick="Bloquer_Desbloquear_Usuario(<?php echo $Usuario_Encontrado->codigousuario;?>, <?php echo $Usuario_Encontrado->estado;?>)"><i class="fa <?php echo $fafa; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Bloquer/Desbloquer"></i></a> </h3>
							 </div>
						  </td>
                        </tr>
							<?php } ?>
					  </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
                </div>