<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $data = array();

	public function __construct()
	{
		parent::__construct();

		$priveleges = array (
			'1' => array(
				'dashboard' => 'dashboard',
				'kesakitan' => 'kesakitan',
			),
			'2' => array(
				'dashboard' => 'dashboard',
				'treemap' => 'treemap',
				'kecamatan' => 'kecamatan',
				'penyakit' => 'penyakit',
 				'puskesmas' => 'puskesmas',


			)
		);



		$auth = $this->session->userdata('auth');
		$akses = isset($auth['akses']) ? $auth['akses'] : '';


		if (isset($priveleges[$akses])) {
			$controller = strtolower($this->router->fetch_class());


			if (!isset($priveleges[$akses][$controller])) {


				view('errors.error_akses');
				die();
			} 
		} else {
			$this->session->sess_destroy();
			redirect('login');
			die();
		}

		$this->data['auth'] = $this->session->userdata('auth');


	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */