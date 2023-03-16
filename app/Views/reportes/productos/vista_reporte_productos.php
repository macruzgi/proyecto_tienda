<div class="x_panel">
                  <div class="x_title">
                    <h2>Reporte de productos</h2>
                    <!--ul class="nav navbar-right panel_toolbox">
                       <a href="javascript:history.back()" class="btn btn-danger" type="reset">Cancelar</a>
                    </ul-->
                    <div class="clearfix"></div>
                  </div>
					<div class="x_content">
					
					<form id="frm_reporte_productos" class="form-horizontal form-label-left">
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
											<label class="col-form-label col-md-6 col-sm-6 label-align" for="first-name">Elija una opci&oacute;n:

												
											</label>

											<div class="form-group">
												
												<div class="radio">
													<label>
														<input type="radio" checked value="sin_kardex" id="con_existencias" name="con_existencias"> Sin inventario
													</label>
												</div>
												<div class="radio">
													<label>
														<input type="radio" checked value="option1" id="con_existencias" name="con_existencias"> Sin existencias
													</label>
												</div>
												<div class="radio">
													<label>
														<input type="radio" value="existencia" id="con_existencias" name="con_existencias"> Con existencias
													</label>
												</div>
												<div class="radio">
													<label>
														<input type="radio" value="listado" id="con_existencias" name="con_existencias"> Listado
													</label>
												</div>
											</div>
										</div>		
										
										
									
							</div>
							<div class="col-md-4">
							<div class="item form-group">
										<label class="col-form-label col-md-6 col-sm-6 label-align" for="first-name">Categor&iacute;a: <span class="required">*</span>
										</label>
										<div class="form-group">
											<div class="input-group date" id="cal_fecha_desde">
												<select class="form-control" id="id_tipo_producto" name="id_tipo_producto">
												<option value ="TODAS">TODAS</option>
<?php
	foreach($Categorias as $Dato_Encontrado){
?>													<option value="<?php echo $Dato_Encontrado->id_tipo_producto;?>"><?php echo $Dato_Encontrado->tipo_nombre; ?></option>
	<?php } ?>
									</select>
											</div>
										</div>
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
												<button  id="btn_generar_reporte_productos" class="btn btn-success">Generar</button>
										
											</div>
										</div>
					</form>
				
				</div>
</div>