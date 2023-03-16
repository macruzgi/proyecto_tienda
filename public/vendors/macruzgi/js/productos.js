$(document).ready(function(){
	
  /*
  *agregar producto
  *
  */
$("#frm_agregar_producto").validate({
			rules:{
				prod_codigo:{required:true, minlength: 6},
				nombre:{required:true, minlength: 6},
				id_tipo_producto:{required:true},
				id_tipo_unidad:{required:true}
			},
			messages:{
				prod_codigo:{required:"Dato requerido", minlength: "Mínimo de caracteres permitidos es {0}"},
				nombre:{required:"Dato requrido", minlength: "Mínimo de caracteres permitidos es {0}"},
				id_tipo_producto:{required:"Dato requerido"},
				id_tipo_unidad:{required:"Dato requerido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:"POST",
					url:baseUrl + "/productos/Agregar_Producto",
					data:$("#frm_agregar_producto").serialize(),
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
								window.location.replace(baseUrl +"/productos/Administrar_Productos");
									
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
		
/*
  *editar usuario
  *
  */	
$("#frm_actualizar_producto").validate({
			rules:{
				codigoproducto:{required:true},
				prod_codigo:{required:true},
				nombre:{required:true, minlength: 6},
				id_tipo_producto:{required:true},
				id_tipo_unidad:{required:true}
			},
			messages:{
				codigoproducto:{required:"Dato requerido"},
				prod_codigo:{required:"Dato requerido"},
				nombre:{required:"Dato requrido", minlength: "Mínimo de caracteres permitidos es {0}"},
				id_tipo_producto:{required:"Dato requerido"},
				id_tipo_unidad:{required:"Dato requerido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:"POST",
					url:baseUrl + "/productos/Editar_Producto",
					data:$("#frm_actualizar_producto").serialize(),
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
								window.location.replace(baseUrl +"/productos/Administrar_Productos");
									
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
