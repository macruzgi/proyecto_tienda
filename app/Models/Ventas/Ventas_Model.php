<?php
namespace App\Models\Ventas;
use CodeIgniter\Model;//para poder usar la librería Models
class Ventas_Model extends Model{
	
	public function Traer_Valor_Configuracion($id_configuracion){
		$resultado = $this->db->query("select valor_configuracion from ferro_adm_configuraciones where id_configuracion =?", $id_configuracion);
		$fila = $resultado->getRow();
		return $fila->valor_configuracion;
	}
	public function Guardar_Pre_Venta($fac_factura){

		//inicio transaccion
		$this->db->transBegin();
		
		
		//traigo el numero de renglones configurados para la factura
		$renglones = $this->Traer_Valor_Configuracion(1);
		/*
		* separo el array en grupos de renglones, en 
		* este caso es el numero de renglones que 
		* soporta la factura, asi saber si se genera 1,
		*	2, 3... facturas
		*/
		$partes_del_array_en_renglones = array_chunk(session('carrito'), $renglones);
		
		/*
		* cuento el numero de itens en el carrito y lo 
		* divido entre los renglones de la factura
		* que dara como resultado el numero de factruas 
		*  a generar
		*/
		$numero_de_items_en_el_carrito = ceil(count(session('carrito')) / $renglones);
		
		/*
		* for para recorrer las partes de grupo del 
		* array en renglones es decir si da como 
		* resultado $numero_de_items_en_el_carrito = 3
		* significa que se generaran 3 facturas
		* y el for dara 3 vueltas con los valores en 
		* los grupos, los items del carrito
		*/
		
		for($i = 0; $i < $numero_de_items_en_el_carrito; $i++){
			//se inserta cada factura dependiendo del numero de renglones que soporta
			//inserto en la tabla fac_factura
			$resultado =$this->db->table('fac_factura');
			$resultado->insert($fac_factura);
			//traigo el ultimo id_factura
			$id_factura = $this->db->insertId();
			//para actualizar el total para cada factura
			$total = 0;
			foreach ($partes_del_array_en_renglones[$i] as $items){
				$total = $total + $items['subtotal'];
				//Proceso por lotes
				//inserto en la tabla fac_factura_detalle
				$fac_factura_detalle =array(
				'facde_cantidad'=>$items['cantidad'],
				'facde_precio_venta'=>$items['precio'],
				'facde_subtotal'=>$items['subtotal'],
				'id_factura'=>$id_factura,
				'codigoproducto'=> $items['codigoproducto']
				);
				$resultado =$this->db->table('fac_factura_detalle');
				$resultado->insert($fac_factura_detalle);
				
				//actualizo el total final para cada factura
				$update = $this->db->table("fac_factura");
				$update->set("fac_total", $total);
				$update->where("id_factura", $id_factura);
				$update->update();
			}
			 
			
		}
		/*
		//inserto en la tabla fac_factura_detalle
		foreach(session('carrito') as $Producto_En_El_Carrito){
				$fac_factura_detalle =array(
				'facde_cantidad'=>$Producto_En_El_Carrito['cantidad'],
				'facde_precio_venta'=>$Producto_En_El_Carrito['precio'],
				'facde_subtotal'=>$Producto_En_El_Carrito['subtotal'],
				'id_factura'=>$id_factura,
				'codigoproducto'=> $Producto_En_El_Carrito['codigoproducto']
				);
				$resultado =$this->db->table('fac_factura_detalle');
				$resultado->insert($fac_factura_detalle);
			}
		*/
		
		//se comprueba el estado de la transaccion
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			return false;
		} else {
			$this->db->transCommit();
			return true;
		}
	
	}
    public function Guardar_Venta($datos){
	
		//inicio transaccion
		$this->db->transBegin();
		//traigo los datos del detalle de la factura 
		$fac_facturacion_detalle = $this->db->query('select  ff.id_cotizacion, ffd.facde_cantidad, ffd.facde_precio_venta, 
		ffd.facde_subtotal, ffd.id_factura, ffd.codigoproducto
		from fac_factura_detalle ffd 
		inner join  fac_factura ff on(ff.id_factura = ffd.id_factura )
		where ffd.id_factura = ?', $datos['id_factura']); 
				
		//inv_kardex
		// consulta SQL para obtener el saldo anterior de cada producto del aray fac_facturacion_detalle
		foreach($fac_facturacion_detalle->getResult() as $Dato_Encontrado){
			$resultado = $this->db->query('SELECT kar_saldo FROM inv_kardex WHERE codigoproducto = ? ORDER BY kar_fecha_creacion DESC LIMIT 1', $Dato_Encontrado->codigoproducto);
			if($resultado->getNumRows() > 0){	
				 $row = $resultado->getRow();
				 $saldo_anterior = $row->kar_saldo;
			}
			else{
				// si no se encontró ningún registro, el saldo anterior es cero
				$saldo_anterior = 0;
			}
			// calcular el saldo actual
			$saldo_actual = $saldo_anterior - $Dato_Encontrado->facde_cantidad;
			// consulta SQL para insertar la transacción en la tabla de inv_kardex
			$inv_kardex = array(
				'kar_fecha_creacion'=> $datos['fac_fecha_creacion'],
				'kar_tipo_transaccion'=> 2,//venta
				'kar_numero_documento'=>$datos['id_factura'],//por el momento le pongo el id_factura de la facturacion porque no se captura el numero de la factura en el formulario
				'id_venta'=> $datos['id_factura'],
				'kar_cantidad'=>$Dato_Encontrado->facde_cantidad,
				'kar_saldo'=> $saldo_actual,
				'codigoproducto'=>$Dato_Encontrado->codigoproducto
			);
			$resultado =$this->db->table('inv_kardex');
			$resultado->insert($inv_kardex);
		}
		
		//actualizo la tabla fac_factura
		$builder = $this->db->table('fac_factura');
		$builder->set('fac_estado', 1);
		$builder->set('codigocajero', session("codigousuario"));
		$builder->where('id_factura',$datos['id_factura']);
		$builder->update();
		
		//actualizo la tabla cotizaciones si la factura proviede de una cotizacion
		$dato_id_cotizacion = $fac_facturacion_detalle->getResult();
		$this->db->query('UPDATE cotizacion c 
		JOIN fac_factura f 
		ON c.id_cotizacion  = f.id_cotizacion
		SET c.estado  = 1, fecha_procesamiento = now() where c.id_cotizacion = ?', $dato_id_cotizacion[0]->id_cotizacion);
		
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