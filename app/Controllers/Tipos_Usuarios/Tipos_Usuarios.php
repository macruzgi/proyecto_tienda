<?php

namespace App\Controllers\Tipos_Usuarios;
use App\Controllers\BaseController;
class Tipos_Usuarios extends BaseController
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
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(22, 'tiene_permiso');//Tipos de usuarios
       
		$tabla = "adm_tipos_usuario ut ";
		$columnas = "ut.id_tipo_usuario , ut.tipousu_nombre, if(ut.tipousu_estado = 1, 'ACTIVO', 'INACTIVO') as ESTADO, DATE_FORMAT(ut.tipousu_fecha_creacion  , '%d-%m-%Y') as fecha_creacion";
		
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas);
		
		$mostrar["contenido"] = "usuarios/tipos_de_usuario/vista_administrar_tipos_de_usuarios";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Agregar_Tipo_Usuario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(22, 'agregar');///Tipos de Usuarios
		
		$mostrar["contenido"] = "usuarios/tipos_de_usuario/vista_agregar_tipo_usuario";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Agregar_Tipo_Usuario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(22, 'agregar');///Tipos de Usuarios
		
		$rules = array(
			"tipousu_nombre" => array(
				"label" => "Tipo de usuario",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es reqerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			)
		);

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$tipousu_nombre 	   	= $this->request->getPost("tipousu_nombre");
		
		$adm_tipos_usuario = array(
			"tipousu_nombre"=>$tipousu_nombre,
			"codigousuario"=>session("codigousuario")
		);
		$Agregar = $this->Model_Insert->Insert_Data("adm_tipos_usuario", $adm_tipos_usuario);
		//print_r($Agregar_Usuario);return;
		if(!$Agregar){
			//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje, y clase css y le puedo en vier un tercer parametro como array
			$respuesta = get_respuesta(0, 'No se ha podido guardar el registro', 'alert alert-danger alert-dismissible');
			return json_encode($respuesta);
		}
		//hubo exito
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje, y clase css y le puedo en vier un tercer parametro como array
		$respuesta = get_respuesta(1, "Dato almacenado", "alert alert-success alert-dismissible ");
		return json_encode($respuesta);
	}
	public function Vista_Editar_Tipo_Usuario($id_tipo_usuario){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(22, 'actualizar');///Tipos de Usuarios
		
		//compruebo que el registro existe
		$adm_tipos_usuario ="adm_tipos_usuario";
		$columnas_adm_tipos_usuario ="count(id_tipo_usuario) as CUENTA";
		$where_adm_tipos_usuario= array(
			"id_tipo_usuario"=>$id_tipo_usuario
		);
		$resultado = $this->Model_Select->Select_Data($adm_tipos_usuario, $columnas_adm_tipos_usuario, $where_adm_tipos_usuario);
		//print_r($resultado); return;
		//$resultado = $resultado->getResult();
		//echo $resultado[0]->CUENTA; return;
		if($resultado[0]->CUENTA == 0){
		    //funcion definida en BaseController
			$this->Errores_No_Existe_Registro();
		}
		$where = array('id_tipo_usuario' => $id_tipo_usuario); 
		
		$mostrar["Traer_Tipo_Usuario_Por_ID"] = $this->Model_Select->Select_Data("adm_tipos_usuario", "id_tipo_usuario, tipousu_nombre", $where);
		$mostrar["contenido"] = "usuarios/tipos_de_usuario/vista_agregar_tipo_usuario";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Modificar_Tipo_Usuario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(22, 'actualizar');///Tipos de Usuarios
		$rules = array(
			"tipousu_nombre" => array(
				"label" => "Tipo de usuario",
				"rules" => "required|min_length[6]|max_length[25]",
				"errors" => array(
					"required" => "El {field} es reqerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					"max_length"=>"El máximo de  caracteres para el {field} es de {param}"
				)
			),
			"id_tipo_usuario"=>array(
				"label" => "ID",
				"rules" => "required|integer",
				"errors" => array(
					"required" => "El {field} es reqerido",
					"integer"=>"El {field} debe ser numérico"
				)
			)
		);

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$tipousu_nombre 	   	= $this->request->getPost("tipousu_nombre");
		$id_tipo_usuario 	   	= $this->request->getPost("id_tipo_usuario");
		
		$datos = array(
			"tipousu_nombre"=>$tipousu_nombre
		);
		$where = array(
			"id_tipo_usuario"=>$id_tipo_usuario
		);
		$Update = $this->Model_Update->Update_Data("adm_tipos_usuario", $datos, $where);
		//print_r($Agregar_Usuario);return;
		if(!$Update){
			//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje, y clase css y le puedo en vier un tercer parametro como array
			$respuesta = get_respuesta(0, 'No se ha podido guardar el registro', 'alert alert-danger alert-dismissible');
			return json_encode($respuesta);
		}
		//hubo exito
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje, y clase css y le puedo en vier un tercer parametro como array
		$respuesta = get_respuesta(1, "Dato almacenado", "alert alert-success alert-dismissible ");
		return json_encode($respuesta);
	}
}
