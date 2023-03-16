$(document).ready(function(){
	 
});

/*
 *formulario para las configuraciones generales
 *
 */
$('#frm_actulaizar_datos_empresa').validate({
			rules:{
				nombre_empresa:{required:true},
				direccion_empresa:{required:true},
				telefono_empresa:{minlength:9, maxlength:9},
				moneda_empresa:{required:true}
			},
			messages:{
				nombre_empresa:{required:'Dato requrido'},
				direccion_empresa:{required:'Dato requrido'},
				telefono_empresa:{minlength:'Mínimo de caracteres es {0}', maxlength:'Máximo de caracteres es {0}'}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				//creo un objeto tipo form data para enviar un archivo
				var formData = new FormData();
				//agrego el objeto del respectivo campo file que contiene la imagen
				
				//agrego los dempas inputs al formData
				formData.append('nombre_empresa', $('#nombre_empresa').val());
				formData.append('direccion_empresa', $('#direccion_empresa').val());
				formData.append('telefono_empresa', $('#telefono_empresa').val());
				formData.append('moneda_empresa', $('#moneda_empresa').val());
				formData.append('nombre_logo', $('#nombre_logo').val());
				formData.append('archivo', $('#archivo')[0].files[0]);
				$.ajax({
					type:'POST',
					url:baseUrl + '/Configuracion/Actualizar_Datos_Generales',
					data:formData,
					processData: false, //para procesar datos de tipo formData
					contentType: false, //para procesar datos de tipo formData
					dataType:'json',//espero un json como respuesta
					beforeSend: function() {
						//muestro el loading espsere..
						$('#overlay').show();
					},
					success:function(datos_esperados){
						$('#mensaje').empty();//limpio los erores
						$('#mensaje').removeClass()
						$('#mensaje').addClass(datos_esperados.clase_css);
						//agrego los errores
						$('#mensaje').append(datos_esperados.mensaje);
						//muestro el contenido de los errores
						$('#mensaje').show();
						
						if(datos_esperados.respuesta == 1){
							//oculto el mensaje
						setTimeout(function() {
								$('#mensaje').fadeOut(1500);
								location.reload();
										},3000);
						}
						else if(datos_esperados.respuesta == 0){
							
						}
					},
					error:function(jqXHR, textStatus, errorThrown){
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
					},
					complete: function() {
						// Oculta el overlay después de completar la petición
						$('#overlay').hide();
					  }
				});
			}
});
function Seleccionar_Producto(codigoproducto){
	$('#buscar_producto_reporte_kardex').val(codigoproducto);
	$('#tbl_productos tbody').empty();
}