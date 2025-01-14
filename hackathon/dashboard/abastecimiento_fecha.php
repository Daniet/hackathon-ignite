<!DOCTYPE html>
<!-- saved from url=(0060)https://www.chartjs.org/samples/latest/scales/time/line.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Line Chart</title>
	<script async="" src="//www.google-analytics.com/analytics.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>	
	<script src="../libs/Chart.min.js"></script>
	<script src="../libs/utils.js"></script>	<style>
		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
	</style>
<style type="text/css">/* Chart.js */
@keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}</style></head>

<body>
	<div style="width:75%;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
		<canvas id="canvas" style="display: block; width: 1013px; height: 506px;" width="1013" height="506" class="chartjs-render-monitor"></canvas>
	</div>
	<br>
	<br>
	<button id="randomizeData">Randomize Data</button>
	<button id="addDataset">Add Dataset</button>
	<button id="removeDataset">Remove Dataset</button>
	<button id="addData">Add Data</button>
	<button id="removeData">Remove Data</button>
	<script>
		var timeFormat = 'MM/DD/YYYY HH:mm';

		function newDate(days) {
			return moment().add(days, 'd').toDate();
		}

		function newDateString(days) {
			return moment().add(days, 'd').format(timeFormat);
		}

		var color = Chart.helpers.color;
		var config = {
			type: 'line',
			data: {
				labels: [ // Date Objects
					'08/08/2019 7:00',
					'08/08/2019 8:00',
					'08/08/2019 9:00',
					'08/08/2019 10:00',
					'08/08/2019 11:00',
					'08/08/2019 12:00',
					'08/08/2019 13:00',
					'08/08/2019 14:00',
					'08/08/2019 15:00',
					'08/08/2019 16:00',
					'08/08/2019 17:00',
					'08/08/2019 18:00',
					'08/08/2019 19:00',
					'08/08/2019 20:00',
					'08/08/2019 21:00'

				],
				datasets: [{
					label: 'Cajero 1',
					backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
					borderColor: window.chartColors.red,
					fill: false,
					data: [
						8000000,
6810000,
6650000,
5970000,
6030000,
5830000,
4370000,
3990000,
3590000,
3530000,
2400000,
1820000,
890000,
610000,
510000					],
				}, {
					label: 'cajero2',
					backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
					borderColor: window.chartColors.blue,
					fill: false,
					data: [
						8000000,
6810000,
6650000,
5970000,
6030000,
5830000,
4370000,
3990000,
3590000,
3530000,
2400000,
1820000,
890000,
610000,
510000
					],
				}, {
					label: 'Dataset with point data',
					backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
					borderColor: window.chartColors.green,
					fill: false,
					data: [{
						x: newDateString(0),
						y: randomScalingFactor()
					}, {
						x: newDateString(5),
						y: randomScalingFactor()
					}, {
						x: newDateString(7),
						y: randomScalingFactor()
					}, {
						x: newDateString(15),
						y: randomScalingFactor()
					}],
				}]
			},
			options: {
				title: {
					text: 'Chart.js Time Scale'
				},
				scales: {
					xAxes: [{
						type: 'time',
						time: {
							parser: timeFormat,
							// round: 'day'
							tooltipFormat: 'll HH:mm'
						},
						scaleLabel: {
							display: true,
							labelString: 'Date'
						}
					}],
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: 'value'
						}
					}]
				},
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);

		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data.forEach(function(dataObj, j) {
					if (typeof dataObj === 'object') {
						dataObj.y = randomScalingFactor();
					} else {
						dataset.data[j] = randomScalingFactor();
					}
				});
			});

			window.myLine.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[config.data.datasets.length % colorNames.length];
			var newColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Dataset ' + config.data.datasets.length,
				borderColor: newColor,
				backgroundColor: color(newColor).alpha(0.5).rgbString(),
				data: [],
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			config.data.datasets.push(newDataset);
			window.myLine.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				config.data.labels.push(newDate(config.data.labels.length));

				for (var index = 0; index < config.data.datasets.length; ++index) {
					if (typeof config.data.datasets[index].data[0] === 'object') {
						config.data.datasets[index].data.push({
							x: newDate(config.data.datasets[index].data.length),
							y: randomScalingFactor(),
						});
					} else {
						config.data.datasets[index].data.push(randomScalingFactor());
					}
				}

				window.myLine.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myLine.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myLine.update();
		});
	</script>



</body></html>