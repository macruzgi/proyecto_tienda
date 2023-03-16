<?php

namespace App\Controllers\Graficos;
use App\Controllers\BaseController;

class Graficos extends BaseController
{
	public function __construct(){
		$this->isLoggedIn();
	
		$this->Model_Select = model("Model_Select");
		date_default_timezone_set('America/El_Salvador');
	}
    public function index()
    {
		//verificar si el usuario tiene acceso
		$this->Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion(19, 'tiene_permiso');//Reportes-Utilidad
        //return view('welcome_message');
		
		//se trae desde un view cell creada en App\Cell\EmpresaInfo.php que trae la informacion de la empresa
		$Datos_Empresa= json_decode(view_cell('\App\Cell\EmpresaInfo::Datos_Empresa') , true);//el valor true es para que el json se convierta en array
			  //print_r($Datos_Empresa);
		
		$tabla = "fac_factura";
		$columnas = "DATE_FORMAT(fac_fecha_creacion, '%W') AS dia_semana, 
		CASE DAYNAME(fac_fecha_creacion)
		WHEN 'Sunday' THEN  'Domingo'
		WHEN 'Monday' THEN	'Lunes'
		WHEN 'Tuesday' THEN	'Martes'
		WHEN 'Wednesday' THEN 'Miércoles'
		WHEN 'Thursday' THEN 'Jueves'
		WHEN 'Friday' THEN	'Viernes'
		WHEN 'Saturday' THEN	'Sábado'
		END AS NOMBRE_DIA_ESPANIOL,
		DATE(fac_fecha_creacion) AS fecha, SUM(fac_total) AS total_ventas";
		
		$where = array(
			"fac_fecha_creacion BETWEEN DATE_ADD(CURDATE(), INTERVAL(1-DAYOFWEEK(CURDATE())) DAY)" =>null,
			"DATE_ADD(CURDATE(), INTERVAL(7-DAYOFWEEK(CURDATE())) DAY)"=>null
		);
		$group_by ="fecha";
		
		$Traer_Ventas_Semana = $this->Model_Select->Select_Data($tabla, $columnas, $where, '', '', '', $group_by);
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
		$respuesta = get_respuesta($Traer_Ventas_Semana,$Datos_Empresa[3]["valor_configuracion"], '');//el[3] indica la posicion de la fila 
		return json_encode($respuesta);
    }
	public function Traer_Ventas_Mes_Por_Vendedor(){
		//se trae desde un view cell creada en App\Cell\EmpresaInfo.php que trae la informacion de la empresa
		$Datos_Empresa= json_decode(view_cell('\App\Cell\EmpresaInfo::Datos_Empresa') , true);//el valor true es para que el json se convierta en array
			  //print_r($Datos_Empresa);
		
		$tabla = "fac_factura ff 
		inner join usuarios u on(u.codigousuario = ff.codigousuario)";
		$columnas = "ff.codigousuario , SUM(ff.fac_total) AS ventas_mes_actual,
		u.nombreusuario ";
		
		$where = array(
			"MONTH(ff.fac_fecha_creacion) = MONTH(NOW())" =>null,
			"YEAR(ff.fac_fecha_creacion) = YEAR(NOW())"=>null
		);
		$group_by ="ff.codigousuario";
		
		$Traer_Ventas_Mes_Por_Vendedor = $this->Model_Select->Select_Data($tabla, $columnas, $where, '', '', '', $group_by);
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
		$respuesta = get_respuesta($Traer_Ventas_Mes_Por_Vendedor,$Datos_Empresa[3]["valor_configuracion"], '');//el[3] indica la posicion de la fila 
		return json_encode($respuesta);
	}
	public function Traer_Top_Cinco_Productos_Mas_Vendido(){
		//no valido el acceso a estas vistas por que en la vista se valida si es administrador el que entra, en decir solo los aministradores tendran acceso a los graficos
		$tabla = "fac_factura_detalle fd
		JOIN productos p ON (fd.codigoproducto = p.codigoproducto)
		JOIN fac_factura f ON (fd.id_factura = f.id_factura)";
		
		$columnas = "p.nombre , SUM(fd.facde_cantidad) AS TOTAL_VENIDOD";
		
		$where = array(
			"YEAR(f.fac_fecha_creacion) = YEAR(CURDATE())" =>null,
			"MONTH(f.fac_fecha_creacion) = MONTH(CURDATE())"=>null
		);
		$group_by ="p.codigoproducto";
		
		$order_by ="TOTAL_VENIDOD DESC";
		
		$limit = 5;
		
		$Traer_Top_Cinco_Productos_Mas_Vendido = $this->Model_Select->Select_Data($tabla, $columnas, $where, $order_by, $limit, "", $group_by);
		//envio la respuesta, la funcion del helper espera valor de la respuesta, mensaje,  clase css y posiblemente otros datos en un array
		$respuesta = get_respuesta(1, $Traer_Top_Cinco_Productos_Mas_Vendido,"", "");//el[3] indica la posicion de la fila 
		return json_encode($respuesta);
		
	}
}
