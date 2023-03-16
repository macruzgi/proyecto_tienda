<div class="x_panel">
                  <div class="x_title">
                    <h2>Reporte de ventas</h2>
                    <!--ul class="nav navbar-right panel_toolbox">
                       <a href="javascript:history.back()" class="btn btn-danger" type="reset">Cancelar</a>
                    </ul-->
                    <div class="clearfix"></div>
                  </div>
					<div class="x_content">
					
					<form id="frm_reporte_ventas" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
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
										<label class="col-form-label col-md-6 col-sm-6 label-align" for="first-name">Usuario: <span class="required">*</span>
										</label>
										<div class="form-group">
											<div class="input-group date" id="cal_fecha_desde">
												<select class="form-control" id="codigousuario" name="codigousuario">
												<option value ="TODOS">TODOS</option>
<?php
	foreach($Usuarios as $Dato_Encontrado){
?>													<option value="<?php echo $Dato_Encontrado->codigousuario;?>"><?php echo $Dato_Encontrado->nombre." (".$Dato_Encontrado->nombreusuario.")"; ?></option>
	<?php } ?>
									</select>
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
												<button  id="btn_generar_reporte_ventas" class="btn btn-success">Generar</button>
										
											</div>
										</div>
					</form>
				
				</div>
</div>