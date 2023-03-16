<?php

namespace App\Controllers;

class Proveedores extends BaseController
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
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(12, 'tiene_permiso');//Administrar proveedores
        //return view('welcome_message');
		$tabla = "com_proveedor";
		$columnas = "id_proveedor, pro_codigo, pro_razon_social, pro_nombre_comercial,
		pro_nrc, pro_nit, pro_dui, pro_direccion, pro_telefono, pro_estado, pro_fecha_alta";
		$oder_by = "id_proveedor desc";
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		$mostrar["contenido"] = "proveedores/vista_administrar_proveedores";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Agregar_Proveedor(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(12, 'agregar');//Administrar proveedores
		 
		  //traigo los departamentos
		 $tablas = "adm_departamento ad";
		 $columnas ="ad.id_departamento , ad.departamento_nombre";
		 $order_by = "ad.id_departamento asc";
		 
		 $mostrar["Departamentos"] =$this->Model_Select->Select_Data($tablas, $columnas, '', $order_by);
		$mostrar["contenido"] = "proveedores/vista_agregar_proveedores";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
		  
	}
	public function Agregar_Proveedor(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(12, 'agregar');//Administrar proveedores 
		$rules = array(
			"pro_codigo" => array(
				"label" => "Código ",
				"rules" => "required|min_length[6]|is_unique[com_proveedor.pro_codigo]",
				"errors" => array(
					"required" => "El {field} es reqerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					'is_unique' => 'El {field} ya existe en la base de datos'
				)
			),
			"pro_razon_social" => array(
				"label" => "Razón Social",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"pro_nombre_comercial" => array(
				"label" => "Nombre Comercial",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"pro_nrc" => array(
				"label" => "NRC",
				"rules" => "required|is_unique[com_proveedor.pro_nrc]",
				"errors" => array(
					"required" => "El {field} es requerido",
					'is_unique' => 'El {field} ya existe en la base de datos'
				)
			),
			"pro_nit" => array(
				"label" => "NIT",
				"rules" => "required|min_length[17]|max_length[17]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					"max_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"id_municipio" => array(
				"label" => "Municipio",
				"rules" => "required|numeric",
				"errors" => array(
					"required" => "El {field} es requerido",
					"numeric"=>"El {field} debe ser numérico"
				)
			)
		);
		if($this->request->getPost("pro_dui") != ""){
			$rules["pro_dui"] =  array(
				"label" => "DUI",
				"rules" => "min_length[10]|max_length[10]",
				"errors" => array(
					"min_length" => "Se esperan {param} caracteres para el {field}",
					"max_length"=>"Solo se permiten {param} para el {field}."
				)
			);
		}
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$pro_codigo 	   		= $this->request->getPost("pro_codigo");
		$pro_razon_social 		= $this->request->getPost("pro_razon_social");
		$pro_nombre_comercial 	= $this->request->getPost("pro_nombre_comercial");
		$pro_nrc 				= $this->request->getPost("pro_nrc");
		$pro_nit 				= $this->request->getPost("pro_nit");
		$pro_dui 				= $this->request->getPost("pro_dui");
		$pro_direccion 			= $this->request->getPost("pro_direccion");
		$pro_telefono 			= $this->request->getPost("pro_telefono");
		$id_municipio			= $this->request->getPost("id_municipio");
		$data = array(
			"pro_codigo"=>str_replace(" ", "" ,$pro_codigo),
			"pro_razon_social"=>$pro_razon_social,
			"pro_nombre_comercial"=>$pro_nombre_comercial,
			"pro_nrc"=>str_replace(" ", "" ,$pro_nrc),
			"pro_nit"=>str_replace(" ", "" ,$pro_nit),
			"pro_dui"=>str_replace(" ", "" ,$pro_dui),
			"pro_direccion"=>$pro_direccion,
			"pro_telefono"=>$pro_telefono,
			"id_municipio"=>$id_municipio
		);
		$Agregar = $this->Model_Insert->Insert_Data("com_proveedor", $data);
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
	public function Vista_Editar_Poveedor($id_proveedor){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(12, 'actualizar');//Administrar proveedores
		
		//compruebo que el proveedor existe
		$tabla_proveedor ="com_proveedor";
		$columnas_proveedor ="count(id_proveedor) as CUENTA";
		$where_proveedor = array(
			"id_proveedor"=>$id_proveedor
		);
		$resultado = $this->Model_Select->Select_Data($tabla_proveedor, $columnas_proveedor, $where_proveedor);
		
		if($resultado[0]->CUENTA == 0){
			$this->Errores_No_Existe_Registro();
		}
		
		 //traigo los departamentos
		 $adm_departamento = "adm_departamento ad";
		 $columnas_depto ="ad.id_departamento , ad.departamento_nombre";
		 $order_by_depto = "ad.id_departamento asc";
		 
		 $mostrar["Departamentos"] =$this->Model_Select->Select_Data($adm_departamento, $columnas_depto, '', $order_by_depto);
		
		$tabla_proveedor ="com_proveedor p
		inner join adm_municipio am on(am.id_municipio = p.id_municipio)
		inner join adm_departamento ad on(ad.id_departamento = am.id_departamento)";
		$columnas_proveedor = "p.id_proveedor, p.pro_codigo, p.pro_razon_social, p.pro_nombre_comercial,
		p.pro_nrc, p.pro_nit, p.pro_dui, p.pro_direccion, p.pro_telefono,
		am.id_municipio , am.municipio_nombre , 
		ad.id_departamento , ad.departamento_nombre";
		
		$where_proveedor = array("p.id_proveedor" => $id_proveedor); 
		
		$mostrar["Traer_Proveedor_por_ID"] = $this->Model_Select->Select_Data($tabla_proveedor, $columnas_proveedor, $where_proveedor);
		
		$mostrar["contenido"] = "proveedores/vista_editar_proveedor";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Editar_Proveedor(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(12, 'actualizar'); //Administrar proveedores
		$rules = array(
			"id_proveedor" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} del proveedor es reqerido"
				)
			),
			"pro_codigo" => array(
				"label" => "Código ",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			),
			"pro_razon_social" => array(
				"label" => "Razón Social",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"pro_nombre_comercial" => array(
				"label" => "Nombre Comercial",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"pro_nrc" => array(
				"label" => "NRC",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"pro_nit" => array(
				"label" => "NIT",
				"rules" => "required|min_length[17]|max_length[17]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					"max_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"id_municipio" => array(
				"label" => "Municipio",
				"rules" => "required|numeric",
				"errors" => array(
					"required" => "El {field} es requerido",
					"numeric"=>"El {field} debe ser numérico"
				)
			)
		);
		if($this->request->getPost("pro_dui") != ""){
			$rules["pro_dui"] =  array(
				"label" => "DUI",
				"rules" => "min_length[10]|max_length[10]",
				"errors" => array(
					"min_length" => "Se esperan {param} caracteres para el {field}",
					"max_length"=>"Solo se permiten {param} para el {field}."
				)
			);
		}

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$id_proveedor 	   		= $this->request->getPost("id_proveedor");
		$pro_codigo 	   		= $this->request->getPost("pro_codigo");
		$pro_razon_social 		= $this->request->getPost("pro_razon_social");
		$pro_nombre_comercial 	= $this->request->getPost("pro_nombre_comercial");
		$pro_nrc 				= $this->request->getPost("pro_nrc");
		$pro_nit 				= $this->request->getPost("pro_nit");
		$pro_dui 				= $this->request->getPost("pro_dui");
		$pro_direccion 			= $this->request->getPost("pro_direccion");
		$pro_telefono 			= $this->request->getPost("pro_telefono");
		$id_municipio 			= $this->request->getPost("id_municipio");
		$data = array(
			"pro_razon_social"=>$pro_razon_social,
			"pro_nombre_comercial"=>$pro_nombre_comercial,
			"pro_nrc"=>str_replace(" ", "" ,$pro_nrc),
			"pro_nit"=>str_replace(" ", "" ,$pro_nit),
			"pro_dui"=>str_replace(" ", "" ,$pro_dui),
			"pro_direccion"=>$pro_direccion,
			"pro_telefono"=>$pro_telefono,
			"id_municipio"=>$id_municipio
		);
		$where = array(
		'id_proveedor' => $id_proveedor
		);

		$Actualizar = $this->Model_Update->Update_Data('com_proveedor', $data, $where);
		//print_r($Agregar_Usuario);return;
		if(!$Actualizar){
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
