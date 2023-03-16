<?php

namespace App\Controllers;

class Cotizaciones extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Delete = model("Model_Delete");
		$this->Cotizaciones_Model = model("Cotizaciones/Cotizaciones_Model");
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'tiene_permiso');
        //return view('welcome_message');
		$tabla = "cotizacion c";
		$columnas = "c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, c.nombre_cliente,
		c.costo, c.terminos_condiciones, DATE_FORMAT(c.fecha_ultima_modificacion, '%d-%m-%Y %H:%i:%s') 
		as fecha_ultima_modificacion, if(c.estado = 1, 'PROCESADA', 'PENDIETNE') as ESTADO";
		$oder_by = "id_cotizacion desc";
		$mostrar["Traer_Cotizaciones"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		$mostrar["contenido"] = "cotizaciones/vista_administrar_cotizaciones";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Re_Imprimir_Cotizacion($id_cotizacion){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'tiene_permiso');
		  
         $tabla = "cotizacion c
		inner join cotizacion_detalle cd ON (cd.id_cotizacion = c.id_cotizacion)
		inner join productos p on(p.codigoproducto = cd.codigoproducto)
		inner join fac_cliente fc on(fc.id_cliente = c.id_cliente)";
		$columnas = "c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, c.nombre_cliente,
		c.terminos_condiciones, DATE_FORMAT(c.fecha_ultima_modificacion , '%d-%m-%Y') as fecha_ultima_modificacion, c.costo ,
		cd.id_detalle , cd.cantidad , cd.precio_venta , cd.subtotal,
		cd.codigoproducto , p.nombre , p.descripcion,
		fc.cli_codigo";
		$where = array(
			"c.id_cotizacion"=>$id_cotizacion
		);
		$oder_by = "cd.id_detalle asc";
		$mostrar["Traer_Cotizacion"] = $this->Model_Select->Select_Data($tabla, $columnas, $where, $oder_by); 
		
		return view("cotizaciones/re_imprimir_cotizacion", $mostrar);
		  
	}
	public function Eliminar_Cotizacion(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'eliminar'); //Cotizaciones
		$rules = array(
			"id_cotizacion" => array(
				"label" => "ID de la cotización",
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
		$id_cotizacion 	   	= $this->request->getPost("id_cotizacion");
		
		//veo si la cotización no se ha procesado
		
		
		$where = array(
		'id_cotizacion' => $id_cotizacion
		);

		$Eliminar_Cotizacion = $this->Model_Delete->Delete_Data('cotizacion', $where);
		
		if(!$Eliminar_Cotizacion){
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
   public function Cargar_Cotizacion(){
	   //verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, "agregar");//Pre-Facturacion
		$rules = array(
			"id_cotizacion" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} de la cotización es requerido."
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		$id_cotizacion 		= $this->request->getPost("id_cotizacion");
		
		
		//busco la factura
		$tablas = "cotizacion c
		inner join cotizacion_detalle cd ON (cd.id_cotizacion = c.id_cotizacion)
		inner join productos p on(p.codigoproducto = cd.codigoproducto)
		inner join fac_cliente fc on(fc.id_cliente = c.id_cliente)";

		$columnas = "c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, c.nombre_cliente,
		c.terminos_condiciones, c.id_cliente,
		cd.id_detalle , cd.cantidad , cd.precio_venta , cd.subtotal,
		cd.codigoproducto , p.nombre , p.descripcion, fc.cli_codigo";
		
		$where = array(
			"c.id_cotizacion "=>$id_cotizacion,
			"c.estado"=>0
		);
		$order_by = "cd.id_detalle asc";
		
		$cotizacion_detalle = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by);
		if(!$cotizacion_detalle){
			//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje, y clase css
			$respuesta = get_respuesta(0, 'El registro ya fue procesado o no está disponible', 'alert alert-danger alert-dismissible');
			return json_encode($respuesta);
		}
		//remuevo la sesion si existe
		$this->session->remove("carrito");
		
		//creo sesion
		$carrito = $this->session->get("carrito");

		// Si el carrito no existe en la sesión, crear un array vacío
		if (!$carrito) {
			$carrito = array();
		}
		//agrego los detalles de la factura al array $carrito
		foreach($cotizacion_detalle as $Registro_Econtrado){
			//agregamos los productos al carrito
			$carrito[$Registro_Econtrado->codigoproducto] = array(
				"codigoproducto" => $Registro_Econtrado->codigoproducto,
				"cantidad" => $Registro_Econtrado->cantidad,
				"producto"=>$Registro_Econtrado->nombre,
				"precio"=>$Registro_Econtrado->precio_venta,
				"subtotal"=>$Registro_Econtrado->subtotal
			);
		}
		
		// Actualizar el carrito de venta agregando el array $carrito  en la sesión carrito
		$this->session->set("carrito", $carrito);
		
		//pas las validadciones
		//envio la respuesta de exito
		$respuesta = get_respuesta(1, 'Cotización cargada.', 'alert alert-success alert-dismissible', array('datos_cotizacion'=>array('id_cotizacion'=>$cotizacion_detalle[0]->id_cotizacion, 'terminos_condiciones'=>$cotizacion_detalle[0]->terminos_condiciones, 'nombre_cliente'=>$cotizacion_detalle[0]->nombre_cliente,'numero_cotizacion'=>$cotizacion_detalle[0]->numero_cotizacion, 'id_cliente'=>$cotizacion_detalle[0]->id_cliente, 'cli_codigo'=>$cotizacion_detalle[0]->cli_codigo )));
		//print_r($respuesta); return;
		return json_encode($respuesta);
   }
   public function Guardar_E_Imprimir_Cotizacion(){
	//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Facturacion
		
		$rules = array(
			"id_cliente" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} del cliente es reqerido"
				)
			),
			"cli_cliente_buscar" => array(
				"label" => "Cliente",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido"
				)
			),
			"cli_nombre" => array(
				"label" => "Nombre",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} del cliente es requerido"
				)
			),
			"terminos_condiciones" => array(
				"label" => "Términos y condiciones",
				"rules" => "max_length[150]",
				"errors" => array(
					"max_length" => "El máximo de caracteres para {field} es de {param}"
				)
			)/*,
			"nombre_numero_cotizacion" => array(
				"label" => "Número",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} de la cotización es requerido"
				)
			)*/
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//valido si hay productos en el carrito
		if(count(session("carrito")) <= 0){
			//envio la respuesta de exito
			$respuesta = get_respuesta(0, 'Deben de haber productos en la cotización', 'alert alert-danger alert-dismissible');
			
			return json_encode($respuesta);
		}
		
		$id_cliente 		= $this->request->getPost("id_cliente");
		$cli_cliente_buscar = $this->request->getPost("cli_cliente_buscar");
		$cli_nombre				= $this->request->getPost("cli_nombre");
		$id_cotizacion			= $this->request->getPost("id_cotizacion");	
		$terminos_condiciones	= $this->request->getPost("terminos_condiciones");			
		
		$fac_fecha_creacion 		= date('Y-m-d H:i:s'); // fecha actual
		$numero_cotizacion 		= date("ym-is");
		
		$Gran_Total = 0;
		foreach(session("carrito") as $Producto_En_El_Carrito){
			$Gran_Total = $Gran_Total + $Producto_En_El_Carrito["subtotal"];
		}
		$cotizacion = array(
			"nombre_cliente"=> $cli_nombre,
			"terminos_condiciones"=>$terminos_condiciones,
			"codigousuario"=> session("codigousuario"),
			"costo"=> $Gran_Total,
			"id_cliente"=> $id_cliente
		);
		 //si el id_cotizacion no esta vacio, tiene algo, que actualice la cotizacion, de lo contrario, que la inserte
		if($id_cotizacion !=""){
			//agrego el indice de fecha ultima de modificacion 
			$cotizacion["fecha_ultima_modificacion"] = $fac_fecha_creacion;
			
			$Insertar_O_Actualizar_Cotizacion = $this->Cotizaciones_Model->Actualizar_Cotizacion($cotizacion, $id_cotizacion);
		}
		else{
			//agrego el numero de coticación
			$cotizacion["numero_cotizacion"] = $numero_cotizacion;
			
			$Insertar_O_Actualizar_Cotizacion = $this->Cotizaciones_Model->Insertar_Cotizacion($cotizacion);
		}
		
		//print_r($Insertar_O_Actualizar_Cotizacion); return;
		if(!$Insertar_O_Actualizar_Cotizacion){
			//envio la respuesta de exito
			$respuesta = get_respuesta(0, 'No se ha podido guardar el registro', 'alert alert-danger alert-dismissible');
			return json_encode($respuesta);
		}
		//hubo exito
		//lipio el corrito 
		$this->Limpiar_Carrito();
		//envio la respuesta de exito
		$respuesta = get_respuesta(1, 'Dato almacenado', 'alert alert-success alert-dismissible', array('id_cotizacion'=>$Insertar_O_Actualizar_Cotizacion));
		
		return json_encode($respuesta);	
	
   }
   function Limpiar_Carrito(){
		// Limpia el carrito
		$this->session->remove("carrito");
		//limpio los datos del cliente si se ha modificado la factura
		$this->session->remove("fac_factura");
		
		//creo la sesion del carrito vacia, esto para que no me de error al eliminar todos los productos
		$carrito = $this->session->get("carrito");
		// Si el carrito no existe en la sesión, crear un array vacío
		if (!$carrito) {
			$carrito = array();
		}
		// Actualizar el carrito de compras en la sesión
		$this->session->set("carrito", $carrito);
		//envio la respuesta de exito
		$respuesta = get_respuesta(1, 'Se han eliminado todos los productos agregados a la cotización.', 'alert alert-success alert-dismissible');
		
		return json_encode($respuesta);
	}
}
