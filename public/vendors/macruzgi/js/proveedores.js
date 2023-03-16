$(document).ready(function(){
	$('#pro_razon_social').keyup(function() {
        var valor_pro = $(this).val();
        $('#pro_nombre_comercial').val(valor_pro);
    });	
  /*
  *agregar proveedor
  *
  */
$("#frm_agregar_proveedor").validate({
			rules:{
				pro_codigo:{required:true, minlength: 6},
				pro_razon_social:{required:true, minlength: 6},
				pro_nombre_comercial:{required:true, minlength: 6},
				pro_nrc:{required:true},
				pro_nit:{required:true, minlength: 17, maxlength:17 },
				pro_dui:{minlength: 10, maxlength:10 },
				id_municipio:{required:true}
			},
			messages:{
				pro_codigo:{required:"Dato requerido", minlength: "Mínimo de caracteres permitidos es {0}"},
				pro_razon_social:{required:"Dato requrido", minlength: "Mínimo de caracteres permitidos es {0}"},
				pro_nombre_comercial:{required:"Dato requrido", minlength: "Mínimo de caracteres permitidos es {0}"},
				pro_nrc:{required:"Dato requrido"},
				pro_nit: {required:"Dato requrido", minlength:"Mínimo de caracteres permitidos es {0}", maxlength:"Máximo de caracteres perminitos es {0}"},
				pro_dui: {minlength:"Mínimo de caracteres permitidos es {0}", maxlength:"Máximo de caracteres perminitos es {0}"},
				id_municipio:{required:"Dato requrido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
							
				$.ajax({
					type:"POST",
					url:baseUrl + "/Agregar_Proveedor",
					data:$("#frm_agregar_proveedor").serialize(),
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
								window.location.replace(baseUrl +"/Administrar_Proveedores");
									
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
  *editar proveedor
  *
  */	
$("#frm_actualizar_proveedor").validate({
			rules:{
				pro_codigo:{required:true, minlength: 6},
				pro_razon_social:{required:true, minlength: 6},
				pro_nombre_comercial:{required:true, minlength: 6},
				pro_nrc:{required:true},
				pro_nit:{required:true, minlength: 17, maxlength:17 },
				pro_dui:{minlength: 10, maxlength:10 },
				id_municipio:{required:true}
			},
			messages:{
				pro_codigo:{required:"Dato requerido", minlength: "Mínimo de caracteres permitidos es {0}"},
				pro_razon_social:{required:"Dato requrido", minlength: "Mínimo de caracteres permitidos es {0}"},
				pro_nombre_comercial:{required:"Dato requrido", minlength: "Mínimo de caracteres permitidos es {0}"},
				pro_nrc:{required:"Dato requrido"},
				pro_nit: {required:"Dato requrido", minlength:"Mínimo de caracteres permitidos es {0}", maxlength:"Máximo de caracteres perminitos es {0}"},
				pro_dui: {minlength:"Mínimo de caracteres permitidos es {0}", maxlength:"Máximo de caracteres perminitos es {0}"},
				id_municipio:{required:"Dato requrido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:"POST",
					url:baseUrl + "/Editar_Proveedor",
					data:$("#frm_actualizar_proveedor").serialize(),
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
								window.location.replace(baseUrl +"/Administrar_Proveedores");
									
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
