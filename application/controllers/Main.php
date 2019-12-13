<?php

defined('BASEPATH') OR exit ('Direct Script Not Allowed');

/**
 * 
 */
class Main extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('main_page');
	}
}



?>