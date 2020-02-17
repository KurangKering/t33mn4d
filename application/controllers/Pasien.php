<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien extends CI_Controller {

	public function index()
	{
		$data['puskesmas'] = $this->M_Puskesmas->orderBy('puskesmas_nama')->get();
		return view('pasien.index', compact('data'));
	}

	

	public function getDataPasien()
	{
		$id = $this->input->post('id');
		$pasien = $this->M_Pasien->findOrFail($id);


		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($pasien));
	}
	
	public function delete()
	{
		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		

		$id = $this->input->post('id');
		$data = $this->M_Pasien->findOrFail($id);
		$deleteData = $data->delete();
		

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));

	}
	public function update()
	{
		$this->load->library('form_validation');
		$post = $this->input->post();
		

		$this->form_validation->set_rules('nama', 'Nama Pasien', 'trim|required');
		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('nama_kk', 'Nama KK', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('puskesmas', 'Puskesmas', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'jk' => form_error('jk', '<p class="mt-3 text-danger">', '</p>'),
				'nama_kk' => form_error('nama_kk', '<p class="mt-3 text-danger">', '</p>'),
				'alamat' => form_error('alamat', '<p class="mt-3 text-danger">', '</p>'),
				'puskesmas' => form_error('puskesmas', '<p class="mt-3 text-danger">', '</p>'),
				'tanggal_lahir' => form_error('tanggal_lahir', '<p class="mt-3 text-danger">', '</p>'),
				'tempat_lahir' => form_error('tempat_lahir', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'pasien_nama' => $post['nama'],
				'pasien_jk' => $post['jk'],
				'pasien_nama_kk' => $post['nama_kk'],
				'pasien_alamat' => $post['alamat'],
				'pasien_puskesmas_id' => $post['puskesmas'],
				'pasien_tanggal_lahir' => $post['tanggal_lahir'],
				'pasien_tempat_lahir' => $post['tempat_lahir'],
			);

			$data = $this->M_Pasien->findOrFail($post['id']);
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
		$this->form_validation->set_rules('nama', 'Nama Pasien', 'trim|required');
		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('nama_kk', 'Nama KK', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		$this->form_validation->set_rules('puskesmas', 'Puskesmas', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');

		$json = array();
		$json['success'] = 1;
		$json['messages'] = array();
		if (!$this->form_validation->run()) {
			$json['messages'] = array(
				'nama' => form_error('nama', '<p class="mt-3 text-danger">', '</p>'),
				'jk' => form_error('jk', '<p class="mt-3 text-danger">', '</p>'),
				'nama_kk' => form_error('nama_kk', '<p class="mt-3 text-danger">', '</p>'),
				'alamat' => form_error('alamat', '<p class="mt-3 text-danger">', '</p>'),
				'puskesmas' => form_error('puskesmas', '<p class="mt-3 text-danger">', '</p>'),
				'tanggal_lahir' => form_error('tanggal_lahir', '<p class="mt-3 text-danger">', '</p>'),
				'tempat_lahir' => form_error('tempat_lahir', '<p class="mt-3 text-danger">', '</p>'),
			);
			$json['messages'] = array_filter($json['messages']);
			$json['success'] = 0;
		} else {
			$postData = array(
				'pasien_nama' => $post['nama'],
				'pasien_jk' => $post['jk'],
				'pasien_nama_kk' => $post['nama_kk'],
				'pasien_alamat' => $post['alamat'],
				'pasien_puskesmas_id' => $post['puskesmas'],
				'pasien_tanggal_lahir' => $post['tanggal_lahir'],
				'pasien_tempat_lahir' => $post['tempat_lahir'],
			);

			$insertData = $this->M_Pasien->insert($postData);
		}

		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json));
	}



	public function jsonDataPasien() {
		$this->dt->select('ps.pasien_id, ps.pasien_nama, ps.pasien_jk, ps.pasien_nama_kk, ps.pasien_alamat, ps.pasien_tanggal_lahir, ps.pasien_tempat_lahir, pk.puskesmas_nama');
		$this->dt->from('pasien ps');
		$this->dt->join('puskesmas pk', 'ps.pasien_puskesmas_id = pk.puskesmas_id');
		$this->dt->add_column('nomor', '');
		$this->dt->add_column('action', 
			'<a href="javascript:void(0)" class="btn btn-outline-warning" onClick="showModal($1,1)">Ubah</a>
			<a href="javascript:void(0)" class="btn btn-outline-danger" onClick="showModal($1,2)">Hapus</a>'
			, 'pasien_id'
		);
		function callback_jk($jk)
		{
			return hJK($jk);
		}
		$this->dt->add_column('jk', '$1', "callback_jk(pasien_jk)");

		function callback_ttl($tempat, $tanggal)
		{
			return "$tempat, $tanggal";
		}
		$this->dt->add_column('ttl', '$1', "callback_ttl(pasien_tempat_lahir, pasien_tanggal_lahir)");

		function callback_usia($tanggal)
		{
			$tanggal_lahir = new DateTime($tanggal);
			$today = new DateTime();
			$selisih = $today->diff($tanggal_lahir);
			return $selisih->y . ' Tahun';
		}
		$this->dt->add_column('usia', '$1', "callback_usia(pasien_tanggal_lahir)");

		echo $this->dt->generate();
		die();
	}
}


/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */
