<style>
.tabla {
border-collapse: collapse;
    border: 1px solid;
    width: 100%;
    //margin-left: 44px;
	font-family: monospace;
}
.tabla td{
	border: 1px solid;
}
.tabla th{
	border: 1px solid;
}
.alinear_derecha{
	text-align:right;
}
h2 {
	font-family: monospace;
}
</style>
<?php
 date_default_timezone_set('America/El_Salvador');
 
?>
<script>
setTimeout("print();",1500);
setTimeout("window.location = '<?php echo base_url();?>/Administrar_Cotizaciones'",3000);
</script>

    <div style="margin-left: 36px;margin-bottom: 15px;">
	<img src='<?php echo base_url();?>/images/logo_cotizacion.jpg' title='Logo' style="width: 19%;">
	</div>
<?php 
if(!$Traer_Cotizacion){
	echo "No hay nada para imprimir";
	return;
}
?>
<table id="tbl_productos" class ="tabla">
 <thead>
	<tr>
		<th colspan='4' style='text-align:left;'> Cotizaci&oacute;n No. <b><?php echo $Traer_Cotizacion[0]->numero_cotizacion;//$this->session->userdata("numero_cotizacion");?></b> Cliente: <?php echo strtoupper($Traer_Cotizacion[0]->nombre_cliente);?></th>
	</tr>
	<tr>
		<th colspan='4' style='text-align:left;'> Fecha  <b><?php echo $Traer_Cotizacion[0]->fecha;//$this->session->userdata("numero_cotizacion");?></b> &Uacute;ltima fecha de Actualizaci&oacute;n: <?php echo $Traer_Cotizacion[0]->fecha_ultima_modificacion;?></th>
	</tr>
	<tr>
		<th colspan='4' style='text-align:left;'> T&eacute;minos y condiciones: <?php echo $Traer_Cotizacion[0]->terminos_condiciones;?></th>
	</tr>
    <tr> 
		<th>Cantidad</th>
        <th>Producto</th>
        
		<th>Precio</th>
		<th>Sub-total</th>
    </tr>
 </thead>
  <tbody>
    <?php 

		foreach($Traer_Cotizacion as $Items_Encontrado):
		
	?>  
		<tr>
			<td class="alinear_derecha"><?php echo $Items_Encontrado->cantidad; ?></td>
			<td><?php echo $Items_Encontrado->nombre; ?></td>
			
			<td class="alinear_derecha"><?php echo $Items_Encontrado->precio_venta; ?></td>
			<td class="alinear_derecha"><?php echo $Items_Encontrado->subtotal; ?></td>
		</tr>
	<?php 
		endforeach;
	?>
		<tr>
			<td colspan="3" class="alinear_derecha"><b>Total $</b></td>
			<td class="alinear_derecha"><b><?php  echo $Traer_Cotizacion[0]->costo;?></b></td>
		</tr>
 </tbody>
</table>
