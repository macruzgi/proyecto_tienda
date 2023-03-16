$(document).ready(function(){
 /*
*buscar un producto para la entrada del inventario
*
*/
$('#buscar_producto_entrada').on('keyup', function() {
		$.ajax({
					url: baseUrl + '/Compras/Buscar_Producto',
					type: 'POST',
					data: {
					  buscar_producto: $(this).val(),
					},
					//dataType: 'html',
					dataType: 'json',
					success: function(datos_esperados) {
					  // Si se encontró un producto con el código dado, actualizar los cuadros de texto de descripción y precio
					   //$('#results').html(data);
					   $('#tbl_productos tbody').empty();
					   $('#tbl_productos').show();
					   $.each(datos_esperados, function(i, datos_iterados){
							$('#tbl_productos tbody').append('<tr><td>'+datos_iterados.codigoproducto+'</td><td>'+datos_iterados.prod_codigo+'</td><td>'+datos_iterados.nombre+' '+ datos_iterados.descripcion+'</td><td style="width:16%;text-align:center;"><a href="#" onclick="Agregar_Producto_A_La_Entrada('+datos_iterados.codigoproducto+',\''+datos_iterados.nombre+' '+ datos_iterados.descripcion+'\'); event.preventDefault();"><img src='+baseUrl+'/images/add.png style ="width: 18%;" title="Agregar producto" id="agregar_producto" ></a></td></tr>');

						})
					  
					}
				  });

});	
 
});
function generarCodigo() {
  var codigoFijo = 'producto_';
  var numeroAleatorio = Math.floor(Math.random() * 1000000);
  var codigoCompleto = codigoFijo + numeroAleatorio.toString().substring(0, 6);
  return codigoCompleto;
}
function sumarSubtotales() {
  var tablaCarrito = document.getElementById('tbl_carrito');
  var subtotales = tablaCarrito.querySelectorAll('input[name="subtotal[]"]');
  var total = 0;
  for (var i = 0; i < subtotales.length; i++) {
    total += parseFloat(subtotales[i].value);
  }
  return total.toFixed(2);;
}
let contador = 0;
function Agregar_Producto_A_La_Entrada(codigo, descripcion) {
	//alert(generarCodigo());
  $('#tbl_carrito').show();
  $('#tbl_productos').hide();
  $('#buscar_producto_entrada').val('');
   // Obtiene la tabla del carrito
  var tablaCarrito = document.getElementById('tbl_carrito');
  // Crea una nueva fila de tabla
  var fila = document.createElement('tr');
  // Crea una nueva celda para el código del producto
  var celdaCodigo = document.createElement('td');
  var codigoProducto = document.createElement('input');
  codigoProducto.type = 'text';
  codigoProducto.value = codigo;
  codigoProducto.readOnly  = true; 
  codigoProducto.classList.add('form-control');
  codigoProducto.name = 'codigoproducto[]';
  codigoProducto.id =  `codigoproducto${contador}`;
  codigoProducto.autocomplete = 'off'; // Agregar el atributo autocomplete="off"
  celdaCodigo.appendChild(codigoProducto);
  fila.appendChild(celdaCodigo);
    //evento para evitar que se eliminen todas las cajas de texto al dar enter en cualquier caja
  celdaCodigo.addEventListener('keypress', function(event) {
    if (event.keyCode === 13) { // Si se presiona Enter
      event.preventDefault(); // Evitar que se ejecute el evento de clic en el botón eliminar
	  //para poner el fonco en la siguiente caja de texo
      var siguienteInput = $(this).closest('tr').next().find(':input');
      if (siguienteInput.length) {
        siguienteInput[0].focus();
      }
    }
  });
  
  // Crea un elemento td para la descripcion del producto y lo llena con el valor del parámetro "descripcion"
  var celdaDescripcion = document.createElement('td');
  celdaDescripcion.innerHTML = descripcion;
  fila.appendChild(celdaDescripcion);
 
  // Crea una nueva celda para la cantidad del producto con valor 1
  var celdaCantidad = document.createElement('td');
  var txtCantidad = document.createElement('input');
  txtCantidad.type = 'text';
  txtCantidad.value = '1';
  txtCantidad.name = 'cantidad[]';
  txtCantidad.classList.add('form-control');
  txtCantidad.id =  `cantidad${contador}`;
  txtCantidad.autocomplete = 'off'; // Agregar el atributo autocomplete="off"
  celdaCantidad.appendChild(txtCantidad);
  fila.appendChild(celdaCantidad);
  //evento para evitar que se eliminen todas las cajas de texto al dar enter en cualquier caja
  txtCantidad.addEventListener('keypress', function(event) {
    if (event.keyCode === 13) { // Si se presiona Enter
      event.preventDefault(); // Evitar que se ejecute el evento de clic en el botón eliminar
      var siguienteInput = $(this).closest('tr').next().find(":input");
      if (siguienteInput.length) {
        siguienteInput[0].focus();
      }
    }
  });
  
  // Crea una nueva celda para el precio del producto
  var celdaPrecio = document.createElement('td');
  var precioProducto = document.createElement('input');
  precioProducto.type = 'text';
  precioProducto.value = '';
  precioProducto.name = 'precio[]';
  precioProducto.classList.add('form-control');
  precioProducto.id =  `precioProducto${contador}`;
  precioProducto.autocomplete = 'off'; // Agregar el atributo autocomplete="off"
  celdaPrecio.appendChild(precioProducto);
  fila.appendChild(celdaPrecio);
  //evento para evitar que se eliminen todas las cajas de texto al dar enter en cualquier caja
  precioProducto.addEventListener('keypress', function(event) {
    if (event.keyCode === 13) { // Si se presiona Enter
      event.preventDefault(); // Evitar que se ejecute el evento de clic en el botón eliminar
	  //para poner el fonco en la siguiente caja de texo
      var siguienteInput = $(this).closest('tr').next().find(':input');
      if (siguienteInput.length) {
        siguienteInput[0].focus();
      }
    }
  });
	// Crea una nueva celda para el subtotal del producto con valor 0
  var celdaSubtotal = document.createElement('td');
  var subTotal = document.createElement('input');
  subTotal.type = 'text';
  subTotal.value = '0';
  subTotal.name = 'subtotal[]';
  subTotal.id =  `subTotal${contador}`;
  subTotal.classList.add('form-control');
  subTotal.autocomplete = 'off'; // Agregar el atributo autocomplete="off"
  celdaSubtotal.appendChild(subTotal);
  fila.appendChild(celdaSubtotal);
  //evento para evitar que se eliminen todas las cajas de texto al dar enter en cualquier caja
  subTotal.addEventListener('keypress', function(event) {
    if (event.keyCode === 13) { // Si se presiona Enter
      event.preventDefault(); // Evitar que se ejecute el evento de clic en el botón eliminar
	  //para poner el fonco en la siguiente caja de texo
      var siguienteInput = $(this).closest('tr').next().find(":input");
      if (siguienteInput.length) {
        siguienteInput[0].focus();
      }
    }
  });
  
  // Crea una nueva celda para el boton de eliminar fila
  var celdaBtnEliminar = document.createElement('td');
  var btnEliminar = document.createElement('button');
	btnEliminar.classList.add('btn', 'btn-danger');
	btnEliminar.id =  `btnEliminar${contador}`;
	btnEliminar.textContent = 'Eliminar';
	btnEliminar.addEventListener('click', function() {
		fila.parentNode.removeChild(fila);
		// Busca el primer elemento de texto de precio en la tabla
		var primerPrecio = $('#tbl_carrito input[name="precio[]"]').first();
		// Establece el foco en el primer elemento de texto de precio
		primerPrecio.focus();
		//llamo la funcion que sume los subtotales y los ponga en la caja de texto TOTAL
	  document.getElementById('TOTAL').value = sumarSubtotales();
	});
	celdaBtnEliminar.appendChild(btnEliminar);
	fila.appendChild(celdaBtnEliminar);
	
    var tablaLength = tablaCarrito.rows.length;
	if(tablaLength==1){
		
	// Crea un elemento td para el TOTAL del producto y lo llena con el valor suma
	  var filalTOTAL = document.createElement('tr');
	  var celtaTOTAL = document.createElement('td');
	   celtaTOTAL.colSpan = '4';
	   celtaTOTAL.innerHTML ='TOTAL';
	   celtaTOTAL.style.textAlign = 'right'; // Establece el texto a la derecha
	   filalTOTAL.appendChild(celtaTOTAL);
	  	   
	  // Crea una nueva celda para el txtTOTAL del producto con valor 0 y la agrego a la fila del filalTOTAL para que se muestre en la misma fila
	  var celdaTOTAL = document.createElement('td');
	  var txtTOTAL = document.createElement('input');
	  txtTOTAL.type = 'text';
	  txtTOTAL.value = '0';
	  txtTOTAL.id = 'TOTAL';
	  txtTOTAL.name = 'TOTAL';
	  txtTOTAL.classList.add('form-control');
	  txtTOTAL.autocomplete = 'off'; // Agregar el atributo autocomplete="off"
	  celdaTOTAL.appendChild(txtTOTAL);
	  filalTOTAL.appendChild(celdaTOTAL);
	  //evento para evitar que se eliminen todas las cajas de texto al dar enter en cualquier caja
  txtTOTAL.addEventListener('keypress', function(event) {
    if (event.keyCode === 13) { // Si se presiona Enter
      event.preventDefault(); // Evitar que se ejecute el evento de clic en el botón eliminar
	  //para poner el fonco en la siguiente caja de texo
      var siguienteInput = $(this).closest('tr').next().find(':input');
      if (siguienteInput.length) {
        siguienteInput[0].focus();
      }
    }
  });
	  //se agrega la fila filalTOTAL a la tabla tablaCarrito
	  tablaCarrito.appendChild(filalTOTAL);
	  
	 // Agrega la última fila con el link de procesar cotización
	  var filalink = document.createElement('tr');
	  var celdaLink = document.createElement('td');
	  celdaLink.colSpan = '4';
	  var linkProcesar = document.createElement('a');
	  linkProcesar.classList.add('btn', 'btn-success');
	  linkProcesar.href = '#';
	  linkProcesar.onclick = function(event) {
		  //evita que el # se ponga en la barra de direcciones
		  event.preventDefault();
		  //valido el formulario
		 if ($('#frm_agregar_entrada_al_inventario').valid()){
			  // Validar que los campos de precio no estén vacíos
		  var precios = document.getElementsByName('precio[]');
		  var codigos = document.getElementsByName('codigoproducto[]');
		  var cantidades = document.getElementsByName('cantidad[]');
		  for (var i = 0; i < precios.length; i++) {
			if (precios[i].value.trim() === '' || codigos[i].value.trim() === '' || cantidades[i].value.trim() === '') {
			  alertify.defaults.glossary.title ='Aviso';
			  //alertify.error('');
			   alertify.alert().set('message', 'El código, la cantidad y/o precio del producto no pueden estar vacíos').show(); 
			   return;
			}
		  }
		  //Código de la función que se ejecuta al hacer clic en el enlace
			$.ajax({
				url: baseUrl + '/Inventario/Procesar_Entrada',
				type: 'POST',
				data: $('#frm_agregar_entrada_al_inventario').serialize(),
				dataType: 'json',//espero como respuesta un json
				beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
					},
				success: function(datos_esperados) {
					$('#mensaje').empty();//quito cualquier mensaje previamente mostrado
					$('#mensaje').removeClass();//remuevo la clase css
					$('#mensaje').addClass(datos_esperados.clase_css);//clase css será la respuesta enviada por el controlador
					$('#mensaje').append(datos_esperados.mensaje);//mensaje que será la respuesta enviada por el controlador
					$('#mensaje').show();//muestro el mensaje
					
						window.scrollTo(0, 0);
					if(datos_esperados.respuesta == 1){
						 setTimeout(()=>{
								window.location.replace(baseUrl +'/Inventario/Administrar_Entradas_Al_Inventario');
									
								}, 3500);
					}
				},
				error: function(datos_esperados) {
				  // Mostrar un mensaje de error si no se puede procesar la solicitud Ajax
				  $('#mensaje').empty();//quito cualquier mensaje previamente mostrado
					$('#mensaje').removeClass();//remuevo la clase css
					$('#mensaje').addClass(datos_esperados.clase_css);//clase css será la respuesta enviada por el controlador
					$('#mensaje').append(datos_esperados.mensaje);//mensaje que será la respuesta enviada por el controlador
					$('#mensaje').show();//muestro el mensaje
				},
				complete: function() {
						// Oculta el overlay después de completar la petición
						$('#overlay').hide();
				}
			});

		  }
		  
		};
	  linkProcesar.textContent = 'Procesar la entrada';
	  celdaLink.appendChild(linkProcesar);
	  filalink.appendChild(celdaLink);
	  tablaCarrito.appendChild(filalink);
	}
	
	
	
  // Agrega la fila de tabla al cuerpo de la tabla
  tablaCarrito.insertBefore(fila, tablaCarrito.firstChild);
  
  // Agrega un ID único a la fila de tabla creada para poder multiplicar los cantidades por el precio y sacar un sub-total
	let codigo_unico =   generarCodigo()
	fila.id =codigo_unico ;

	// Agrega un controlador de eventos de cambio en el campo de precio del producto
	precioProducto.addEventListener('change', function() {
	  // Busca la fila correspondiente en la tabla del carrito usando el ID único
	  var fila = document.getElementById(codigo_unico);
	  // Obtiene el campo de cantidad y el campo de precio de la fila
	  var cantidad = fila.querySelector('input[name="cantidad[]"]');
	  var precio = fila.querySelector('input[name="precio[]"]');
	  // Calcula el subtotal y actualiza el campo de subtotal de la fila
	  var subtotal = cantidad.value * precio.value;
	  fila.querySelector('input[name="subtotal[]"]').value = subtotal.toFixed(2);
	  //llamo la funcion que sume los subtotales y los ponga en la caja de texto TOTAL
	  document.getElementById('TOTAL').value = sumarSubtotales();
	  
	});

	// Agrega un controlador de eventos de cambio en el campo de cantidad del producto
	txtCantidad.addEventListener('change', function() {
	  // Busca la fila correspondiente en la tabla del carrito usando el ID único
	  var fila = document.getElementById(codigo_unico);
	  // Obtiene el campo de cantidad y el campo de precio de la fila
	  var cantidad = fila.querySelector('input[name="cantidad[]"]');
	  var precio = fila.querySelector('input[name="precio[]"]');
	  // Calcula el subtotal y actualiza el campo de subtotal de la fila
	  var subtotal = cantidad.value * precio.value;
	  fila.querySelector('input[name="subtotal[]"]').value = subtotal.toFixed(2);
	  //llamo la funcion que sume los subtotales y los ponga en la caja de texto TOTAL
	  document.getElementById('TOTAL').value = sumarSubtotales();
	});

	
  // Establece el foco en el último elemento de texto agregado (precioCantidad)
  txtCantidad.focus();
  //para que agregue un id unico para cada elemento:
   contador++;
}
/*
*valido el formulario de agregar la entrada al inventario
*/
$('#frm_agregar_entrada_al_inventario').validate({
    rules:{
				en_numero_documento:{required:true}
			},
			messages:{
				en_numero_documento:{required:'Dato requrido'}
			}
});

function Traer_Detalle_Entrada_Inventario(id_entrada){
	$.ajax({
			type: 'POST',
			url: baseUrl + '/Inventario/Traer_Detalle_Entrada_Inventario',
			data: { id_entrada: id_entrada },
			dataType: 'html',
			beforeSend: function() {
						//muestro el loadin espsere..
						$('#overlay').show();
			},
			success: function(data) {
				// Agregar el fragmento de HTML devuelto a un elemento de la página
				$('#tbl_entrada_elegida').html(data);
				// Muestra una modal para el detalle de la entrada al inventario
				$('#modal_entrada_inventario').modal('show');
			},
			complete: function() {
				// Oculta el overlay después de completar la petición
				$('#overlay').hide();
			}
	});
	
	
}