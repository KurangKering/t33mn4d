<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends CI_Controller {

	public function index()
	{	
		$data['kabupaten'] = $this->M_Kabupaten->get();
		return view('kecamatan.index', compact('data'));

		// $this->output
		// ->set_content_type('application/json', 'utf-8')
		// ->set_output(json_encode($this->vars, JSON_HEX_APOS | JSON_HEX_QUOT))
		// ->_display();
		// exit;
	}


	public function getDataKecamatan()
	{
		$id = $this->input->post('id');
		$kecamatan = $this->M_Kecamatan->findOrFail($id);


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($kecamatan));
	}
	
	public function delete()
	{
		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		

		$id = $this->input->post('id');
		$data = $this->M_Kecamatan->findOrFail($id);
		$deleteData = $data->delete();
		

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));

	}
	public function update()
	{
		$this->load->library('form_validation');
		$post = $this->input->post();
		$this->form_validation->set_rules('nama', 'Nama Kecamatan', 'trim|required');
		$this->form_validation->set_rules('kabupaten', 'Nama Kabupaten', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'kabupaten' => form_error('kabupaten', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'kecamatan_nama' => $post['nama'],
				'kecamatan_kabupaten_id' => $post['kabupaten'],
			);

			$data = $this->M_Kecamatan->findOrFail($post['id']);
			$dataUpdate = $data->update($postData);
		}

		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}

	public function store()
	{
		$this->load->library('form_validation');
		$post = $this->input->post();
		$this->form_validation->set_rules('nama', 'Nama Kecamatan', 'trim|required');
		$this->form_validation->set_rules('kabupaten', 'Nama Kabupaten', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'kabupaten' => form_error('kabupaten', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'kecamatan_nama' => $post['nama'],
				'kecamatan_kabupaten_id' => $post['kabupaten'],
			);

			$insertData = $this->M_Kecamatan->insert($postData);
		}

		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}



	public function jsonDataKecamatan() {
		$this->dt->select('kec.kecamatan_id, kec.kecamatan_nama, k.kabupaten_nama');
		$this->dt->from('kecamatan kec');
		$this->dt->join('kabupaten k', 'kec.kecamatan_kabupaten_id = k.kabupaten_id');
		$this->dt->add_column('nomor', '');
		$this->dt->add_column('action', 
			'<a href="javascript:void(0)" class="btn btn-outline-warning" onClick="showModal($1,1)">Ubah</a>
			<a href="javascript:void(0)" class="btn btn-outline-danger" onClick="showModal($1,2)">Hapus</a>'
			, 'kecamatan_id'
		);
		echo $this->dt->generate();
		die();
	}

}

/* End of file MstKecamatan.php */
/* Location: ./application/controllers/MstKecamatan.php */