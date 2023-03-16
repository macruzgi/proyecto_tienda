$(document).ready(function(){
	Poner_Foco_y_Limpiar_Texto();
  /*
  *buscar cliente para la venta
  *
  */
$('#cli_cliente_buscar').on('keydown', function(event) {
  if (event.key === 'Enter' || event.key === 'Tab') {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del evento keyup
    // Hacer una petición a tu servidor para obtener los datos correspondientes
   
	$.ajax({
					type:'POST',
					url:baseUrl + '/Ventas/Traer_Cliente',
					data:{ cli_cliente_buscar: $('#cli_cliente_buscar').val() },
					dataType:'json',//espero un json como respuesta
					beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
					success:function(datos_esperados){
						 if (datos_esperados === null || Object.keys(datos_esperados).length === 0) {
							//si no encuentra resultados, que levante la modal para buscar el cliente
							$.ajax({
								type: 'POST',
								url: baseUrl + '/Ventas/Vista_Resultado_Busqueda_Cliente',
								//data: { mi_dato: 'valor' },
								dataType: 'html',
								success: function(data) {
									// Agregar el fragmento de HTML devuelto a un elemento de la página
									$('#div_tbl_clientes').html(data);
									$('#tbl_busqueda_cliente').DataTable();
								}
							});

							// Muestra una modal para la busqueda de proveedores
							$('#modal_busqueda').modal('show');
						} else {
							//si encuentra resultados al dar enter o tab que cargue los datos en los text
							//que suba la pagina scroll
							window.scrollTo(0, 0);
							//alert(datos_esperados[0].pro_nrc);
							$('cli_cliente_buscar').val(datos_esperados[0].cli_codigo);
							$('#id_cliente').val(datos_esperados[0].id_cliente);
							$('#cli_nombre').val(datos_esperados[0].cli_nombre);
							
						}
					},
					complete: function() {
						// Oculta el overlay después de completar la petición
						$('#overlay').hide();
					  }
				});  
  }
});
$(document).keydown(function(e){

    e = e || Event;
	if (e.altKey && e.keyCode == 73){//presione alt + i (imprimir cotizacion)
		Guardar_E_Imprimir_Cotizacion();
    }
	else if(e.altKey && e.keyCode == 71){//presione alt + g (guardar)
		Guardar_Pre_Venta();
	}
	else if(e.altKey && e.keyCode == 76){//presione alt + l (limpiar carrito)
		Limpiar_Carrito();
	}
	else if(e.altKey && e.keyCode == 66){//presione alt + b (poner foco en el txt de buscar producto)
		Poner_Foco_y_Limpiar_Texto();
	}
});
    
/*
*buscar un producto
*
*/
$('#buscar_producto_venta').on('keyup', function() {
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
					$('#tbl_productos tbody').append('<tr><td>'+ '('+datos_iterados.prod_codigo+ ') '+ datos_iterados.nombre+'</td><td>'+datos_iterados.descripcion+'</td><td>'+datos_iterados.tipo_nombre+'</td><td>'+datos_iterados.precioventa+'</td><td>'+datos_iterados.existencia+'</td><td><input type="number" step="any" class="form-control" id="'+datos_iterados.codigoproducto+'" value="1">'+'</td><td style="width:16%;text-align:center;"><a href="#" onclick="Agregar_Producto_Al_Carro('+datos_iterados.codigoproducto+'); event.preventDefault();"><img src="'+baseUrl+'/images/add.png"  class="imagen_quitar_carro" title="Agregar" id="agregar_producto" style="width:16%;text-align:center;"></a></td></tr>');	
				})
					  
					}
				  });

});	

 
});
/*
*valido el formulario de agregar la venta
*/
$('#frm_nueva_venta').validate({
    rules:{
				cli_cliente_buscar:{required:true},
				id_cliente:{required:true},
				cli_nombre:{required:true}
			},
			messages:{
				cli_cliente_buscar:{required:'Dato requrido'},
				id_cliente:{required:'Dato requrido'},
				cli_nombre:{required:'Dato requrido'}
			}
});
function Eligir_Cliente(id_cliente, cli_codigo, cli_nombre){
	$('#id_cliente').val(id_cliente);
	$('#cli_nombre').val(cli_nombre);
	$('#cli_cliente_buscar').val(cli_codigo);
	// oculto la modal de la busqueda
	$('#modal_busqueda').modal('hide');
	
}

function Agregar_Producto_Al_Carro(codigoproducto){
		$.ajax({
			type:'POST',
			url: baseUrl+ '/Ventas/Agregar_Producto_Al_Carro',
			data:{codigoproducto:codigoproducto, cantidad:$('#'+codigoproducto).val()},
			dataType: 'json',//espero un son de respuesta
			success:function(data){
				if(data.respuesta == 0){
					//$("#mensaje").show();
					$('#mensaje').empty();//limpio los erores
					$('#mensaje').removeClass()
					$('#mensaje').addClass(data.clase_css);
					//agrego los errores
					$('#mensaje').append(data.mensaje);
					//muestro el contenido de los errores
					$('#mensaje').show();
				}
				else if(data.respuesta == 1){
					
					//exito
					if(data.datos_adicionales.tipo_alertify == 'success'){
						alertify.success(data.mensaje);
					}
					else if(data.datos_adicionales.tipo_alertify == 'warning'){
						alertify.warning(data.mensaje);
					}
					//limpio la caja de texto buscar_producto_venta y la enfoco
					$('#buscar_producto_venta').val('');
					$('#buscar_producto_venta').focus();
					//limpio la tabla de los productos mostrados para agregar
					$('#tbl_productos tbody').empty();
					//llamo la funcion que mustra los datos en una tabla, del carrito
					Mostar_Productos_En_El_Carrito();
					
				}
			}
		});
}
//elimina un item del carrito
$(document).on('click', '#btn_eliminar_items', function(){
  var valor = $(this).data('valor');
   
	  $.ajax({
		url: baseUrl+'/Ventas/Eliminar_Producto_Del_Carito',
		type: 'POST',
		data: {codigoproducto: valor},
		dataType: 'json',//espero un son de respuesta
		success: function(datos_esperados) {
		  // hacer algo con la respuesta
		  if(datos_esperados.respuesta == 1){
			  //exito
			   alertify.success(datos_esperados.mensaje);
			  //llamo la funcion que mustra los datos en una tabla, del carrito
			  //alert(valor);
			  Mostar_Productos_En_El_Carrito();
		  }
		},
		error: function(xhr, status, error) {
		  // manejar el error
		}
	  });
	
})

//actualiza un item del carrtio
$(document).on('click', '.btn_actualizar_item', function() {
  var codigoproducto = $(this).data('id');
  var fila = $('tr[data-id="' + codigoproducto + '"]');
  var cantidad = fila.find('#cantidad_' + codigoproducto).val();
  var precio = fila.find('#precio_' + codigoproducto).val();
  //alert (codigoproducto + " " + precio + " " + cantidad);
  // Hacer algo con los valores recuperados...
  $.ajax({
		type:'POST',
		url: baseUrl+ '/Ventas/Actualizar_Items_Carrito',
		data:{codigoproducto:codigoproducto, cantidad:cantidad, precio:precio},
		dataType: 'json',//espero un json de respuesta
		success:function(datos_esperados){
			if(datos_esperados.respuesta==1){
				$('#mensaje_cantidad_mayor').empty();//limpio los erores
				$('#mensaje_cantidad_mayor').removeClass()
				$('#mensaje_cantidad_mayor').addClass(datos_esperados.clase_css);
				//agrego los errores
				$('#mensaje_cantidad_mayor').append(datos_esperados.mensaje);
				//muestro el contenido de los errores
				$('#mensaje_cantidad_mayor').show();
				//dependiendo el tipo de alertify que reciba de respuesta asi los muestro
				if(datos_esperados.datos_adicionales.tipo_alertify == 'success'){
					alertify.success(datos_esperados.mensaje);
				}
				else if(datos_esperados.datos_adicionales.tipo_alertify == 'warning'){
					alertify.warning(datos_esperados.mensaje);
				}
				setTimeout(function() {
					$('#mensaje_cantidad_mayor').fadeOut(3500);
				},3000);
				//muestro el carro
				Mostar_Productos_En_El_Carrito();
						
			}
			else{
					
					alertify.error(datos_esperados.mensaje);
					
				}
		}
	});
});

function Mostar_Productos_En_El_Carrito(){
		$('#tbl_productos_en_carrito tbody').empty();
		//pongo el foco en la text para buscar
		//Poner_Foco_y_Limpiar_Texto();
		$.ajax({
						type:'POST',
						url: baseUrl+ '/Ventas/Ver_Productos_Del_Carrito',
						//data:{codigoproducto:codigoproducto, cantidad:$('#'+codigoproducto).val()},
						dataType: 'html',//espero un html de respuesta
						success:function(data){
							// Agregar el fragmento de HTML devuelto a un elemento de la página
							$('#div_tbl_productos_en_el_carrito').html(data);
							//comvierto la tabla en datatable y sin ordenar
							$('#tbl_productos_en_carrito').DataTable({
							  'ordering': false
							} );
						}
					});
}
function Poner_Foco_y_Limpiar_Texto(){
	
	if ($('#frm_nueva_venta').length > 0) {
	$('#buscar_producto_venta').focus();
	$('#buscar_producto_venta').val('');
	$('#cli_cliente_buscar').val('');
	$('#id_cliente').val('');
	$('#cli_nombre').val('');
	$('#nombre_numero_cotizacion').val('');
	$('#id_cotizacion').val('');
	$('#terminos_condiciones').val('');
	}
}
function Limpiar_Carrito(){
	$.ajax({
				type:'POST',
				url: baseUrl+ '/Ventas/Limpiar_Carrito',
				dataType: 'json',//espero un son de respuesta
				success:function(data){
						$('#mensaje').empty();//limpio los erores
						$('#mensaje').removeClass()
						$('#mensaje').addClass(data.clase_css);
						//agrego los errores
						$('#mensaje').append(data.mensaje);
						//muestro el contenido de los errores
						$('#mensaje').show();
						//oculto el mensaje
						 setTimeout(function() {
									$('#mensaje').fadeOut(1500);
									},3000);
					
					if(data.respuesta == 1){
						//muestro mensaje
						alertify.success(data.mensaje);
						//muestro los productos en el carro
						Mostar_Productos_En_El_Carrito();
						//que suba la pagina scroll
						window.scrollTo(0, 0);
						//y pongo el foco en el buscar_producto_venta
						Poner_Foco_y_Limpiar_Texto();
					}
					
				}
			});
}
function Guardar_Pre_Venta(){
	//valido el formulario
	 if ($('#frm_nueva_venta').valid()){
		$.ajax({
				type:'POST',
				url: baseUrl+ '/Ventas/Guardar_Pre_Venta',
				data:$('#frm_nueva_venta').serialize(),
				dataType: 'json',//espero un son de respuesta
				beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
				success:function(datos_esperados){
					
					if(datos_esperados.respuesta == 1){
						//alert('exito');
						window.location.replace(baseUrl + '/Ventas/Bandeja_Facturas');
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
						// Oculta el overlay después de completar la petición
						$('#overlay').hide();			
					}
					
				},
				complete: function() {
					// Oculta el overlay después de completar la petición
					//$('#overlay').hide();
				}
			});
	 }
	 else{
		  alertify.error('Hay datos vacíos que son obligatorios');
	 }
}

function Guardar_Venta(id_factura){
alertify.defaults.glossary.title ='Cobar factura';
alertify.defaults.glossary.ok = 'Sí';
alertify.defaults.glossary.cancel = 'Cancelar';
alertify.confirm('¿Está seguro/a de facturar?',
  function(){
	  $.ajax({ 
            url: baseUrl+'/Ventas/Guardar_Venta',
            type: 'POST',
            data: {id_factura:id_factura},
            dataType: 'json',
            success: function(respuesta){
				if(respuesta.respuesta==1){
					window.location.replace(baseUrl + '/Ventas/Imprimir_Factura/'+id_factura);
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
function Modificar_Venta(id_factura){
alertify.defaults.glossary.title ='Modificar pre-factura';
alertify.defaults.glossary.ok = 'Sí';
alertify.defaults.glossary.cancel = 'Cancelar';
alertify.confirm('¿Está seguro/a de querer modificar la pre-factura?',
  function(){
	  $.ajax({ 
            url: baseUrl+'/Ventas/Modificar_Venta',
            type: 'POST',
            data: {id_factura:id_factura},
            dataType: 'json',
            success: function(respuesta){
				if(respuesta.respuesta==1){
					window.location.replace(baseUrl + '/Ventas/Nueva_Venta');
				}
				else{
					alertify.error(respuesta.mensaje);
					
					//si no se puede modificar la factura, redirijo
					setTimeout(function() {
						window.location.replace(baseUrl + '/Ventas/Bandeja_Facturas');
					},3000);
				}
            }
        });
    
  },
  function(){
    alertify.error('Se canceló el proceso');
  });
}
function Eliminar_Pre_Factura(id_factura){
alertify.defaults.glossary.title ='Eliminar pre-factura';
alertify.defaults.glossary.ok = 'Sí';
alertify.defaults.glossary.cancel = 'Cancelar';
alertify.confirm('¿Está seguro/a de eliminar la pre-factura?',
  function(){
	  $.ajax({ 
            url: baseUrl+'/Ventas/Eliminar_Pre_Factura',
            type: 'POST',
            data: {id_factura:id_factura},
            dataType: 'json',
            success: function(respuesta){
				if(respuesta.respuesta==1){
					//exito
					alertify.success(respuesta.mensaje);
					//si fue exito recargo
					setTimeout(function() {
						location.reload();
					},1000);
				}
				else{
					alertify.error(respuesta.mensaje);
					setTimeout(function() {
						location.reload();
					},1000);
				}
            }
        });
    
  },
  function(){
    alertify.error('Se canceló el proceso');
  });
}
function Traer_Detalle_Venta(id_factura, estado){
	$.ajax({
			type: 'POST',
			url: baseUrl + '/Ventas/Traer_Detalle_Venta',
			data: { id_factura: id_factura, estado:estado},
			dataType: 'html',
			beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
			},
			success: function(data) {
				// Agregar el fragmento de HTML devuelto a un elemento de la página
				$('#div_tbl_seleccionado').html(data);
				// Muestra una modal
				$('#modal_dato_selecconado').modal('show');
				$('#tbl_detalle_de_factura_selecionada').DataTable({
				'ordering': false
				});
			},
			complete: function() {
				// Oculta el overlay después de completar la petición
				$('#overlay').hide();
			}
	});
		
}