<?php
include('koneksi.php');
$produk = mysqli_query($koneksi,"select * from tb_newcases");
while($row = mysqli_fetch_array($produk)){
	$nama_produk[] = $row['new_cases'];
	
	$query = mysqli_query($koneksi,"select sum(new_cases) as new_cases from tb_newcases where id='".$row['id']."'");
	$row = $query->fetch_array();
	$jumlah_produk[] = $row['new_cases'];
}
?>
<!doctype html>
<html>
 
<head>
	<title>Pie Chart</title>
	<script type="text/javascript" src="chart.js"></script>
</head>
 
<body>
	<div id="canvas-holder" style="width:85%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($jumlah_produk); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
                    'rgba(100, 0, 0, 0.2)',
                    'rgba(0, 255, 255, 0.2)',
                    'rgba(25, 100, 0, 0.2)',
                    'rgba(0, 0, 255, 0.2)',
                    'rgba(93, 88, 89, 0.2)',
                    'rgba(255, 255, 0, 0.2)',

					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
                    'rgba(100, 0, 0, 1)',
                    'rgba(0, 255, 255, 1)',
                    'rgba(25, 100, 0, 1)',
                    'rgba(0, 0, 255, 1)',
                    'rgba(93, 88, 89, 1)',
                    'rgba(255, 255, 0, 1)',
					],
					label: 'Presentase new cases covid'
				}],
				labels: <?php echo json_encode($nama_produk); ?>},
			options: {
				responsive: true
			}
		};
 
		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
 
		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});
 
			window.myPie.update();
		});
 
		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};
 
			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
 
				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}
 
			config.data.datasets.push(newDataset);
			window.myPie.update();
		});
 
		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>
</html>