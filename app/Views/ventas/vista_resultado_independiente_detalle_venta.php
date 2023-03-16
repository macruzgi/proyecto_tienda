
<div class="item form-group">
	<label class="col-form-label col-md-2 col-sm-2 label-align" for="first-name">Fecha<span class="required"></span>
	</label>
	<div class="col-md-3 col-sm-3 ">
		<span class="form-control"><?php  if($Traer_Datos){ echo $Traer_Datos[0]->fac_fecha_creacion;}?></span>
		
	</div>
	<label class="col-form-label col-md-2 col-sm-2 label-align" for="first-name">No. de documento<span class="required"></span>
	</label>
	<div class="col-md-3 col-sm-3 ">
		<span class="form-control"><?php  if($Traer_Datos){ echo $Traer_Datos[0]->id_factura;}?></span>
		
	</div>
</div>
<div class="item form-group">
	<label class="col-form-label col-md-2 col-sm-2 label-align" for="first-name">Cliente<span class="required"></span>
	</label>
	<div class="col-md-6 col-sm-6 ">
		<span class="form-control"><?php if($Traer_Datos){ echo $Traer_Datos[0]->fac_nombre_cliente;}?></span>
		
	</div>
	
</div>

<table class="table table-striped jambo_table" id="tbl_detalle_de_factura_selecionada">
                      <thead>
                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending">C&oacute;digo</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">Producto</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">Cantidad</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">Precio U.</th><th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending">Subtotal</th></tr>
                      </thead>
                      <tbody>
						<?php 
						if(!$Traer_Datos){
							return;
						}
							foreach($Traer_Datos as $Dato_Encontrado){
						?>
                       <tr role="row" class="odd">
                          <td class="sorting_1"><?php echo $Dato_Encontrado->codigoproducto;?></td>
                          <td><?php echo $Dato_Encontrado->nombre." (".$Dato_Encontrado->descripcion.")";?></td>
                          <td><?php echo $Dato_Encontrado->facde_cantidad;?></td>
                          <td style="text-align:right;">$&nbsp;<?php echo $Dato_Encontrado->facde_precio_venta;?></td>
                          <td style="text-align:right;">$&nbsp;<?php echo $Dato_Encontrado->facde_subtotal;?></td>
                         
                        </tr>
						<?php 
							}
						?>
						</tbody>
						<tr>
							<td colspan="4" style="text-align:right;"><h2>Total</h2></td>
							<td style="text-align:right;"><h2>$&nbsp;<?php echo $Dato_Encontrado->fac_total;?></h2></td>
						</tr>
					
                    </table>