<?php

namespace App\Controllers\productos;
use App\Controllers\BaseController;
class Productos extends BaseController
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
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(3, 'tiene_permiso');//Productos
        //return view('welcome_message');
		$tabla = "productos p 
		inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad )
		inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto )";
		$columnas = "p.codigoproducto , p.nombre , p.descripcion,
		DATE_FORMAT(p.prod_fecha_creacion, '%d-%m-%Y') as prod_fecha_creacion,
		ptu.tipo_unidad_nombre , pt.tipo_nombre";
		$oder_by = "codigoproducto desc";
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		$mostrar["contenido"] = "productos/vista_administrar_productos";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Vista_Agregar_Productos(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(3, 'agregar');//Productos
		$tabla = "prod_tipo_unidad";
		$columnas = "id_tipo_unidad , tipo_unidad_nombre";
		$oder_by = "tipo_unidad_nombre asc"; 
		$mostrar["Unidad_Medida"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by);
		
		$tabla = "prod_tipos";
		$columnas = "id_tipo_producto , tipo_nombre";
		$oder_by = "tipo_nombre asc"; 
		$mostrar["Categorias"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by);
		
		$mostrar["contenido"] = "productos/vista_agregar_productos";//contenido tendra la vista
		return view("plantilla", $mostrar);
		  
	}
	public function Agregar_Producto(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(3, 'agregar');//Productos 
		$rules = array(
			"prod_codigo" => array(
				"label" => "Código",
				"rules" => "required|min_length[6]|is_unique[productos.prod_codigo]",
				"errors" => array(
					"required" => "El {field} es reqerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}",
					'is_unique' => 'El {field} ya existe en la base de datos'
				)
			),
			"nombre" => array(
				"label" => "Nombre",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"id_tipo_producto" => array(
				"label" => "Categoría",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida"
				)
			),
			"id_tipo_unidad" => array(
				"label" => "Unidad de medida",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida"
				)
			)
		);

		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$prod_codigo 	   	= $this->request->getPost("prod_codigo");
		$nombre 			= $this->request->getPost("nombre");
		$descripcion 		= $this->request->getPost("descripcion");
		$id_tipo_producto 	= $this->request->getPost("id_tipo_producto");
		$id_tipo_unidad 	= $this->request->getPost("id_tipo_unidad");
		
		$data = array(
			"prod_codigo"=>str_replace(" ", "" ,$prod_codigo),
			"nombre"=>$nombre,
			"descripcion"=>$descripcion,
			"id_tipo_producto"=>$id_tipo_producto,
			"id_tipo_unidad"=>$id_tipo_unidad
		);
		$Agregar = $this->Model_Insert->Insert_Data("productos", $data);
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
	public function Vista_Editar_Producto($codigoproducto){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(3, 'actualizar');//Productos 
		$productos = 'productos p 
		inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad )
		inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto )';
		$columnas = 'p.codigoproducto , p.prod_codigo, p.nombre , p.descripcion ,
		ptu.id_tipo_unidad, ptu.tipo_unidad_nombre , 
		pt.id_tipo_producto, pt.tipo_nombre ';
		$where = array('p.codigoproducto' => $codigoproducto); 
		
		$prod_tipo_unidad = "prod_tipo_unidad";
		$columnas_prod_tipo_unidad = "id_tipo_unidad , tipo_unidad_nombre";
		$oder_by_prod_tipo_unidad = "tipo_unidad_nombre asc"; 
		$mostrar["Unidad_Medida"] = $this->Model_Select->Select_Data($prod_tipo_unidad, $columnas_prod_tipo_unidad, '', $oder_by_prod_tipo_unidad);
		
		$tabla_prod_tipos = "prod_tipos";
		$columnas_prod_tipos = "id_tipo_producto , tipo_nombre";
		$oder_by_prod_tipos = "tipo_nombre asc"; 
		$mostrar["Categorias"] = $this->Model_Select->Select_Data($tabla_prod_tipos, $columnas_prod_tipos, '', $oder_by_prod_tipos);
		
		$mostrar['Traer_Producto_por_ID'] = $this->Model_Select->Select_Data($productos, $columnas, $where);
		
		$mostrar["contenido"] = "productos/vista_editar_producto";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Editar_Producto(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(3, 'actualizar'); //Productos
		$rules = array(
			"codigoproducto" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} del producto es reqerido"
				)
			),
			"prod_codigo" => array(
				"label" => "Código",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			),
			"nombre" => array(
				"label" => "Nombre",
				"rules" => "required|min_length[6]",
				"errors" => array(
					"required" => "El {field} es requerido",
					"min_length"=>"El mínimo de caracteres para el {field} es de {param}"
				)
			),
			"id_tipo_producto" => array(
				"label" => "Categoría",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida"
				)
			),
			"id_tipo_unidad" => array(
				"label" => "Unidad de medida",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida"
				)
			)
		);
	
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//pasa la validacion
		$codigoproducto 	   	= $this->request->getPost("codigoproducto");
		$nombre 			= $this->request->getPost("nombre");
		$descripcion 		= $this->request->getPost("descripcion");
		$id_tipo_producto 	= $this->request->getPost("id_tipo_producto");
		$id_tipo_unidad 	= $this->request->getPost("id_tipo_unidad");
		
		$data = array(
			"nombre"=>$nombre,
			"descripcion"=>$descripcion,
			"id_tipo_producto"=>$id_tipo_producto,
			"id_tipo_unidad"=>$id_tipo_unidad
		);
		$where = array(
		'codigoproducto' => $codigoproducto
		);

		$Actualizar = $this->Model_Update->Update_Data('productos', $data, $where);
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
