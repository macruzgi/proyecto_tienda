<?php

namespace App\Controllers\Reportes;
use App\Controllers\BaseController;
//usar la libreria tcpdf
use App\Libraries\Pdftcpdf;
class Reportes extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		$this->Model_Insert = model("Model_Insert");
		$this->Model_Update = model("Model_Update");
		$this->Model_Delete = model("Model_Delete");
		//cargar el helper para la trata de archivos
		helper('filesystem');
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(19, 'tiene_permiso');//Reportes-Utilidad
        //return view('welcome_message');
		
		$mostrar["contenido"] = "reportes/ventas/vista_reporte_utilidad";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
    }
	function Traer_Datos_Empresa(){
		$tabla = "ferro_adm_configuraciones fac";
		$columnas = "fac.id_configuracion , fac.valor_configuracion";
		
		$where_in = array(
			"fac.id_configuracion" => array(2,3,4,5,6) 
		);
		
		$Traer_Datos_Empresa = $this->Model_Select->Select_Data($tabla, $columnas, '', '', '', '', '', $where_in);
		return $Traer_Datos_Empresa;
	}
	public function Reporte_De_Utilidad(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(19, 'tiene_permiso');//Reportes-Utilidad
		
		$rules = array(
			"fecha_desde" => array(
				"label" => "Fecha desde",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es reqerida"
				)
			),
			"fecha_hasta" => array(
				"label" => "Fecha hasta",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida.",
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		$fecha_desde 				= date("Y-m-d", strtotime($this->request->getPost("fecha_desde")));
		$fecha_hasta 				= date("Y-m-d", strtotime($this->request->getPost("fecha_hasta")));
		
		$tablas = "fac_factura ff
		join fac_factura_detalle ffd on (ffd.id_factura = ff.id_factura)";
		
		$columnas = " DATE_FORMAT(ff.fac_fecha_creacion, '%d-%m-%Y') AS fecha,
		SUM(ffd.facde_cantidad * ffd.facde_precio_venta - ffd.facde_cantidad * (
        SELECT det_precio FROM com_compras_detalle
        WHERE codigoproducto = ffd.codigoproducto
        ORDER BY id_detalle_compra DESC LIMIT 1
		)) AS utilidad,
		SUM(ffd.facde_cantidad * (
        SELECT det_precio FROM com_compras_detalle
        WHERE codigoproducto = ffd.codigoproducto
        ORDER BY id_detalle_compra DESC LIMIT 1
		)) AS costo_verdadero,
		SUM(ffd.facde_cantidad * ffd.facde_precio_venta) AS venta_total";
		
		$where = array(
			"DATE(ff.fac_fecha_creacion) >="=>$fecha_desde,
			"DATE(ff.fac_fecha_creacion) <="=>$fecha_hasta
		);
		$group_by ="DATE(ff.fac_fecha_creacion)";
		
		$Reporte_De_Utilidad = $this->Model_Select->Select_Data($tablas, $columnas, $where, '', '', '', $group_by);
		//print_r($Reporte_De_Utilidad);
		//return;
		$Traer_Datos_Empresa = $this->Traer_Datos_Empresa();
		
		$pdf = new Pdftcpdf('P', 'mm', 'Letter', true, 'UTF-8', false);
		$pdf->nombre_empresa =$Traer_Datos_Empresa[0]->valor_configuracion;
		$pdf->direccion=$Traer_Datos_Empresa[1]->valor_configuracion;
		$pdf->telefono =$Traer_Datos_Empresa[2]->valor_configuracion;
		$pdf->logo_empresa =$Traer_Datos_Empresa[4]->valor_configuracion;
		$pdf->moneda =$Traer_Datos_Empresa[3]->valor_configuracion;
		$pdf->tituloReporte ="Costo vrs. Utilidad";
		$pdf->usuario =session("nombreusuario");
		$pdf->SetMargins(10, 25, 10); // Establecer los márgenes (izquierda, arriba, derecha)
		$pdf->AddPage();
		$pdf->SetFont('', '', 8);
		
		$total_costo_verdadero = 0;
		$total_utilidad = 0;
		$total_venta = 0;	
		
		$fecha_desde = date("d-m-Y", strtotime($fecha_desde));
		$fecha_hasta = date("d-m-Y", strtotime($fecha_hasta));
		$tbl ='
		<table border="0" cellpadding="0" cellspacing="0"  width="100%">
		<tr>
			<td style="text-align:right;">Fecha desde: <b>'.$fecha_desde.'</b> hasta: <b>'.$fecha_hasta.'</b></td>
		</tr>
		</table>
		
		<style>
			table {
				border-collapse: collapse;
			}

			td, th {
				border-bottom: 1px solid black;
			}
		</style>
		<table>
			<thead>
				<tr>
					<th style="width:25%; text-align:center;"><b>Fecha</b></th>
					<th  style="width:25%; text-align:center;"><b>Costo</b></th>
					<th  style="width:25%; text-align:center;"><b>Utilidad</b></th>
					<th  style="width:25%; text-align:center;"><b>Venta total

					</b></th>
				</tr>
			</thead>
			<tbody>';
		foreach($Reporte_De_Utilidad as $Dato_Encontrado){
				$total_costo_verdadero = $total_costo_verdadero + $Dato_Encontrado->costo_verdadero;
				$total_utilidad = $total_utilidad + $Dato_Encontrado->utilidad;
				$total_venta = $total_venta + $Dato_Encontrado->venta_total;
				$tbl .='
			<tr>
				<td style="text-align:center;">'.$Dato_Encontrado->fecha.'</td>
				<td style="text-align:right;">'.$Dato_Encontrado->costo_verdadero.' &nbsp;</td>
				<td style="text-align:right;">'.$Dato_Encontrado->utilidad.' &nbsp;</td>
				<td style="text-align:right;">'.$Dato_Encontrado->venta_total.' &nbsp;</td>
			</tr>';
		}
		$tbl .='
		<tr>
			<td style="text-align:center;">TOTALES</td>
			<td style="text-align:right;font-weight: bold;">'.$total_costo_verdadero.' &nbsp;</td>
			<td style="text-align:right;font-weight: bold;">'.$total_utilidad.' &nbsp;</td>
			<td style="text-align:right;font-weight: bold;">'.$total_venta.' &nbsp;</td>
		</tr>
		</table>';
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// Guarda el archivo en la carpeta public/Reportes
		// Crea la ruta del archivo en la carpeta public/Reportes
		$nombre_archivo = 'Reportes/Reporte.pdf';
		$success = write_file($nombre_archivo, $pdf->Output('', 'S'));
					 
		$respuesta = array(
			"respuesta" => 1,
			"pdf_url" =>base_url()."/".$nombre_archivo
		);
		return json_encode($respuesta);
					 
	}
	public function Ventas(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(20, 'tiene_permiso');//Reportes Ventas
        //return view('welcome_message');
		
		//traiog los usuarios para mostrarlos en la vista del reporte
		$tablas = "usuarios u";
		$columnas = "u.codigousuario , u.nombreusuario , u.nombre";
		
		$mostrar["Usuarios"] = $this->Model_Select->Select_Data($tablas, $columnas);
		
		
		$mostrar["contenido"] = "reportes/ventas/vista_reporte_ventas";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Reporte_De_Ventas(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(20, 'tiene_permiso');//Reportes-Utilidad
		
		$rules = array(
			"fecha_desde" => array(
				"label" => "Fecha desde",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es reqerida"
				)
			),
			"fecha_hasta" => array(
				"label" => "Fecha hasta",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida.",
				)
			),
			"codigousuario" => array(
				"label" => "Usuario",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido.",
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		$fecha_desde 				= date("Y-m-d", strtotime($this->request->getPost("fecha_desde")));
		$fecha_hasta 				= date("Y-m-d", strtotime($this->request->getPost("fecha_hasta")));
		$codigousuario				= $this->request->getPost("codigousuario");
		
		//traigo los datos del usuario logueado
		$tbl_usuario = "usuarios u";
		$columnas_usuario ="u.codigousuario , u.nombreusuario, u.id_tipo_usuario, u.nombre";
		$where_usuario = array(
			"u.nombreusuario"=>session("nombreusuario")
		);
		$Usuario = $this->Model_Select->Select_Data($tbl_usuario, $columnas_usuario, $where_usuario);
		//si el usuario no es tipo aministrador (1), solo puede ver sus ventas
		if($Usuario[0]->id_tipo_usuario != 1 and session("codigousuario") != $codigousuario){
			//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
			$respuesta = get_respuesta(0, "No esposible visualizar las ventas de los otros vendedores", "alert alert-danger alert-dismissible");
		
			return json_encode($respuesta);
		}
		
		
		$tablas = "fac_factura ff  
		inner join usuarios u on(u.codigousuario = ff.codigousuario)";
		
		$columnas = "ff.id_factura , DATE_FORMAT(ff.fac_fecha_creacion, '%d-%m-%Y %H:%i:%s') fac_fecha_creacion, ff.fac_total  , u.nombreusuario ";
		
		$where = array(
			"DATE(ff.fac_fecha_creacion) >="=>$fecha_desde,
			"DATE(ff.fac_fecha_creacion) <="=>$fecha_hasta
		);
		$nombre_del_usaurio ="TODOS";
		//si el usaurio no es TODOS que agregue un filtro mas
		if($codigousuario != "TODOS"){
			$where["ff.codigousuario"] = $codigousuario;
			$nombre_del_usaurio =$Usuario[0]->nombre;
		} 
		$order_by ="ff.id_factura asc";
		
		$Datos_Para_El_Reporte = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by);
		
		$Traer_Datos_Empresa = $this->Traer_Datos_Empresa();
		
		$pdf = new Pdftcpdf('P', 'mm', 'Letter', true, 'UTF-8', false);
		$pdf->nombre_empresa =$Traer_Datos_Empresa[0]->valor_configuracion;
		$pdf->direccion=$Traer_Datos_Empresa[1]->valor_configuracion;
		$pdf->telefono =$Traer_Datos_Empresa[2]->valor_configuracion;
		$pdf->logo_empresa =$Traer_Datos_Empresa[4]->valor_configuracion;
		$pdf->moneda =$Traer_Datos_Empresa[3]->valor_configuracion;
		$pdf->tituloReporte ="Reporte de Ventas";
		$pdf->usuario =session("nombreusuario");
		$pdf->SetMargins(10, 25, 10); // Establecer los márgenes (izquierda, arriba, derecha)
		$pdf->AddPage();
		$pdf->SetFont('', '', 8);
		
		$TOTAL = 0;
		$fecha_desde = date("d-m-Y", strtotime($fecha_desde));
		$fecha_hasta = date("d-m-Y", strtotime($fecha_hasta));
		$tbl ='
		<table border="0" cellpadding="0" cellspacing="0"  width="100%">
		<tr>
			<td>Cajero: <b>'.$nombre_del_usaurio.'</b></td>
			<td style="text-align:right;">Fecha desde: <b>'.$fecha_desde.'</b> hasta: <b>'.$fecha_hasta.'</b></td>
		</tr>
		</table>
		<style>
			table {
				border-collapse: collapse;
			}

			td, th {
				border-bottom: 1px solid black;
			}
		</style>
		<table>
			<thead>
				<tr>
					<th style="width:33.33%; text-align:center;"><b>Número de factura</b></th>
					<th  style="width:33.33%; text-align:center;"><b>Fecha y hora</b></th>
					<th  style="width:33.33%; text-align:center;"><b>Total</b></th>
				</tr>
			</thead>
			<tbody>';
			foreach($Datos_Para_El_Reporte as $Dato_Encontrado){
				$TOTAL = $TOTAL + $Dato_Encontrado->fac_total;

				$tbl .='
					<tr>
					<td style="text-align:center;">'.$Dato_Encontrado->id_factura.'</td>
					<td style="text-align:center;">'.$Dato_Encontrado->fac_fecha_creacion .'&nbsp;</td>
					<td style="text-align:right;">'.$Dato_Encontrado->fac_total.' &nbsp;</td>
					</tr>';
			}
		$tbl .='
		<tr>
			<td style="text-align:center;" colspan="2">TOTAL</td>
			<td style="text-align:right;font-weight: bold;">'.$TOTAL.' &nbsp;</td>
		</tr>
		</table>
		</tbody>';
	
		$pdf->writeHTML($tbl, true, false, false, false, '');
		// Guarda el archivo en la carpeta public/Reportes
		// Crea la ruta del archivo en la carpeta public/Reportes
		$nombre_archivo = 'Reportes/Reporte.pdf';
		$success = write_file($nombre_archivo, $pdf->Output('', 'S'));
					 
		$respuesta = array(
			"respuesta" => 1,
			"pdf_url" =>base_url()."/".$nombre_archivo
		);
		return json_encode($respuesta);
					 
	}
	public function Productos(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(21, 'tiene_permiso');//Reportes Productos
		
		//traigo las categorías de los productos
		$tablas = "prod_tipos pt";
		$columnas = " pt.id_tipo_producto , pt.tipo_nombre";
		$order_by = "tipo_nombre asc";
		
		$mostrar["Categorias"] = $this->Model_Select->Select_Data($tablas, $columnas,  '', $order_by);
		
		//contenido tendra la vista 
		$mostrar["contenido"] = "reportes/productos/vista_reporte_productos";
		return view("plantilla", $mostrar);
	}
	public function Reporte_De_Productos(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(21, 'tiene_permiso');//Reportes-Productos
		
		$rules = array(
			"con_existencias" => array(
				"label" => "Tipo de reporte",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es reqerido"
				)
			),
			"id_tipo_producto" => array(
				"label" => "Categoría",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida.",
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		$con_existencias				= $this->request->getPost("con_existencias");
		$id_tipo_producto				= $this->request->getPost("id_tipo_producto");
		
		$tablas = "inv_kardex ik 
		inner join productos p on(p.codigoproducto = ik.codigoproducto)
		inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad)
		inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto)";
		
		$columnas = "ik.codigoproducto, SUM(ik.kar_saldo) AS existencia,
		p.prod_codigo , p.nombre , p.descripcion, ptu.tipo_unidad_nombre, pt.tipo_nombre";
		
		$where = "";
		if($id_tipo_producto != "TODAS"){
			$where = array(
				"p.id_tipo_producto"=>$id_tipo_producto
			);
		}
		$group_by = "ik.codigoproducto";
		$having ="existencia <= 0";
		
		$con_sin_existencia = "SIN existencias";
		//si si se marca el radio con existencias
		if($con_existencias =="existencia"){
			$having ="existencia >= 0";
			$con_sin_existencia = "CON existencias";
		}
		
		$order_by ="p.nombre asc";
		$columna_existenica_o_fisico ="Existencias";
		//si si se marca el radio con listado
		if($con_existencias =="listado"){
			$columna_existenica_o_fisico = "Existencia en físico";
			$con_sin_existencia = " Listado";
			$tablas = "productos p inner join prod_tipos pt ON (pt.id_tipo_producto = p.id_tipo_producto )
			inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad )";
			
			$columnas ="p.prod_codigo, p.nombre, pt.tipo_nombre, ptu.tipo_unidad_nombre, 0 as existencia ";
			$order_by ="p.nombre asc";
			$group_by ="";
			$having ="";
			
		} 
		
		//si si se marca el radio sin inventario
		if($con_existencias =="sin_kardex"){
			$columna_existenica_o_fisico = "Sin kardex";
			$con_sin_existencia = " sin inventario (kardex)";
			$tablas = "productos p inner join prod_tipos pt ON (pt.id_tipo_producto = p.id_tipo_producto )
			inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad )";
			
			$columnas ="p.prod_codigo, p.nombre, pt.tipo_nombre, ptu.tipo_unidad_nombre, 0 as existencia ";
			$where = array(
				"p.codigoproducto not in(select codigoproducto from inv_kardex ik)"=>null
			);
			if($id_tipo_producto != "TODAS"){
				$where["p.id_tipo_producto"] = $id_tipo_producto;
			}
			$order_by ="p.nombre asc";
			$group_by ="";
			$having ="";
			
		} 
		
		$Datos_Para_El_Reporte = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by, '', '', $group_by, '', $having);
		//print_r($Datos_Para_El_Reporte); return;
		$Traer_Datos_Empresa = $this->Traer_Datos_Empresa();
		
		
		
		$pdf = new Pdftcpdf('P', 'mm', 'Letter', true, 'UTF-8', false);
		$pdf->nombre_empresa =$Traer_Datos_Empresa[0]->valor_configuracion;
		$pdf->direccion=$Traer_Datos_Empresa[1]->valor_configuracion;
		$pdf->telefono =$Traer_Datos_Empresa[2]->valor_configuracion;
		$pdf->logo_empresa =$Traer_Datos_Empresa[4]->valor_configuracion;
		//$pdf->moneda =$Traer_Datos_Empresa[3]->valor_configuracion;
		$pdf->tituloReporte ="Reporte de Productos ".$con_sin_existencia;
		$pdf->usuario =session("nombreusuario");
		$pdf->SetMargins(10, 25, 10); // Establecer los márgenes (izquierda, arriba, derecha)
		$pdf->AddPage();
		
		//$pdf->SetY(30);
		$pdf->SetFont('', '', 8);
		//$pdf->SetMargins(10, 20, 10, true);
		$TOTAL_EXISTENCIA = 0;

		// Establecer la posición inicial de la tabla
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		// Crear la estructura de la tabla con HTML
		$html = '
		<style>
			table {
				border-collapse: collapse;
			}

			td, th {
				border-bottom: 1px solid black;
			}
		</style>
		<table>
					<thead>
					<tr>
						<th style="text-align:center;font-weight: bold;">Código</th>
						<th style="text-align:center;font-weight: bold;">Producto</th>
						<th style="text-align:center;font-weight: bold;">Categoría</th>
						<th style="text-align:center;font-weight: bold;">Medida</th>
						<th style="text-align:center;font-weight: bold;">'.$columna_existenica_o_fisico.'</th>
					</tr>
				</thead>
				<tbody>';
		
		foreach ($Datos_Para_El_Reporte as $Dato_Encontrado) {
			$TOTAL_EXISTENCIA = $TOTAL_EXISTENCIA + $Dato_Encontrado->existencia;
			if($con_existencias =="listado" || $con_existencias =="sin_kardex"){
				$valor_segun_reporte = "";
			}			
			else{
				$valor_segun_reporte = $Dato_Encontrado->existencia;
			}
			$html .= '<tr>
						<td>' . $Dato_Encontrado->prod_codigo . '</td>
						<td>' . $Dato_Encontrado->nombre . '</td>
						<td style="text-align:center;">' . $Dato_Encontrado->tipo_nombre . '</td>
						<td style="text-align:center;">' . $Dato_Encontrado->tipo_unidad_nombre . '</td>
						<td style="text-align:right;">' . $valor_segun_reporte . ' &nbsp;</td>
					</tr>';
								  
		}

		$html .= '</tbody></table>';

		$pdf->writeHTML($html, true, false, false, false, '');

		// Establecer la posición para escribir el total
		$pdf->SetXY($x, $pdf->GetY() + 10);
		$pdf->Cell(60, 10, 'TOTAL EXISTENCIAS:', 1, 0, 'R');
		$pdf->Cell(30, 10, number_format($TOTAL_EXISTENCIA, 2), 1, 0, 'R');				
		// Guarda el archivo en la carpeta public/Reportes
		// Crea la ruta del archivo en la carpeta public/Reportes
		$nombre_archivo = 'Reportes/Reporte.pdf';
		$success = write_file($nombre_archivo, $pdf->Output('', 'S'));
		$respuesta = array(
			"respuesta" => 1,
			"pdf_url" =>base_url()."/".$nombre_archivo
		);
		return json_encode($respuesta);
					 
	}
	public function Kardex(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(23, 'tiene_permiso');//Reportes Kardex
        //return view('welcome_message');
		
				
		$mostrar["contenido"] = "reportes/productos/vista_reporte_kardex";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Reporte_De_Kardex(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(23, 'tiene_permiso');//Reportes-Kardex
		
		$rules = array(
			"fecha_desde" => array(
				"label" => "Fecha desde",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es reqerida"
				)
			),
			"fecha_hasta" => array(
				"label" => "Fecha hasta",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es requerida.",
				)
			),
			"buscar_producto_reporte_kardex" => array(
				"label" => "Procucto",
				"rules" => "required",
				"errors" => array(
					"required" => "El {field} es requerido.",
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		$fecha_desde 				= date("Y-m-d", strtotime($this->request->getPost("fecha_desde")));
		$fecha_hasta 				= date("Y-m-d", strtotime($this->request->getPost("fecha_hasta")));
		$codigoproducto				= $this->request->getPost("buscar_producto_reporte_kardex");
		
		$tablas = "inv_kardex ik
		inner join productos p on(p.codigoproducto = ik.codigoproducto)";
		
		$columnas = "DATE_FORMAT(kar_fecha_creacion  , '%d-%m-%Y') AS fecha, 
		case ik.kar_tipo_transaccion
		when 1 then 'Compra'
		when 2 then 'Venta'
		when 3 then 'Entrada al inventario'
		when 4 then 'Salida del inventario' 
		end AS tipo, 
		ik.kar_numero_documento AS numero, 
		ik.kar_cantidad AS cantidad,  
		ik.kar_saldo AS saldo, ik.codigoproducto, p.nombre";
		
		$where = array(
			"ik.codigoproducto"=>$codigoproducto,
			"DATE(ik.kar_fecha_creacion) >="=>$fecha_desde,
			"DATE(ik.kar_fecha_creacion) <="=>$fecha_hasta
			
		);
		
		$order_by ="ik.kar_fecha_creacion  ASC";
		
		$Datos_Para_El_Reporte = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by);
		if(!$Datos_Para_El_Reporte){
			//no se encontraron registro para esa feha
			
			//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
			$respuesta = get_respuesta(0, "No hay registro para mostrar", "alert alert-danger alert-dismissible");
		
			return json_encode($respuesta);
		}
		//print_r($Datos_Para_El_Reporte); return;
		$Traer_Datos_Empresa = $this->Traer_Datos_Empresa();
		
		
		$pdf = new Pdftcpdf('P', 'mm', 'Letter', true, 'UTF-8', false);
		$pdf->nombre_empresa =$Traer_Datos_Empresa[0]->valor_configuracion;
		$pdf->direccion=$Traer_Datos_Empresa[1]->valor_configuracion;
		$pdf->telefono =$Traer_Datos_Empresa[2]->valor_configuracion;
		$pdf->logo_empresa =$Traer_Datos_Empresa[4]->valor_configuracion;
		//$pdf->moneda =$Traer_Datos_Empresa[3]->valor_configuracion;
		$pdf->tituloReporte ="Reporte de Kardex";
		$pdf->usuario =session("nombreusuario");
		$pdf->SetMargins(10, 25, 10); // Establecer los márgenes (izquierda, arriba, derecha)
		$pdf->AddPage();
		
		//$pdf->SetY(30);
		$pdf->SetFont('', '', 8);
		//$pdf->SetMargins(10, 20, 10, true);
		

		
		$fecha_desde = date("d-m-Y", strtotime($fecha_desde));
		$fecha_hasta = date("d-m-Y", strtotime($fecha_hasta));
		
		// Crear la estructura de la tabla con HTML
		$html = '
		<table border="0" cellpadding="0" cellspacing="0"  width="100%">
		<tr>
			<td>Producto: <b>('.$Datos_Para_El_Reporte[0]->codigoproducto.') '. $Datos_Para_El_Reporte[0]->nombre.'</b></td>
			<td style="text-align:right;">Fecha desde: <b>'.$fecha_desde.'</b> hasta: <b>'.$fecha_hasta.'</b></td>
		</tr>
		</table>
		<style>
			table {
				border-collapse: collapse;
			}

			td, th {
				border-bottom: 1px solid black;
			}
		</style>
		<table>
					<thead>
					<tr>
						<th style="text-align:center;font-weight: bold;">Fecha</th>
						<th style="text-align:center;font-weight: bold;">Tipo transación</th>
						<th style="text-align:center;font-weight: bold;">Número de documento</th>
						<th style="text-align:center;font-weight: bold;">Cantidad</th>
						<th style="text-align:center;font-weight: bold;">Saldo</th>
					</tr>
				</thead>
				<tbody>';
		
		foreach ($Datos_Para_El_Reporte as $Dato_Encontrado) {
			
			$html .= '<tr>
						<td style="text-align:center;">' . $Dato_Encontrado->fecha . '</td>
						<td>' . $Dato_Encontrado->tipo . '</td>
						<td>' . $Dato_Encontrado->numero . '</td>
						<td style="text-align:right;">' . $Dato_Encontrado->cantidad . '</td>
						<td style="text-align:right;">' . $Dato_Encontrado->saldo . ' &nbsp;</td>
					</tr>';
								  
		}

		$html .= '</tbody></table>';

		$pdf->writeHTML($html, true, false, false, false, '');

					
		// Guarda el archivo en la carpeta public/Reportes
		// Crea la ruta del archivo en la carpeta public/Reportes
		$nombre_archivo = 'Reportes/Reporte.pdf';
		$success = write_file($nombre_archivo, $pdf->Output('', 'S'));
		$respuesta = array(
			"respuesta" => 1,
			"pdf_url" =>base_url()."/".$nombre_archivo
		);
		return json_encode($respuesta);
					 
	}
	public function Precios(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(25, 'tiene_permiso');//Reportes Precios
        //return view('welcome_message');
		
		//traigo las categorías de los productos
		$tablas = "prod_tipos pt";
		$columnas = " pt.id_tipo_producto , pt.tipo_nombre";
		$order_by = "tipo_nombre asc";
		
		$mostrar["Categorias"] = $this->Model_Select->Select_Data($tablas, $columnas,  '', $order_by);
		
		
		$mostrar["contenido"] = "reportes/productos/vista_reporte_precios";//contenido tendra la vista php vista_inicio
		return view("plantilla", $mostrar);
	}
	public function Reporte_Precios(){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(25, 'tiene_permiso');//Reportes-Precios
		
		$rules = array(
			"id_tipo_producto" => array(
				"label" => "Categoría",
				"rules" => "required",
				"errors" => array(
					"required" => "La {field} es reqerida"
				)
			)
		);
		if($this->Validar_Campos($rules, '')){//el segundo parámetro no es necesario
		  return ( $this->Validar_Campos($rules, ''));
		}
		
		$id_tipo_producto 				= $this->request->getPost("id_tipo_producto");
	
		$tablas = "productos p
		JOIN (
		  SELECT codigoproducto, MAX(pp.pre_fecha_creacion) AS ult_fecha
		  FROM prod_precios pp 
		  GROUP BY codigoproducto
		) AS pvm ON pvm.codigoproducto = p.codigoproducto
		JOIN prod_precios pv ON (pv.codigoproducto = pvm.codigoproducto AND pv.pre_fecha_creacion  = pvm.ult_fecha)
		inner join prod_tipos pt ON (pt.id_tipo_producto = p.id_tipo_producto)";
		
		$columnas = "p.prod_codigo ,p.nombre , p.descripcion, pv.pre_precio, pt.tipo_nombre";
		
		$where ="";
		if($id_tipo_producto !="TODAS"){
			$where = array(
				"p.id_tipo_producto"=>$id_tipo_producto
				
			);
		}
		
		$order_by ="p.nombre asc";
		
		$Datos_Para_El_Reporte = $this->Model_Select->Select_Data($tablas, $columnas, $where, $order_by);
		//print_r($Datos_Para_El_Reporte); return;
		$Traer_Datos_Empresa = $this->Traer_Datos_Empresa();
		
		
		$pdf = new Pdftcpdf('P', 'mm', 'Letter', true, 'UTF-8', false);
		$pdf->nombre_empresa =$Traer_Datos_Empresa[0]->valor_configuracion;
		$pdf->direccion=$Traer_Datos_Empresa[1]->valor_configuracion;
		$pdf->telefono =$Traer_Datos_Empresa[2]->valor_configuracion;
		$pdf->logo_empresa =$Traer_Datos_Empresa[4]->valor_configuracion;
		$pdf->moneda =$Traer_Datos_Empresa[3]->valor_configuracion;
		$pdf->tituloReporte ="Reporte de Kardex";
		$pdf->usuario =session("nombreusuario");
		$pdf->SetMargins(10, 25, 10); // Establecer los márgenes (izquierda, arriba, derecha)
		$pdf->AddPage();
		
		//$pdf->SetY(30);
		$pdf->SetFont('', '', 8);
		//$pdf->SetMargins(10, 20, 10, true);
	
		// Crear la estructura de la tabla con HTML
		
		$html = '
		
		<style>
			table {
				border-collapse: collapse;
			}

			td, th {
				border-bottom: 1px solid black;
			}
		</style>
		<table>
					<thead>
					<tr>
						<th style="text-align:center;font-weight: bold; width:50%;">Producto</th>
						<th style="text-align:left;font-weight: bold;width:25%;">Categoría</th>
						<th style="text-align:center;font-weight: bold;width:25%;">Precio de venta</th>
					</tr>
				</thead>
				<tbody>';
		
		foreach ($Datos_Para_El_Reporte as $Dato_Encontrado) {
			
			$html .= '<tr>
						<td style="width:50%;">(' . $Dato_Encontrado->prod_codigo . ') '.$Dato_Encontrado->nombre.'</td>
						<td style="width:25%;">' . $Dato_Encontrado->tipo_nombre . '</td>
						<td style="text-align:right;width:25%;">' . $Dato_Encontrado->pre_precio . ' &nbsp;</td>
						
					</tr>';
								  
		}

		$html .= '</tbody></table>';

		$pdf->writeHTML($html, true, false, false, false, '');

					
		// Guarda el archivo en la carpeta public/Reportes
		// Crea la ruta del archivo en la carpeta public/Reportes
		$nombre_archivo = 'Reportes/Reporte.pdf';
		$success = write_file($nombre_archivo, $pdf->Output('', 'S'));
		$respuesta = array(
			"respuesta" => 1,
			"pdf_url" =>base_url()."/".$nombre_archivo
		);
		return json_encode($respuesta);
					 
	}
	public function Re_Imprimir_Cotizacion($id_cotizacion){
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(1, 'tiene_permiso'); //1 es Cotizaciones
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
		
		$Datos_Para_El_Reporte = $this->Model_Select->Select_Data($tabla, $columnas, $where, $oder_by);
		
		//print_r($Datos_Para_El_Reporte); return;
		$Traer_Datos_Empresa = $this->Traer_Datos_Empresa();
		
		
		$pdf = new Pdftcpdf('P', 'mm', 'Letter', true, 'UTF-8', false);
		$pdf->nombre_empresa =$Traer_Datos_Empresa[0]->valor_configuracion;
		$pdf->direccion=$Traer_Datos_Empresa[1]->valor_configuracion;
		$pdf->telefono =$Traer_Datos_Empresa[2]->valor_configuracion;
		$pdf->logo_empresa =$Traer_Datos_Empresa[4]->valor_configuracion;
		$pdf->moneda =$Traer_Datos_Empresa[3]->valor_configuracion;
		$pdf->tituloReporte ="Cotización";
		$pdf->usuario =session("nombreusuario");
		$pdf->SetMargins(10, 25, 10); // Establecer los márgenes (izquierda, arriba, derecha)
		$pdf->AddPage();
		
		//$pdf->SetY(30);
		$pdf->SetFont('', '', 8);
				
		
		// Crear la estructura de la tabla con HTML
		$html = '
		<table border="0" cellpadding="0" cellspacing="0"  width="100%">
		<tr>
			<td>Cotización No. <b>'.$Datos_Para_El_Reporte[0]->numero_cotizacion.'</b></td>
			<td style="text-align:right;">Cliente: <b>'.$Datos_Para_El_Reporte[0]->nombre_cliente.'</b> Fecha: <b>'.$Datos_Para_El_Reporte[0]->fecha.'</b> Fecha de actualización: '.$Datos_Para_El_Reporte[0]->fecha_ultima_modificacion.'</td>
		</tr>
		<tr>
			<td colspan="2">Términos y condiciones: '.$Datos_Para_El_Reporte[0]->terminos_condiciones.'</td>
		</tr>
		</table>
		<style>
			table {
				border-collapse: collapse;
			}

			td, th {
				border-bottom: 1px solid black;
			}
		</style>
		<table>
					<thead>
					<tr>
						<th style="text-align:center;font-weight: bold;">Cantidad</th>
						<th style="text-align:center;font-weight: bold;">Producto</th>
						<th style="text-align:center;font-weight: bold;">Precio</th>
						<th style="text-align:center;font-weight: bold;">Sub-total</th>
					</tr>
				</thead>
				<tbody>';
		
		foreach ($Datos_Para_El_Reporte as $Dato_Encontrado) {
			
			$html .= '<tr>
						<td style="text-align:center;">' . $Dato_Encontrado->cantidad . '</td>
						<td>' . $Dato_Encontrado->nombre . '</td>
						<td style="text-align:right;">' . $Dato_Encontrado->precio_venta . '</td>
						<td style="text-align:right;">' . $Dato_Encontrado->subtotal . '</td>
					</tr>';
								  
		}
		$html .='<tr>
					<td colspan="3" style="text-align:right;">Total $</td>
					<td style="text-align:right;"><b>' . $Dato_Encontrado->subtotal . '</b></td>
				</tr>';
		$html .= '</tbody></table>';

		$pdf->writeHTML($html, true, false, false, false, '');

					
		// Guarda el archivo en la carpeta public/Reportes
		// Crea la ruta del archivo en la carpeta public/Reportes
		$nombre_archivo = 'Reportes/Reporte.pdf';
		$success = write_file($nombre_archivo, $pdf->Output('', 'I'));
		exit();
		
						 
	}
	
}
