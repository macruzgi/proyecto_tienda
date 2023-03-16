$(document).ready(function(){
	$("#frm_permisos").validate({
			rules:{
				"id_opcion[]":{required:true},
				id_usuario:{required:true}
			},
			messages:{
				"id_opcion[]":{required:"Elija alguna opción"},
				id_usuario:{required:"Debe elegir algún usuario"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				$.ajax({
					type:"POST",
					url:baseUrl + "/Asignar_Permisos",
					data:$("#frm_permisos").serialize(),
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
								window.location.replace(baseUrl +"/Administrar_Usuarios");
									
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
* agregar tipo de usuario
*/

	 // e.preventDefault(); // previene comportamiento por defecto
	$("#frm_agregar_tipo_usuario").validate({
			rules:{
				tipousu_nombre:{required:true, minlength:6, maxlength:25}
			},
			messages:{
				tipousu_nombre:{required:"Dato requerido", minlength:"Se esperan {0} caracteres como mínimo", maxlength:"Máximo de caracteres {0}"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				var url_Action = "Agregar_Tipo_Usuario";
				var id_tipo_usuario = $("#id_tipo_usuario").val();
				//si la varible id_tipo_usuario no esta vacia significa que es actualizacion
				if(id_tipo_usuario != ""){
					url_Action = "Modificar_Tipo_Usuario";
				}
				$.ajax({
					type:"POST",
					url:baseUrl + "/Tipos_Usuarios/"+url_Action,
					data:$("#frm_agregar_tipo_usuario").serialize(),
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
								window.location.replace(baseUrl +"/Tipos_Usuarios/Administrar_Tipos_Usuarios");
									
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
*Marcar y desmarcar la opcion ver en los permisos
*
*/
 // Agregar evento de click al checkbox "marcarTodo"
  $("#marcarTodo").click(function() {
	    // Obtener el estado actual del checkbox "marcarTodo"
    const isChecked = $(this).prop("checked");
    // Establecer el estado de los demás checkboxes
    $(".marcar").prop("checked", isChecked);
  });
  
  // Agregar evento de click a los demás checkboxes
  $(".marcar").click(function() {
    // Verificar si todos los checkboxes están marcados
    const todosMarcados = $(".marcar").length === $(".marcar:checked").length;
    // Establecer el estado del checkbox "marcarTodo"
    $("#marcarTodo").prop("checked", todosMarcados);
  });
/*
*Marcar y desmarcar la opcion agregar en los permisos
*
*/
 // Agregar evento de click al checkbox "agregar_todo"
  $("#agregar_todo").click(function() {
	    // Obtener el estado actual del checkbox "agregar_todo"
    const isChecked = $(this).prop("checked");
    // Establecer el estado de los demás checkboxes
    $(".agregar").prop("checked", isChecked);
  });
  
  // Agregar evento de click a los demás checkboxes
  $(".agregar_todo").click(function() {
    // Verificar si todos los checkboxes están marcados
    const todosMarcados = $(".agregar_todo").length === $(".agregar_todo:checked").length;
    // Establecer el estado del checkbox "agregar_todo"
    $("#agregar_todo").prop("checked", todosMarcados);
  }); 
/*
*Marcar y desmarcar la opcion editar en los permisos
*
*/
 // Agregar evento de click al checkbox "editar_todo"
  $("#editar_todo").click(function() {
	    // Obtener el estado actual del checkbox "editar_todo"
    const isChecked = $(this).prop("checked");
    // Establecer el estado de los demás checkboxes
    $(".actualizar").prop("checked", isChecked);
  });
  
  // Agregar evento de click a los demás checkboxes
  $(".editar_todo").click(function() {
    // Verificar si todos los checkboxes están marcados
    const todosMarcados = $(".editar_todo").length === $(".editar_todo:checked").length;
    // Establecer el estado del checkbox "editar_todo"
    $("#editar_todo").prop("checked", todosMarcados);
  }); 
  /*
*Marcar y desmarcar la opcion eliminar en los permisos
*
*/
 // Agregar evento de click al checkbox "elimiar_todo"
  $("#elimiar_todo").click(function() {
	    // Obtener el estado actual del checkbox "elimiar_todo"
    const isChecked = $(this).prop("checked");
    // Establecer el estado de los demás checkboxes
    $(".eliminar").prop("checked", isChecked);
  });
  
  // Agregar evento de click a los demás checkboxes
  $(".elimiar_todo").click(function() {
    // Verificar si todos los checkboxes están marcados
    const todosMarcados = $(".elimiar_todo").length === $(".elimiar_todo:checked").length;
    // Establecer el estado del checkbox "elimiar_todo"
    $("#elimiar_todo").prop("checked", todosMarcados);
  });
  /*
  *agregar usuario
  *
  */
$("#frm_agregar_usuario").validate({
			rules:{
				usuario:{required:true, minlength: 6},
				clave:{required:true, minlength: 6},
				re_clave:{required:true, equalTo: "#clave"},
				usuario_nombre:{required:true},
				id_tipo_usuario:{required:true}
			},
			messages:{
				usuario:{required:"Dato requerido", minlength: "Mínimo de caracteres permitidos es 6"},
				clave:{required:"Dato requrido", minlength: "Mínimo de caracteres permitidos es 6"},
				re_clave:{required:"Dato requrido", equalTo:"Las contraseñas no son iguales"},
				usuario_nombre:{required:"Dato requrido"},
				id_tipo_usuario:{required:"Dato requrido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:"POST",
					url:baseUrl + "/Agregar_Usuario",
					data:$("#frm_agregar_usuario").serialize(),
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
								window.location.replace(baseUrl +"/Administrar_Usuarios");
									
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
$("#frm_editar_usuario").validate({
			ignore: '#clave, #re_clave', // Ignora la validación del campo contraseña quite los campos contraseña y re_clave pero dejo eso como ejemplo para ignorar campos
			rules:{
				usuario:{required:true, minlength: 6},
				usuario_nombre:{required:true}
			},
			messages:{
				usuario:{required:"Dato requerido", minlength: "Mínimo de caracteres permitidos es 6"},
				usuario_nombre:{required:"Dato requrido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:"POST",
					url:baseUrl + "/Editar_Usuario",
					data:$("#frm_editar_usuario").serialize(),
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
								window.location.replace(baseUrl +"/Administrar_Usuarios");
									
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
function Bloquer_Desbloquear_Usuario(codigousuario, estado){
alertify.defaults.glossary.title ='Bloquera/Desbloquear usuario';
alertify.defaults.glossary.ok = 'Sí';
alertify.defaults.glossary.cancel = 'Cancelar';
let mensaje = 'BLOQUEAR';
if(estado == 0){
	mensaje = 'DESBLOQUEAR';
}
alertify.confirm('¿Está seguro/a de ' + mensaje +' el usuario?',
  function(){
	  $.ajax({ 
            url: baseUrl+'/Bloquer_Desbloquear_Usuario',
            type: 'POST',
            data: {codigousuario:codigousuario, estado:estado},
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
  }).set('defaultFocus', 'cancel');
}
