<?php
defined('BASEPATH') or exit('No direct script access allowed');
Use illuminate\support\Collection;
use \Colors\RandomColor;
class Treemap extends CI_Controller
{

	public function index()
	{
		$tahun     = $this->M_Kesakitan->pluck('kesakitan_tahun')->push((int)date('Y'))->unique()->sort(function($a, $b)  { 
			if ($a == $b) {
				return 0; 
			}
			return ($a > $b) ? -1 : 1; })->flatten();
		$data['kabupaten'] = $this->M_Kabupaten->get();
		$data['kecamatan'] = $this->M_Kecamatan->get();
		$data['puskesmas'] = $this->M_Puskesmas->get();
		$data['status'] = hStatusPenyakit();
		$data['penyakit']  = $this->M_Penyakit->get();
		$data['tahun'] = $tahun;		
		$data['bulan']     = hBulan();
		return view('treemap.index', compact('data'));
	}

	public function map()
	{
		$this->benchmark->mark('doggy');

		$kabupaten = $this->input->get('kabupaten');
		$kecamatan = $this->input->get('kecamatan');
		$puskesmas = $this->input->get('puskesmas');
		$status    = $this->input->get('status');
		$penyakit  = $this->input->get('penyakit');
		$tahun     = $this->input->get('tahun') ?? date('Y');
		$bulan     = $this->input->get('bulan') ?? date('n');
		$urutan    = $this->input->get('urutan');
		$penyakitTerbanyak = $this->input->get('terbanyak');
		$conditions = array(
			'kb.kabupaten_id' => $kabupaten,
			'kc.kecamatan_id' => $kecamatan,
			'ks.kesakitan_puskesmas_id' => $puskesmas,
			'py.penyakit_status' => $status,
			'ks.kesakitan_penyakit_id'  => $penyakit,
			'ks.kesakitan_tahun'        => $tahun,
			'ks.kesakitan_bulan'        => $bulan,

		);

		$conditions = array_filter($conditions);

		$idsPenyakitTerbanyak = array();

		if ($penyakitTerbanyak) {


			$this->db->select(' 
				ks.kesakitan_penyakit_id,
				');
			$this->db->where($conditions);
			$this->db->from('kesakitan ks');
			$this->db->join('puskesmas ps', 'ks.kesakitan_puskesmas_id = ps.puskesmas_id');
			$this->db->join('kecamatan kc', 'ps.puskesmas_kecamatan_id = kc.kecamatan_id');
			$this->db->join('kabupaten kb', 'kc.kecamatan_kabupaten_id = kb.kabupaten_id');
			$this->db->join('penyakit py', 'ks.kesakitan_penyakit_id = py.penyakit_id');
			$this->db->group_by('ks.kesakitan_penyakit_id');
			$this->db->order_by('SUM(ks.kesakitan_BL +
				ks.kesakitan_BP +
				ks.kesakitan_LL +
				ks.kesakitan_LP)', 'desc');
			$this->db->limit($penyakitTerbanyak);
			$idsPenyakitTerbanyak = $this->db->get();
			$idsPenyakitTerbanyak = array_values(array_column($idsPenyakitTerbanyak->result_array(),'kesakitan_penyakit_id'));

		}

		$this->db->select(' 
			ks.kesakitan_bulan,
			ks.kesakitan_tahun,
			ks.kesakitan_puskesmas_id,
			ks.kesakitan_penyakit_id,
			ks.kesakitan_BL,
			ks.kesakitan_BP,
			ks.kesakitan_LL,
			ks.kesakitan_LP,
			(ks.kesakitan_BL +
			ks.kesakitan_BP +
			ks.kesakitan_LL +
			ks.kesakitan_LP) as kesakitan_jumlah,
			ps.puskesmas_id,
			ps.puskesmas_nama,
			kc.kecamatan_id,
			kc.kecamatan_nama,
			kb.kabupaten_id,
			kb.kabupaten_nama,
			py.penyakit_status,
			py.penyakit_nama,
			');
		$this->db->where($conditions);
		if (!empty($idsPenyakitTerbanyak)) {
			$this->db->where_in('ks.kesakitan_penyakit_id', $idsPenyakitTerbanyak, false);
		}
		$this->db->from('kesakitan ks');
		$this->db->join('puskesmas ps', 'ks.kesakitan_puskesmas_id = ps.puskesmas_id');
		$this->db->join('kecamatan kc', 'ps.puskesmas_kecamatan_id = kc.kecamatan_id');
		$this->db->join('kabupaten kb', 'kc.kecamatan_kabupaten_id = kb.kabupaten_id');
		$this->db->join('penyakit py', 'ks.kesakitan_penyakit_id = py.penyakit_id');
		$dKesakitan = $this->db->get();
		$dKesakitan = $dKesakitan->result();
		$dKesakitan = collect($dKesakitan);
		
		
		$dKabupaten = $dKesakitan->unique(function($q) {return $q->kabupaten_id;});
		$dKecamatan = $dKesakitan->unique(function($q) {return $q->kecamatan_id;});
		$dPuskesmas = $dKesakitan->unique(function($q) {return $q->puskesmas_id;});
		$dPenyakit = $dKesakitan->unique(function($q) {return $q->kesakitan_penyakit_id;});



		$dBulan     = $dKesakitan->pluck('kesakitan_bulan')->flatten()->unique();


		$hBulan  = hBulan();
		$hStatus = hStatusPenyakit();
		$container = array();
		$idTmp = array();

		$wKabupaten = RandomColor::many(count($dKabupaten));
		$wKecamatan = RandomColor::many(count($dKecamatan));
		$wPuskesmas = RandomColor::many(count($dPuskesmas));
		$wStatus = RandomColor::many(count($hStatus));
		$wPenyakit = RandomColor::many(count($dPenyakit));
		$wBulan = RandomColor::many(count($dBulan));


		$iwkab = 0;
		foreach ($dKabupaten as $kkab => $vkab) {
			$qJumlahKabupaten = $dKesakitan->where('kabupaten_id', $vkab->kabupaten_id);
			$cJumlahKabupaten = $qJumlahKabupaten->count();

			if ($cJumlahKabupaten < 1) {
				$iwkab++;
				continue;
			}

			$isiTableKabupaten = array(
				'Kota / Kabupaten'     => $vkab->kabupaten_nama,
			);


			$rawTableKabupaten = $this->genRow($isiTableKabupaten);
			$tmpKabupaten = array(
				'id' => md5('kab'. $vkab->kabupaten_id),
				'name' => $vkab->kabupaten_nama,
				'value' => $cJumlahKabupaten,
				'status' => 1,
				'color' => $wKabupaten[$iwkab++],
				'description' => $rawTableKabupaten,

			);

			$xKecamatan = $dKecamatan->where('kabupaten_id',$vkab->kabupaten_id);
			$iwkec = 0;
			foreach ($xKecamatan as $kkec => $vkec) {
				$qJumlahKecamatan = $qJumlahKabupaten->where('kecamatan_id', $vkec->kecamatan_id);
				$cJumlahKecamatan = $qJumlahKecamatan->count();

				if ($cJumlahKecamatan < 1) {
					$iwkec++;
					continue;
				}

				$isiTableKecamatan = array(
					'Kota / Kabupaten'     => $vkab->kabupaten_nama,
					'Kecamatan'     => $vkec->kecamatan_nama,
				);


				$rawTableKecamatan = $this->genRow($isiTableKecamatan);
				$tmpKecamatan = array(
					'id' => md5('kec'.$vkec->kecamatan_id),
					'name' => $vkec->kecamatan_nama,
					'value' => $cJumlahKecamatan,
					'status' => 2,
					'color' => $wKecamatan[$iwkec++],
					'description' => $rawTableKecamatan,



				);
				$xPuskesmas = $dPuskesmas->where('kecamatan_id',$vkec->kecamatan_id);
				$iwpus = 0;
				foreach ($xPuskesmas as $kpus => $vpus) {
					$qJumlahPuskesmas = $qJumlahKecamatan->where('puskesmas_id', $vpus->puskesmas_id);
					$cJumlahPuskesmas = $qJumlahPuskesmas->count();


					if ($cJumlahPuskesmas < 1) {
						$iwpus++;
						continue;
					}
					
					$isiTablePuskesmas = array(
						'Kota / Kabupaten'     => $vkab->kabupaten_nama,
						'Kecamatan'     => $vkec->kecamatan_nama,
						'Puskesmas'     => $vpus->puskesmas_nama,
					);


					$rawTablePuskesmas = $this->genRow($isiTablePuskesmas);

					$tmpPuskesmas = array(
						'id' => md5('pus'.$vpus->puskesmas_id),
						'name' => $vpus->puskesmas_nama,
						'value' => $cJumlahPuskesmas,
						'status' => 3,
						'color' => $wPuskesmas[$iwpus++],
						'description' => $rawTablePuskesmas,




					);


					$iwstat = -1;
					$iwpen = -1;
					foreach ($hStatus as $kstat => $vstat) {
						$qJumlahStatus = $qJumlahPuskesmas->where('penyakit_status', $kstat);
						$cJumlahStatus = $qJumlahStatus->count();

						$iwstat++;
						if ($cJumlahStatus < 1) {
							continue;
						}
						$isiTableStatus = array(
							'Kota / Kabupaten'     => $vkab->kabupaten_nama,
							'Kecamatan'     => $vkec->kecamatan_nama,
							'Puskesmas'     => $vpus->puskesmas_nama,
							'Status'     => $vstat,
						);


						$rawTableStatus = $this->genRow($isiTableStatus);

						$tmpStatus = array(
							'id' => md5('stat'.$kstat),
							'name' => $vstat,
							'value' => $cJumlahStatus,
							'status' => 4,
							'color' => $wStatus[$iwstat],
							'description' => $rawTableStatus,


						);

						$xPenyakit = $dPenyakit->where('penyakit_status',$kstat);

						
						foreach ($xPenyakit as $kpen => $vpen) {

							$iwpen++;
							$qJumlahPenyakit = $qJumlahStatus->where('kesakitan_penyakit_id', $vpen->kesakitan_penyakit_id);
							$cJumlahPenyakit = $qJumlahPenyakit->count();

							if ($cJumlahPenyakit < 1) {
								continue;
							}

							$isiTablePenyakit = array(
								'Kota / Kabupaten'     => $vkab->kabupaten_nama,
								'Kecamatan'     => $vkec->kecamatan_nama,
								'Puskesmas'     => $vpus->puskesmas_nama,
								'Status'     => $vstat,
								'Penyakit'     => $vpen->penyakit_nama,
							);


							$rawTablePenyakit = $this->genRow($isiTablePenyakit);

							$tmpPenyakit = array(
								'id' => md5('pen'.$vpen->kesakitan_penyakit_id),
								'name' => (string) $vpen->kesakitan_penyakit_id,
								'value' => 1,
								'status' => 5,
								'color' => $wPenyakit[$iwpen],
								'description' => $rawTablePenyakit,


							);	

							$iwbul = 0;
							foreach ($dBulan as $vbul) {

								$qJumlahBulan = $qJumlahPenyakit->where('kesakitan_bulan', $vbul);
								$cJumlahBulan = $qJumlahBulan->sum('kesakitan_jumlah');

								if ($cJumlahBulan < 1) {
									$iwbul++;
									continue;
								}

								$isiTableBulan = array(
									'Kota / Kabupaten'     => $vkab->kabupaten_nama,
									'Kecamatan'     => $vkec->kecamatan_nama,
									'Puskesmas'     => $vpus->puskesmas_nama,
									'Status'     => $vstat,
									'Penyakit'     => $vpen->penyakit_nama,
									'Bulan'     => $hBulan[$vbul],
									'Total Sakit' => $cJumlahBulan,
								);


								$rawTableBulan = $this->genRow($isiTableBulan);
								$tmpBulan = array(
									'id' => md5('bul'.$vbul),
									'name' => $hBulan[$vbul],
									'value' => $cJumlahBulan,
									'status' => 6,
									'color' => $wBulan[$iwbul++],
									'description' => $rawTableBulan,




								);

								$tmpp = array(
									$tmpKabupaten,
									$tmpKecamatan,
									$tmpPuskesmas,
									$tmpStatus,
									$tmpPenyakit,
									$tmpBulan,
								);
								if ($urutan != null && $urutan != "sama") {

									$hasilUrut = explode(',', $urutan);
									$tmp = array();
									$countTmp = count($tmpp);
									foreach ($tmpp as $i => $vtmpp) {
										$tmp[$i] = $tmpp[$hasilUrut[$i]]; 
										$tmp[$i]['status'] = $i + 1;
										if ($i+1 < $countTmp) {
											$tmp[$i]['description'] = '';
										} else {
											$tmp[$i]['description'] = $vtmpp['description'];
										}
									}
									

								} else {
									$tmp = $tmpp;
								}




								$tmp[0]['id'] = ($tmp[0]['id']);
								$tmp[0]['parentt'] = '';

								foreach ($tmp as $i => $vtmp) {
									if ($i > 0 ) {
										$tmp[$i]['id'] = md5($tmp[$i-1]['id'] . $tmp[$i]['id']);
										$tmp[$i]['parentt'] = $tmp[$i-1]['id'];
									}

									if (!isset($container[$tmp[$i]['id']])) {
										$container[$tmp[$i]['id']] = $tmp[$i];
									}

								}
								


								




							}

						}

					}

				}

			}

		}

		$json = array(
			'data' => array_values($container),
			'table' => '',
			'subtitle' => '',
		);

		$json = gzencode(json_encode($json));

		$this->output
		->set_header('Content-Encoding: gzip')
		->set_content_type('application/json', 'utf-8')
		->set_output(($json))
		->_display();
		exit;

	}

	private function genRow($data,
		$openTag = "<table class=\"table table-tooltip\">", $closeTag = "</table>") {
		$rows = $openTag;
		$rows .= "<tbody>";
		foreach ($data as $k => $v) {
			$rows .=
			"<tr><th>{$k}</th><td>: {$v}</td></tr>";
		}
		$rows . "</tbody>";
		$rows .= $closeTag;
		return $rows;
	}

}

/* End of file Treemap.php */
/* Location: ./application/controllers/Treemap.php */
