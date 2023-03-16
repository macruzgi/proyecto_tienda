<?php
namespace App\Models\Cotizaciones;
use CodeIgniter\Model;//para poder usar la librería Models
class Cotizaciones_Model extends Model{
	
	public function Actualizar_Cotizacion($cotizacion, $id_cotizacion){
		
		//inicio transaccion
		$this->db->transBegin();
		//actualizo en la tabla cotizacion
		$resultado =$this->db->table('cotizacion');
		$resultado->where('id_cotizacion', $id_cotizacion);
		$resultado->update($cotizacion);
		
		//elimino los detalles de la cotizacion
		$this->db->query('delete from cotizacion_detalle where id_cotizacion =?', $id_cotizacion);
		
		
		//inserto en la tabla cotizacion_detalle
		foreach(session('carrito') as $Producto_En_El_Carrito){
				$cotizacion_detalle =array(
				'cantidad'=>$Producto_En_El_Carrito['cantidad'],
				'precio_venta'=>$Producto_En_El_Carrito['precio'],
				'subtotal'=>$Producto_En_El_Carrito['subtotal'],
				'id_cotizacion'=>$id_cotizacion,
				'codigoproducto'=> $Producto_En_El_Carrito['codigoproducto']
				);
				$resultado =$this->db->table('cotizacion_detalle');
				$resultado->insert($cotizacion_detalle);
			}
		
		
		//se comprueba el estado de la transaccion
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			return false;
		} else {
			$this->db->transCommit();
			return $id_cotizacion;
		}
		
		
	}
    public function Insertar_Cotizacion($cotizacion){
	
		//inicio transaccion
		$this->db->transBegin();
		//inserto en la tabla cotizacion
		$resultado =$this->db->table('cotizacion');
		$resultado->insert($cotizacion);
		//traigo el ultimo id_cotizacion
		$id_cotizacion = $this->db->insertId();
		
		//inserto en la tabla cotizacion_detalle
		foreach(session('carrito') as $Producto_En_El_Carrito){
				$cotizacion_detalle =array(
				'cantidad'=>$Producto_En_El_Carrito['cantidad'],
				'precio_venta'=>$Producto_En_El_Carrito['precio'],
				'id_cotizacion'=>$id_cotizacion,
				'subtotal'=>$Producto_En_El_Carrito['subtotal'],
				'codigoproducto'=> $Producto_En_El_Carrito['codigoproducto']
				);
				$resultado =$this->db->table('cotizacion_detalle');
				$resultado->insert($cotizacion_detalle);
			}
		
		
		//se comprueba el estado de la transaccion
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			return false;
		} else {
			$this->db->transCommit();
			return $id_cotizacion;
		}
		
		
	}
}
?>