<div class="x_panel">
                  <div class="x_title">
                    <h2>Bandeja de Facturas</small></h2>
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
						  <div class="alert alert-danger alert-dismissible" role="alert" style="display:none;" id="mensaje">
									<!--
									Aqui se veran los mensajes de error-->
						  </div>
						  <a class="btn btn-app" href="<?php echo base_url();?>/Ventas/Nueva_Venta">
							<i class="fa fa-edit"></i> Agregar Factura
						  </a>
                            <div class="card-box table-responsive">
       
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" style="width: 100%;" role="grid" aria-describedby="datatable-buttons_info">
                      <thead>
                        <tr role="row">
							<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">Fecha y hora</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Cliente</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">Total</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Usuario</th>
						
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" style="text-align:center;">Acci&oacute;n</th>
							
						</tr>
                      </thead>
					  <tbody>
							<?php 
								foreach($Traer_Datos as $Dato_Encontrado){
							?>
							<tr>
								<td><?php echo $Dato_Encontrado->id_factura;?></td>
								
								<td><?php echo $Dato_Encontrado->fac_fecha_creacion;?></td>
								<td><?php echo $Dato_Encontrado->fac_nombre_cliente;?></td>
								<td><?php echo $Dato_Encontrado->fac_total;?></td>
								<td><?php echo $Dato_Encontrado->nombreusuario." (".$Dato_Encontrado->nombre.")";?></td>
								
								<td style="text-align:center;">
									<div class="fa-hover col-md-3 col-sm-4  ">
										<h3><a  href="#" onClick="Guardar_Venta(<?php echo $Dato_Encontrado->id_factura;?>); event.preventDefault();" data-toggle="tooltip" data-placement="top" title data-original-title="Cobrar">
										<i class="fa fa-dollar"></i> 
									  </a></h3>
									</div>
									<div class="fa-hover col-md-3 col-sm-4  ">
										<h3><a  href="#" onClick="Modificar_Venta(<?php echo $Dato_Encontrado->id_factura;?>); event.preventDefault();" data-toggle="tooltip" data-placement="top" title data-original-title="Modificar">
										<i class="fa fa-edit"></i> 
									  </a></h3>
									</div>
									<div class="fa-hover col-md-3 col-sm-4  ">
										<h3><a  href="#" onClick="Eliminar_Pre_Factura(<?php echo $Dato_Encontrado->id_factura;?>); event.preventDefault();" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar">
										<i class="fa fa-trash"></i> 
									  </a></h3>
									</div>
									
									<div class="fa-hover col-md-3 col-sm-4  ">
										<h3><a  href="#" onClick="Traer_Detalle_Venta('<?php echo $Dato_Encontrado->id_factura;?>', 0); event.preventDefault();" data-toggle="tooltip" data-placement="top" title data-original-title="Ver">
										<i class="fa fa-file-text"></i> 
									  </a></h3>
									</div>
									
								</td>
							</tr>
								<?php }?>
					  </tbody>
                    </table>
                  </div>
                </div>
              </div>
					<!--inicio de la modal donde se muestra el detalle del registro-->
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" id="modal_dato_selecconado">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">Detalle de la Venta</h4>
						  
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          
                          <div class="card-box table-responsive">
                    <p class="text-muted font-13 m-b-30">
                     
                    </p>
						<!--aqui se mostrará la tabal de de los detalles del registro-->
						<div id="div_tbl_seleccionado"></div>
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