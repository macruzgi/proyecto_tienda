$(document).ready(function(){
  // Line chart
	$.ajax({
		type:'POST',
		url:baseUrl + '/Graficos/Traer_Ventas_Semana',
		dataType:'json',//espero un json como respuesta
		beforeSend: function() {
		//muestro el loadin espsere..
		$('#overlay').show();
		},
		success:function(datos_esperados){
			// Arreglos para las etiquetas y los valores
			var etiquetas = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
			var valores = [];
			// Recorrer los datos_esperados y agregar los valores correspondientes al arreglo de valores
			for (var i = 0; i < datos_esperados.respuesta.length; i++) {
			  var dia = datos_esperados.respuesta[i].NOMBRE_DIA_ESPANIOL;
			  var valor = parseFloat(datos_esperados.respuesta[i].total_ventas);
			  var indice = etiquetas.indexOf(dia);
			  
			  // Si el día se encuentra en el arreglo de etiquetas, agregar el valor correspondiente
			  if (indice !== -1) {
				valores[indice] = valor;
			  }
			}
			if ($('#venta_semana').length) {

				var ctx = document.getElementById('venta_semana');
				var lineChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: etiquetas,
						datasets: [{
							label: 'Ventas',
							backgroundColor: 'rgba(38, 185, 154, 0.31)',
							borderColor: 'rgba(38, 185, 154, 0.7)',
							pointBorderColor: 'rgba(38, 185, 154, 0.7)',
							pointBackgroundColor: 'rgba(38, 185, 154, 0.7)',
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(220,220,220,1)',
							pointBorderWidth: 1,
							data: valores
						}]
					},
					options: {
						title: {
							display: true,
							text: datos_esperados.mensaje,
							fontSize: 12
						}
					}
				});

			}
									
		},
		complete: function() {
			// Oculta el overlay después de completar la petición
			$('#overlay').hide();
		}
	});
//Bar chart
	$.ajax({
		type:'POST',
		url:baseUrl + '/Graficos/Traer_Ventas_Mes_Por_Vendedor',
		dataType:'json',//espero un json como respuesta
		beforeSend: function() {
		//muestro el loadin espsere..
		$('#overlay').show();
		},
		success:function(datos_esperados){
			const labels = [];
			const data = [];

			datos_esperados.respuesta.forEach(item => {
			  labels.push(item.nombreusuario);
			  data.push(item.ventas_mes_actual);
			});
			if ($('#bar_graph').length) {

				var ctx = document.getElementById('bar_graph');
				var mybarChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: labels,
						datasets: [{
							label: 'Ventas del mes por usuario',
							backgroundColor: '#26B99A',
							data: data
						}]
					},

					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						},
						title: {
							display: true,
							text: datos_esperados.mensaje,
							fontSize: 12
						}
					}
				});

			}
									
		},
		complete: function() {
			// Oculta el overlay después de completar la petición
			$('#overlay').hide();
		}
	});

//pastel chart
	$.ajax({
		type:'POST',
		url:baseUrl + '/Graficos/Traer_Top_Cinco_Productos_Mas_Vendido',
		dataType:'json',//espero un json como respuesta
		beforeSend: function() {
		//muestro el loadin espsere..
		$('#overlay').show();
		},
		success:function(datos_esperados){
			const datos_grafica = datos_esperados.mensaje.map(objeto => objeto.TOTAL_VENIDOD);
			const labels = datos_esperados.mensaje.map(objeto => objeto.nombre);
			// pastel chart
			if ($('#grafica_pastel').length) {

				var ctx = document.getElementById('grafica_pastel');
				var data = {
					datasets: [{
						data: datos_grafica,
						backgroundColor: [
							"#455C73",
							"#9B59B6",
							"#BDC3C7",
							"#26B99A",
							"#3498DB"
						],
						label: 'My dataset' // for legend
					}],
					labels: labels
				};

				var pieChart = new Chart(ctx, {
					data: data,
					type: 'pie',
					otpions: {
						legend: false
					}
				});

			}

		},
		complete: function() {
			// Oculta el overlay después de completar la petición
			$('#overlay').hide();
		}
	});
});