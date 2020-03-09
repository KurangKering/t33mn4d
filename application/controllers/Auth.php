<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	

	public function index()
	{
		
	}

	public function login_page()
	{
		return view('login');
	}

	public function login() 
	{
		$this->load->model('M_Pengguna');
		$data = $this->input->post();
		$post_data = array(
			'pengguna_username' => $data['username'],
			'pengguna_password' => $data['password'],
		);

		
		$pengguna = $this->M_Pengguna->where($post_data)->first();
		$response = array (
			'message' => '',
			'success' => 0,
		);
		if (!$pengguna) {
			$response['message'] = 'Username / Password Salah';
		} else {
			$sess_data = array(
				'role' => hRole($pengguna->pengguna_akses),
				'user_id' => $pengguna->pengguna_id,
				'akses' => $pengguna->pengguna_akses,
			);


			$this->session->set_userdata(array( 'auth' => $sess_data) );
			$response['success'] = 1;
		}


		echo json_encode($response);
		die();
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */