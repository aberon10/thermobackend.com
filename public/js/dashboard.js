$(document).ready(function() {
	// GRFICA DE TORTA
	$('#first_chart').highcharts({
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie',
			style: {
				"fontFamily": "\"Roboto\", Verdana, Arial, Helvetica, sans-serif",
				"fontSize": "12px"
			},
		},
		title: {
			text: 'Grafica de torta'
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
			data: [{
				name: 'Microsoft Internet Explorer',
				y: 24.03,
			}, {
				name: 'Chrome',
				y: 56.33,
				sliced: true,
				selected: true
			}, {
				name: 'Firefox',
				y: 10.38
			}, {
				name: 'Safari',
				y: 4.77
			}, {
				name: 'Opera',
				y: 0.91
			}, {
				name: 'Proprietary or Undetectable',
				y: 0.2
			}]
		}]
	});

	// GRAFICA DE BARRAS
	$('#second_chart').highcharts({
		chart: {
			type: 'column'
		},
		xAxis: {
			categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']
		},
		plotOptions: {
			series: {
				animation: {
					duration: 2000,
					easing: 'easeOutBounce'
				}
			},
			legend: {
				text: 'Hola',
			},
		},
		series: [{
			data: [29.9, 71.5, 106.4, 129.2, 250]
		}]
	});
});
