$(document).ready(function(){
	
  /*
  *agregar precio
  *
  */
$("#frm_agregar_precio").validate({
			rules:{
				codigoproducto:{required:true},
				nombre_producto:{required:true},
				pre_precio:{required:true}
			},
			messages:{
				codigoproducto:{required:"Dato requerido"},
				nombre_producto:{required:"Dato requrido"},
				pre_precio:{required:"Dato requerido"}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				alertify.defaults.glossary.title ="Bloquera/Desbloquear usuario";
				alertify.defaults.glossary.ok = "SÍ";
				alertify.defaults.glossary.cancel = "Cancelar";
				alertify.confirm("¿Está seguro/a de signar el precio a: " + $("#nombre_producto").val(),
				function(){
					$.ajax({
						type:"POST",
						url:baseUrl + "/Precios/Agregar_Precio",
						data:$("#frm_agregar_precio").serialize(),
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
										window.location.replace(baseUrl +"/Precios/Administrar_Precios");
											
										}, 3500);
									
								}
								
							},
							complete: function() {
								// Oculta el overlay después de completar la petición
								$("#overlay").hide();
							  }
					});
				},
				  function(){
					alertify.error("Se canceló el proceso");
				  }).set("defaultFocus", "cancel");
				
			}
		});
		
});
function Traer_Dato_Producto_Para_Precio(codigoproducto, nombre_producto){ 
	$.ajax({
					type:"POST",
					url:baseUrl + "/Precios/Traer_Dato_Producto_Para_Precio",
					data:{codigoproducto:codigoproducto},
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
						 //window.scrollTo(0, 0);
						 $("#nombre_producto").val(nombre_producto);
						 $("#codigoproducto").val(codigoproducto);
						 $("#pre_precio").focus();
						if(datos_esperados.respuesta ==1){
							$("#resultados_kardex").empty();
							// Agrega cada objeto en la lista
							var ul = $(".top_profiles");
							$.each(datos_esperados.traer_datos, function(index, obj){
							  var li = $("<li>").addClass("media event");
							  var a = $("<a>").addClass("pull-left border-aero profile_thumb");
							  var i = $("<i>").addClass("fa fa-calculator aero");
							  a.append(i);
							  var div = $("<div>").addClass("media-body");
							  var title = $("<a>").addClass("title").text(obj.PRODUCTO);
							  var strong = $("<strong>").text("$" + obj.det_precio);
							  var p = $("<p>").append(strong).append(" precio de compra").append(obj.descripcion);
							  var small = $("<small>").text(obj.kar_fecha_creacion);
							  div.append(title).append(p).append(small);
							  li.append(a).append(div);
							  ul.append(li);
							});
													
						}
						else{
							$("#resultados_kardex").empty();
						}
						if(datos_esperados.prod_precios && datos_esperados.prod_precios.length >0){
							$("#resultados_precios").empty();
							// Agrega cada objeto en la lista
							var ul = $("#resultados_precios").find(".top_profiles");
							$.each(datos_esperados.prod_precios, function(index, obj){
							  var li = $("<li>").addClass("media event").appendTo("#resultados_precios");
							  var a = $("<a>").addClass("pull-left border-aero profile_thumb").appendTo("#resultados_precios");
							  var i = $("<i>").addClass("fa fa-dollar aero").appendTo("#resultados_precios");
							  a.append(i);
							  var div = $("<div>").addClass("media-body").appendTo("#resultados_precios");
							  var title = $("<a>").addClass("title").text(obj.PRODUCTO).appendTo("#resultados_precios");
							  var strong = $("<strong>").text("$" + obj.pre_precio).appendTo("#resultados_precios");
							  var p = $("<p>").append(strong).append(" precio de venta").append(obj.descripcion).appendTo("#resultados_precios");
							  var small = $("<small>").text(obj.pre_fecha_creacion).appendTo("#resultados_precios");
							  div.append(title).append(p).append(small);
							  li.append(a).append(div);
							  ul.append(li);
							});
													
						}
						else{
							$("#resultados_precios").empty();
						}
					},
					complete: function() {
						// Oculta el overlay después de completar la petición
						$("#overlay").hide();
					  }
				});
}