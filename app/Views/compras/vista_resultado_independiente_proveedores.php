<div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap no-footer"><div class="row"></div><div class="row"><div class="col-sm-12"><table id="datatable" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="datatable_info">
                      <thead>
                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">NRC</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">NIT</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">Raz&oacute;n social</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Nombre comercial</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending">Acci&oacute;n</th></tr>
                      </thead>
                      <tbody>
						<?php 
							foreach($Traer_Datos as $Dato_Encontrado){
						?>
                       <tr role="row" class="odd">
                          <td class="sorting_1"><?php echo $Dato_Encontrado->id_proveedor;?></td>
                          <td><?php echo $Dato_Encontrado->pro_nrc;?></td>
                          <td><?php echo $Dato_Encontrado->pro_nit;?></td>
                          <td><?php echo $Dato_Encontrado->pro_razon_social;?></td>
                          <td><?php echo $Dato_Encontrado->pro_nombre_comercial;?></td>
                          <td><a href="#" onClick="Eligir_Proveedor('<?php echo $Dato_Encontrado->id_proveedor;?>', '<?php echo $Dato_Encontrado->pro_nrc;?>', '<?php echo $Dato_Encontrado->pro_razon_social;?>', '<?php echo $Dato_Encontrado->pro_nombre_comercial;?>', '<?php echo $Dato_Encontrado->pro_nit;?>'); event.preventDefault();" data-toggle="tooltip" data-placement="top" title data-original-title="Elegir proveedor"><img src="<?php echo base_url();?>/images/add.png " style ="width: 47%;"  id="agregar_producto" >
										</a></td>
                        </tr>
						<?php 
							}
						?>
					 </tbody>
                    </table></div></div></div>