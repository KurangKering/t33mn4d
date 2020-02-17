<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Treemap extends CI_Controller
{

	public function index()
	{
		$data['puskesmas'] = $this->M_Puskesmas->get();
		$data['penyakit'] = $this->M_Penyakit->get();
		$data['tahun'] = $this->M_Kesakitan->get()->pluck('tahun')->unique();
		$data['bulan'] = hBulan();
		return view('treemap.index', compact('data'));
	}

	public function map()
	{

		$tahun  = $this->input->get('tahun') ?? date('Y');
		$puskesmas     = $this->input->get('puskesmas');
		$penyakit   = $this->input->get('penyakit');
		$bulan = $this->input->get('bulan');


		$dataKesakitan = $this->M_Kesakitan;
		if ($puskesmas) {

			$dataKesakitan = $dataKesakitan->whereHas('dataPasien.dataPuskesmas', function($q) use ($puskesmas){
				$q->where('puskesmas_id', $puskesmas);
			});
		}
		if ($penyakit) {

			$dataKesakitan = $dataKesakitan->whereHas('dataPenyakit', function($q) use ($penyakit) {
				$q->where('penyakit_id', $penyakit);
			});
		}
		if ($tahun) {
			$dataKesakitan = $dataKesakitan->whereYear('kesakitan_tanggal', '=', $tahun);
		}
		if ($bulan) {

			$dataKesakitan = $dataKesakitan->whereMonth('kesakitan_tanggal', '=', $bulan);
		}

		$dataKesakitan = $dataKesakitan->with('dataPenyakit', 'dataPasien.dataPuskesmas.dataKecamatan.dataKabupaten')->get();

		$container = array();
		$zz        = array();

		$urutan = $this->input->get('urutan');
		foreach ($dataKesakitan as $dkk => $dkv) {
			$penyakit  = $dkv->dataPenyakit;
			$pasien    = $dkv->dataPasien;
			$puskesmas = $pasien->dataPuskesmas;
			$kecamatan = $puskesmas->dataKecamatan;
			$kabupaten = $kecamatan->dataKabupaten;

			$uniqueId = md5($dkv->bulan. $penyakit->penyakit_id . $puskesmas->puskesmas_id);

			if (in_array($uniqueId, $zz)) {
				continue;
			} else {
				array_push($zz, $uniqueId);
			}


			$dataPasien = $dataKesakitan->where('bulan', $dkv->bulan)
			->where('dataPenyakit.penyakit_id', $penyakit->penyakit_id)
			->where('dataPasien.dataPuskesmas.puskesmas_id', $puskesmas->puskesmas_id);

			$jmlPasien = $dataPasien->pluck('dataPasien')->count();

			$tmpKabupaten = array(
				'id'     => "kabupaten {$kabupaten->kabupaten_id}",
				'name'   => $kabupaten->kabupaten_nama,

			);
			$tmpKecamatan = array(
				'id'     => "kecamatan {$kecamatan->kecamatan_id}",
				'name'   => $kecamatan->kecamatan_nama,
			);
			$tmpPuskesmas = array(
				'id'     => "puskesmas {$puskesmas->puskesmas_id}",
				'name'   => $puskesmas->puskesmas_nama,
			);
			$tmpStatusPenyakit = array(
				'id'     => "status {$penyakit->penyakit_status}",
				'name'   => hStatusPenyakit($penyakit->penyakit_status),

			);
			$tmpPenyakit = array(
				'id'     => "penyakit {$penyakit->penyakit_nama}",
				'name'   => $penyakit->penyakit_nama,
			);
			$tmpBulan = array(
				'id'     => "bulan {$dkv->bulan}",
				'name'   => hBulan($dkv->bulan),
			);


			$tmpp = array(
				$tmpKabupaten,
				$tmpKecamatan,
				$tmpPuskesmas,
				$tmpStatusPenyakit,
				$tmpPenyakit,
				$tmpBulan,
			);
			if ($urutan) {
				$hasilUrut = explode(',', $urutan);
				$tmp = array();
				for ($i=0; $i < count($tmpp); $i++) { 
					$tmp[] = $tmpp[$hasilUrut[$i]]; 
				}
			} else {
				$tmp = $tmpp;
			}

			

			
			$tmp[0]['id'] = $tmp[0]['id'];
			$tmp[1]['id'] = $tmp[0]['id'] . $tmp[1]['id'];
			$tmp[2]['id'] = $tmp[1]['id'] . $tmp[2]['id'];
			$tmp[3]['id'] = $tmp[2]['id'] . $tmp[3]['id'];
			$tmp[4]['id'] = $tmp[3]['id'] . $tmp[4]['id'];
			$tmp[5]['id'] = $tmp[4]['id'] . $tmp[5]['id'];
			
			$tmp[5]['value'] = $jmlPasien;
			$tmp[5]['parent'] = $tmp[4]['id'];
			$tmp[4]['parent'] = $tmp[3]['id'];
			$tmp[3]['parent'] = $tmp[2]['id'];
			$tmp[2]['parent'] = $tmp[1]['id'];
			$tmp[1]['parent'] = $tmp[0]['id'];
			$tmp[0]['parent'] = null;



			for ($i=0; $i < count($tmp); $i++) { 
				if (!in_array($tmp[$i], $container)) {
					array_push($container, $tmp[$i]);
				}
			}

			

		}

		$this->output
		->set_content_type('application/json', 'utf-8')
		->set_output(json_encode($container, JSON_PRETTY_PRINT))
		->_display();
		exit;

	}

}

/* End of file Treemap.php */
/* Location: ./application/controllers/Treemap.php */
