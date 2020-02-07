<?php

defined('BASEPATH') OR exit ('Direct Script Not Allowed');


class Main extends CI_Controller
{
	
	private $arrFormInput 	= array();
	private $arrResponse	= array();	
	private $userID;

	function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel','userModel');
	}

	public function index()
	{
		if(!$this->session->userdata('is_login')){
			
			$this->load->view('mainPage');	
		
		} else {

			$userMenu	= $this->session->userdata('user_page');
			redirect(base_url().$userMenu);

		}
		
	}

	public function doLogin()
	{
		if($this->input->is_ajax_request()){

			$this->arrFormInput['username'] = $this->input->post('username', TRUE);
			$this->arrFormInput['password']	= substr(hash("sha256", $this->input->post('password', TRUE)), 0,8);
			$getUserLoginStat 				= $this->userModel->checkUser($this->arrFormInput['username'], $this->arrFormInput['password']);

			$checkUserLogin					= $getUserLoginStat->num_rows();

			if($checkUserLogin > 0){

				$isLogin			= $getUserLoginStat->row()->IS_LOGIN;
				$this->userID		= $getUserLoginStat->row()->U_ID;
				$status 			= TRUE;

				if($isLogin == FALSE){
					
					$updateUserLoginStatus	= $this->userModel->updateLoginStat($this->userID, $status);

					if ($updateUserLoginStatus) {
						
						$this->arrResponse['is_user']	 = 200;
						$this->arrResponse['db_err']	 = FALSE;
						$this->arrResponse['is_login']	 = FALSE;
						$this->arrResponse['user_name']	 = $this->arrFormInput['username'];
						$this->arrResponse['login_time'] = date('Y-m-d H:i:s');
						$this->arrResponse['user_ip']	 = $_SERVER['REMOTE_ADDR'];
						$this->arrResponse['route_page'] = 'main_page';

						$this->session->set_userdata(array('id_user' 	=> $this->userID,
														   'is_login'	=> TRUE,
														   'user_page'	=> 'main_page'));
						
						echo json_encode(array('response'=> $this->arrResponse));					

					} else {

						$this->arrResponse['is_user']	 = 200;
						$this->arrResponse['db_err']	 = TRUE;
						$this->arrResponse['is_login']	 = TRUE;

						echo json_encode(array('response' => $this->arrResponse));

					}
					

				} else {
					
					$this->arrResponse['is_user']	 = 200;
					$this->arrResponse['db_err']	 = FALSE;
					$this->arrResponse['is_login']	 = TRUE;
					$this->arrResponse['user_ip']	 = $_SERVER['REMOTE_ADDR'];
					
					echo json_encode(array('response' => $this->arrResponse));

				}


			} else {
				
				$this->arrResponse['is_user']	 =	404;
				echo json_encode(array('response' => $this->arrResponse));

			}

		} else {

			echo "Direct Scripts Not Allowed";

		}

	}

	public function doLogout()
	{
		$u_id 					= $this->session->userdata('id_user');
		$status 				= FALSE;
		$updateUserLoginStatus	= $this->userModel->updateLoginStat($u_id, $status);

		if($updateUserLoginStatus){
			$this->session->sess_destroy();
			echo json_encode(array('response' => 200));
		} else {
			echo json_encode(array('response' => 400));
		}

	}

}



?>