<?php

namespace App\Controllers;

class Facturacion extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Update = model("Model_Update");
		$this->Model_Delete = model("Model_Delete");
		
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'tiene_permiso');
        //return view('welcome_message');
		$tabla = "cotizacion c";
		$columnas = "c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, c.nombre_cliente,
		c.costo, c.terminos_condiciones, DATE_FORMAT(c.fecha_ultima_modificacion, '%d-%m-%Y %H:%i:%s') 
		as fecha_ultima_modificacion, if(c.estado = 1, 'PROCESADA', 'PENDIETNE') as ESTADO";
		$oder_by = "id_cotizacion desc";
		$mostrar["Traer_Cotizaciones"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		$mostrar["contenido"] = "cotizaciones/vista_administrar_cotizaciones";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Re_Imprimir_Cotizacion($id_cotizacion){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'tiene_permiso');
		  
         $tabla = "cotizacion c 
				inner join cotizacion_detalle cd ON (cd.id_cotizacion = c.id_cotizacion)
				inner join abastecimiento a on(a.codigoabastecimiento = cd.codigoabastecimiento)
				inner join productos p on(p.codigoproducto = a.codigoproducto)";
		$columnas = "c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, DATE_FORMAT(c.fecha_ultima_modificacion, '%d-%m-%Y %H:%i:%s') as fecha_ultima_modificacion,  c.nombre_cliente,
			c.terminos_condiciones, c.costo,
			cd.id_detalle , cd.cantidad , cd.precio_venta , cd.subtotal, cd.codigoabastecimiento ,
			a.codigoproducto , a.precioventa, p.nombre , p.descripcion , p.tipo";
		$where = array(
			"c.id_cotizacion"=>$id_cotizacion
		);
		$oder_by = "cd.id_detalle asc";
		$mostrar["Traer_Cotizacion"] = $this->Model_Select->Select_Data($tabla, $columnas, $where, $oder_by); 
		
		return view("cotizaciones/re_imprimir_cotizacion", $mostrar);
		  
	}
	public function Eliminar_Cotizacion(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'eliminar'); //Cotizaciones
		$rules = array(
			"id_cotizacion" => array(
				"label" => "ID de la cotización",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			)
		);

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$id_cotizacion 	   	= $this->request->getPost("id_cotizacion");
				
		
		$where = array(
		'id_cotizacion' => $id_cotizacion
		);

		$Eliminar_Cotizacion = $this->Model_Delete->Delete_Data('cotizacion', $where);
		
		if(!$Eliminar_Cotizacion){
			$respuesta = array(
				"respuesta" => 0,
				"mensaje" => "No se ha podido guardar el registro",
				"clase_css" => "alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
		//hubo exito
		$respuesta = array(
				"respuesta" => 1,
				"mensaje" => "Dato almacenado",
				"clase_css" => "alert alert-success alert-dismissible "
			);
		return json_encode($respuesta);
	}	
}
