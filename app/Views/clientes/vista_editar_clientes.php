<div class="x_panel">
                  <div class="x_title">
                    <h2>Editar Clientes<small><?php echo $Traer_Cliente_por_ID[0]->cli_nombre;?></small></h2>
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
						<div class="row">
							<div class="col-sm-6">
								<form id="frm_actualizar" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">C&oacute;digo <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="cli_codigo" name="cli_codigo" required="required" class="form-control" autocomplete="off" readOnly value="<?php echo $Traer_Cliente_por_ID[0]->cli_codigo;?>">
												<input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $Traer_Cliente_por_ID[0]->id_cliente;?>">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombre <span class="required">*</span>
											</label>
											<div class="col-md-8 col-sm-8 ">
												<input type="text" id="cli_nombre" name="cli_nombre" required="required" class="form-control " autocomplete="off" value="<?php echo $Traer_Cliente_por_ID[0]->cli_nombre;?>">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Raz&oacute;n Social<span class="required"> *</span>
											</label>
											<div class="col-md-8 col-sm-8">
												<input type="text" id="cli_razon_social" name="cli_razon_social" class="form-control" autocomplete="off" value="<?php echo $Traer_Cliente_por_ID[0]->cli_razon_social;?>">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombre comercial<span class="required"></span>
											</label>
											<div class="col-md-8 col-sm-8">
												<input type="text" id="cli_nombre_comercial" name="cli_nombre_comercial" class="form-control " autocomplete="off" value="<?php echo $Traer_Cliente_por_ID[0]->cli_nombre_comercial;?>">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">NRC <span class="required"></span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="cli_nrc" name="cli_nrc" class="form-control " autocomplete="off" value="<?php echo $Traer_Cliente_por_ID[0]->cli_nrc;?>">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">DUI <span class="required"></span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="cli_dui" name="cli_dui" class="form-control " autocomplete="off" data-inputmask="'mask': '99999999-9'" value="<?php echo $Traer_Cliente_por_ID[0]->cli_dui;?>">
											</div>
										</div>
										
										
										
                            
							</div>
							<div class="col-sm-6">
							<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">NIT <span class="required"></span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="cli_nit" name="cli_nit" class="form-control " autocomplete="off" data-inputmask="'mask': '9999-999999-999-9'" value="<?php echo $Traer_Cliente_por_ID[0]->cli_nit;?>">
											</div>
										</div>
								<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Departamento <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" id="id_departamento" name="id_departamento">
													<option>Elija un departamento</option>
													<?php 
														foreach($Departamentos as $Registro_Econtrado):			
													?>
													<option value="<?php echo $Registro_Econtrado->id_departamento;?>" <?php 
if($Registro_Econtrado->id_departamento == $Traer_Cliente_por_ID[0]->id_departamento){
	echo "selected";
}
													?>><?php echo $Registro_Econtrado->departamento_nombre;?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Municipio <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" id="id_municipio" name="id_municipio">
													<option value="<?php echo $Traer_Cliente_por_ID[0]->id_municipio;?>"><?php echo $Traer_Cliente_por_ID[0]->municipio_nombre;?></option>
												</select>
											</div>
										</div>
								<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Direcci&oacute;n</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="cli_direccion" class="form-control" type="text" name="cli_direccion" autocomplete="off" value="<?php echo $Traer_Cliente_por_ID[0]->cli_direccion;?>">
											</div>
										</div>
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Tel&eacute;fono</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="cli_telefono" class="form-control" type="text" name="cli_telefono" autocomplete="off" data-inputmask="'mask': '9999-9999'" value="<?php echo $Traer_Cliente_por_ID[0]->cli_telefono;?>">
											</div>
										</div>
										
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