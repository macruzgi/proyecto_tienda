<?php

namespace App\Controllers;

class Usuarios extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
		$this->Usuario_model = model("Usuario_model");
		$this->Model_Select = model("Model_Select");
		$this->Model_Update = model("Model_Update");
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'tiene_permiso');
        //return view('welcome_message');
		$mostrar["Traer_Ususuarios"] = $this->Usuario_model->Traer_Ususuarios();
		$mostrar["contenido"] = "usuarios/vista_administrar_usuarios";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Asignar_Permisos($codigousuario){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'actualizar');//Usuarios
		$mostrar["Traer_Todos_Los_Permisos"] = $this->Usuario_model->Traer_Todos_Los_Permisos($codigousuario);
		$mostrar["contenido"] = "usuarios/vista_administrar_permisos";
		return view("plantilla", $mostrar);
	}
	public function Asignar_Permisos(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'actualizar');//Usuarios
		//validacion de CodeIgniter
		$this->validacion->setRules([
			"id_usuario"=>[
				"label"=>"Usuario",
				"rules"=>"required",//si hubieren más validaciones se pondrían aquí
				"errors"=>[
					"required"=>"Debe legir algún usuario"
				]
			],
			"id_opcion.*"=>[
				"label"=>"Pocción",
				"rules"=>"required",
				"errors"=>[
					"required"=>"Debe elegir alguna opción"
				]
			]
		]);
		//valido y si no pasa las validaciones, que retorne errores
		if(!$this->validacion->withRequest($this->request)->run()){
			$respuesta = array(
				"respuesta"=>0,
				"mensaje"=>$this->validacion->listErrors(),
				"clase_css"=>"alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
		//si pasa la validación de los campos requeridos
		//busco el user y contraseña en la base de datos
		$id_usuario 	= $this->request->getPost("id_usuario");
		$id_opciones	= $this->request->getPost("id_opcion");
		$agregar		= $this->request->getPost("agregar");
		$actualizar		= $this->request->getPost("actualizar");
		$eliminar		= $this->request->getPost("eliminar");
		$usuario_opciones = array(
			"id_usuario"=>$id_usuario,
			"id_opciones"=>$id_opciones,
			"agregar"=>$agregar,
			"actualizar"=>$actualizar,
			"eliminar"=>$eliminar
		);
		
		/*
		foreach($id_opciones as $value){
			//actualizo cada linea
			echo $value."<br>";
		}
		return;
		*/
		
		//actualizar opciones permitidas al usuario
		$Actualizar_Opciones_Permitidas = $this->Usuario_model->Actualizar_Opciones_Permitidas($usuario_opciones);
		if(!$Actualizar_Opciones_Permitidas){
			$respuesta = array(
				"respuesta"=>0,
				"mensaje"=>"Hubieron errores al generar, solicite ayuda a un administrador.",
				"clase_css"=>"alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
		//hubo exito
		$respuesta = array(
				"respuesta"=>1,
				"mensaje"=>"Permisos actualizados.",
				"clase_css"=>"alert alert-success alert-dismissible "
			);
		return json_encode($respuesta);
	}
	public function Vista_Agregar_Usuario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'agregar');///Usuarios
		
		$mostrar["Traer_Tipos_De_Usuarios"] = $this->Model_Select->Select_Data("adm_tipos_usuario", "id_tipo_usuario, tipousu_nombre");
		
		$mostrar["contenido"] = "usuarios/vista_agregar_usuarios";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Agregar_Usuario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'agregar'); //Usuarios
		$rules = array(
			"usuario" => array(
				"label" => "Usuario",
				"rules" => "required|min_length[6]|is_unique[usuarios.nombreusuario]",
				"errors" => array(
					"required" => "El {field} es reqerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					'is_unique' => 'El {field} ya existe en la base de datos'
				)
			),
			"clave" => array(
				"label" => "Clave",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "La {field} es requerida",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"re_clave" => array(
				"label" => "Repertir Clave",
				"rules" => "required|min_length[6]|matches[clave]",
				"errors" => array(
					"required" => "{field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					"matches"=>"{field} es diferente a la {param}"
				)
			),
			"usuario_nombre" => array(
				"label" => "Nombre del usuario",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"id_tipo_usuario" => array(
				"label" => "Tipo de usuario",
				"rules" => "required|integer",
				"errors" => array(
					"required" => "El {field} es requerido",
					"integer"=>"El {field} debe ser numérico"
				)
			)
		);

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$nombreusuario 	   	= $this->request->getPost("usuario");
		$id_tipo_usuario 	   	= $this->request->getPost("id_tipo_usuario");
		$clave 			   	= $this->request->getPost("clave");
		$usuario_nombre 	= $this->request->getPost("usuario_nombre");
		$direccion 			= $this->request->getPost("direccion");
		$telefono = $this->request->getPost("telefono");
		$usuarios = array(
			"nombreusuario"=>str_replace(" ", "",$nombreusuario),
			"id_tipo_usuario"=>$id_tipo_usuario,
			"contrasena"=>md5($clave),
			"nombre"=>$usuario_nombre,
			"direccion"=>$direccion, 
			"telefono"=>$telefono
		);
		$Agregar_Usuario = $this->Usuario_model->Agregar_Usuario($usuarios);
		//print_r($Agregar_Usuario);return;
		if(!$Agregar_Usuario){
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
	public function Vista_Editar_Usuario($codigousuario){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'actualizar');//Usuarios
		
		//compruebo que el registro existe
		$tabla_usuarios ="usuarios";
		$columnas_usuarios ="count(codigousuario) as CUENTA";
		$where_usuarios = array(
			"codigousuario"=>$codigousuario
		);
		$resultado = $this->Model_Select->Select_Data($tabla_usuarios, $columnas_usuarios, $where_usuarios);
		//print_r($resultado); return;
		//$resultado = $resultado->getResult();
		//echo $resultado[0]->CUENTA; return;
		if($resultado[0]->CUENTA == 0){
		    //funcion definida en BaseController
			$this->Errores_No_Existe_Registro();
		}
		
		$mostrar["Traer_Tipos_De_Usuarios"] = $this->Model_Select->Select_Data("adm_tipos_usuario", "id_tipo_usuario, tipousu_nombre");
		
		$tabla ="usuarios u
		inner join adm_tipos_usuario tipou on(tipou.id_tipo_usuario  = u.id_tipo_usuario)";
		$columnas ="u.codigousuario, u.nombreusuario, u.nombre, u.id_tipo_usuario,u.direccion,u.telefono, tipou.tipousu_nombre";
		
		$where = array(
				"u.codigousuario" => $codigousuario
				); 
		
		$mostrar["Traer_Usuario_por_ID"] = $this->Model_Select->Select_Data($tabla, $columnas, $where);
		
		$mostrar["contenido"] = "usuarios/vista_editar_usuarios";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Editar_Usuario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'actualizar'); //Usuarios
		$rules = array(
			"usuario" => array(
				"label" => "Usuario",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			),
			"codigousuario" => array(
				"label" => "ID de usuario",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"usuario_nombre" => array(
				"label" => "Nombre del usuario",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"id_tipo_usuario" => array(
				"label" => "Tipo de usuario",
				"rules" => "required|integer",
				"errors" => array(
					"required" => "El {field} es requerido",
					"integer"=>"El {field} debe ser numérico"
				)
			)
		);

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$codigousuario 	   	= $this->request->getPost("codigousuario");
		$usuario_nombre 	= $this->request->getPost("usuario_nombre");
		$direccion 			= $this->request->getPost("direccion");
		$telefono = $this->request->getPost("telefono");
		$id_tipo_usuario = $this->request->getPost("id_tipo_usuario");
		$usuarios = array(
			"nombre"=>$usuario_nombre,
			"direccion"=>$direccion, 
			"telefono"=>$telefono,
			"id_tipo_usuario"=>$id_tipo_usuario
		);
		$where = array(
		'codigousuario' => $codigousuario
		);


		$Actualizar_Usuario = $this->Model_Update->Update_Data('usuarios', $usuarios, $where);
		//print_r($Agregar_Usuario);return;
		if(!$Actualizar_Usuario){
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
	public function Bloquer_Desbloquear_Usuario(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(8, 'actualizar'); //Usuarios
		$rules = array(
			"codigousuario" => array(
				"label" => "ID de usuario",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"estado" => array(
				"label" => "Estado del usuario",
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
		$codigousuario 	   	= $this->request->getPost("codigousuario");
		$estado 	   	= $this->request->getPost("estado");
		if($estado == 0){
			$estado = 1;
		}
		else{
			$estado = 0;
		}
		
		$usuarios = array(
			"estado"=>$estado
		);
		$where = array(
		'codigousuario' => $codigousuario
		);

		$Actualizar_Usuario = $this->Model_Update->update_data('usuarios', $usuarios, $where);
		//print_r($Agregar_Usuario);return;
		if(!$Actualizar_Usuario){
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
