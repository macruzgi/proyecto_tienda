<?php

namespace App\Controllers\Precios;
use App\Controllers\BaseController;
class Precios extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Insert = model("Model_Insert");
		$this->Model_Update = model("Model_Update");
		$this->Model_Delete = model("Model_Delete");
		
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(13, 'tiene_permiso');//Precios
        //return view('welcome_message');
		$tabla = "productos p 
		inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad )
		inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto )";
		$columnas = "p.codigoproducto , p.nombre , p.descripcion,
		DATE_FORMAT(p.prod_fecha_creacion, '%d-%m-%Y') as prod_fecha_creacion,
		ptu.tipo_unidad_nombre , pt.tipo_nombre";
		$oder_by = "codigoproducto desc";
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		$mostrar["contenido"] = "precios/vista_administrar_precios";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Traer_Dato_Producto_Para_Precio(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(13, 'agregar');//Precios
		$rules = array(
			"codigoproducto" => array(
				"label" => "Código",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			)
		);

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$codigoproducto 	   	= $this->request->getPost("codigoproducto");
		
		$tabla = 'inv_kardex ik 
		inner join com_compras cc on(cc.id_compra = ik.id_compra)
		inner join com_compras_detalle ccd on(ccd.id_compra = cc.id_compra and ik.codigoproducto = ccd.codigoproducto)
		inner join productos p on(p.codigoproducto = ik.codigoproducto)';
		$columnas = "DATE_FORMAT(ik.kar_fecha_creacion, '%d-%m-%Y') as kar_fecha_creacion , ik.kar_tipo_transaccion,
		ccd.det_cantidad , ccd.det_precio, concat(p.nombre , ' (', p.descripcion , ')') as PRODUCTO";
		$where = array('ik.codigoproducto ' => $codigoproducto); 
				
		$oder_by = "ik.kar_fecha_creacion desc"; 
		$limit = 5;
		
		$Traer_Datos = $this->Model_Select->Select_Data($tabla, $columnas, $where, $oder_by, $limit);
		
		
		
		$tabla_prod_precios = 'prod_precios pp 
		inner join productos p on(p.codigoproducto = pp.codigoproducto)';
		$columnas_prod_precios = "DATE_FORMAT(pp.pre_fecha_creacion , '%d-%m-%Y') as pre_fecha_creacion , 
		pp.pre_precio , concat(p.nombre , ' (', p.descripcion , ')') as PRODUCTO";
		$where_prod_precios = array('pp.codigoproducto ' => $codigoproducto); 
				
		$oder_by_prod_precios = "pp.id_precio desc"; 
		$limit_prod_precios = 5;
		
		$Traer_Datos_Precios = $this->Model_Select->Select_Data($tabla_prod_precios, $columnas_prod_precios, $where_prod_precios, $oder_by_prod_precios, $limit_prod_precios);
		if(!$Traer_Datos && !$Traer_Datos_Precios){
			$respuesta = array(
				"respuesta" => 0,
				"mensaje" => "Pueda que no haya datos de compras o precios",
				"clase_css" => "alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
		
		//hubo exito
		$respuesta = array(
				"respuesta" => 1,
				"mensaje" => "Resultados cargados",
				"clase_css" => "alert alert-success alert-dismissible ",
				"traer_datos"=>$Traer_Datos,
				"prod_precios"=>$Traer_Datos_Precios
			);
		return json_encode($respuesta);
		//return json_encode($Traer_Datos);
	}
	public function Agregar_Precio(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(13, 'agregar');//Precios
		$rules = array(
			"codigoproducto" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} del producto es reqerido"
				)
			),
			"nombre_producto" => array(
				"label" => "Nombre producto",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"pre_precio" => array(
				"label" => "Precio",
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
		$codigoproducto 	   	= $this->request->getPost("codigoproducto");
		$pre_precio 			= $this->request->getPost("pre_precio");
		$pre_fecha_creacion 	= date("Y-m-d H:i:s");
		
		$data = array(
			"codigoproducto"=>$codigoproducto,
			"pre_precio"=>$pre_precio,
			"pre_fecha_creacion"=>$pre_fecha_creacion
		);
		$Agregar = $this->Model_Insert->Insert_Data("prod_precios", $data);
		//print_r($Agregar_Usuario);return;
		if(!$Agregar){
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
