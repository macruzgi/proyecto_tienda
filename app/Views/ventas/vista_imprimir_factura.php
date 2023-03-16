<style>
.tabla {
border-collapse: collapse;
    border: 0px solid;
    /*width: 94%;*/
	font-family: Lucida Console;
	font-size:11px;
}
.tabla td{
	border: 0px solid;
	 /* Alto de las celdas */
  height: 22px;
}
.tabla th{
	border: 0px solid;
}
.alinear_derecha{
	text-align:right;
}
h2 {
	font-family: Lucida Console;
}
#div_factura{
	/*margin-top: 120px;
    margin-right: 34px;*/
    /*margin-left: 20px;*/
	margin-top: 2px;
	position: absolute;
}
#div_total{
	
	margin-left: 438px;
    margin-top: 110px;
	font-family: Lucida Console;
	font-size:11px;
	position: absolute;
}

#div_generales{
	
	margin-left: 43px;
	margin-top: 160px;
	font-family: Lucida Console;
	font-size:11px;
	
}
#div_cliente{
	margin-left: 98px;
    margin-top: 10px;
	margin-bottom: 110px;
	font-family: Lucida Console;
	font-size:11px;
}
#div_total_en_letras{
	font-family: Lucida Console;
	font-size:11px;
	margin-left: 15px;
    margin-top: 45px;
	position: absolute;
}
#div_sumas{
	font-family: Lucida Console;
	font-size:11px;
	margin-top: 6px;
    margin-left: 438px;
	position: absolute;
}
#div_sub_total{
	font-family: Lucida Console;
	font-size:11px;
	margin-top: 53px;
    margin-left: 438px;
	position: absolute;
}
#div_annio{
	margin-left: 275px;
	margin-top: -14px;
	font-family: Lucida Console;
	font-size:11px;
	position:absolute;
}
#div_pie{
	/*margin-left: 20px;*/
	margin-top: 270px;
	position:absolute;
}
.td_cantidad{
	width: 42px;
}
.td_producto{
	width: 325px;
}
.td_precio{
	width: 60px;
	text-align:right;
}
.td_vacia{
	width: 38px;
}
.td_sutototal{
	width: 110px;
	text-align:right;
}
#tbl_pie_detalles{
	border: 0px solid;
    /*height: 119px;*/
	border-collapse: collapse;
    border: 0px solid;
    /*width: 94%;*/
	font-family: Lucida Console;
	font-size:11px;
}
</style>
<script>
setTimeout("print();",1500);
setTimeout("window.location = '<?php echo base_url();?>/Ventas/Bandeja_Facturas'",3000);
</script>
<div id="div_generales">
<?php 
//convierto el mes en nombre
$Mes_en_Nombre= $Extras->Convertir_Mes_en_Nombre_Espaniol(date("n", strtotime($Traer_Factura_Para_Imprimir[0]->fac_fecha_creacion)));
//total en letras
$Total_En_Letras = $Numero_A_Letras->convertir($Traer_Factura_Para_Imprimir[0]->fac_total);			

/*
	Limitar / Cortar una cadena en PHP y agregarle
	puntos suspensivos si es necesario
	@author parzibyte
*/
function limitar_cadena($cadena, $limite, $sufijo){
	// Si la longitud es mayor que el límite...
	if(strlen($cadena) > $limite){
		// Entonces corta la cadena y ponle el sufijo
		return substr($cadena, 0, $limite) . $sufijo;
	}
	
	// Si no, entonces devuelve la cadena normal
	return $cadena;
}


echo date("d", strtotime($Traer_Factura_Para_Imprimir[0]->fac_fecha_creacion))."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Mes_en_Nombre;
?>


</div>
<div id="div_annio">
<?php echo "&nbsp;&nbsp;&nbsp;".date("y", strtotime($Traer_Factura_Para_Imprimir[0]->fac_fecha_creacion));
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>
</div>
<div id="div_cliente">
<?php echo $Traer_Factura_Para_Imprimir[0]->fac_nombre_cliente;?>
</div>


<div id="div_factura">
<table id="tbl_productos" class ="tabla">
 
  <tbody>
    <?php 

	$numero_de_renglones_a_imprimir_en_blanco = $Numero_Renglones_Factura - count($Traer_Factura_Para_Imprimir);
		foreach($Traer_Factura_Para_Imprimir as $item):
	?>  
		<tr>
			<td class="td_cantidad"><?php echo $item->facde_cantidad; ?></td>
			<td class="td_producto"><?php echo $item->nombre;//limitar_cadena($item->nombre, 20, "..."); ?></td>
			<td class="td_precio"><?php echo $item->facde_precio_venta; ?></td>
			<td class="td_vacia"></td>
			<td  class="td_vacia"></td>
			<td  class="td_sutototal"><?php echo $item->facde_subtotal; ?></td>
		</tr>

	<?php 
		endforeach;
	?>
		<?php

for($i = 1; $i<= $numero_de_renglones_a_imprimir_en_blanco; $i ++){
?>
<tr>
<td></td>
</tr>
<?php
}
			?>	
 </tbody>
</table>

</div>
<div id="div_pie">
<table  id="tbl_pie_detalles">
	<tr>
		<td style="width: 937px;"><?php
	//esta es variable definiada en el array $data del controlador en la vista Imprimir_Factura con wordwrap se parte la linea
	//echo $Total_En_Letras. " Dólares";
	 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".wordwrap($Total_En_Letras. " Dólares", 30, "<br>" ,TRUE); ?></td>
	 <td  style="width: 110px; text-align:right;"><?php echo $Traer_Factura_Para_Imprimir[0]->fac_total; ?></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 110px; text-align:right;"><?php echo $Traer_Factura_Para_Imprimir[0]->fac_total;?></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td style="width: 110px; text-align:right;"><?php echo $Traer_Factura_Para_Imprimir[0]->fac_total; ?></td>
	</tr>
	
</table>

</div>
<div id="div_total_en_letras">

</div>
<div id="div_sumas">

</div>
<div id="div_sub_total">

</div>
<div id="div_total">

</div>
