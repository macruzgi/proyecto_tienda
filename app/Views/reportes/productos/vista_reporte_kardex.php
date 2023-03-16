<div class="x_panel">
                  <div class="x_title">
                    <h2>Reporte de kardex pro producto</h2>
                    <!--ul class="nav navbar-right panel_toolbox">
                       <a href="javascript:history.back()" class="btn btn-danger" type="reset">Cancelar</a>
                    </ul-->
                    <div class="clearfix"></div>
                  </div>
					<div class="x_content">
					
					<form id="frm_reporte_kardex" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
						<div class="row">
								<div id="overlay">
								  <!--overlay para cuando se está procesando el formulario y mustra un alerta de espere..-->
								  <div class="spinner"></div>
								  <div class="message">
								  <div class="spinner-border text-primary" role="status">
									  <span class="sr-only">Loading...</span>
									</div>
								  Espere por favor...</div>
								</div>
							<div class="col-md-12">
							<div class="alert alert-danger alert-dismissible " role="alert" id="mensaje" style="display:none;">
									<!--aqui se muestran los mensajes devueltos par la peticion-->
								</div>
							</div>
							<div class="col-md-6">
								<div class="item form-group">
									<label class="col-form-label col-md-6 col-sm-6 label-align" for="first-name">Fecha desde: <span class="required">*</span>
									</label>
									<div class="form-group">
										<div class="input-group date" id="cal_fecha_desde">
											<input type="text" class="form-control input-group-addon" id="fecha_desde" name="fecha_desde">
								
										</div>
									</div>
								</div>
										
								<div class="item form-group">
									<label class="col-form-label col-md-6 col-sm-6 label-align" for="first-name">Producto <span class="required">*</span>
									</label>
									<div class="form-group">
										<div class="input-group">
											<input id="buscar_producto_reporte_kardex" class="form-control" type="text" name="buscar_producto_reporte_kardex" autocomplete="off" placeholder="Digite coincidencias para buscar un producto">								
										</div>
									</div>
								</div>
									
							</div>
							<div class="col-md-6">
								<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Fecha hasta: <span class="required">*</span>
											</label>
											<div class="form-group">
												<div class="input-group date" id="cal_fecha_hasta">
												<input type="text" class="form-control input-group-addon" name ="fecha_hasta" id="fecha_hasta">
										
												</div>
											</div>
								</div>
								<div class="table-responsive">
								<!-- inicio tabla donde se muestran los prudctos cuando se buscan en la caja de texto-->
								  <table class="table table-striped jambo_table bulk_action" id="tbl_productos">
									<thead>
									  <tr class="headings">
									   
										<th class="column-title">C&oacute;digo/Nombre </th>
										<th class="column-title">Descripci&oacute;n </th>
										<th class="column-title">Categor&iacute;a </th>
										<th class="column-title">Seleccionar Producto
										</th>
									   
									  </tr>
									</thead>
									<tbody>
									
									</tbody>
								   </table>
								</div>
							</div>
							<div class="col-md-12">
								<div id="pdf-container" style ="display:none;">
								  <embed id="pdf" src="" type="application/pdf" width="100%" height="350px">
								</div>
							</div>
						</div>
						
						<div class="ln_solid"></div>
						<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button type="submit"  id="btn_generar_reporte_kardex" class="btn btn-success">Generar</button>
										
											</div>
										</div>
					</form>
				
				</div>
</div>