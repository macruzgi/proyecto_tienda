<div class="x_panel">
                  <div class="x_title">
                    <h2>Editar Usuario: <?php echo $Traer_Usuario_por_ID[0]->nombre;?></small></h2>
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
							<div class="alert alert-danger alert-dismissible " role="alert" id="mensaje" style="display:none;">
								<!--aqui se muestran los mensajes devueltos par la peticion-->
							</div>

								<form id="frm_editar_usuario" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Usuario <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="usuario" name="usuario" required="required" class="form-control" autocomplete="off" value="<?php echo $Traer_Usuario_por_ID[0]->nombreusuario;?>" readOnly>
												<input type="hidden" name="codigousuario" value ="<?php echo $Traer_Usuario_por_ID[0]->codigousuario;?>" id="codigousuario">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nombre <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="usuario_nombre" name="usuario_nombre" required="required" class="form-control" autocomplete="off" value="<?php echo $Traer_Usuario_por_ID[0]->nombre;?>">
											</div>
										</div>
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Tipo de usuario <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" id="id_tipo_usuario" name="id_tipo_usuario">
													<option>Elija una opci&oacute;n</option>
	<?php foreach ($Traer_Tipos_De_Usuarios as $Dato_Encontrado){ ?>
	<option value="<?php echo $Dato_Encontrado->id_tipo_usuario;?>"
		<?php
			if($Dato_Encontrado->id_tipo_usuario == $Traer_Usuario_por_ID[0]->id_tipo_usuario){
				echo "selected";
			}
		?>
	><?php echo $Dato_Encontrado->tipousu_nombre;?></option>
	<?php }?>
	</select>
											</div>
										</div>
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Direcci&oacute;n</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="direcion" class="form-control" type="text" name="direccion" autocomplete="off" value="<?php echo $Traer_Usuario_por_ID[0]->direccion;?>">
											</div>
										</div>
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Tel&eacute;fono</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="telefono" class="form-control" type="text" name="telefono" autocomplete="off" value="<?php echo $Traer_Usuario_por_ID[0]->telefono;?>" data-inputmask="'mask': '9999-9999'">
											</div>
										</div>
										
										
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button type="submit" id="btn_Guardar" class="btn btn-success">Guardar</button>
												<a href="javascript:history.back()" class="btn btn-danger" type="reset">Cancelar</a>
											</div>
										</div>

									</form>
                            
							</div>
						</div>
					</div>
</div>