<?php 
// Archivo: App/View/Cell/EmpresaInfo.php

namespace App\Cell;

use CodeIgniter\View\Cell;

class EmpresaInfo {
	
    public function Datos_Empresa()
    {
		//cargo el modelo
		$Model_Select = model("Model_Select");
        // Obtener los datos de la empresa desde tu modelo, por ejemplo
        $tabla = "ferro_adm_configuraciones fac";
		$columnas = "fac.id_configuracion , fac.valor_configuracion";
		
		$where_in = array(
			"fac.id_configuracion" => array(2,3,4,5,6) 
		);
		
		$Traer_Datos_Empresa = $Model_Select->Select_Data($tabla, $columnas, '', '', '', '', '', $where_in);

        // Cargar una vista parcial con los datos de la empresa o envia datos, en este caso envia datos
		//se envian en json_encode ya que las view cell solo retornan strings
        return json_encode($Traer_Datos_Empresa);
    }
}

?>