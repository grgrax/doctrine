<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class donee extends Frontend_Controller {

	public $data;
	const MODULE='donee/';

	function __construct()
	{
		try {
			parent::__construct();
			
			//session handling rax
			echo uri_string();
			if(!$this->session->userdata('donee_id'))
				redirect('donee/auth/login');	
			else{
				redirect('donee/dashboard');
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('error','Donnee not logged in');
			redirect('donee/auth/login');			
		}
	}

	public function index()
	{
		
	}

	
}
/* End of file sample.php */
/* Location: ./application/modules/sample/controllers/sample.php */