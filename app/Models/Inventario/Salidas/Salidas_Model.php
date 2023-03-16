<?php
namespace App\Models\Inventario\Salidas;
use CodeIgniter\Model;//para poder usar la librería Models
class Salidas_Model extends Model{
	
	public function Agregar_Salida($inv_salidas, $codigos, $precios, $cantidades, $subtotales, $fecha_creacion){

		//inicio transaccion
		$this->db->transBegin();
		//inserto en la tabla inv_salidas
		$resultado =$this->db->table('inv_salidas');
		$resultado->insert($inv_salidas);
		//traigo el ultimo id insertado
		$id_salida = $this->db->insertId();
		
		// Obtener la cantidad de productos en el carrito de entradas y arma un array para insertar en la tabla inv_salidas_detalle
		$cantidad_productos = count($codigos);
		// Recorrer los arrays y procesar los valores
		for ($i = 0; $i < $cantidad_productos; $i++) {
			$codigo 	= $codigos[$i];
			$precio 	= $precios[$i];
			$cantidad 	= $cantidades[$i];
			$subtotal 	= $subtotales[$i];
			$salida_detalle[] = array(
				'codigoproducto'=>$codigo,
				'salde_cantidad'=>$cantidad,
				'salde_precio'=>$precio,
				'salde_sub_total'=>$subtotal,
				'id_salida'=>$id_salida
				
			);
			
		}
		//recorro el array salida_detalle para insertar cada fila de los productos con sus cantidades, precios y subtotales respectivos
		foreach($salida_detalle as $valor){
				$inv_salidas_detalle =array(
				'codigoproducto'=>$valor['codigoproducto'],
				'salde_cantidad'=>$valor['salde_cantidad'],
				'salde_precio'=>$valor['salde_precio'],
				'salde_sub_total'=>$valor['salde_sub_total'],
				'id_salida'=>$id_salida
				);
				$resultado =$this->db->table('inv_salidas_detalle');
				$resultado->insert($inv_salidas_detalle);
			}
		
		
		//recorro los detalles de la salida y los agrego al array inv_kardex para luego insertar cada fila en la tabal kardex
		foreach($salida_detalle as $valor){
			// consulta SQL para obtener el saldo anterior de cada producto iterado
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
			$saldo_actual = $saldo_anterior - $valor['salde_cantidad'];
			// consulta SQL para insertar la transacción en la tabla de inv_kardex
			$inv_kardex = array(
				'kar_fecha_creacion'=> $fecha_creacion,
				'kar_tipo_transaccion'=> 4,//salidas al inventario
				'kar_numero_documento'=> $inv_salidas['sa_numero_documento'],
				'id_salida'=> $id_salida,
				'kar_cantidad'=>$valor['salde_cantidad'],
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