<?php
defined('BASEPATH') or exit('No direct script access allowed');
Use illuminate\support\Collection;
use \Colors\RandomColor;
use Dompdf\Dompdf;
class Treemap extends MY_Controller
{

	public function index()
	{
		$tahun     = $this->M_Kesakitan->pluck('kesakitan_tahun')->push((int)date('Y'))->unique()->sort(function($a, $b)  { 
			if ($a == $b) {
				return 0; 
			}
			return ($a > $b) ? -1 : 1; })->flatten();

		$this->data['kabupaten'] = $this->M_Kabupaten->get();
		$this->data['kecamatan'] = $this->M_Kecamatan->get();
		$this->data['puskesmas'] = $this->M_Puskesmas->get();
		$this->data['status'] = hStatusPenyakit();
		$this->data['penyakit']  = $this->M_Penyakit->get();
		$this->data['tahun'] = $tahun;		
		$this->data['bulan']     = hBulan();

		return view('treemap.index', array('data' => $this->data));
	}

	public function report()
	{

		$kabupaten = $this->input->post('kabupaten');
		$kecamatan = $this->input->post('kecamatan');
		$puskesmas = $this->input->post('puskesmas');
		$status    = $this->input->post('status');
		$penyakit  = $this->input->post('penyakit');
		$tahun     = $this->input->post('tahun') ?? date('Y');
		$bulan     = $this->input->post('bulan') ?? date('n');
		$penyakitTerbanyak = $this->input->post('terbanyak');


		$params = array(
			'conditions' => array(
				'kabupaten' => $kabupaten,
				'kecamatan' => $kecamatan,
				'puskesmas' => $puskesmas,
				'status' => $status,
				'penyakit' => $penyakit,
				'tahun' => $tahun,
				'bulan' => $bulan,
			),
			'top_data' => $penyakitTerbanyak,
			'urutan' => $urutan ?? 'sama',
		);
		$this->load->library('LibraryTreemap', $params);


		$html = $this->librarytreemap->report();
		$response = array(
			'source' => '',
			'success' => 0,
		);
		if ($html) {
			
			$this->load->library('Pdfgenerator');
			$this->pdfgenerator->generate($html, 'data-kesakitan-'. date('d-m-Y H:i:s'), TRUE, 'A4','portrait');

		} else {

		}


		



	}

	public function map()
	{

		$kabupaten = $this->input->get('kabupaten');
		$kecamatan = $this->input->get('kecamatan');
		$puskesmas = $this->input->get('puskesmas');
		$status    = $this->input->get('status');
		$penyakit  = $this->input->get('penyakit');
		$tahun     = $this->input->get('tahun') ?? date('Y');
		$bulan     = $this->input->get('bulan') ?? date('n');
		$urutan    = $this->input->get('urutan');
		$penyakitTerbanyak = $this->input->get('terbanyak');


		$params = array(
			'conditions' => array(
				'kabupaten' => $kabupaten,
				'kecamatan' => $kecamatan,
				'puskesmas' => $puskesmas,
				'status' => $status,
				'penyakit' => $penyakit,
				'tahun' => $tahun,
				'bulan' => $bulan,
			),
			'top_data' => $penyakitTerbanyak,
			'urutan' => $urutan ?? 'sama',
		);
		$this->load->library('LibraryTreemap', $params);

		$result = $this->librarytreemap->generate();

		$this->output
		->set_header('Content-Encoding: gzip')
		->set_content_type('application/json', 'utf-8')
		->set_output($result)
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
