<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyakit extends CI_Controller {

	public function index()
	{
		$data['kelompok'] = $this->M_Kelompok_Penyakit->get();
		return view('penyakit.index', compact('data'));
	}

	public function getDataPenyakit()
	{
		$id = $this->input->post('id');
		$penyakit = $this->M_Penyakit->findOrFail($id);


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($penyakit));
	}
	
	public function delete()
	{
		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		

		$id = $this->input->post('id');
		$data = $this->M_Penyakit->findOrFail($id);
		$deleteData = $data->delete();
		

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));

	}
	public function update()
	{
		$this->load->library('form_validation');
		$post = $this->input->post();
		$this->form_validation->set_rules('kode', 'Kode Penyakit', 'trim|required');
		$this->form_validation->set_rules('kelompok', 'Kelompok Penyakit', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama Penyakit', 'trim|required');
		$this->form_validation->set_rules('menular', 'Tipe Penularan', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'kode' => form_error('kode', '<p class="mt-3 text-danger">', '</p>'),
				'kelompok' => form_error('kelompok', '<p class="mt-3 text-danger">', '</p>'),
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'menular' => form_error('menular', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'penyakit_kode' => $post['kode'],
				'penyakit_nama' => $post['nama'],
				'penyakit_kelompok_penyakit_id' => $post['kelompok'],
				'penyakit_status' => $post['menular'],
			);

			$data = $this->M_Penyakit->findOrFail($post['id']);
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
		$this->form_validation->set_rules('kode', 'Kode Penyakit', 'trim|required|is_unique[penyakit.penyakit_kode]');
		$this->form_validation->set_rules('kelompok', 'Kelompok Penyakit', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama Penyakit', 'trim|required');
		$this->form_validation->set_rules('menular', 'Tipe Penularan', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'kode' => form_error('kode', '<p class="mt-3 text-danger">', '</p>'),
				'kelompok' => form_error('kelompok', '<p class="mt-3 text-danger">', '</p>'),
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'menular' => form_error('menular', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'penyakit_kode' => $post['kode'],
				'penyakit_nama' => $post['nama'],
				'penyakit_kelompok_penyakit_id' => $post['kelompok'],
				'penyakit_status' => $post['menular'],
			);

			$insertData = $this->M_Penyakit->insert($postData);
		}

		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}


	public function jsonDataPenyakit() {
		$this->dt->select('p.penyakit_id, p.penyakit_kode, p.penyakit_nama, p.penyakit_status');
		$this->dt->from('penyakit p');
		$this->dt->join('kelompok_penyakit jp', 'p.penyakit_kelompok_penyakit_id = jp.kelompok_penyakit_id');

		function callback_status($st)
		{
			return hStatusPenyakit($st);
		}
		$this->dt->edit_column('penyakit_status', '$1', "callback_status(penyakit_status)");
		$this->dt->add_column('nomor', '');
		$this->dt->add_column('action', 
			'<a href="javascript:void(0)" class="btn btn-outline-warning" onClick="showModal($1,1)">Ubah</a>
			<a href="javascript:void(0)" class="btn btn-outline-danger" onClick="showModal($1,2)">Hapus</a>'
			, 'penyakit_id'
		);
		echo $this->dt->generate();
		die();
	}
}

/* End of file MstPenyakit.php */
/* Location: ./application/controllers/MstPenyakit.php */
