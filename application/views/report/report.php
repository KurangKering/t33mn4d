<html>
<head>

<style>
	table {
		
	}
</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Tahun</th>
				<th>Bulan</th>
				<th>Penyakit</th>
				<th>Puskesmas</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1;
			?>
			<?php foreach ($data['kesakitan'] as $k => $kesakitan): ?>
				<tr>
					<th><?= $no++ ?></th>
					<th><?= $kesakitan->kesakitan_tahun ?></th>
					<th><?= $kesakitan->kesakitan_bulan ?></th>
					<th><?= $kesakitan->penyakit_nama ?></th>
					<th><?= $kesakitan->puskesmas_nama ?></th>
					<th><?= $kesakitan->kesakitan_jumlah ?></th>
				</tr>
				
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>