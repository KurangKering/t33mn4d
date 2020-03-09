<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puskesmas extends MY_Controller {

	public function index()
	{	
		$this->data['kecamatan'] = $this->M_Kecamatan->get();
		return view('puskesmas.index', array('data' => $this->data));

		// $this->output
		// ->set_content_type('application/json', 'utf-8')
		// ->set_output(json_encode($this->vars, JSON_HEX_APOS | JSON_HEX_QUOT))
		// ->_display();
		// exit;
	}


	public function getDataPuskesmas()
	{
		$id = $this->input->post('id');
		$puskesmas = $this->M_Puskesmas->findOrFail($id);


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($puskesmas));
	}
	
	public function delete()
	{
		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		

		$id = $this->input->post('id');
		$data = $this->M_Puskesmas->findOrFail($id);
		$deleteData = $data->delete();
		

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));

	}
	public function update()
	{
		$this->load->library('form_validation');
		$post = $this->input->post();
		$this->form_validation->set_rules('nama', 'Nama Puskesmas', 'trim|required');
		$this->form_validation->set_rules('kecamatan', 'Nama Kabupaten', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'kecamatan' => form_error('kecamatan', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'puskesmas_nama' => $post['nama'],
				'puskesmas_kecamatan_id' => $post['kecamatan'],
			);

			$data = $this->M_Puskesmas->findOrFail($post['id']);
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
		$this->form_validation->set_rules('nama', 'Nama Puskesmas', 'trim|required');
		$this->form_validation->set_rules('kecamatan', 'Nama Kabupaten', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'kecamatan' => form_error('kecamatan', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'puskesmas_nama' => $post['nama'],
				'puskesmas_kecamatan_id' => $post['kecamatan'],
			);

			$insertData = $this->M_Puskesmas->insert($postData);
		}

		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}



	public function jsonDataPuskesmas() {
		$this->dt->select('p.puskesmas_id, p.puskesmas_nama, k.kecamatan_nama');
		$this->dt->from('puskesmas p');
		$this->dt->join('kecamatan k', 'p.puskesmas_kecamatan_id = k.kecamatan_id');
		$this->dt->add_column('nomor', '');
		$this->dt->add_column('action', 
			'<a href="javascript:void(0)" class="btn btn-outline-warning" onClick="showModal($1,1)">Ubah</a>
			<a href="javascript:void(0)" class="btn btn-outline-danger" onClick="showModal($1,2)">Hapus</a>'
			, 'puskesmas_id'
		);
		echo $this->dt->generate();
		die();
	}

}

/* End of file MstPuskesmas.php */
/* Location: ./application/controllers/MstPuskesmas.php */