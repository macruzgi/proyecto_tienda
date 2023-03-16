<?php

namespace App\Controllers;

class Utilidades extends BaseController
{
	public function __construct(){
		//verifico si el usuario se ha logueado
		$this->isLoggedIn();
		
		$this->Usuario_model = model("Usuario_model");
		$this->Model_Select = model("Model_Select");
		$this->Model_Update = model("Model_Update");
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(9, 'tiene_permiso');
        //return view('welcome_message');
		$mostrar["contenido"] = "utilidades/vista_administrar_backus";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Generar_Backup(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(9, 'agregar');
		  
         
		  
	}
	public function Traer_Municipios(){
		$id_departamento = $this->request->getPost("id_departamento");
		//traigo los departamentos
		 $tablas = "adm_municipio m";
		 $columnas ="m.id_municipio , m.municipio_nombre";
		 $where = array(
			"m.id_departamento"=> $id_departamento
		 );
		 $order_by = "m.id_municipio asc";
		 $Municipios = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by);
		 
		//el formulario espera un json como respuesta
		return json_encode($Municipios);
	}
	public function Errores_No_Existe_Registro(){
		$mostrar["error"] ="El registro no existe.";
		$mostrar["contenido"] = "vista_acceso_denegado";
		return view("plantilla", $mostrar);
	}
}
