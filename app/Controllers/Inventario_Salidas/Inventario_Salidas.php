<?php

namespace App\Controllers\Inventario_Salidas;
use App\Controllers\BaseController;
class Inventario_Salidas extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Insert = model("Model_Insert");
		$this->Model_Update = model("Model_Update");
		$this->Model_Delete = model("Model_Delete");
		$this->Salidas_Model = model("Inventario/Salidas/Salidas_Model");
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(14, 'tiene_permiso');//Salidas al inventario
        //return view('welcome_message');
		$tabla = "inv_salidas isal
		inner join usuarios u on(u.codigousuario = isal.codigousuario)";
		$columnas = "isal.id_salida  , isal.sa_numero_documento  , 
		isal.sa_comentario , DATE_FORMAT(isal.sa_fecha_creacion  , '%d-%m-%Y') as sa_fecha_creacion ,
		isal.sa_total  , u.nombreusuario , u.nombre";
		
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas);
		
		$mostrar["contenido"] = "inventario/salidas_al_inventario/vista_administrar_salidas_del_inventario";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Agregar_Salida_Al_Inventario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(14, 'agregar');//Salidas al inventario
				
		$mostrar["contenido"] = "inventario/salidas_al_inventario/vista_agregar_salidas_al_inventario";//contenido tendra la vista
		return view("plantilla", $mostrar);
		  
	}
	public function Procesar_Salida(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(14, 'agregar');//Salidas al inventario
		
		$rules = array(
			"sa_numero_documento" => array(
				"label" => "Número de documento",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			),
			"codigoproducto.*" => array(
				"label" => "Producto",
				"rules" => "required",
				"errors" => array(
					"required" => "Debe haber algún {field}.",
				)
			),
			"precio.*" => array(
				"label" => "Precio",
				"rules" => "required|greater_than[0]",
				"errors" => array(
					"required" => "Debe haber algún {field}.","greater_than" => "El {field} sebe ser mayor a {param}."
				)
			),
			"cantidad.*" => array(
				"label" => "Cantidad",
				"rules" => "required|greater_than[0]",
				"errors" => array(
					"required" => "Debe haber alguna {field}.",
					"greater_than" => "La {field} sebe ser mayor a {param}."
				)
			),
			"subtotal.*" => array(
				"label" => "Subtotal",
				"rules" => "required",
				"errors" => array(
					"required" => "Debe haber algún {field}."
				)
			),
			"TOTAL" => array(
				"label" => "TOTAL",
				"rules" => "required",
				"errors" => array(
					"required" => "EL {field} es requerido"
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		$codigos 				= $this->request->getPost("codigoproducto");
		$precios 				= $this->request->getPost("precio");
		$cantidades				= $this->request->getPost("cantidad");		
		$sa_numero_documento 	= $this->request->getPost("sa_numero_documento");
		$sa_comentario 			= $this->request->getPost("sa_comentario");
		$subtotales 			= $this->request->getPost("subtotal");
		$TOTAL 					= $this->request->getPost("TOTAL");
		$fecha_creacion 		= date('Y-m-d H:i:s'); // fecha actual
		
		$inv_salidas = array(
			'sa_numero_documento'=> $sa_numero_documento,
			'sa_comentario'=>$sa_comentario,
			'sa_total'=>$TOTAL,
			'sa_fecha_creacion'=>$fecha_creacion,
			'codigousuario'=>session('codigousuario')
		);
		  
		$Agregar_Salida = $this->Salidas_Model->Agregar_Salida($inv_salidas, $codigos, $precios, $cantidades, $subtotales, $fecha_creacion);
		//print_r($Agregar_Salida); return;
		if(!$Agregar_Salida){
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
	public function Traer_Detalle_Salida_Inventario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(14, 'tiene_permiso');//Salidas al inventario
		
		$id_salida 		= $this->request->getPost("id_salida");
		
		$tablas = "inv_salidas_detalle isd   
		inner join inv_salidas isa  on(isa.id_salida  = isd.id_salida)
		inner join productos p on(p.codigoproducto = isd.codigoproducto)";
		
		$columnas = "isd.id_salida_detalle  , isd.codigoproducto , isd.salde_cantidad  , isd.salde_precio  , 
		isd.salde_sub_total  , 
		isa.sa_numero_documento  , DATE_FORMAT(isa.sa_fecha_creacion  , '%d-%m-%Y') as sa_fecha_creacion  , 
		isa.sa_total  ,
		p.nombre , p.descripcion";
		
		$where = array(
			"isd.id_salida "=>$id_salida
		);
		$oder_by = "isd.id_salida_detalle  asc";
		
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tablas, $columnas, $where, $oder_by); 
		return view("inventario/salidas_al_inventario/vista_resultado_independiente_detalle_salida_al_inventario", $mostrar);

	}
}
