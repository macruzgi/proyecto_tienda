<?php

namespace App\Controllers\Compras;
use App\Controllers\BaseController;
class Compras extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Insert = model("Model_Insert");
		$this->Model_Update = model("Model_Update");
		$this->Model_Delete = model("Model_Delete");
		$this->Compras_Model = model("Compras_Model");
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(5, 'tiene_permiso');//Compras
        //return view('welcome_message');
		$tabla = "com_compras cc";
		$columnas = "cc.id_compra , cc.com_razon_social , cc.com_nombre_comercial , cc.com_nrc ,
		cc.com_numero_documednto , cc.com_total , DATE_FORMAT(cc.com_fecha_creacion , '%d-%m-%Y') as com_fecha_creacion";
		//$oder_by = "id_compra desc";
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas); 
		$mostrar["contenido"] = "compras/vista_administrar_compras";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Agregar_Compras(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(5, 'agregar');//Compras
		
		$tabla = "com_proveedor";
		$columnas = "id_proveedor, pro_codigo, pro_razon_social, pro_nombre_comercial,
		pro_nrc, pro_nit, pro_dui, pro_direccion, pro_telefono, pro_estado, pro_fecha_alta";
		$oder_by = "id_proveedor desc";
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		
		$mostrar["contenido"] = "compras/vista_agregar_compras";//contenido tendra la vista
		return view("plantilla", $mostrar);
		  
	}
	public function Traer_Proveedor(){
		$pro_nrc 	   	= $this->request->getPost("pro_nrc");
		$columnas = 'prov.id_proveedor , prov.pro_codigo, prov.pro_razon_social, prov.pro_nombre_comercial ,
		prov.pro_nrc , prov.pro_nit';
		$where = array('pro_nrc' => $pro_nrc); 
		$datos = $this->Model_Select->Select_Data('com_proveedor prov', $columnas, $where);
		
		return json_encode($datos);
	}
	public function Buscar_Producto(){
		
        $buscar_producto 	= $this->request->getPost("buscar_producto");
		
		$columnas = 'p.codigoproducto , p.prod_codigo, p.nombre, p.descripcion';
		/*$where = array(
			'p.nombre like ' => $buscar_producto
		);*/
		$oder_by = "p.nombre";
		$limit = '10';
		$or_where = array(
			'p.descripcion like ' => '%'.$buscar_producto.'%',
			'p.nombre like ' => '%'.$buscar_producto.'%'
		);
		$datos = $this->Model_Select->Select_Data('productos p ', $columnas, '', $oder_by, $limit, $or_where);
		
		return json_encode($datos);
        
	}
	public function Procesar_Compra(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(5, 'agregar');//Compras
		
		$rules = array(
			"id_proveedor" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} del proveedor es reqerido"
				)
			),
			"pro_razon_social" => array(
				"label" => "Razón Social",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"pro_nombre_comercial" => array(
				"label" => "Nombre Comercial",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"pro_nrc_buscar" => array(
				"label" => "NRC",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"pro_nit" => array(
				"label" => "NIT",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
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
		$pro_razon_social 		= $this->request->getPost("pro_razon_social");
		$pro_nombre_comercial 	= $this->request->getPost("pro_nombre_comercial");
		$pro_nrc 				= $this->request->getPost("pro_nrc_buscar");
		$pro_nit 				= $this->request->getPost("pro_nit");
		$id_proveedor 			= $this->request->getPost("id_proveedor");
		$numero_documento 		= $this->request->getPost("numero_documento");
		$subtotales 			= $this->request->getPost("subtotal");
		$TOTAL 					= $this->request->getPost("TOTAL");
		$fecha_creacion 		= date('Y-m-d H:i:s'); 
		
		$com_compras = array(
			'com_razon_social'=> $pro_razon_social,
			'com_nombre_comercial'=> $pro_nombre_comercial,
			'com_nrc'=> $pro_nrc,
			'com_nit'=> $pro_nit,
			'id_proveedor'=> $id_proveedor,
			'com_numero_documednto'=> $numero_documento,
			'com_total'=>$TOTAL,
			'com_fecha_creacion'=>$fecha_creacion
		);
		  
		$Agregar_Compra = $this->Compras_Model->Agregar_Compra($com_compras, $codigos, $precios, $cantidades, $subtotales, $fecha_creacion);
		//print_r($Agregar_Compra);
		if(!$Agregar_Compra){
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
	public function Vista_Resultado_Busqueda_Proveedor(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(5, 'agregar');//Compras
		
		$tabla = "com_proveedor";
		$columnas = "id_proveedor, pro_codigo, pro_razon_social, pro_nombre_comercial,
		pro_nrc, pro_nit, pro_dui, pro_direccion, pro_telefono, pro_estado, pro_fecha_alta";
		$oder_by = "id_proveedor desc";
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		
		//$mostrar["contenido"] = "compras/vista_agregar_compras";//contenido tendra la vista
		return view("compras/vista_resultado_independiente_proveedores", $mostrar);
		  
	}
	public function Taer_Detalle_Compra(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(5, 'tiene_permiso');//Compras
		
		$id_compra 		= $this->request->getPost("id_compra");
		$tablas = "com_compras cc
		inner join com_compras_detalle ccd ON (cc.id_compra=ccd.id_compra)
		inner join productos p on (p.codigoproducto = ccd.codigoproducto)";
		$columnas = "cc.id_compra , cc.com_razon_social , cc.com_nrc , cc.com_total ,
		DATE_FORMAT(cc.com_fecha_creacion, '%d-%m-%Y') as com_fecha_creacion , cc.com_numero_documednto , p.codigoproducto ,p.nombre , p.descripcion ,
		ccd.det_cantidad , ccd.det_precio, ccd.det_sub_total, ccd.id_detalle_compra";
		$where = array(
			"ccd.id_compra"=>$id_compra
		);
		$oder_by = "ccd.id_detalle_compra asc";
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tablas, $columnas, $where, $oder_by); 
		return view("compras/vista_resultado_independiente_detalle_compra", $mostrar);
		  
	}

}
