<?php 
function get_respuesta($respuesta, $mensaje, $clase_css,$datos_adicionales = array())
{
    return array(
            "respuesta" => $respuesta,
            "mensaje" => $mensaje,
            "clase_css" => $clase_css,
			"datos_adicionales" => $datos_adicionales
        );
}

?>