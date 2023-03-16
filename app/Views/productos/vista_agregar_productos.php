<div class="x_panel">
                  <div class="x_title">
                    <h2>Agregar Productos</h2>
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

								<form id="frm_agregar_producto" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">C&oacute;digo <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="prod_codigo" name="prod_codigo" required="required" class="form-control" autocomplete="off">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombre <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="nombre" name="nombre" required="required" class="form-control " autocomplete="off">
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Descripci&oacute;n<span class="required"></span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="descripcion" class="form-control" type="text" name="descripcion" autocomplete="off">
											</div>
										</div>
																				
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Categor&iacute;a<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" id="id_tipo_producto" name="id_tipo_producto">
													<option value="">Elija una opci&oacute;n</option>
													<?php 
														foreach($Categorias as $Fila_Encontrada){
													?>
													<option value="<?php echo $Fila_Encontrada->id_tipo_producto;?>"><?php echo $Fila_Encontrada->tipo_nombre;?></option>
													<?php }?>
												</select>
											</div>
										</div>
										
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Unidad de medida<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" id="id_tipo_unidad" name="id_tipo_unidad">
													<option value="">Elija una opci&oacute;n</option>
													<?php 
														foreach($Unidad_Medida as $Fila_Encontrada){
													?>
													<option value="<?php echo $Fila_Encontrada->id_tipo_unidad;?>"><?php echo $Fila_Encontrada->tipo_unidad_nombre;?></option>
													<?php }?>
												</select>
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