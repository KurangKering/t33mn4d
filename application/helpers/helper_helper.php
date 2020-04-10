<?php 
Use eftec\bladeone;

if (!function_exists('view')) {
	function view($view, $data = []) {
		$views = APPPATH .'/views';
		$cache = APPPATH . '/cache';
		define("BLADEONE_MODE",1); 
		$blade=new bladeone\BladeOne($views,$cache);
		echo $blade->run($view,$data);
	}
}
if (!function_exists('hBulan')) {
	function hBulan($bulan = null) {
		$daftar =  array(
			'1' => 'Januari',
			'2' => 'Februari',
			'3' => 'Maret',
			'4' => 'April',
			'5' => 'Mei',
			'6' => 'Juni',
			'7' => 'Juli',
			'8' => 'Agustus',
			'9' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);
		if ($bulan) {
			return $daftar[$bulan];
		} 
		return $daftar;
	}
}
if (!function_exists('hJK')) {
	function hJK($status = null) {
		$daftar =  array(
			'L' => 'Laki-Laki',
			'P' => 'Perempuan',

		);
		if ($status) {
			return $daftar[$status];
		} 
		return $daftar;
	}
}
if (!function_exists('hStatusPenyakit')) {
	function hStatusPenyakit($status = null) {
		$daftar =  array(
			'1' => 'Tidak Menular',
			'2' => 'Menular',

		);
		if ($status) {
			return $daftar[$status];
		} 
		return $daftar;
	}
}
if (!function_exists('hRole')) {
	function hRole($akses = null) {
		$roles =  array(
			'1' => 'Puskesmas',
			'2' => 'Staff',

		);
		if ($akses) {
			return $roles[$akses];
		} 
		return $daftar;
	}
}

if (!function_exists('bilangan')) {
	function bilangan($angka){

		$bilangan = number_format($angka, 0, ',', '.');
		return $bilangan;

	}

}










