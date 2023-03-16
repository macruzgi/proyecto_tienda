<?php

namespace App\Controllers;
use App\Models\Usuario_model;
class Login extends BaseController
{
	public function __construct(){
		$this->Usuario_model = model("Usuario_model");
	}
    public function index()
    {
        return view('vista_login');
    }
	public function Validar_Usuario(){
		//validos los datos enviados por la vista_login
		//validacion de CodeIgniter
		$this->validacion->setRules([
			"usuario"=>[
				"label"=>"Usuario",
				"rules"=>"required|min_length[5]",//si hubieren más validaciones se pondrían aquí
				"errors"=>[
					"required"=>"La contraseña es requeridad",
					"min_length"=>"El mínio de caracteres del {field} es 5"
				]
			],
			"clave"=>[
				"label"=>"Contraseña",
				"rules"=>"required|min_length[5]",
				"errors"=>[
					"required"=>"El usuario es requerido",
					"min_length"=>"El mínimo de caracteres de la {field} es de 5"
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
		$usuario 	= $this->request->getPost("usuario");
		$clave 		= $this->request->getPost("clave");
		
		//preparo los datos para buscar en la db
		$adm_usuario = array(
			"nombreusuario"=>$usuario,
			"contrasena"=>md5($clave)
		);
		$Usuario_Encontrado = $this->Usuario_model->Traer_Usuario_Login($adm_usuario);
		//si no hay coincidencias que muestre errores
		if(!$Usuario_Encontrado){
			$respuesta = array(
				"respuesta"=>0,
				"mensaje"=>"Los datos ingresados son incorrectos, o posiblemente su usuario está inactivo",
				"clase_css"=>"alert alert-danger alert-dismissible"
			);
			echo json_encode($respuesta);
			return;//evito la continuación del la ejecución del código
		}
		
		//si encontro resultados
		//traigo las opciones del menu para cargarlas y generarlas
		$Taer_Opciones_Del_Menu = $this->Usuario_model->Taer_Opciones_Del_Menu($Usuario_Encontrado->codigousuario);
		//itero las opciones del menu para agregarlas a un array de la sesion y en los controladores evaluar solo si el usuario posee permisos a esa vista
		$ids_modulo_opciones = array();
		if($Taer_Opciones_Del_Menu){
		foreach($Taer_Opciones_Del_Menu as $Opciones_Encontradas):
			$ids_modulo_opciones[] = array(
				"id_modulo_opcion"=>$Opciones_Encontradas->id_modulo_opcion, 
				"tiene_permiso"=>$Opciones_Encontradas->tiene_permiso,
				"agregar"=>$Opciones_Encontradas->agregar,
				"actualizar"=>$Opciones_Encontradas->actualizar,
				"eliminar"=>$Opciones_Encontradas->eliminar
				);
		
		endforeach;
		}
		//print_r($ids_modulo_opciones); return;
		//agrego los ids_modulo_opciones a la variable de sesion
		//si se encontro usuario valido
		$Datos_En_Sesion = array(
			"codigousuario"=>$Usuario_Encontrado->codigousuario,
			"nombreusuario"=>$Usuario_Encontrado->nombreusuario,
			"nombre"=>$Usuario_Encontrado->nombre,
			"id_tipo_usuario"=>$Usuario_Encontrado->id_tipo_usuario,
			"usuario_estado"=>1, //este indice no se para que se ocupa, pero ahi lo dejare
			"Taer_Opciones_Del_Menu"=>$Taer_Opciones_Del_Menu,
			"ids_modulo_opciones"=>$ids_modulo_opciones,
			"chequear"=>true
		);
		//agrego los datos del usaurio del array $Datos_En_Sesion a una sesion de codeigniter
		$this->session->set($Datos_En_Sesion);
		$respuesta = array(
				"respuesta"=>1,
				"mensaje"=>"",
				"clase_css"=>""
			);
		echo json_encode($respuesta);
	}
	public function Error_De_Acceso(){
		//comprobamos si el usuario esta logueado, si no esta logueado que lo redirija al login
		if(!session("chequear")){
			throw new \CodeIgniter\Router\Exceptions\RedirectException('/');
		}
		else{
			$mostrar["error"] ="ACCESO DENEGADO, SOLICITE AYUDA A UN ADMINISTRADOR.";
			$mostrar["contenido"] = "vista_acceso_denegado";
			return view("plantilla", $mostrar);
		}
	}
	public function Cerrar_Sesion(){
		//$this->session->set('chequear', false);
		$this->session->destroy();//destruyo la sesion
		//redirecciono a login
		throw new \CodeIgniter\Router\Exceptions\RedirectException('/');
	}
}
