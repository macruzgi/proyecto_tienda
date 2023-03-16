$(document).ready(function(){
	$('#cli_nombre').keyup(function() {
        var valor = $(this).val();
        $('#cli_razon_social').val(valor);
        $('#cli_nombre_comercial').val(valor);
    });
	
	$('#id_departamento').change(function(){
			$.ajax({
				type:'POST',
				url:baseUrl+'/Traer_Municipios',
				data:{id_departamento:$('#id_departamento').val()},
				dataType:'json',//espero un jseon de respuesta
				success:function(datos_esperados){
					//limpio las opciones del select
					$('#id_municipio').find('option').remove();
					$.each(datos_esperados, function(key, valor){//indice, valor 
						$('#id_municipio').append('<option value="'+valor.id_municipio+'">'+valor.municipio_nombre+'</option>');
					});
				}
			});
		});	
  /*
  *agregar cliente
  *
  */
$('#frm_agregar').validate({
			rules:{
				cli_codigo:{required:true, minlength: 6},
				cli_nombre:{required:true, minlength: 6},
				cli_razon_social:{required:true},
				id_municipio:{required:true},
				cli_dui:{minlength:10, maxlength:10},
				cli_nit:{minlength:17, maxlength:17}
			},
			messages:{
				cli_codigo:{required:'Dato requerido', minlength: 'Mínimo de caracteres permitidos es 6'},
				cli_nombre:{required:'Dato requrido', minlength: 'Mínimo de caracteres permitidos es 6'},
				cli_razon_social:{required:'Dato requrido'},
				id_municipio:{required:'Dato requrido'},
				cli_dui:{minlength:'Se esperan {0} caracteres', maxlength:'Solo se permiten {0}'},
				cli_nit:{minlength:'Se  {0} caracteres', maxlength:'Solo se permiten {0}'}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:'POST',
					url:baseUrl + '/Agregar_Cliente',
					data:$('#frm_agregar').serialize(),
					dataType:'json',//espero un json como respuesta
					beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
					success:function(datos_esperados){
						$('#mensaje').empty();//quito cualquier mensaje previamente mostrado
						$('#mensaje').removeClass();//remuevo la clase css
						$('#mensaje').addClass(datos_esperados.clase_css);//clase css será la respuesta enviada por el controlador
						$('#mensaje').append(datos_esperados.mensaje);//mensaje que será la respuesta enviada por el controlador
						$('#mensaje').show();//muestro el mensaje
						 window.scrollTo(0, 0);
						if(datos_esperados.respuesta ==1){
							//respuesta será la respuesta enviada por el controlador
							//si la respuesta es 1 como sussces que nos rediriga a la pagina de inicio
							setTimeout(()=>{
								window.location.replace(baseUrl +'/Administrar_Clientes');
									
								}, 3500);
							
						}
						
					},
					complete: function() {
						// Oculta el overlay después de completar la petición
						$('#overlay').hide();
					  }
				});
			}
		});
		
/*
  *editar usuario
  *
  */	
$("#frm_actualizar").validate({
			rules:{
				id_cliente:{required:true},
				cli_nombre:{required:true, minlength: 6},
				cli_razon_social:{required:true},
				id_municipio:{required:true},
				cli_dui:{minlength:10, maxlength:10},
				cli_nit:{minlength:17, maxlength:17}
			},
			messages:{
				id_cliente:{required:'Dato requerido'},
				cli_nombre:{required:'Dato requrido', minlength: 'Mínimo de caracteres permitidos es 6'},
				cli_razon_social:{required:'Dato requrido'},
				id_municipio:{required:'Dato requrido'},
				cli_dui:{minlength:'Se esperan {0} caracteres', maxlength:'Solo se permiten {0}'},
				cli_nit:{minlength:'Se  {0} caracteres', maxlength:'Solo se permiten {0}'}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:"POST",
					url:baseUrl + "/Editar_Cliente",
					data:$("#frm_actualizar").serialize(),
					dataType:"json",//espero un json como respuesta
					beforeSend: function() {
						//muestro el loadin espsere..
						$("#overlay").show();
					},
					success:function(datos_esperados){
						$("#mensaje").empty();//quito cualquier mensaje previamente mostrado
						$("#mensaje").removeClass();//remuevo la clase css
						$("#mensaje").addClass(datos_esperados.clase_css);//clase css será la respuesta enviada por el controlador
						$("#mensaje").append(datos_esperados.mensaje);//mensaje que será la respuesta enviada por el controlador
						$("#mensaje").show();//muestro el mensaje
						 window.scrollTo(0, 0);
						if(datos_esperados.respuesta ==1){
							//respuesta será la respuesta enviada por el controlador
							//si la respuesta es 1 como sussces que nos rediriga a la pagina de inicio
							setTimeout(()=>{
								window.location.replace(baseUrl +"/Administrar_Clientes");
									
								}, 3500);
							
						}
						
					},
					complete: function() {
						// Oculta el overlay después de completar la petición
						$("#overlay").hide();
					  }
				});
			}
		});
  
});
