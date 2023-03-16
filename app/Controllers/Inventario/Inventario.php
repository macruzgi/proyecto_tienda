<?php

namespace App\Controllers\Inventario;
use App\Controllers\BaseController;
class Inventario extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Insert = model("Model_Insert");
		$this->Model_Update = model("Model_Update");
		$this->Model_Delete = model("Model_Delete");
		$this->Entradas_Model = model("Entradas_Model");
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(4, 'tiene_permiso');//Entradas al inventario
        //return view('welcome_message');
		$tabla = "inv_entradas ie 
			inner join usuarios u on(u.codigousuario = ie.codigousuario)";
		$columnas = "ie.id_entrada , ie.en_numero_documento , 
		ie.en_comentario, DATE_FORMAT(ie.en_fecha_creacion , '%d-%m-%Y') as en_fecha_creacion ,
		ie.en_total , u.nombreusuario , u.nombre ";
		
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas);
		
		$mostrar["contenido"] = "inventario/entradas_al_inventario/vista_administrar_entradas_del_inventario";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Agregar_Entrada_Al_Inventario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(4, 'agregar');//Entradas al inventario
		$tabla = "prod_tipo_unidad";
		$columnas = "id_tipo_unidad , tipo_unidad_nombre";
		$oder_by = "tipo_unidad_nombre asc"; 
		$mostrar["Unidad_Medida"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by);
		
		$tabla = "prod_tipos";
		$columnas = "id_tipo_producto , tipo_nombre";
		$oder_by = "tipo_nombre asc"; 
		$mostrar["Categorias"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by);
		
		$mostrar["contenido"] = "inventario/entradas_al_inventario/vista_agregar_entradas_al_inventario";//contenido tendra la vista
		return view("plantilla", $mostrar);
		  
	}
	public function Procesar_Entrada(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(4, 'agregar');//Entradas al inventario
		
		$rules = array(
			"en_numero_documento" => array(
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
				"label" => "Subtotales",
				"rules" => "required",
				"errors" => array(
					"required" => "Debe haber almenos un {field}."
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
		$en_numero_documento 	= $this->request->getPost("en_numero_documento");
		$en_comentario 			= $this->request->getPost("en_comentario");
		$subtotales 			= $this->request->getPost("subtotal");
		$TOTAL 					= $this->request->getPost("TOTAL");
		$fecha_creacion 		= date('Y-m-d H:i:s'); // fecha actual
		
		$inv_entradas = array(
			'en_numero_documento'=> $en_numero_documento,
			'en_comentario'=>$en_comentario,
			'en_total'=>$TOTAL,
			'en_fecha_creacion'=>$fecha_creacion,
			'codigousuario'=>session('codigousuario')
		);
		  
		$Agregar_Entrada = $this->Entradas_Model->Agregar_Entrada($inv_entradas, $codigos, $precios, $cantidades, $subtotales, $fecha_creacion);
		//print_r($Agregar_Entrada);
		if(!$Agregar_Entrada){
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
	public function Traer_Detalle_Entrada_Inventario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(4, 'tiene_permiso');//Entradas al inventario
		
		$id_entrada 		= $this->request->getPost("id_entrada");
		$tablas = "inv_entradas_detalle ied 
		inner join inv_entradas ie on(ie.id_entrada = ied.id_entrada)
		inner join productos p on(p.codigoproducto = ied.codigoproducto)";
		
		$columnas = "ied.id_entrada_detalle , ied.codigoproducto , ied.ende_cantidad , ied.ende_precio , 
		ied.ende_sub_total , 
		ie.en_numero_documento , DATE_FORMAT(ie.en_fecha_creacion , '%d-%m-%Y') as en_fecha_creacion  , ie.en_total ,
		p.nombre , p.descripcion";
		
		$where = array(
			"ied.id_entrada"=>$id_entrada
		);
		$oder_by = "ied.id_entrada_detalle asc";
		
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tablas, $columnas, $where, $oder_by); 
		return view("inventario/entradas_al_inventario/vista_resultado_independiente_detalle_entrada_al_inventario", $mostrar);

	}
}
