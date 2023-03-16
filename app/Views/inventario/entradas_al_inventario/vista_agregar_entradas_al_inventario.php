<div class="x_panel">
                  <div class="x_title">
                    <h2>Agregar Entrada al Inventario</h2>
                    <ul class="nav navbar-right panel_toolbox">
                       <a href="javascript:history.back()" class="btn btn-danger" type="reset">Cancelar</a>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
					<div class="x_content">
					<form id="frm_agregar_entrada_al_inventario" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
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
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. de Documento <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="en_numero_documento" name="en_numero_documento" required="required" class="form-control " autocomplete="off">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Comentario<span class="required"></span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="en_comentario" class="form-control" name="en_comentario" ></textarea>
												<ul class="parsley-errors-list filled" id="parsley-id-40"><li class="parsley-minlength">Solo se permiten 250 caracteres</li></ul>
												
												
											</div>
										</div>
										
										
									
							</div>
							<div class="col-md-12">
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Producto<span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="buscar_producto_entrada" class="form-control" type="text" name="buscar_producto_entrada" autocomplete="off" placeholder="Digite coincidencias para buscar un producto">
											</div>
										</div>
										<table class="table table-striped" id="tbl_productos" style="display:none;">
										  
										  <thead>
											<tr>
											  <th>ID</th>
											  <th>Código del producto</th>
											  <th>Descripción</th>
											  <th>Acci&oacute;n</th>
											</tr>
										  </thead>
										  <tbody id="productos-container">
											
										  </tbody>
										</table>	
										<table class="table table-striped" id="tbl_carrito" style="display:none;">
										  <thead>
											<tr>
											  <th>Código del producto</th>
											   <th>Descripción</th>
											  <th>Cantidad</th>
											  <th>Precio</th>
											   <th>Sub-Total</th>
											  <th>Acciones</th>
											</tr>
										  </thead>
										  <tbody>
											
										  </tbody>
										</table>
							</div>
						</div>
						
						<div class="ln_solid"></div>
						<!--div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<button  id="btn_Guardar" class="btn btn-success">Guardar</button>
												<a href="javascript:history.back()" class="btn btn-primary" type="reset">Cancelar</a>
											</div>
										</div-->
					</form>
				<!--inicio de la modal de busqueda-->
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" id="modal_busqueda">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">Buscar proveedores</h4>
						  
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h4>Busque el proveedor deseado</h4>
                          <div class="card-box table-responsive">
                    <p class="text-muted font-13 m-b-30">
                      Si no lo encuentra utilice el proveedor comod&iacute;n, de lo contrario debe registrarlo</code>
                    </p>
					
						<div id="tbl_proveedores"></div>
                  </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <!--button type="button" class="btn btn-primary">Save changes</button-->
                        </div>

                      </div>
                    </div>
                  </div>
				<!--fin modal-->
				</div>
</div>