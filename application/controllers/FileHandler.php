<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class FileHandler extends CI_Controller
{
	private $arrFormInput 	= array();
	private $arrDataInsert	= array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('FileHandlerModel','FHModel');
	}


	public function uploadFile()
	{
		if($this->input->is_ajax_request()){

			$this->arrFormInput['fileName'] = $this->input->post('fileName', TRUE);
			$this->arrFormInput['fullName'] = $_FILES['fileLogData']['name'];
			$user_id						= $this->session->userdata('id_user');
			$dtime							= date('Y-m-d H:i:s');

			$explode_fullname				= explode('.', $this->arrFormInput['fullName']);

			//primary config for upload library
			$config['upload_path']  = './log_files';
			$config['allowed_types']= 'xls|xlsx|XLS|XLSX';
	        $config['file_name']    = $this->arrFormInput['fileName'];
	        //primary config for upload library

	        $this->load->library('upload',$config);

	        if($this->upload->do_upload("fileLogData")){

	        	$this->arrDataInsert['id_user']		= $user_id;
	        	$this->arrDataInsert['file_name']	= $this->arrFormInput['fileName'];
	        	$this->arrDataInsert['date_insert']	= date('Y-m-d H:i:s');
	        	$this->arrDataInsert['file_type']	= $explode_fullname[1];
	        	$this->arrDataInsert['up_to_db']	= 'BELUM';

	        	$this->db->trans_begin(); // begin transaction for input log files data
	        	$inputDataFiles	= $this->FHModel->insertLogDataFile($this->arrDataInsert);

	        	if($this->db->trans_status() === FALSE){

					$this->db->trans_rollback();
					unlink('./file_csv/'.$this->arrFormInput['fileName']);
					echo json_encode(array('response' => 400));

				} else {
							
					$this->db->trans_commit();
					echo json_encode(array('response' => 200));

				}

	        } else {

	        	echo json_encode(array('response' => 400));

	        }


		} else {

			echo "Direct Access is Forbidden";

		}


	}

}
?>