<div class="x_panel">
                  <div class="x_title">
                    <h2>Administraci&oacute;n de Cotizaciones</small></h2>
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
						  
                            <div class="card-box table-responsive">
       
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" style="width: 100%;" role="grid" aria-describedby="datatable-buttons_info">
                      <thead>
                        <tr role="row">
							<th class="sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Position: activate to sort column ascending">No. de cotizaci&oacute;n</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Office: activate to sort column ascending">Fecha</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1"  aria-label="Age: activate to sort column ascending">&Uacute;timo update</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Cliente</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">T&eacute;rminos y condiciones</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Total</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Estado</th>
							<th class="sorting" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Acci&oacute;n</th>
							
						</tr>
                      </thead>
					  <tbody>
							<?php 
								foreach($Traer_Cotizaciones as $Cotizacion_Encontrada){
							?>
							<tr>
								<td><?php echo $Cotizacion_Encontrada->id_cotizacion;?></td>
								
								<td><?php echo $Cotizacion_Encontrada->numero_cotizacion;?></td>
								<td><?php echo $Cotizacion_Encontrada->fecha;?></td>
								<td><?php echo $Cotizacion_Encontrada->fecha_ultima_modificacion;?></td>
								<td><?php echo $Cotizacion_Encontrada->nombre_cliente;?></td>
								<td><?php echo $Cotizacion_Encontrada->terminos_condiciones;?></td>
								<td><?php echo $Cotizacion_Encontrada->costo;?></td>
								<td><?php echo $Cotizacion_Encontrada->ESTADO;?></td>
								<td>
									<div class="fa-hover col-md-3 col-sm-4  mr-3">
									<h3><a href="<?php echo base_url();?>/Re_Imprimir_Cotizacion/<?php echo $Cotizacion_Encontrada->id_cotizacion;?>" data-toggle="tooltip" data-placement="top" title data-original-title="Re-imprimir"><i class="fa fa-print"></i></a></h3>
									</div>
									<div class="fa-hover col-md-3 col-sm-4  ">
									  <h3><a href="#" onClick="Eliminar_Cotizacion(<?php echo $Cotizacion_Encontrada->id_cotizacion;?>); event.preventDefault();"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i></a></h3> 
									 </div>
								</td>
							</tr>
								<?php }?>
					  </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
                </div>