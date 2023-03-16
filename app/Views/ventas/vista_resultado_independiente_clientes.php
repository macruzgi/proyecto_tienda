<div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap no-footer"><div class="row"></div><div class="row"><div class="col-sm-12"><table id="tbl_busqueda_cliente" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="datatable_info">
                      <thead>
                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">C&oacute;digo cliente</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">Nombre</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">Telef&oacute;no</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Direcci&oacute;n</th>
						<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Acci&oacute;n</th>
						</tr>
                      </thead>
                      <tbody>
						<?php 
							foreach($Traer_Datos as $Dato_Encontrado){
						?>
                       <tr role="row" class="odd">
                          <td class="sorting_1"><?php echo $Dato_Encontrado->id_cliente;?></td>
                          <td><?php echo $Dato_Encontrado->cli_codigo;?></td>
                          <td><?php echo $Dato_Encontrado->cli_nombre;?></td>
                          <td><?php echo $Dato_Encontrado->cli_telefono;?></td>
                          <td><?php echo $Dato_Encontrado->cli_direccion;?></td>
                          <td><a href="#" onClick="Eligir_Cliente('<?php echo $Dato_Encontrado->id_cliente;?>', '<?php echo $Dato_Encontrado->cli_codigo;?>', '<?php echo $Dato_Encontrado->cli_nombre;?>'); event.preventDefault();" data-toggle="tooltip" data-placement="top" title data-original-title="Elegir proveedor"><img src="<?php echo base_url();?>/images/add.png " style ="width: 30%;"  id="agregar_producto" >
										</a></td>
                        </tr>
						<?php 
							}
						?>
					 </tbody>
                    </table></div></div></div>