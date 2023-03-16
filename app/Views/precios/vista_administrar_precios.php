<div class="x_panel">
                  <div class="x_title">
                    <h2>Aministrar Precios</h2>
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
					<form id="frm_agregar_precio" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
						<div class="row">
						<div class="col-md-12">
							<div class="alert alert-danger alert-dismissible " role="alert" id="mensaje" style="display:none;">
									<!--aqui se muestran los mensajes devueltos par la peticion-->
								</div>
							</div>
							
							<div class="col-md-6">
								<div id="overlay">
								  <!--overlay para cuando se está procesando el formulario y mustra un alerta de espere..-->
								  <div class="spinner"></div>
								  <div class="message">
								  <div class="spinner-border text-primary" role="status">
									  <span class="sr-only">Loading...</span>
									</div>
								  Espere por favor...</div>
								</div>
								 <div class="card-box table-responsive">
       
                    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="datatable_info">
                      <thead>
                        <tr role="row">
							<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Name: activate to sort column descending">C&oacute;digo</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Producto</th>
							
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Categor&iacute;a</th>
							
							
						</tr>
                      </thead>
					  <tbody>
							<?php 
								foreach($Traer_Datos as $Fila_Encontrada){
							?>
							
							<tr>
								<td><?php echo $Fila_Encontrada->codigoproducto;?></td>
								<td><a href="#" onClick="Traer_Dato_Producto_Para_Precio('<?php echo $Fila_Encontrada->codigoproducto;?>', '<?php echo $Fila_Encontrada->nombre. " (".$Fila_Encontrada->descripcion.")";?>'); event.preventDefault();"><?php echo $Fila_Encontrada->nombre. " (".$Fila_Encontrada->descripcion.")";?></a></td>
								
								<td><?php echo $Fila_Encontrada->tipo_nombre;?></td>
							</tr>
						
								<?php }?>
					  </tbody>
                    </table>
                  </div>
                
										
										
									
							</div>
							<div class="col-md-6">
							 <h2>&Uacute;ltimas 5 compras</h2>
								<ul class="list-unstyled top_profiles scroll-view" id ="resultados_kardex">
								  <li class="media event">
									<a class="pull-left border-aero profile_thumb">
									  <i class="fa fa-calculator aero"></i>
									</a>
								
								  </li>
								</ul>
								<h2>&Uacute;ltimos 5 precios de ventas asignados</h2>
								<ul class="list-unstyled top_profiles scroll-view" id ="resultados_precios">
								  <li class="media event">
									<a class="pull-left border-aero profile_thumb">
									  <i class="fa fa-dollar aero"></i>
									</a>
									
								  </li>
								</ul>
							</div>
							
							
						</div>
						
						<div class="ln_solid"></div>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-12">
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Producto<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="nombre_producto" class="form-control" type="text" name="nombre_producto" autocomplete="off" readOnly placeholder="Debe sleccionar un producto de los mostrados arriba">
												<input type="hidden" name="codigoproducto" id="codigoproducto">
												
											</div>
										</div>
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Nuevo Precio<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="pre_precio" class="form-control" type="text" name="pre_precio" autocomplete="off" placeholder="Nuevo precio">
												
												
											</div>
										</div>
										</div>
								</div>
							</div>
							<div class="ln_solid"></div>
						<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button  id="btn_Guardar" class="btn btn-success">Guardar</button>
												<a href="javascript:history.back()" class="btn btn-danger" type="reset">Cancelar</a>
											</div>
										</div>
					</form>
				
				</div>
</div>