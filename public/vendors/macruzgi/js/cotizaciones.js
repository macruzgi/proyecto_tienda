$(document).ready(function(){
	/*
*buscar cotizacion
*
*/
$('#nombre_numero_cotizacion').on('keyup', function(){
      if($('#nombre_numero_cotizacion').val() ==''){
		  $('#tbl_productos').show();
		  $('#tbl_cotizaciones').hide();
		  return;
	  }
        $.ajax({
            url: baseUrl +'/Ventas/Traer_Cotizaciones',
            type: 'POST',
            data: {nombre_numero_cotizacion:$('#nombre_numero_cotizacion').val()},
            dataType: 'json',
            success: function(data){
				//alert(tml.codigoproducto);
                //$('#tabla').html(tml);
				$('#tbl_productos').hide();
				$('#tbl_cotizaciones tbody').empty();
				$('#tbl_cotizaciones').show();
				$.each(data, function(i, datos_iterados){
					$('#tbl_cotizaciones tbody').append('<tr><td>'+datos_iterados.numero_cotizacion+'</td><td>'+datos_iterados.fecha+'</td><td>'+datos_iterados.fecha_ultima_modificacion+'</td><td>'+datos_iterados.nombre_cliente+'</td><td>'+datos_iterados.terminos_condiciones+'</td><td style="text-align:right;">'+datos_iterados.costo+'</td><td style="width:16%;text-align:center;"><a href="#" onclick="Cargar_Cotizacion('+datos_iterados.id_cotizacion+');  event.preventDefault();"><img src="'+baseUrl+'/images/lista.png" class="imagen_procesar_cotizacion" title="Procesar Cotizaci&oacute;n" id="agregar_producto" style="width:27%;"></a></td></tr>');	
				})
                
            }
        });
        
    }) 
});
function Eliminar_Cotizacion(id_cotizacion){
alertify.defaults.glossary.title ='Eliminar cotización';
alertify.defaults.glossary.ok = 'Sí';
alertify.defaults.glossary.cancel = 'Cancelar';

alertify.confirm('¿Está seguro/a de eliminar la cotización?',
  function(){
	  $.ajax({ 
            url: baseUrl+'/Eliminar_Cotizacion',
            type: 'POST',
            data: {id_cotizacion:id_cotizacion},
            dataType: 'json',//espero como respuesta un json
			beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
            success: function(respuesta){
				if(respuesta.respuesta==1){
					alertify.success(respuesta.mensaje);
					
					//si fue exito recargo
					setTimeout(function() {
						location.reload();
					},900);
				}
				else{
					alertify.error(respuesta.mensaje);
				}
            },
			complete: function() {
					// Oculta el overlay después de completar la petición
					$('#overlay').hide();
				}
        });
    
  },
  function(){
    alertify.error('Se canceló el proceso');
  }).set('defaultFocus', 'cancel'); ;
}
function Cargar_Cotizacion(id_cotizacion){
	alertify.defaults.glossary.title ='Cargar cotización';
alertify.defaults.glossary.ok = 'Sí';
alertify.defaults.glossary.cancel = 'Cancelar';
alertify.confirm('¿Está seguro/a de cargar la cotización?',
  function(){
	  $.ajax({ 
            url: baseUrl+'/Cargar_Cotizacion',
            type: 'POST',
            data: {id_cotizacion:id_cotizacion},
            dataType: 'json',
            success: function(respuesta){
				if(respuesta.respuesta==1){
					Mostar_Productos_En_El_Carrito();
					$('#tbl_cotizaciones').hide();
					//lleno los datos de cliente factura
					$('#cli_cliente_buscar').val(respuesta.datos_adicionales.datos_cotizacion.cli_codigo);
					$('#id_cliente').val(respuesta.datos_adicionales.datos_cotizacion.id_cliente);
					$('#cli_nombre').val(respuesta.datos_adicionales.datos_cotizacion.nombre_cliente);
					
					$('#id_cotizacion').val(id_cotizacion);
					$('#terminos_condiciones').val(respuesta.datos_adicionales.datos_cotizacion.terminos_condiciones);
					$('#nombre_numero_cotizacion').val(respuesta.datos_adicionales.datos_cotizacion.numero_cotizacion + ' ' +respuesta.datos_adicionales.datos_cotizacion.nombre_cliente);
					alertify.success(respuesta.mensaje);
				}
				else{
					alertify.error(respuesta.mensaje);
					
				}
            }
        });
    
  },
  function(){
    alertify.error('Se canceló el proceso');
  });
}
/*
*valido el formulario de agregar la cotizacion
*/
$('#frm_nueva_venta').validate({
    rules:{
				//nombre_numero_cotizacion:{required:true},
				//id_cotizacion:{required:true},
				cli_cliente_buscar:{required:true},
				id_cliente:{required:true},
				cli_nombre:{required:true},
				terminos_condiciones:{maxlength:150}
			},
			messages:{
				//nombre_numero_cotizacion:{required:'Dato requrido'},
				//id_cotizacion:{required:'Dato requrido'},
				cli_cliente_buscar:{required:'Dato requrido'},
				id_cliente:{required:'Dato requrido'},
				cli_nombre:{required:'Dato requrido'},
				terminos_condiciones:{maxlength:'El máximo de caracteres es {0}'}
			}
});
function Guardar_E_Imprimir_Cotizacion(){
	//valido el formulario
	 if ($('#frm_nueva_venta').valid()){
		$.ajax({
				type:'POST',
				url: baseUrl+ '/Guardar_E_Imprimir_Cotizacion',
				data:$('#frm_nueva_venta').serialize(),
				dataType: 'json',//espero un son de respuesta
				beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
				success:function(datos_esperados){
					
					if(datos_esperados.respuesta == 1){
						//alert('exito');
						//window.location.replace(
						//se cambia para mostrar la cotizacion en pdf y no solo en print
						//window.open(baseUrl + '/Re_Imprimir_Cotizacion/'+datos_esperados.datos_adicionales.id_cotizacion, '_blank');
						window.open(baseUrl + '/Reportes/Re_Imprimir_Cotizacion/'+datos_esperados.datos_adicionales.id_cotizacion, '_blank');
						
						location.reload();
					}
					else if(datos_esperados.respuesta == 0){
						$('#mensaje').empty();//limpio los erores
						$('#mensaje').removeClass()
						$('#mensaje').addClass(datos_esperados.clase_css);
						//agrego los errores
						$('#mensaje').append(datos_esperados.mensaje);
						//muestro el contenido de los errores
						$('#mensaje').show();
						//oculto el mensaje
						 setTimeout(function() {
									$('#mensaje').fadeOut(1500);
									},3000);
					}
					
				},
				complete: function() {
					// Oculta el overlay después de completar la petición
					$('#overlay').hide();
				}
			});
	 }
	 else{
		  alertify.error('Hay datos vacíos que son obligatorios');
	 }
}