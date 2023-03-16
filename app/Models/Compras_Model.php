<?php
namespace App\Models;
use CodeIgniter\Model;//para poder usar la librería Models
class Compras_Model extends Model{
	
	public function Agregar_Compra($com_compras, $codigos, $precios, $cantidades, $subtotales, $fecha_creacion){
	
		//inicio transaccion
		$this->db->transBegin();
		//inserto en la tabla com_compras
		$resultado =$this->db->table('com_compras');
		$resultado->insert($com_compras);
		//traigo el ultimo codigousuario insertado
		$id_compra = $this->db->insertId();
		
		// Obtener la cantidad de productos en el carrito de compra para insertar en la tabla com_compras_detalle
		$cantidad_productos = count($codigos);
		// Recorrer los arrays y procesar los valores
		for ($i = 0; $i < $cantidad_productos; $i++) {
			$codigo 	= $codigos[$i];
			$precio 	= $precios[$i];
			$cantidad 	= $cantidades[$i];
			$subtotal 	= $subtotales[$i];
			$detalle_compra[] = array(
				'codigoproducto'=>$codigo,
				'det_cantidad'=>$cantidad,
				'det_precio'=>$precio,
				'det_sub_total'=>$subtotal,
				'id_compra'=>$id_compra
			);
			
		}
		foreach($detalle_compra as $valor){
				$com_compras_detalle =array(
				'codigoproducto'=>$valor['codigoproducto'],
				'det_cantidad'=>$valor['det_cantidad'],
				'det_precio'=>$valor['det_precio'],
				'det_sub_total'=>$valor['det_sub_total'],
				'id_compra'=>$id_compra
				);
				$resultado =$this->db->table('com_compras_detalle');
				$resultado->insert($com_compras_detalle);
			}
		
		
		//inv_kardex
		// consulta SQL para obtener el saldo anterior de cada producto del aray detalle_compra
		foreach($detalle_compra as $valor){
			$resultado = $this->db->query("SELECT kar_saldo FROM inv_kardex WHERE codigoproducto = ? ORDER BY kar_fecha_creacion DESC LIMIT 1", $valor['codigoproducto']);
			if($resultado->getNumRows() > 0){	
				 $row = $resultado->getRow();
				 $saldo_anterior = $row->kar_saldo;
			}
			else{
				// si no se encontró ningún registro, el saldo anterior es cero
				$saldo_anterior = 0;
			}
			// calcular el saldo actual
			$saldo_actual = $saldo_anterior + $valor['det_cantidad'];
			// consulta SQL para insertar la transacción en la tabla de inv_kardex
			$inv_kardex = array(
				'kar_fecha_creacion'=> $fecha_creacion,
				'kar_tipo_transaccion'=> 1,//compra
				'kar_numero_documento'=> $com_compras['com_numero_documednto'],
				'id_compra'=> $id_compra,
				'kar_cantidad'=>$valor['det_cantidad'],
				'kar_saldo'=> $saldo_actual,
				'codigoproducto'=>$valor['codigoproducto']
			);
			$resultado =$this->db->table('inv_kardex');
			$resultado->insert($inv_kardex);
		}

		//se comprueba el estado de la transaccion
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			return false;
		} else {
			$this->db->transCommit();
			return true;
		}
		
	}	
}
?>