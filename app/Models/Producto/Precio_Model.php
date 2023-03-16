<?php
namespace App\Models\Producto;
use CodeIgniter\Model;//para poder usar la librería Models
class Precio_Model extends Model{
	
	public function Trear_Existencia_Producto($codigoproducto){
		$resultado = $this->db->query("SELECT 
		  p.codigoproducto, 
		  p.prod_codigo, 
		  p.nombre, 
		  p.descripcion, 
		  pt.tipo_nombre,
		  coalesce((SELECT kar_saldo FROM inv_kardex  
		  WHERE codigoproducto = p.codigoproducto ORDER BY kar_fecha_creacion DESC LIMIT 1) ,0) AS existencia, 
			coalesce((select pre_precio FROM prod_precios 
			WHERE codigoproducto = p.codigoproducto ORDER BY pre_fecha_creacion DESC LIMIT 1), 0) as precio
		FROM 
		  productos p 
		  INNER JOIN prod_tipos pt ON (pt.id_tipo_producto = p.id_tipo_producto)  
		WHERE 
		  p.codigoproducto = ?", $codigoproducto
		);
		
		return $resultado->getRow();
		
	}	
}
?>