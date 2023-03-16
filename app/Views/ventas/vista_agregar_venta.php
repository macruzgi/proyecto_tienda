<div class="x_panel">
                  <div class="x_title">
                    <h2>Agregar Factura</h2>
					<ul class="nav navbar-right panel_toolbox">
                      <a href="javascript:void(0)" class="btn btn-app" data-toggle="tooltip" data-placement="top" title="" data-original-title="Guardar pre-factura">
						<i class="fa fa-save"></i> Alt + G
					  </a>
					<a href="javascript:void(0)"  class="btn btn-app" data-toggle="tooltip" data-placement="top" title="" data-original-title="Imprimir cotizaci&oacute;n">
										<i class="fa fa-print"></i> Alt + i
					</a>
									 
					<a href="javascript:void(0)" class="btn btn-app" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quitar todos los productos agregados a la factura">
						<i class="fa fa-trash"></i> Alt + L
					</a>
					<a href="javascript:void(0)" class="btn btn-app" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enfocar para buscar">
						<i class="fa fa-search"></i> Alt + B
					</a>
					
                    </ul>
                    <ul class="nav navbar-right panel_toolbox">
                       <!--a href="javascript:void(0)" class="btn btn-primary" type="reset">Teclas de atajo:</a-->
					   	
					   <div class="alert alert-primary" role="alert">
						  Teclas de atajo, posicione el mause sobre cada opci&oacute;n para una breve descripci&oacute;n:
						</div>
						
                    </ul>
					
                    <div class="clearfix"></div>
                  </div>
					<div class="x_content">
					<form id="frm_nueva_venta" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
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
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cliente<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="cli_cliente_buscar" name="cli_cliente_buscar" required="required" class="form-control" autocomplete="off" placeholder="Digite el c&oacute;digo del cliente para buscar">
												<input type="hidden" id="id_cliente" name="id_cliente">
											</div>
										</div>
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombre <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="cli_nombre" name="cli_nombre" required="required" class="form-control " autocomplete="off">
											</div>
										</div>
										
									
							</div>
							<div class="col-md-6">
							<h4>Para cotizaci&oacute;n:</h4>
							<div class="ln_solid"></div>
								<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. de Cotizaci&oacute;n <span class="required"></span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="nombre_numero_cotizacion" name="nombre_numero_cotizacion" class="form-control " autocomplete="off" placeholder="Digite algo para buscar cotizaciones">
<input type="hidden" name="id_cotizacion" id="id_cotizacion">
											</div>
								</div>
								<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">T&eacute;minos y condiciones<span class="required"></span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="terminos_condiciones" class="form-control" name="terminos_condiciones"></textarea>
												<ul class="" id="parsley-id-40"><li class="">Solo se permiten 150 caracteres</li></ul>
												
												
											</div>
								</div>
							</div>
							<div class="col-md-12">
										<div class="item form-group">
											<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Producto<span class="required"></span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="buscar_producto_venta" class="form-control" type="text" name="buscar_producto_venta" autocomplete="off" placeholder="Digite coincidencias para buscar un producto">
											</div>
										</div>
<div class="table-responsive">
					<!-- inicio tabla donde se muestran los prudctos cuando se buscan en la caja de texto-->
                      <table class="table table-striped jambo_table bulk_action" id="tbl_productos">
                        <thead>
                          <tr class="headings">
                           
                            <th class="column-title">Nombre </th>
                            <th class="column-title">Descripci&oacute;n </th>
                            <th class="column-title">Categor&iacute;a </th>
                            <th class="column-title">Precio Unitario </th>
                            <th class="column-title">Existencias </th>
                            <th class="column-title" style="width:12%;">Cantidad </th>
                            <th class="column-title">Agregar Producto
                            </th>
                           
                          </tr>
                        </thead>
						<tbody>
						
						</tbody>
                       </table>
					   <!-- inicio tabla donde se muestran los prudctos cuando se buscan en la caja de texto-->
					   
					   <!-- tabla para mostrar las cotizaciones cuando se busca en el cuadro de texto de cotizaciones-->
						<table class="table table-striped jambo_table bulk_action" id="tbl_cotizaciones" style="display:none;">
                        <thead>
                          <tr class="headings">
                           
                            <th class="column-title">No. de Cotizaci&oacute;n </th>
                            <th class="column-title">Fecha </th>
                            <th class="column-title">&Uacute;ltimo update </th>
                            <th class="column-title">Cliente </th>
                            <th class="column-title">T&eacute;minos y condiciones </th>
                            <th class="column-title">Total </th>
                            <th class="column-title no-link last"><span class="nobr">Procesar cotizaci&oacute;n</span>
                            </th>
                           
                          </tr>
                        </thead>
						<tbody>
						
						</tbody>
                       </table>
					    <!-- fin tabla para mostrar las cotizaciones-->
						
                    <div class="col-md-12">
						<div class="alert alert-danger alert-dismissible " role="alert" id="mensaje_cantidad_mayor" style="display:none;">
									<!--aqui se muestran los mensajes cuando la cantidad del producto es mayor a la existente-->
						</div>
					</div>
					<!--aqui se muestra la tabla de los productos en el carrito-->
					<div id="div_tbl_productos_en_el_carrito"></div>
					
					</div>
											
										
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
                          <h4 class="modal-title" id="myModalLabel">Buscar clientes</h4>
						  
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h4>Busque el cliente deseado</h4>
                          <div class="card-box table-responsive">
                    <p class="text-muted font-13 m-b-30">
                      Si no lo encuentra, utilice el clietne comod&iacute;n, de lo contrario debe registrarlo</code>
                    </p>
					
						<div id="div_tbl_clientes"></div>
                  </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                          <!--button type="button" class="btn btn-primary">Save changes</button-->
                        </div>

                      </div>
                    </div>
                  </div>
				<!--fin modal-->
				</div>
</div>
