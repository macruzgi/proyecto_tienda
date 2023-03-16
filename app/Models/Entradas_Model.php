<?php
namespace App\Models;
use CodeIgniter\Model;//para poder usar la librería Models
class Entradas_Model extends Model{
	
	public function Agregar_Entrada($inv_entradas, $codigos, $precios, $cantidades, $subtotales, $fecha_creacion){

		//inicio transaccion
		$this->db->transBegin();
		//inserto en la tabla inv_entradas
		$resultado =$this->db->table('inv_entradas');
		$resultado->insert($inv_entradas);
		//traigo el ultimo codigousuario insertado
		$id_entrada = $this->db->insertId();
		
		// Obtener la cantidad de productos en el carrito de compra para insertar en la tabla inv_entradas_detalle
		$cantidad_productos = count($codigos);
		// Recorrer los arrays y procesar los valores
		for ($i = 0; $i < $cantidad_productos; $i++) {
			$codigo 	= $codigos[$i];
			$precio 	= $precios[$i];
			$cantidad 	= $cantidades[$i];
			$subtotal 	= $subtotales[$i];
			$entrada_detalle[] = array(
				'codigoproducto'=>$codigo,
				'ende_cantidad'=>$cantidad,
				'ende_precio'=>$precio,
				'ende_sub_total'=>$subtotal,
				'id_entrada'=>$id_entrada
				
			);
			
		}
		foreach($entrada_detalle as $valor){
				$inv_entradas_detalle =array(
				'codigoproducto'=>$valor['codigoproducto'],
				'ende_cantidad'=>$valor['ende_cantidad'],
				'ende_precio'=>$valor['ende_precio'],
				'ende_sub_total'=>$valor['ende_sub_total'],
				'id_entrada'=>$id_entrada
				);
				$resultado =$this->db->table('inv_entradas_detalle');
				$resultado->insert($inv_entradas_detalle);
			}
		
		
		//inv_kardex
		// consulta SQL para obtener el saldo anterior
		foreach($entrada_detalle as $valor){
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
			$saldo_actual = $saldo_anterior + $valor['ende_cantidad'];
			// consulta SQL para insertar la transacción en la tabla de inv_kardex
			$inv_kardex = array(
				'kar_fecha_creacion'=> $fecha_creacion,
				'kar_tipo_transaccion'=> 3,//entradas al inventario
				'kar_numero_documento'=> $inv_entradas['en_numero_documento'],
				'id_entrada'=> $id_entrada,
				'kar_cantidad'=>$valor['ende_cantidad'],
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