<?php 
if(!session("carrito")){
	return;
}
$productos_en_el_carro = count(session("carrito"));
$total_facturas_a_generar = $productos_en_el_carro/$numero_de_renglones_factura;
?>

<table class="table table-sm" id="tbl_productos_en_carrito">
                        <thead>
							<tr class="table-info">
								<th colspan="6" style="text-align:center;"><label id="leyenda"><h3><span class="badge badge-dark"><?php echo $productos_en_el_carro;?> producto/s agregados y se generar&aacute;n <?php echo ceil($total_facturas_a_generar);?> Factura/s</span></h3></label> </th>
							</tr>
                          <tr class="table-info">
                           
                            <th class="column-title">C&oacute;digo </th>
                            <th class="column-title">Producto </th>
                            <th class="column-title" style="width:12%;">Catnidad </th>
                            <th class="column-title" style="width:12%;">Precio U. </th>
                            <th class="column-title">Sub-total </th>
                            <th class="column-title no-link last" style="text-align:center">Acciones
                            </th>
                           
                          </tr>
                        </thead>
						<tbody>
							<?php 
								$Gran_Total = 0;
								foreach(session("carrito") as $Producto_En_El_Carrito){
								$Gran_Total = $Gran_Total + $Producto_En_El_Carrito["subtotal"];
							?>
							<tr data-id="<?php echo $Producto_En_El_Carrito["codigoproducto"];?>">
								<td><?php echo $Producto_En_El_Carrito["codigoproducto"];?></td>
								<td><?php echo $Producto_En_El_Carrito["producto"];?>
								
								</td>
								<td>
									<input type="number" id="cantidad_<?php echo $Producto_En_El_Carrito["codigoproducto"];?>" name="cantidad" class="form-control " autocomplete="off" value="<?php echo $Producto_En_El_Carrito["cantidad"];?>">
								
								</td>
								<td style="text-align:left">
								
									<input type="number" id="precio_<?php echo $Producto_En_El_Carrito["codigoproducto"];?>" name="precio" class="form-control" autocomplete="off" value="<?php echo $Producto_En_El_Carrito["precio"];?>">
								
									</td>
								<td style="text-align:right"><?php echo $Producto_En_El_Carrito["subtotal"];?></td>
								<td style="text-align:center">
									
									<button type="button" class="btn btn-danger" id="btn_eliminar_items" data-valor="<?php echo $Producto_En_El_Carrito["codigoproducto"];?>">Elminar</button>
									<button type="button" class="btn btn-primary btn_actualizar_item" data-id="<?php echo $Producto_En_El_Carrito["codigoproducto"];?>">Actualizar</button>									
								</td>
							</tr>
							<?php 
								}
							?>
							
						</tbody>
						<tr>
								<td colspan="4" style="text-align:right"><h3>Total $</h3></td>
								<td style="text-align:right"><h3><?php echo $Gran_Total;?></h3></td>
								<td></td>
						</tr>
						<tr>
							<td colspan="6" style="text-align:center">
								<?php 
									if($productos_en_el_carro > 0){
								?>
									<a href="#" class="btn btn-app" onClick="Guardar_Pre_Venta(); event.preventDefault();">
										<i class="fa fa-save" ></i> Pre-Factura
									 </a>
									 <a href="#" class="btn btn-app"  onclick="Guardar_E_Imprimir_Cotizacion(); event.preventDefault();">
										<i class="fa fa-print" ></i> Cotizaci&oacute;n
									 </a>
									 
									 <a href="#" class="btn btn-app" onclick="Limpiar_Carrito();  event.preventDefault();">
										<i class="fa fa-trash" ></i> Limpiar
									 </a>
									<?php }?>
								</td>
						</tr>
                       </table>
					