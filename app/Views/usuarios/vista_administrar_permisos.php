<div class="x_panel">
                  <div class="x_title">
                    <h2>Asignaci&oacute;n de permisos para el usuario: <b><?php echo $Traer_Todos_Los_Permisos[0]->nombreusuario;?> (<?php echo  $Traer_Todos_Los_Permisos[0]->nombre;?> )</b></small></h2>
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
						  <form id="frm_permisos">
							 <div class="alert alert-danger alert-dismissible" role="alert" style="display:none;" id="mensaje">
									<!--
									Aqui se veran los mensajes de error-->
							  </div>
                            <div class="card-box table-responsive">
					
							   <table class="table table-striped">
								  <thead>
									<tr role="row">
										<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" style="width: 231px;" aria-label="Position: activate to sort column ascending">ID</th>
										<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" style="width: 231px;" aria-label="Position: activate to sort column ascending">Opci&oacute;n del men&uacute;</th>
										
										<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" style="width: 153px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Ver&nbsp;<input type="checkbox"  id="marcarTodo"></th>
										
										<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" style="width: 153px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Agregar&nbsp;<input type="checkbox"  id="agregar_todo"></th>
										<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" style="width: 153px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Editar&nbsp;<input type="checkbox"  id="editar_todo"></th>
										<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" style="width: 153px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Eliminar&nbsp;<input type="checkbox"  id="elimiar_todo"></th>
										
									</tr>
								  </thead>
								  <tbody>
									 <?php 
										$bandera_id_modulo = 0;
										foreach($Traer_Todos_Los_Permisos as $Permisos_Encontrado){
									 ?>
									<tr role="row" class="odd">
									  <?php 
											if($bandera_id_modulo != $Permisos_Encontrado->id_modulo){
									   ?>
									   <tr>
									   <td colspan="6" style="text-align:center">M&oacute;dulo: <b><?php echo $Permisos_Encontrado->nombre_modulo;?></b></td></tr>
									   <?php } ?>
									  <td><?php echo $Permisos_Encontrado->id_modulo_opcion;?></td>
									  <td><?php echo $Permisos_Encontrado->nombre_opcion;?></td>
									  <td><input type="checkbox" value="<?php echo $Permisos_Encontrado->id_modulo_opcion;?>" name="id_opcion[]" id="id_opcion" <?php 
										if($Permisos_Encontrado->tiene_permiso == 1){echo "checked";} else { echo "";}
									  ?> class="marcar"></td>
									  <td><input type="checkbox" value="<?php echo $Permisos_Encontrado->id_modulo_opcion;?>" name="agregar[]" id="agregar" <?php 
										if($Permisos_Encontrado->agregar == 1){echo "checked";} else { echo "";}
									  ?> class="agregar"></td>
									  <td><input type="checkbox" value="<?php echo $Permisos_Encontrado->id_modulo_opcion;?>" name="actualizar[]" id="actualizar" <?php 
										if($Permisos_Encontrado->actualizar == 1){echo "checked";} else { echo "";}
									  ?> class="actualizar"></td>
									  <td><input type="checkbox" value="<?php echo $Permisos_Encontrado->id_modulo_opcion;?>" name="eliminar[]" id="eliminar" <?php 
										if($Permisos_Encontrado->eliminar == 1){echo "checked";} else { echo "";}
									  ?> class="eliminar"></td>
									 
									</tr>
										<?php 
											$bandera_id_modulo = $Permisos_Encontrado->id_modulo;
										} 
										?>
								  </tbody>
								</table>
							  </div>
							  <input type ="hidden" name="id_usuario" id="id_usuario" value="<?php echo $Traer_Todos_Los_Permisos[0]->codigousuario;?>">
							  <button class="btn btn-success" id="btnGuardar">Guardar</button>
							  <a href="javascript:history.back()" class="btn btn-danger" type="reset">Cancelar</a>
						</form>
                </div>
              </div>
            </div>
                </div>

<script>

	</script>
  