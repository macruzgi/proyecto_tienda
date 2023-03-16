<?php

namespace App\Controllers\Configuracion;
use App\Controllers\BaseController;
class Configuracion extends BaseController
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
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(24, 'tiene_permiso');//Datos de la empresa
        
		$tabla = "ferro_adm_configuraciones fac";
		$columnas = "fac.id_configuracion , fac.valor_configuracion";
		
		$where_in = array(
			"fac.id_configuracion" => array(2,3,4,5,6) 
		);
		
		$mostrar["Traer_Datos_Empresa"] = $this->Model_Select->Select_Data($tabla, $columnas, '', '', '', '', '', $where_in);
		
		$mostrar["contenido"] = "administracion/vista_administrar_datos_empresa";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Actualizar_Datos_Generales(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(24, 'actualizar');//Datos de la empresa
		
		$rules = array(
			"nombre_empresa" => array(
				"label" => "Nombre de la empresa",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			),
			"direccion_empresa" => array(
				"label" => "Dirección",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida"
				)
			),
			"moneda_empresa" => array(
				"label" => "Moneda",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida"
				)
			)
		);
		if($this->request->getPost("archivo") != "undefined"){
			$rules["archivo"] =  array(
				"label"=>"Archivo",
				"rules"=>"uploaded[archivo]|is_image[archivo]|mime_in[archivo,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[archivo,4096]",
				"errors"=>[
					"is_image"=>"El archivo no es una imagen",
					"max_size"=>"El {field} excede el tamaño de lo permitido {param} MB."
				]
			);
		}
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		$nombre_empresa 				= $this->request->getPost("nombre_empresa");
		$direccion_empresa 				= $this->request->getPost("direccion_empresa");
		$telefono_empresa				= $this->request->getPost("telefono_empresa");		
		$moneda_empresa 		= $this->request->getPost("moneda_empresa");
		$archivo 				= $this->request->getFile("archivo");
		$nombre_orginal_archivo = $this->request->getPost("nombre_logo");
		if($archivo && $archivo->isValid() && !$archivo->hasMoved()){
			$archivo->move(ROOTPATH . "public/images/");
			$nombre_orginal_archivo = $archivo->getClientName();
		}
		
		$datos_formulario = array(
			"2" => $nombre_empresa,
			"3" => $direccion_empresa,
			"4" => $telefono_empresa,
			"5" => $moneda_empresa,
			"6" => $nombre_orginal_archivo
		);
		
		foreach($datos_formulario as $dato=>$valor){
			//echo $dato." ".$valor."<br>";
			$where = array("id_configuracion" => $dato);
			$data = array(
				"valor_configuracion" => $valor
			);
			$Acutalizar = $this->Model_Update->Update_Data("ferro_adm_configuraciones", $data, $where);
		}
		 //return; 
		
		if(!$Acutalizar){
			
			//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
			$respuesta = get_respuesta(0, "No esposible actualizar el registro.", "alert alert-danger alert-dismissible");
			return json_encode($respuesta);
			
		}
		//hubo exito
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
		$respuesta = get_respuesta(1, "Registro actualizado.", "alert alert-success alert-dismissible");
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
