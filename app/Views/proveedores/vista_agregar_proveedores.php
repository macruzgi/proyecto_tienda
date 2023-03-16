<div class="x_panel">
                  <div class="x_title">
                    <h2>Agregar Proveedores</h2>
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
							

								<form id="frm_agregar_proveedor" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">C&oacute;digo <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="pro_codigo" name="pro_codigo" required="required" class="form-control" autocomplete="off">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Raz&oacute;n social <span class="required">*</span>
											</label>
											<div class="col-md-8 col-sm-8">
												<input type="text" id="pro_razon_social" name="pro_razon_social" required="required" class="form-control " autocomplete="off">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombre comercial <span class="required">*</span>
											</label>
											<div class="col-md-8 col-sm-8">
												<input id="pro_nombre_comercial" class="form-control" type="text" name="pro_nombre_comercial" autocomplete="off">
											</div>
										</div>
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">NRC<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="pro_nrc" class="form-control" type="text" name="pro_nrc" autocomplete="off">
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">NIT<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="pro_nit" class="form-control" type="text" name="pro_nit" autocomplete="off" data-inputmask="'mask': '9999-999999-999-9'">
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">DUI</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="pro_dui" class="form-control" type="text" name="pro_dui" autocomplete="off" data-inputmask="'mask': '99999999-9'">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
									<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Departamento <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" id="id_departamento" name="id_departamento">
													<option>Elija un departamento</option>
													<?php 
														foreach($Departamentos as $Registro_Econtrado):			
													?>
													<option value="<?php echo $Registro_Econtrado->id_departamento;?>"><?php echo $Registro_Econtrado->departamento_nombre;?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Municipio <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" id="id_municipio" name="id_municipio">
													<option value="">Elija un municipio</option>
												</select>
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Direcci&oacute;n</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="pro_direccion" class="form-control" name="pro_direccion"></textarea>
												<ul class="" id="parsley-id-40"><li class="">Solo se permiten 250 caracteres</li></ul>
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Tel&eacute;fono</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="pro_telefono" class="form-control" type="text" name="pro_telefono" autocomplete="off" data-inputmask="'mask': '9999-9999'">
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