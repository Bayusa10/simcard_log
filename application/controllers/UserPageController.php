<?php

defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class UserPageController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel','userModel');
	}

	public function index()
	{
		if($this->session->userdata('is_login')){
			
			$this->load->view('homePage');	
		
		} else {

			redirect(base_url());

		}

		
	}

	public function masterDataPage($page_name)
	{
		if($this->session->userdata('is_login')){
			
			$paramIn['main']					= 'main';
			$paramIn['master_data_region']		= 'master_data_region';
			$paramIn['master_data_city']		= 'master_data_city';
			$paramIn['master_data_log']			= 'master_data_log';
			$paramIn['master_data_simcard']		= 'master_data_simcard';

			$layoutShow['main']					= 'masterDataFilePage';
			$layoutShow['master_data_region']	= 'masterDataRegionPage';
			$layoutShow['master_data_city']		= 'masterDataCityPage';
			$layoutShow['master_data_log']		= 'masterDataLogPage';
			$layoutShow['master_data_simcard']	= 'masterDataSIMCard';

			
			if (array_key_exists($page_name, $paramIn)){
				
				$this->load->view($layoutShow[$page_name]);

			} else {

				$this->load->view('errors/html/error_404');			
				
			}	
		
		} else {

			redirect(base_url());

		}


		
	}

	public function logDataPage()
	{
		if($this->session->userdata('is_login')){
			
			$this->load->view('logDataPage');

		} else {

			redirect(base_url());

		}

	}

}

?>