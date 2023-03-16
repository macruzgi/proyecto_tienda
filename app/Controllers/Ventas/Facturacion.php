<?php

namespace App\Controllers\Ventas;
use App\Controllers\BaseController;
class Facturacion extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Update = model("Model_Update");
		$this->Model_Delete = model("Model_Delete");
		$this->Ventas_Model = model("Ventas/Ventas_Model");
		$this->Precio_Model = model("Producto/Precio_Model");
		
		date_default_timezone_set("America/El_Salvador");
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(2, 'tiene_permiso');//Por cobrar
        //return view('welcome_message');
		$tabla = "fac_factura f 
			inner join usuarios u on(u.codigousuario= f.codigousuario)";
			
		$columnas = " f.id_factura , DATE_FORMAT(f.fac_fecha_creacion  , '%d-%m-%Y') as fac_fecha_creacion,
		f.fac_nombre_cliente , f.fac_total ,
		u.nombreusuario , u.nombre";
		
		$where = array(
			"f.fac_estado"=>1
		);
		
		$order_by = "id_factura desc";
		
		$limit = 1000;
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, $where, $order_by, $limit); 
		$mostrar["contenido"] = "ventas/vista_administrar_facturas";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	public function Bandeja_Facturas(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'tiene_permiso');//Facturacion
        //return view('welcome_message');
		$tabla = "fac_factura f 
			inner join usuarios u on(u.codigousuario= f.codigousuario )";
			
		$columnas = " f.id_factura , DATE_FORMAT(f.fac_fecha_creacion  , '%d-%m-%Y %H:%i:%s') as fac_fecha_creacion,
		f.fac_nombre_cliente , f.fac_total ,
		u.nombreusuario , u.nombre";
		
		$where = array(
			"f.fac_estado"=>0
		);
		
		$order_by = "id_factura desc";
		
		$limit = 1000;
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, $where, $order_by, $limit); 
		$mostrar["contenido"] = "ventas/vista_bandeja_de_facturas";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Nueva_Venta(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Pre factura
		$mostrar["contenido"] = "ventas/vista_agregar_venta";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Traer_Cliente(){
		$cli_cliente_buscar 	   	= $this->request->getPost("cli_cliente_buscar");
		
		$columnas = 'fc.id_cliente , fc.cli_codigo , fc.cli_nombre , fc.cli_direccion , fc.cli_telefono';
		
		$where = array('fc.cli_codigo' => $cli_cliente_buscar);
		
		$datos = $this->Model_Select->Select_Data('fac_cliente fc', $columnas, $where);
		
		return json_encode($datos);
	}
	public function Vista_Resultado_Busqueda_Cliente(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'agregar');//Facturacion
		
		$tabla = "fac_cliente fc";
		$columnas = "fc.id_cliente , fc.cli_codigo , fc.cli_nombre , fc.cli_direccion , fc.cli_telefono";
		
		$oder_by = "id_cliente desc";
		
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tabla, $columnas, '', $oder_by); 
		
		return view("ventas/vista_resultado_independiente_clientes", $mostrar);
		  
	}
	public function Traer_Cotizaciones(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Pre factura
		 $nombre_numero_cotizacion 				= $this->request->getPost("nombre_numero_cotizacion");
		 
		$tabla = "cotizacion c";
		$columnas = "c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, c.nombre_cliente,
		c.costo, c.terminos_condiciones, DATE_FORMAT(c.fecha_ultima_modificacion, '%d-%m-%Y %H:%i:%s') as fecha_ultima_modificacion";
		
		$where = array(
			"c.estado" => 0,
			'(c.numero_cotizacion like "%'.$nombre_numero_cotizacion.'%" or c.nombre_cliente like "%'.$nombre_numero_cotizacion.'%")' => null
		);
		
		/*$or_where = array(
			"c.numero_cotizacion like " => "%".$nombre_numero_cotizacion."%",
			"c.nombre_cliente like " => "%".$nombre_numero_cotizacion."%"
		);*/
		$oder_by = "c.id_cotizacion desc";
		
		$limit = '10';
		
		$Taer_Cotizaciones = $this->Model_Select->Select_Data($tabla, $columnas, $where, $oder_by, $limit);
		 
		 echo json_encode($Taer_Cotizaciones);
	}
	public function Buscar_Producto(){//funcion para buscar productos en la compra
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(5, 'agregar');//Compras
		$buscar_producto_venta 				= $this->request->getPost("buscar_producto_venta");
		 
		$tabla = "cotizacion c";
		$columnas = "c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, c.nombre_cliente,
		c.costo, c.terminos_condiciones, DATE_FORMAT(c.fecha_ultima_modificacion, '%d-%m-%Y %H:%i:%s') as fecha_ultima_modificacion";
		
		$where = array(
			"c.estado" => 0
		);
		
		$or_where = array(
			"c.numero_cotizacion like " => "%".$nombre_numero_cotizacion."%",
			"c.nombre_cliente like " => "%".$nombre_numero_cotizacion."%"
		);
		$oder_by = "c.nombre_cliente asc";
		
		$limit = '10';
		
		$Taer_Cotizaciones = $this->Model_Select->Select_Data($tabla, $columnas, $where, $oder_by, $limit, $or_where);
		 
		 echo json_encode($Taer_Cotizaciones);
	}
	public function Buscar_Producto_Para_Venta(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Pre-Facturacion
        $buscar_producto_venta 	= $this->request->getPost("buscar_producto_venta");
		
		$tablas = "productos p 
		inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto)";

		$columnas = "p.codigoproducto , p.prod_codigo, p.nombre, p.descripcion,
		pt.tipo_nombre,  coalesce((SELECT kar_saldo FROM inv_kardex  
		WHERE codigoproducto = p.codigoproducto ORDER BY kar_fecha_creacion DESC LIMIT 1) ,0) AS existencia, coalesce((select pre_precio FROM prod_precios 
		WHERE codigoproducto = p.codigoproducto ORDER BY pre_fecha_creacion DESC LIMIT 1), 0) as precioventa";
		
		$oder_by = "p.nombre";
		
		$limit = 10;
		
		$or_where = array(
			"p.descripcion like " => "%".$buscar_producto_venta."%",
			"p.nombre like" => "%".$buscar_producto_venta."%",
			"p.prod_codigo like" => "%".$buscar_producto_venta."%"
		);
		$datos = $this->Model_Select->Select_Data($tablas, $columnas, '', $oder_by, $limit, $or_where);
		
		return json_encode($datos);
        
	}
	public function Agregar_Producto_Al_Carro(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Pre-Facturacion
		$codigoproducto 	= $this->request->getPost("codigoproducto");
		$cantidad 			= $this->request->getPost("cantidad");
		$mensaje_producto_sin_inventario = "";
		
				
		$producto = $this->Precio_Model->Trear_Existencia_Producto($codigoproducto);
		if ($cantidad > $producto->existencia) {//si la cantidad ingresada es mayor a la existencia del producto se agrega un mensaje
			$mensaje_producto_sin_inventario = "La cantidad solicitada: ".$cantidad." del producto: ".$producto->nombre." ".$producto->descripcion." no est&aacute; disponible, mas sin embargo, se a agregar&aacute; a la factura y el inventario quedar&aacute; negativo.";
		}
		
		$carrito = $this->session->get("carrito");

		// Si el carrito no existe en la sesión, crear un array vacío
		if (!$carrito) {
			$carrito = array();
		}

		//Comprobar si el producto ya existe en el carrito de compras
		if (array_key_exists($codigoproducto, $carrito)) {
			$carrito[$codigoproducto]["cantidad"] += $cantidad;
			$carrito[$codigoproducto]["subtotal"] = str_replace(",", "", number_format(($carrito[$codigoproducto]["cantidad"] * $producto->precio), 3));
		} else {
			$carrito[$codigoproducto] = array(
				"codigoproducto" => $codigoproducto,
				"cantidad" => $cantidad,
				"producto"=>$producto->nombre,
				"precio"=>$producto->precio,
				"subtotal"=>str_replace(",", "", number_format(($cantidad * $producto->precio), 3)),
			);
		}

		// Actualizar el carrito de compras en la sesión
		$this->session->set("carrito", $carrito);
		//print_r(session("carrito"));
		// Limpia el carrito
		//$this->session->remove('carrito');
		if($mensaje_producto_sin_inventario != ""){
			$mensaje = $mensaje_producto_sin_inventario;
			$clase_css = "alert alert-warning alert-dismissible ";
			$tipo_alertify = "warning"; //par ver que tipo de alertifi se muestra al cliente
		}
		else{
			$mensaje ="Producto agregado.";
			$clase_css = "alert alert-success alert-dismissible ";
			$tipo_alertify = "success"; //par ver que tipo de alertify se muestra al cliente
		}
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
		$respuesta = get_respuesta(1, $mensaje, $clase_css, array("tipo_alertify"=>$tipo_alertify));
		
		echo json_encode($respuesta);		
	}
	function Numero_Renglones_Factura(){
		//traer numero de reglones para las facturas
		 
		$tabla = "ferro_adm_configuraciones fac";
		$columnas = "fac.id_configuracion , fac.valor_configuracion";
		
		$where = array(
			"fac.id_configuracion" => 1
		);
		
		$Numero_Renglones_Factura = $this->Model_Select->Select_Data($tabla, $columnas, $where);
		return $Numero_Renglones_Factura[0]->valor_configuracion;
	}
	public function Ver_Productos_Del_Carrito(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Pre-Facturacion
		
		
		$mostrar["numero_de_renglones_factura"] = $this->Numero_Renglones_Factura();
		return view("ventas/vista_resultado_independiente_ver_productos_carrito", $mostrar);
	}
	public function Eliminar_Producto_Del_Carito(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, "agregar");//Pre-Facturacion
		
		$codigoproducto 	= $this->request->getPost("codigoproducto");
		
		$carrito = $this->session->get("carrito");

		if (array_key_exists($codigoproducto, $carrito)) {
			unset($carrito[$codigoproducto]);
		}

		$this->session->set("carrito", $carrito);
		$respuesta = array(
			"respuesta"=>1,
			"mensaje"=>"Producto eliminado de la factura"
		);
		return json_encode($respuesta);
	}
	public function Actualizar_Items_Carrito(){
		// Comprobar si el producto ya existe en el carrito de compras
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, "agregar");//Pre-Facturacion
		
		$rules = array(
			"codigoproducto" => array(
				"label" => "Producto",
				"rules" => "required",
				"errors" => array(
					"required" => "Debe haber algún {field}.",
				)
			),
			"precio" => array(
				"label" => "Precio",
				"rules" => "required|greater_than[0]",
				"errors" => array(
					"required" => "Debe haber algún {field}.",
					"greater_than" => "El {field} debe ser mayor a {param}."
				)
			),
			"cantidad" => array(
				"label" => "Cantidad",
				"rules" => "required|greater_than[0]",
				"errors" => array(
					"required" => "Debe haber alguna {field}.",
					"greater_than" => "La {field} debe ser mayor a {param}."
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		//pasó la validacion
		$codigoproducto 	= $this->request->getPost("codigoproducto");
		$cantidad 			= $this->request->getPost("cantidad");
		$precio 			= $this->request->getPost("precio");
		$mensaje_producto_sin_inventario = "";
		//valido si el producto a actualizar no exeda las existiencias actuales, si es así muestra un mensaje que el producto se agregará pero el inventario quedará en negativo
		$producto = $this->Precio_Model->Trear_Existencia_Producto($codigoproducto);
		if ($cantidad > $producto->existencia) {//si la cantidad ingresada es mayor a la existencia del producto se agrega un mensaje
			$mensaje_producto_sin_inventario = "La cantidad solicitada: ".$cantidad." del producto: ".$producto->nombre." ".$producto->descripcion." no est&aacute; disponible, mas sin embargo, se a agregar&aacute; a la factura y el inventario quedar&aacute; negativo.";
		}
		
		//asigno el carro a la variable $carrito
		$carrito = $this->session->get("carrito");
		//se valida para ver si existe el producto que siemrpe tiene que existir de lo contrario no hará nada
		if (array_key_exists($codigoproducto, $carrito)) {
			// Actualizar la cantidad y el precio del producto
			$carrito[$codigoproducto]["cantidad"] = $cantidad;
			$carrito[$codigoproducto]["precio"] = $precio;
			// Recalcular el subtotal del producto
			$carrito[$codigoproducto]["subtotal"] = str_replace(",", "", number_format(($cantidad * $precio), 3));
		}
		// Actualizar el carrito de compras en la sesión
		$this->session->set("carrito", $carrito);
		
		if($mensaje_producto_sin_inventario != ""){
			$mensaje = $mensaje_producto_sin_inventario;
			$clase_css = "alert alert-warning alert-dismissible ";
			$tipo_alertify = "warning"; //par ver que tipo de alertifi se muestra al cliente
		}
		else{
			$mensaje ="Producto actualizado.";
			$clase_css = "alert alert-success alert-dismissible ";
			$tipo_alertify = "success"; //par ver que tipo de alertifi se muestra al cliente
		}
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
		$respuesta = get_respuesta(1, $mensaje, $clase_css, array("tipo_alertify"=>$tipo_alertify));
		/*
		$respuesta = array(
				"respuesta" => 1,
				"mensaje" => $mensaje,
				"clase_css" => $clase_css,
				"span_producto_id"=>$codigoproducto
			);
			*/
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
		$respuesta = array(
			"respuesta"=>1,
			"mensaje"=>"Se han eliminado todos los productos agregados a la factura.",
			"clase_css"=>"alert alert-success alert-dismissible "
		);
		return json_encode($respuesta);
	}
	public function Guardar_Pre_Venta(){
		
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Pre-Facturacion
		
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
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		//valido si hay productos en el carrito
		if(count(session("carrito")) <= 0){
			$respuesta = array(
				"respuesta" => 0,
				"mensaje" => "Deben de haber productos en la factura",
				"clase_css" => "alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
		
		$id_cliente 		= $this->request->getPost("id_cliente");
		$cli_cliente_buscar = $this->request->getPost("cli_cliente_buscar");
		$cli_nombre				= $this->request->getPost("cli_nombre");		
		$id_cotizacion				= $this->request->getPost("id_cotizacion");
		$fac_fecha_creacion 		= date('Y-m-d H:i:s'); // fecha actual
		
		$Gran_Total = 0;
		foreach(session("carrito") as $Producto_En_El_Carrito){
			$Gran_Total = $Gran_Total + $Producto_En_El_Carrito["subtotal"];
		}
		$fac_factura = array(
			"fac_fecha_creacion"=> $fac_fecha_creacion,
			"fac_nombre_cliente"=> $cli_nombre,
			"codigousuario"=> session("codigousuario"),
			"fac_total"=> $Gran_Total,
			"id_cliente"=> $id_cliente,
			"id_cotizacion"=>$id_cotizacion
		);
		  
		$Guardar_Pre_Venta = $this->Ventas_Model->Guardar_Pre_Venta($fac_factura);
		//print_r($Guardar_Pre_Venta); return;
		if(!$Guardar_Pre_Venta){
			$respuesta = array(
				"respuesta" => 0,
				"mensaje" => "No se ha podido guardar el registro",
				"clase_css" => "alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
		//hubo exito
		//lipio el corrito 
		$this->Limpiar_Carrito();
		$respuesta = array(
				"respuesta" => 1,
				"mensaje" => "Dato almacenado",
				"clase_css" => "alert alert-success alert-dismissible "
			);
		return json_encode($respuesta);	
	}
	function Ver_Si_Factura_Se_Ha_Procesado($id_factura){
		//verifico si la factuar aún no se ha facturado
		
		$columnas = "count(id_factura) as REGISTRO_ELIMINADO, id_factura, fac_estado ";
		$where = array("id_factura" => $id_factura); 
		
		$Ver_Si_Factura_Se_Ha_Procesado = $this->Model_Select->Select_Data("fac_factura", $columnas, $where);
		
			//si la factura tiene estado 0, que permita modificar, eliminar y cobrar, de lo contrario que no haga nada y que lo redirija a la bandeja de fac_factura
			$factura_procesada_o_no = 1;
			if($Ver_Si_Factura_Se_Ha_Procesado[0]->fac_estado == 0){
				$factura_procesada_o_no = 0;
			}
			//si el registro ha sido eliminado que lo redirija a la bandeja de facturacion tambien
			if($Ver_Si_Factura_Se_Ha_Procesado[0]->REGISTRO_ELIMINADO == 0){
				$factura_procesada_o_no = 1;
			}
		return $factura_procesada_o_no;
	}
	public function Guardar_Venta(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, 'agregar');//Pre-Facturacion
		$rules = array(
			"id_factura" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} de la factura es requerido"
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		$id_factura 		= $this->request->getPost("id_factura");
		$fac_fecha_creacion 		= date('Y-m-d H:i:s'); // fecha actual
		//verifico si la factura fue procesada
		$factura_procesada_o_no = $this->Ver_Si_Factura_Se_Ha_Procesado($id_factura);
		//si la factura en el estado tiene 1 significa que ya ha sido procesa
		if($factura_procesada_o_no == 1){
			$respuesta = array(
				"respuesta" => 0,
				"mensaje" => "El registro ya fue facturado o no está disponible.",
				"clase_css" => "alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
		
		$datos = array(
			"id_factura"=>$id_factura,
			"fac_fecha_creacion"=>$fac_fecha_creacion
		);
		
		$Guardar_Venta = $this->Ventas_Model->Guardar_Venta($datos);
		//print_r($Guardar_Venta); return;
		if(!$Guardar_Venta){
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
	public function Imprimir_Factura($id_factura){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, "tiene_permiso");//Pre-Facturacion
		
		$tablas = "fac_factura ff 
		inner join fac_factura_detalle ffd on(ffd.id_factura = ff.id_factura)
		inner join productos p on(p.codigoproducto = ffd.codigoproducto)";

		$columnas = "ff.id_factura , ff.fac_fecha_creacion , ff.fac_nombre_cliente , ff.fac_total ,
		p.codigoproducto , p.nombre , p.descripcion ,
		ffd.facde_cantidad , ffd.facde_precio_venta , ffd.facde_subtotal";
		
		$where = array(
			"ff.id_factura"=>$id_factura,
			"ff.fac_estado"=>1
		);
		$mostrar["Numero_Renglones_Factura"] = $this->Numero_Renglones_Factura();
		$mostrar["Traer_Factura_Para_Imprimir"] = $this->Model_Select->Select_Data($tablas, $columnas, $where);
		// Cargar la librería Extras
		$Extras = new \App\Libraries\Extras();
		$mostrar["Extras"] = $Extras;
		// Cargar la librería Numero_A_Letras
		$Numero_A_Letras = new \App\Libraries\Numero_A_Letras();
		$mostrar["Numero_A_Letras"] = $Numero_A_Letras;
		return view("ventas/vista_imprimir_factura", $mostrar);
	}
	public function Modificar_Venta(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, "actualizar");//Pre-Facturacion
		$rules = array(
			"id_factura" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} de la factura es requerido"
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		$id_factura 		= $this->request->getPost("id_factura");
		//verifico si la factura fue procesada
		$factura_procesada_o_no = $this->Ver_Si_Factura_Se_Ha_Procesado($id_factura);
		//si la factura en el estado tiene 1 significa que ya ha sido procesa
		if($factura_procesada_o_no == 1){
			
			$respuesta = get_respuesta(0, 'El registro ya fue facturado o no está disponible.', 'alert alert-danger alert-dismissible');

			return json_encode($respuesta);
		}
		
		//busco la factura
		$tablas = "fac_factura ff 
		inner join fac_factura_detalle ffd on(ffd.id_factura = ff.id_factura)
		inner join productos p on(p.codigoproducto = ffd.codigoproducto)";

		$columnas = "ff.id_factura , ff.fac_fecha_creacion , ff.fac_nombre_cliente , ff.fac_total , ff.id_cliente ,
		p.codigoproducto , p.nombre , p.descripcion ,
		ffd.id_factura_detalle, ffd.facde_cantidad , ffd.facde_precio_venta , ffd.facde_subtotal";
		
		$where = array(
			"ff.id_factura"=>$id_factura,
			"ff.fac_estado"=>0
		);
		$order_by = "ffd.id_factura_detalle asc";
		
		$fac_factura_detalle = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by);
		
		//remuevo la sesion si existe
		$this->session->remove("carrito");
		
		//creo sesion
		$carrito = $this->session->get("carrito");

		// Si el carrito no existe en la sesión, crear un array vacío
		if (!$carrito) {
			$carrito = array();
		}
		//agrego los detalles de la factura al array $carrito
		foreach($fac_factura_detalle as $Registro_Econtrado){
			//agregamos los productos al carrito
			$carrito[$Registro_Econtrado->codigoproducto] = array(
				"codigoproducto" => $Registro_Econtrado->codigoproducto,
				"cantidad" => $Registro_Econtrado->facde_cantidad,
				"producto"=>$Registro_Econtrado->nombre,
				"precio"=>$Registro_Econtrado->facde_precio_venta,
				"subtotal"=>$Registro_Econtrado->facde_subtotal
			);
		}
		
		// Actualizar el carrito de venta agregando el array $carrito  en la sesión carrito
		$this->session->set("carrito", $carrito);
		/*
		* comento eso debido a que si la factura se
		* modifica se elimina y pues hay que llenar otra
		* vez los datos del cliente, menos los detalles de 
		* la factura y se validaba en la vista vista_agregar_venta
		*if(session("fac_factura")){
			echo session("fac_factura")["cli_nombre"]
		*
		*
		*
		//agrego a un arary los datos de la factura y los agrego a una sesion también
		$fac_factura = array(
			"id_factura"=>$fac_factura_detalle[0]->id_factura,
			"id_cliente"=>$fac_factura_detalle[0]->id_cliente,
			"cli_nombre"=>$fac_factura_detalle[0]->fac_nombre_cliente
		);
		//agrego el array $fac_factura al la sesion fac_factura
		$this->session->set("fac_factura", $fac_factura);
		*/
		
		//eliminto la factura original
		$tabla_del = "fac_factura"; 
		$where_fac = array(
			"id_factura"=>$id_factura
		);
		$Eliminar_Factura_Oringinal = $this->Model_Delete->Delete_Data($tabla_del, $where_fac);
		if(!$Eliminar_Factura_Oringinal){
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje, y clase css
		$respuesta = get_respuesta(0, 'Por algún motivo no se puede modificar la factura, consulte con un administrador', 'alert alert-danger alert-dismissible');

		return json_encode($respuesta);
		}
		
		//pas las validadciones
		//envio la respuesta de exito
		$respuesta = get_respuesta(1, '', '');

		return json_encode($respuesta);
	}
	public function Eliminar_Pre_Factura(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(16, "eliminar");//Pre-Facturacion
		$rules = array(
			"id_factura" => array(
				"label" => "ID",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} de la factura es requerido"
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		$id_factura 		= $this->request->getPost("id_factura");
		//verifico si la factura fue procesada
		$factura_procesada_o_no = $this->Ver_Si_Factura_Se_Ha_Procesado($id_factura);
		//si la factura en el estado tiene 1 significa que ya ha sido procesa
		if($factura_procesada_o_no == 1){
			
			$respuesta = get_respuesta(0, 'El registro ya fue facturado o no está disponible.', 'alert alert-danger alert-dismissible');

			return json_encode($respuesta);
		}
		
		//pasa las validacion
		//eliminto la factura original
		$tabla_del = "fac_factura"; 
		$where_fac = array(
			"id_factura"=>$id_factura
		);
		$Eliminar_Factura_Oringinal = $this->Model_Delete->Delete_Data($tabla_del, $where_fac);
		if(!$Eliminar_Factura_Oringinal){
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje, y clase css
		$respuesta = get_respuesta(0, 'Por algún motivo no se puede modificar la factura, consulte con un administrador', 'alert alert-danger alert-dismissible');

		return json_encode($respuesta);
		}
		
		//pas las validadciones
		//envio la respuesta de exito
		$respuesta = get_respuesta(1, 'Se ha eliminado el registro.', '');

		return json_encode($respuesta);
	}
	public function Traer_Detalle_Venta(){
		//verificar si el usuario tiene acceso
		//$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(15, 'tiene_permiso');//Facturas
		
		$id_factura 		= $this->request->getPost("id_factura");
		/*
		*este $estado es para saber si se manda la 
		*peticion desde la vista bandeja de facturas por
		*cobrar que el estado debe ser 0 o de la vista
		*administrar facturas que el estado debe ser 1 de
		*que indica que la factura ha sido procesada
		*/
		$estado 		= $this->request->getPost("estado");
		
		$tablas = "fac_factura ff 
		inner join fac_factura_detalle ffd on(ffd.id_factura = ff.id_factura)
		inner join productos p on(p.codigoproducto = ffd.codigoproducto)";

		$columnas = "ff.id_factura , DATE_FORMAT(ff.fac_fecha_creacion, '%d-%m-%Y') fac_fecha_creacion, ff.fac_nombre_cliente , ff.fac_total ,
		p.codigoproducto , p.nombre , p.descripcion ,
		ffd.facde_cantidad , ffd.facde_precio_venta , ffd.facde_subtotal";
		
		$where = array(
			"ff.id_factura"=>$id_factura,
			"ff.fac_estado"=>$estado
		);
		
		$order_by = "ffd.id_factura_detalle asc";
				
		$mostrar["Traer_Datos"] = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by); 
		
		return view("ventas/vista_resultado_independiente_detalle_venta", $mostrar);
		  
	}
}
