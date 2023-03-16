$(document).ready(function(){
	 $('#cal_fecha_desde').datetimepicker({
        format: 'DD-MM-YYYY'
    });
	 $('#cal_fecha_hasta').datetimepicker({
        format: 'DD-MM-YYYY'
    });
	//valido el formulario del reporte de utilidad
	 $('#btn_generar_reporte_utilidad').on('click', function(event) {
		 event.preventDefault();
		 if ($('#frm_reporte_utilidad').valid()){
			$.ajax({
					type:'POST',
					url: baseUrl+ '/Reportes/Reporte_De_Utilidad',
					data:$('#frm_reporte_utilidad').serialize(),
					dataType: 'json',//espero un son de respuesta
					beforeSend: function() {
							//muestro el loadin espsere..
							$('#overlay').show();
						},
					success:function(datos_esperados){
						
						if(datos_esperados.respuesta == 1){
							// Si se generó el PDF con éxito, asignamos la URL al objeto embed
							$('#pdf').attr('src', datos_esperados.pdf_url);
							$('#pdf-container').show();
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
	 });
	 //valido el formulario del reporte de ventas
	 $('#btn_generar_reporte_ventas').on('click', function(event) {
		 event.preventDefault();
		 if ($('#frm_reporte_ventas').valid()){
			$.ajax({
					type:'POST',
					url: baseUrl+ '/Reportes/Reporte_De_Ventas',
					data:$('#frm_reporte_ventas').serialize(),
					dataType: 'json',//espero un son de respuesta
					beforeSend: function() {
							//muestro el loadin espsere..
							$('#overlay').show();
						},
					success:function(datos_esperados){
						
						if(datos_esperados.respuesta == 1){
							// Si se generó el PDF con éxito, asignamos la URL al objeto embed
							$('#pdf').attr('src', datos_esperados.pdf_url);
							$('#pdf-container').show();
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
	 });

	
/*
*buscar un producto reporte kardex
*
*/
$('#buscar_producto_reporte_kardex').on('keyup', function() {
		$.ajax({
					url: baseUrl + '/Ventas/Buscar_Producto_Para_Venta',
					type: 'POST',
					data: {
					  buscar_producto_venta: $(this).val(),
					},
					//dataType: 'html',
					dataType: 'json',
					success: function(datos_esperados) {
					  // Si se encontró un producto con el código dado, actualizar los cuadros de texto de descripción y precio
					   //$('#results').html(data);
					   $('#tbl_productos tbody').empty();
					   $('#tbl_productos').show();
					   $('#tbl_productos tbody').empty();
				$.each(datos_esperados, function(i, datos_iterados){
					$('#tbl_productos tbody').append('<tr><td>'+ '('+datos_iterados.prod_codigo+ ') '+ datos_iterados.nombre+'</td><td>'+datos_iterados.descripcion+'</td><td>'+datos_iterados.tipo_nombre+'</td><td style="width:16%;text-align:center;"><a href="#" onclick="Seleccionar_Producto('+datos_iterados.codigoproducto+'); event.preventDefault();"><i class="fa fa-check"></i></a></td></tr>');	
				})
					  
					}
				  });

});	
});
/*
*valido el formulario generar reporte de utilidad
*/
$('#frm_reporte_utilidad').validate({
    rules:{
				fecha_desde:{required:true},
				fecha_hasta:{required:true}
			},
			messages:{
				fecha_desde:{required:'Dato requrido'},
				fecha_hasta:{required:'Dato requrido'}
			}
});
/*
*valido el formulario generar reporte de venta
*/
$('#frm_reporte_ventas').validate({
    rules:{
				fecha_desde:{required:true},
				fecha_hasta:{required:true},
				codigousuario:{required:true}
			},
			messages:{
				fecha_desde:{required:'Dato requrido'},
				fecha_hasta:{required:'Dato requrido'},
				codigousuario:{required:'Dato requrido'}
			}
});

/*
 *formulario para reporte de kardex
 *
 */
$('#frm_reporte_kardex').validate({
			rules:{
				fecha_desde:{required:true},
				fecha_hasta:{required:true}
			},
			messages:{
				fecha_desde:{required:'Dato requrido'},
				fecha_hasta:{required:'Dato requrido'}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:'POST',
					url:baseUrl + '/Reportes/Reporte_De_Kardex',
					data:$('#frm_reporte_kardex').serialize(),
					dataType:'json',//espero un json como respuesta
					beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
					success:function(datos_esperados){
						if(datos_esperados.respuesta == 1){
							// Si se generó el PDF con éxito, asignamos la URL al objeto embed
							$('#pdf').attr('src', datos_esperados.pdf_url);
							$('#pdf-container').show();
						}
						else if(datos_esperados.respuesta == 0){
							$('#pdf-container').hide();
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
});

/*
 *formulario para reporte de precios
 *
 */
$('#frm_reporte_precios').validate({
			rules:{
				id_tipo_producto:{required:true}
			},
			messages:{
				id_tipo_producto:{required:'Dato requrido'}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:'POST',
					url:baseUrl + '/Reportes/Reporte_Precios',
					data:$('#frm_reporte_precios').serialize(),
					dataType:'json',//espero un json como respuesta
					beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
					success:function(datos_esperados){
						if(datos_esperados.respuesta == 1){
							// Si se generó el PDF con éxito, asignamos la URL al objeto embed
							$('#pdf').attr('src', datos_esperados.pdf_url);
							$('#pdf-container').show();
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
});

/*
 *formulario para reporte de productos
 *
 */
$('#frm_reporte_productos').validate({
			rules:{
				con_existencias:{required:true},
				id_tipo_producto:{required:true}
			},
			messages:{
				con_existencias:{required:'Dato requrido'},
				id_tipo_producto:{required:'Dato requrido'}
			},
			submitHandler: function (formulario){
				//una vez de clic desabilito el boton
				//$("#btnEntrar").prop("disabled", true);
				
				$.ajax({
					type:'POST',
					url: baseUrl+ '/Reportes/Reporte_De_Productos',
					data:$('#frm_reporte_productos').serialize(),
					dataType: 'json',//espero un son de respuesta
					beforeSend: function() {
							//muestro el loadin espsere..
							$('#overlay').show();
						},
					success:function(datos_esperados){
						
						if(datos_esperados.respuesta == 1){
							// Si se generó el PDF con éxito, asignamos la URL al objeto embed
							$('#pdf').attr('src', datos_esperados.pdf_url);
							$('#pdf-container').show();
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
});

function Seleccionar_Producto(codigoproducto){
	$('#buscar_producto_reporte_kardex').val(codigoproducto);
	$('#tbl_productos tbody').empty();
}