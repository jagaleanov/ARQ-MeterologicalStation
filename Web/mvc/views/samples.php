<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8"/>
	<title>MRG-Ethernet 0.1 - Muestreo atmosférico</title>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<!--CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel='stylesheet' type='text/css' href="css/style.css">
	<!--CSS-->

	<!--JS-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script language="javascript" type="text/javascript">


		$( function () {
			$( "#date" ).datepicker();
			$( "#date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
			$( "#date" ).datepicker( "setDate", "<?=$data['date']?>" );
		} );

		document.addEventListener( "DOMContentLoaded", function () {
			var chart_t = Highcharts.chart( "chartTemperature", {
				title: {
					text: ""
				},
				xAxis: {
					categories: [ <?=$data['timestamps']?> ]
				},
				yAxis: {
					title: {
						text: "(°c) centigrados"
					}
				},
				series: [ {
					name: "Temperatura (DHT11)",
					data: [ <?=$data['t1']?> ]
				}, {
					name: "Temperatura (BMP180)",
					data: [ <?=$data['t2']?> ]
				} ],

				colors: [ '#C3423F', '#E2A800' ]

			} );

			var chart_h = Highcharts.chart( "chartHumidity", {
				title: {
					text: ""
				},
				xAxis: {
					categories: [ <?=$data[ 'timestamps' ]?> ]
				},
				yAxis: {
					title: {
						text: "% humedad"
					}
				},
				series: [ {
					name: "Humedad (DHT11)",
					data: [ <?=$data['h']?> ]
				} ],

				colors: [ '#5BC0EB' ]
			} );

			var chart_p = Highcharts.chart( "chartPressure", {
				title: {
					text: ""
				},
				xAxis: {
					categories: [ <?=$data['timestamps']?> ]
				},
				yAxis: {
					title: {
						text: "(mb) milibares"
					}
				},
				series: [ {
					name: "Presión atmosférica (BMP180)",
					data: [ <?=$data['p']?> ]
				} ],

				colors: [ '#9BC53D' ]
			} );
			

		} );
	</script>
	<!--JS-->
</head>

<body>

	<!--HEADER---------------------------------------------------------------->
	<header>
		<!--NAV-->
		<div class="pos-f-t">
			<nav class="navbar navbar-dark" style="background-color: #333;">
				<h3 class="text-light">MRG <small>v0.1</small> Estación atmosférica</h3>
				<form class="form-inline" action="" method="post">
					<input type="text" name="date" id="date" value="<?=$data['date']?>" placeholder="aaaa-mm-dd" class="form-control mr-sm-2" aria-label="<?=$data['date']?>" autocomplete="off">

					<button name="submit" class="btn btn-outline-light my-2 my-sm-0" type="submit">Ir</button>
				</form>
			</nav>
		</div>
	</header>
	<!--MAIN------------------------------------------------------------->
	<div>
		<div class="container">
			<div class="main">
				<div id="content" class="container">
					<!--CONTENT-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<br>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm">
									<div>
										<h3 class="h3-t">Temperatura</h3>
										<div class="row">
											<div class="col-sm  module bor-t1">
												<h5>DHT11</h5>
												<p>Máxima:
													<?=$data[ 'maxAndMin' ]['t1']['max']?>°c</p>
												<p>Mínima:
													<?=$data[ 'maxAndMin' ]['t1']['min']?>°c</p>
											</div>
											<div class="col-sm  module bor-t2">
												<h5>BMP180</h5>
												<p>Máxima:
													<?=$data[ 'maxAndMin' ]['t2']['max']?>°c</p>
												<p>Mínima:
													<?=$data[ 'maxAndMin' ]['t2']['min']?>°c</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm">
									<div>
										<h3 class="h3-h">Humedad</h3>
										<div class="row module bor-h">
											<div class="col-sm">
												<h5>DHT11</h5>
												<p>Máxima:
													<?=$data[ 'maxAndMin' ]['h']['max']?>%</p>
												<p>Mínima:
													<?=$data[ 'maxAndMin' ]['h']['min']?>%</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm">
									<div>
										<h3 class="h3-p">Presión atmosférica</h3>
										<div class="row module bor-p">
											<div class="col-sm">
												<h5>BMP180</h5>
												<p>Máxima:
													<?=$data[ 'maxAndMin' ]['p']['max']?>mb</p>
												<p>Mínima:
													<?=$data[ 'maxAndMin' ]['p']['min']?>mb</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr>
									<div id="chartTemperature" style="height: 275px;"></div>
									<div id="chartHumidity" style="height: 275px;"></div>
									<div id="chartPressure" style="height: 275px;"></div>

							<?=$data['counter']['total_samples']?>registros encontrados.

							<table class="table table-hover">
								<tr>
									<!--<th>Id</th>-->
									<th>Hora</th>
									<th>Temp.<br>(DHT11) - (BMP180)</th>
									<th>Humedad<br>(DHT11)</th>
									<th>Presión<br>(BMP180)</th>
								</tr>
								<?php
								foreach ( $data[ 'samples' ] as $sample ) {
									?>
								<tr>
									<!--
									<td>
										<?=$sample['id']?>
									</td>
-->
									<td>
										<?=date('H:i:s',strtotime($sample['timestamp']))?>
									</td>
									<td>
										<?=$sample['t1']?>°c -
										<?=$sample['t2']?>°c
									</td>
									<td>
										<?=$sample['h']?>%
									</td>
									<td>
										<?=$sample['p']?>mb
									</td>
								</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
					<!--END CONTENT-->
				</div>
			</div>
		</div>
	</div>
	<!--FOOTER------------------------------------------------------------->
	<footer>
		<div class="container">
			© Copyright 2019.
		</div>
	</footer>

	<!--JS------------------------------------------------------------->

	<!--BOOTSTRAP------------------------------------------------------------->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>