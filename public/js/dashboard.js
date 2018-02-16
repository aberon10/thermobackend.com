$(document).ready(function () {
	var date = new Date();
	var currentMonth = date.getMonth();
	currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
	var MONTHS = [
		'Enero', 'Febrero', 'Marzo',
		'Abril', 'Mayo', 'Junio',
		'Julio', 'Agosto', 'Setiembre',
		'Octubre', 'Noviembre', 'Diciembre'
	];

	function charGenres(porcentajes) {
		// GRFICA DE TORTA
		$('#first_chart').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie',
				style: {
					"fontFamily": "\"Source Sans Pro\", Verdana, Arial, Helvetica, sans-serif",
					"fontSize": "12px"
				},
			},
			title: {
				text: 'Generos más Populares'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Porcentaje',
				colorByPoint: true,
				data: porcentajes
			}]
		});
	}

	function charUsers(porcentajes) {
		// GRAFICA DE BARRAS
		$('#second_chart').highcharts({
			chart: {
				type: 'pie',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				style: {
					"fontFamily": "\"Source Sans Pro\", Verdana, Arial, Helvetica, sans-serif",
					"fontSize": "12px"
				},
			},
			title: {
				text: 'Registros de los ultimos 2 meses'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				series: {
					animation: {
						duration: 2000,
						easing: 'easeOutBounce'
					}
				},
				legend: {
					text: 'Registro de los ultimos 2 meses',
				},
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Porcentaje',
				colorByPoint: true,
				data: porcentajes
			}]
		});
	}

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$.ajax({
			url: '/dashboard/graphics',
			type: 'POST',
			dataType: 'json',
			data: null
		})
		.done(function (response) {
			var count_genres = response.porcentajes_generos.length;

			if (count_genres < 0) {
				$('#first_chart').parent().parent().addClass('hide');
			} else {
				var porcentajes_generos = [];

				for (var i = 0; i < count_genres; i++) {
					porcentajes_generos[i] = {
						name: response.porcentajes_generos[i][0],
						y: response.porcentajes_generos[i][1],
						sliced: (i === 0) ? true : false,
						selected: (i === 0) ? true : false
					};
				}
				charGenres(porcentajes_generos);
			}

			var porcentajes_usuarios = [{
					name: MONTHS[currentMonth] + ' - ' + date.getFullYear(),
					y: response.porcentajes_usuarios.mes_anterior
				},
				{
					name: MONTHS[currentMonth + 1] + ' - ' + date.getFullYear(),
					y: response.porcentajes_usuarios.mes_actual,
					sliced: true,
					selected: true
				}
			];

			charUsers(porcentajes_usuarios);
		})
		.fail(function (jXHR) { console.log(jXHR); });
});c
