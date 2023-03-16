<?php

namespace App\Controllers;

class Clientes extends BaseController
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
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(11, 'tiene_permiso');//Administrar clientes
        //return view('welcome_message');
		$tabla = "fac_cliente";
		$columnas = "id_cliente, cli_codigo, cli_nombre, cli_telefono, cli_direccion";
		$oder_by = "id_cliente desc";
		$mostrar["Traer_Clientes"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		$mostrar["contenido"] = "clientes/vista_administrar_clientes";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Agregar_Cliente(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(11, 'agregar');//Administrar clientes
		 
		 //traigo los departamentos
		 $tablas = "adm_departamento ad";
		 $columnas ="ad.id_departamento , ad.departamento_nombre";
		 $order_by = "ad.id_departamento asc";
		 
		 $mostrar["Departamentos"] =$this->Model_Select->Select_Data($tablas, $columnas, '', $order_by);
		
		$mostrar["contenido"] = "clientes/vista_agregar_clientes";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
		  
	}
	public function Agregar_Cliente(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(11, 'agregar');//Administrar clientes
		$rules = array(
			"cli_codigo" => array(
				"label" => "Código ",
				"rules" => "required|min_length[6]|is_unique[fac_cliente.cli_codigo]",
				"errors" => array(
					"required" => "El {field} es reqerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					'is_unique' => 'El {field} ya existe en la base de datos'
				)
			),
			"cli_nombre" => array(
				"label" => "Nombre",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"cli_razon_social" => array(
				"label" => "Nombre",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
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
		if($this->request->getPost("cli_dui") != ""){
			$rules["cli_dui"] =  array(
				"label" => "DUI",
				"rules" => "min_length[10]|max_length[10]",
				"errors" => array(
					"min_length" => "Se esperan {param} caracteres para el {field}",
					"max_length"=>"Solo se permiten {param} para el {field}."
				)
			);
		}
		if($this->request->getPost("cli_nit") != ""){
			$rules["cli_nit"] =  array(
				"label" => "NIT",
				"rules" => "if_exist|min_length[17]|max_length[17]",
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
		$cli_codigo 	   		= $this->request->getPost("cli_codigo");
		$cli_nombre 			= $this->request->getPost("cli_nombre");
		$cli_direccion 			= $this->request->getPost("cli_direccion");
		$cli_telefono 			= $this->request->getPost("cli_telefono");
		$cli_razon_social 		= $this->request->getPost("cli_razon_social");
		$cli_nombre_comercial 	= $this->request->getPost("cli_nombre_comercial");
		$cli_nrc 				= $this->request->getPost("cli_nrc");
		$cli_dui 				= $this->request->getPost("cli_dui");
		$cli_nit 				= $this->request->getPost("cli_nit");
		$id_municipio 		= $this->request->getPost("id_municipio");
		
		$data = array(
			"cli_codigo"=>$cli_codigo,
			"cli_nombre"=>$cli_nombre,
			"cli_direccion"=>$cli_direccion,
			"cli_telefono"=>$cli_telefono,
			"cli_razon_social"=>$cli_razon_social,
			"cli_nombre_comercial"=>$cli_nombre_comercial,
			"cli_nrc"=>$cli_nrc,
			"cli_dui"=>$cli_dui,
			"cli_nit"=>$cli_nit,
			"id_municipio"=>$id_municipio
		);
		$Agregar = $this->Model_Insert->Insert_Data("fac_cliente", $data);
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
	public function Vista_Editar_Cliente($id_cliente){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(11, 'actualizar');//Administrar clientes
		
		//compruebo que el cliente existe
		$tabla_cliente ="fac_cliente";
		$columnas_cliente ="count(id_cliente) as CUENTA";
		$where = array(
			"id_cliente"=>$id_cliente
		);
		$resultado = $this->Model_Select->Select_Data($tabla_cliente, $columnas_cliente, $where);
		//print_r($resultado); return;
		//$resultado = $resultado->getResult();
		//echo $resultado[0]->CUENTA; return;
		if($resultado[0]->CUENTA == 0){
			$this->Errores_No_Existe_Registro();
		}
		$tablas ="fac_cliente fc 
		inner join adm_municipio am ON (am.id_municipio=fc.id_municipio)
		inner join adm_departamento ad on(ad.id_departamento= am.id_departamento)";
		
		$columnas = "id_cliente, cli_codigo, cli_nombre, cli_direccion, 
		cli_telefono, cli_razon_social, cli_nombre_comercial, 
		cli_dui, cli_nit, cli_nrc,
		am.id_municipio , am.municipio_nombre , 
		ad.id_departamento , ad.departamento_nombre";
		
		$where = array("id_cliente" => $id_cliente); 
		
		$mostrar["Traer_Cliente_por_ID"] = $this->Model_Select->Select_Data($tablas, $columnas, $where);
		
		//traigo los departamentos:
		 //traigo los departamentos
		 $tablas_dep = "adm_departamento ad";
		 $columnas_dep ="ad.id_departamento , ad.departamento_nombre";
		 $order_by_dep = "ad.id_departamento asc";
		 
		 $mostrar["Departamentos"] =$this->Model_Select->Select_Data($tablas_dep, $columnas_dep, '', $order_by_dep);
		
		$mostrar["contenido"] = "clientes/vista_editar_clientes";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Editar_Cliente(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(11, 'actualizar'); //Administrar clientes
		$rules = array(
			"id_cliente" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			),
			"cli_nombre" => array(
				"label" => "Nombre",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"cli_razon_social" => array(
				"label" => "Nombre",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
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
		if($this->request->getPost("cli_dui") != ""){
			$rules["cli_dui"] =  array(
				"label" => "DUI",
				"rules" => "min_length[10]|max_length[10]",
				"errors" => array(
					"min_length" => "Se esperan {param} caracteres para el {field}",
					"max_length"=>"Solo se permiten {param} para el {field}."
				)
			);
		}
		if($this->request->getPost("cli_nit") != ""){
			$rules["cli_nit"] =  array(
				"label" => "NIT",
				"rules" => "if_exist|min_length[17]|max_length[17]",
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
		$id_cliente 	   	= $this->request->getPost("id_cliente");
		$cli_nombre 		= $this->request->getPost("cli_nombre");
		$cli_direccion 		= $this->request->getPost("cli_direccion");
		$cli_telefono 		= $this->request->getPost("cli_telefono");
		
		$cli_razon_social 		= $this->request->getPost("cli_razon_social");
		$cli_nombre_comercial 	= $this->request->getPost("cli_nombre_comercial");
		$cli_nrc 				= $this->request->getPost("cli_nrc");
		$cli_dui 				= $this->request->getPost("cli_dui");
		$cli_nit 				= $this->request->getPost("cli_nit");
		$id_municipio 		= $this->request->getPost("id_municipio");
		
		$data = array(
			"cli_nombre"=>$cli_nombre,
			"cli_direccion"=>$cli_direccion,
			"cli_telefono"=>$cli_telefono,
			"cli_razon_social"=>$cli_razon_social,
			"cli_nombre_comercial"=>$cli_nombre_comercial,
			"cli_nrc"=>$cli_nrc,
			"cli_dui"=>$cli_dui,
			"cli_nit"=>$cli_nit,
			"id_municipio"=>$id_municipio
		);
		
		$where = array(
		'id_cliente' => $id_cliente
		);

		$Actualizar = $this->Model_Update->Update_Data('fac_cliente', $data, $where);
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
