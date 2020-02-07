<?php

defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class UserTransactionController extends CI_Controller
{
	
	private $array_data = array();
	private $formInput	= array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('UserTransactionModel','userTransaction');
		$this->load->library('ReadFile');
		$this->load->library('FilePropertyHandler');
		$this->load->library('RegionHandler');
		$this->load->library('CityHandler');
		$this->load->library('SIMCardHandler');
		$this->load->library('LogDataHandler');
		$this->load->library('ExportExcel');
	}

	public function listLogFile($with_id_file)
	{
		if($this->input->is_ajax_request()){

			$data 	= $this->userTransaction->listFileLogData();
			
			if($with_id_file == 0){

				$numb	= 1;

				foreach ($data as $value) {
					
					$getDateUpDB = $this->DateUpDB($value->DATE_UP_TO_DB);

					array_push($this->array_data, array('Numb' 			=> $numb,
														'File Name'		=> $value->FILE_NAME,
														'Date Upload'	=> $value->DATE_INSERT,
														'Uploader'		=> $value->USERNAME,
														'Up to DB'		=> $value->UP_TO_DB,
														'Date Up DB'	=> $getDateUpDB));
					$numb++;
				}

				echo json_encode(array('data' => $this->array_data));

			} elseif($with_id_file == 1) {

				$numb	= 1;

				foreach ($data as $value) {
					
					$getDateUpDB = $this->DateUpDB($value->DATE_UP_TO_DB);

					array_push($this->array_data, array('Numb' 			=> $numb,
														'File Name'		=> $value->FILE_NAME,
														'Date Upload'	=> $value->DATE_INSERT,
														'Uploader'		=> $value->USERNAME,
														'Action'		=> '<input type="radio" name="fileChoosen" id="fileChoosen" value='.$value->ID_FILE.'>'));
					$numb++;
				}

				echo json_encode(array('data' => $this->array_data));

			} else {

				$numb	= 1;

				foreach ($data as $value) {
					
					$getDateUpDB = $this->DateUpDB($value->DATE_UP_TO_DB);

					array_push($this->array_data, array('Numb' 			=> $numb,
														'File Name'		=> $value->FILE_NAME,
														'Date Upload'	=> $getDateUpDB,
														'Up to DB'		=> $value->UP_TO_DB,
														'Action'		=> '<input type="radio" name="fileChoosen" id="fileChoosen" value='.$value->ID_FILE.'>'
														));
					$numb++;
				}

				echo json_encode(array('data' => $this->array_data));

			}

		
		} else {

			echo "Direct Access is Forbidden";

		}
	}

	private function DateUpDB($value)
	{
		if($value == NULL){
			return '-';
		} else {
			return $value;
		}
	}

	/* All Function About Master Data Region */
	public function listRegion()
	{
		if($this->input->is_ajax_request()){
			
			$regional 	= $this->userTransaction->listRegion();
			$numb 		= 1;

			foreach ($regional as $value) {
				array_push($this->array_data, array('Numb' 			=> $numb,
													'Region Name'	=> $value->REG_NAME,
													'User Input'	=> $value->USERNAME));
				$numb++;
			}

			echo json_encode(array('data' => $this->array_data));
		
		} else {

			echo "Direct Access Not Allowed";

		}
	}

	public function addRegionalBatch()
	{
		if($this->input->is_ajax_request()){

			$this->formInput['idFile']	= $this->input->post('idFile', TRUE);
			$regionalBatch				= array();
			$id_user					= $this->session->userdata('id_user');

			$full_fileName 				= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_NAME;
			$explode_fName				= explode(" ", $full_fileName);
			
			$fileName 					= $this->filepropertyhandler->setFName($explode_fName);
			$fileType					= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_TYPE;

			$readData					= json_decode($this->readfile->readFileLog($fileType, $fileName), TRUE);
			$regionColumn				= 'C';

			$columnName					= $readData[1][$regionColumn];

			$rawDescription 			= $this->userTransaction->getFileDescription($this->formInput['idFile'])->row()->UP_TO_DB;

			if($columnName == 'Region'){

				$rawRegionalBatch 	= $this->regionhandler->setRawBatchRegional($readData, $regionColumn);
				$descFile 			= $this->filepropertyhandler->setDescription($rawDescription, '[ Tambah Provinsi ]');
				$regionalBatch 		= $this->regionhandler->setRegionalBatch($rawRegionalBatch, $id_user);


				if(count($regionalBatch) > 0){

					$this->db->trans_begin();
					$insertRegion  		= $this->userTransaction->insertRegionBatch($regionalBatch);
					$updateDescription	= $this->userTransaction->updateFileDescription($this->formInput['idFile'], $descFile);

					if($this->db->trans_status() === FALSE){

						$this->db->trans_rollback();
						echo json_encode(array('response' => 400));

					} else {
									
						$this->db->trans_commit();
						echo json_encode(array('response' => 200));

					}

				} else {

					echo json_encode(array('response' => 204));

				}

			} else {
				
				echo json_encode(array('response' => 404));

			}

		} else {

			echo "Direct Access Not Allowed";

		}
	}

	public function addRegion()
	{
		if($this->input->is_ajax_request()){

			$this->formInput['regionName'] 	= $this->input->post('regionName', TRUE);
			$id_user						= $this->session->userdata('id_user');

			/* Check, if region was inserted, then reject, if don't store it to db */
			$checkRegion					= $this->userTransaction->checkRegion($this->formInput['regionName']);

			if($checkRegion->num_rows() == 0){

				$this->array_data['REG_NAME']	= $this->formInput['regionName'];
				$this->array_data['U_INS']		= $id_user;

				$this->db->trans_begin();
				$insertRegion 					= $this->userTransaction->insertRegion($this->array_data);

				if($this->db->trans_status() === FALSE){

					$this->db->trans_rollback();
					echo json_encode(array('response' => 400));

				} else {
									
					$this->db->trans_commit();
					echo json_encode(array('response' => 200));

				}

			} else {

				echo json_encode(array('response' => 204));

			}

		} else {

			echo "Direct Access Not Allowed";

		}

	}
	/* All Function About Master Data Region */


	/* All Function About Master Data City */
	public function cityList()
	{
		$listCity = $this->cityhandler->listCity();
		echo json_encode(array('data' => $listCity));
	}


	public function addCityBatch()
	{
		if($this->input->is_ajax_request()){

			$this->formInput['idFile']	= $this->input->post('idFile', TRUE);
			$id_user					= $this->session->userdata('id_user');

			$full_fileName 				= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_NAME;
			$explode_fName				= explode(" ", $full_fileName);
			
			$fileName 					= $this->filepropertyhandler->setFName($explode_fName);
			$fileType					= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_TYPE;

			$readData					= json_decode($this->readfile->readFileLog($fileType, $fileName), TRUE);
			$cityColumn					= 'B';
			$regionColumn				= 'C';

			$columnName					= $readData[1][$cityColumn];
			$rawDescription 			= $this->userTransaction->getFileDescription($this->formInput['idFile'])->row()->UP_TO_DB;

			if($columnName == 'City'){
				
				$firstRow 	= 2;
				$lastRow	= count($readData)+1;	

				$rawData 	= $this->cityhandler->setRawBatchCity($firstRow, $lastRow, $readData, $cityColumn, $regionColumn);
				$cityBatch  = $this->cityhandler->setBatchCity($rawData, $id_user);
				$descFile 	= $this->filepropertyhandler->setDescription($rawDescription, '[ Tambah Kota/Kab. ]');

				if(count($cityBatch) > 0){

					$this->db->trans_begin();
					$insertData 		= $this->userTransaction->insertCityBatch($cityBatch);
					$updateDescription	= $this->userTransaction->updateFileDescription($this->formInput['idFile'], $descFile);

					if($this->db->trans_status() === FALSE){

						$this->db->trans_rollback();
						echo json_encode(array('response' => 400));

					} else {
									
						$this->db->trans_commit();
						echo json_encode(array('response' => 200));

					}

				} else {

					echo json_encode(array('response' => 204));

				}
				

			} else {
				
				echo json_encode(array('response' => 404));

			}

		} else {

			echo "Direct Access Not Allowed";

		}

	}

	public function getListRegion()
	{
		if($this->input->is_ajax_request()){
		
			$dataProvince = $this->regionhandler->listRegion();
			echo json_encode($dataProvince);

		} else {

			echo "Direct Access Not Allowed";

		}
	}


	public function addCity()
	{
		if ($this->input->is_ajax_request()) {
			
			$this->formInput['idRegion']	= $this->input->post('idRegion', TRUE);
			$this->formInput['cityName']	= $this->input->post('cityName', TRUE);
			$id_user						= $this->session->userdata('id_user');

			$checkData 						= $this->userTransaction->_checkCity($this->formInput['idRegion'], $this->formInput['cityName']);

			if($checkData->num_rows() == 0){

				$this->array_data['REG_ID']		= $this->formInput['idRegion']; 
				$this->array_data['CITY_NAME']	= $this->formInput['cityName'];
				$this->array_data['U_INS']		= $id_user; 

				$this->db->trans_begin();
				$insertCity 					= $this->userTransaction->insertCity($this->array_data);


				if($this->db->trans_status() === FALSE){

					$this->db->trans_rollback();
					echo json_encode(array('response' => 400));

				} else {
										
					$this->db->trans_commit();
					echo json_encode(array('response' => 200));

				}


			} else {

				echo json_encode(array('response' => 204));

			}

		} else {

			echo "Direct Scripts Not Allowed";

		}

	}

	/* Function all about SIM Card Master Data */
	public function listSIMCard($slug)
	{
		if ($this->input->is_ajax_request()) {
			
			$choosen 		= $slug;

			$dataSIMCard 	= $this->simcardhandler->listSIMCard($choosen);
			echo json_encode(array('data' => $dataSIMCard));

		} else {

			echo "Direct Scripts Not Allowed";

		}
	}

	
	public function addSIMCardBatch()
	{
		if ($this->input->is_ajax_request()) {
			
			$this->formInput['idFile']	= $this->input->post('idFile', TRUE);
			$id_user					= $this->session->userdata('id_user');

			$full_fileName 				= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_NAME;
			$explode_fName				= explode(" ", $full_fileName);
				
			$fileName 					= $this->filepropertyhandler->setFName($explode_fName);
			$fileType					= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_TYPE;

			$readData					= json_decode($this->readfile->readFileLog($fileType, $fileName), TRUE);

			$rtuColumn 					= 'A';
			$cityColumn					= 'B';
			$regionColumn				= 'C';
			$simcardColumn 				= 'D';
			$latestRead					= 'E';
			
			$columnName					= $readData[1][$simcardColumn];
			$rawDescription 			= $this->userTransaction->getFileDescription($this->formInput['idFile'])->row()->UP_TO_DB;


			if($columnName == 'SIM Card Number'){

				$rawBatchData 	= $this->simcardhandler->setRawBatchData($readData, $rtuColumn, $cityColumn, $regionColumn, $simcardColumn, $latestRead);
				$simcardBatch  	= $this->simcardhandler->setBatchData($rawBatchData, $id_user);
				$descFile 		= $this->filepropertyhandler->setDescription($rawDescription, '[ Update Data SIM Card ]');


				if(count($simcardBatch) > 0){

					$this->db->trans_begin();
					
					$insertDataBatch 	= $this->userTransaction->insertSIMBatch($simcardBatch);
					$arrLatestRead 		= $this->simcardhandler->setLatestReading($rawBatchData);
					$updateLatestRead	= $this->userTransaction->updateLatestRead($arrLatestRead);
					$updateDescription	= $this->userTransaction->updateFileDescription($this->formInput['idFile'], $descFile);

					if($this->db->trans_status() === FALSE){

						$this->db->trans_rollback();
						echo json_encode(array('response' => 400));

					} else {
										
						$this->db->trans_commit();
						echo json_encode(array('response' => 200));

					}

				} else {

					$this->db->trans_begin();
					$arrLatestRead 		= $this->simcardhandler->setLatestReading($rawBatchData);
					$updateLatestRead	= $this->userTransaction->updateLatestRead($arrLatestRead);

					if($this->db->trans_status() === FALSE){

						$this->db->trans_rollback();
						echo json_encode(array('response' => 400));

					} else {
										
						$this->db->trans_commit();
						echo json_encode(array('response' => 200));

					}

				}


			} else {

				echo json_encode(array('response' => 404));

			}

		} else {

			echo "Direct Scripts Not Allowed";

		}

	}

	public function getCity()
	{
		if($this->input->is_ajax_request()){

			$this->formInput['idRegion']	= $this->input->post('idRegion', TRUE);
			$data 							= $this->cityhandler->getCity($this->formInput['idRegion']);
			echo json_encode($data); 

		} else {

			echo "Direct Access Not Allowed";

		}
	}

	/* Function all about Clean DB */
	public function cleanLogSCard()
	{

		if($this->input->is_ajax_request()){

			$checkIsEmpty = $this->userTransaction->checkLogScard();

			if($checkIsEmpty->num_rows() > 0){

				$this->db->trans_begin();
				$cleandetailLog 	= $this->userTransaction->cleanLogSCard('log_simcard_table');
				$cleanLogSCNotFound	= $this->userTransaction->cleanLogSCard('log_sc_notfound_table');
				$cleanSCNotFound	= $this->userTransaction->cleanLogSCard('sc_numbers_notfound');
				
				if($this->db->trans_status() === FALSE){

					$this->db->trans_rollback();
					echo json_encode(array('response' => 400));

				} else {
											
					$this->db->trans_commit();
					echo json_encode(array('response' => 200));

				}

			} else {

				echo json_encode(array('response' => 200));			

			}

		} else {

			echo "Direct Scripts Not Allowed";

		}				

	}

	/*Function about upload data log simcard*/
	public function getFileName()
	{
		if ($this->input->is_ajax_request()) {
		
			$this->formInput['idFile']	= $this->input->post('idFile', TRUE);
			$full_fileName 				= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_NAME;
			echo json_encode(array('response' => $full_fileName));
		
		} else {

			echo "Direct Scripts Not Allowed";

		}

	}


	public function insertLogSIMCard()
	{
		if ($this->input->is_ajax_request()) {

			$this->formInput['idFile']	= 3;//$this->input->post('idFile', TRUE);
			$id_user					= $this->session->userdata('id_user');

			$logCount					= $this->userTransaction->listLogSCard(0);

			if($logCount->num_rows() == 0){

				$full_fileName 		= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_NAME;
				$explode_fName		= explode(" ", $full_fileName);
					
				$fileName 			= $this->filepropertyhandler->setFName($explode_fName);
				$fileType			= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_TYPE;

				$readData			= json_decode($this->readfile->readFileLog($fileType, $fileName), TRUE);
				$insDateColumn		= 'B';
				$smsDateColumn		= 'C';
				$emailDateColumn	= 'D';
				$smsSender			= 'E';
				$smsContent			= 'F';

				$columnName			= $readData[1][$smsContent];

				if($columnName == 'sms_isi'){

					$rawDescription 	= $this->userTransaction->getFileDescription($this->formInput['idFile'])->row()->UP_TO_DB;

					$logbatchData      	= $this->logdatahandler->setLogDataBatch($readData, $insDateColumn, $smsDateColumn, $emailDateColumn, $smsSender, $smsContent, $id_user);

					/*Fungsi untuk setting simcard yang tidak ada di dalam master data simcard*/
					$batchDataNotFound 	= $this->logdatahandler->setLogDataNotFoundBatch($readData, $insDateColumn, $smsDateColumn, $emailDateColumn, $smsSender, $smsContent, $id_user);

					$scNFBatch			= $this->simcardhandler->setBatchDataSCNotFound($batchDataNotFound, $id_user);
					/* --------------------------- */

					$descFile 			= $this->filepropertyhandler->setDescription($rawDescription, '[ Upload Log SIM Card ]');

					if(count($scNFBatch) > 0){

						$this->db->trans_begin();
					
						$insertLog 			= $this->userTransaction->insertLogSIMCard($logbatchData);
						$insertSCNF 		= $this->userTransaction->insertSIMCardNF($scNFBatch);
						$updateDescription	= $this->userTransaction->updateFileDescription($this->formInput['idFile'], $descFile);

						if($this->db->trans_status() === FALSE){

							$this->db->trans_rollback();
							echo json_encode(array('response' => 400));
						
						} else {
						
							$this->db->trans_commit();
							echo json_encode(array('response' 			=> 200,
												   'simcard_not_found'	=> TRUE));
						
						}


					} else {

						$this->db->trans_begin();
					
						$insertLog 			= $this->userTransaction->insertLogSIMCard($logbatchData);
						$updateDescription	= $this->userTransaction->updateFileDescription($this->formInput['idFile'], $descFile);

						if($this->db->trans_status() === FALSE){

							$this->db->trans_rollback();
							echo json_encode(array('response' => 400));
						
						} else {
						
							$this->db->trans_commit();
							echo json_encode(array('response' 			=> 200,
												   'simcard_not_found'	=> FALSE));
						
						}						

					}

				} else {
						
					echo json_encode(array('response' => 404));

				}



			} else {

				echo json_encode(array('response' => 204));

			}


		} else {

			echo "Direct Access Not Allowed";

		}
	}

	public function insertLogSCardNF()
	{
		if ($this->input->is_ajax_request()) {

			$this->formInput['idFile']	= $this->input->post('idFile', TRUE);
			$id_user					= $this->session->userdata('id_user');

			$full_fileName 				= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_NAME;
			$explode_fName				= explode(" ", $full_fileName);
						
			$fileName 					= $this->filepropertyhandler->setFName($explode_fName);
			$fileType					= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_TYPE;

			$readData					= json_decode($this->readfile->readFileLog($fileType, $fileName), TRUE);
			$insDateColumn				= 'B';
			$smsDateColumn				= 'C';
			$emailDateColumn			= 'D';
			$smsSender					= 'E';
			$smsContent					= 'F';

			$columnName			= $readData[1][$smsContent];

			if($columnName == 'sms_isi'){

				$batchDataNotFound 	= $this->logdatahandler->setLogDataNotFoundBatch($readData, $insDateColumn, $smsDateColumn, $emailDateColumn, $smsSender, $smsContent, $id_user);

				$logBatchSCNF		= $this->logdatahandler->logBatchDataNF($batchDataNotFound);

				$this->db->trans_begin();

				$insertLogNF		= $this->userTransaction->insertLogSIMCardNF($logBatchSCNF);
		
				if($this->db->trans_status() === FALSE){

					$this->db->trans_rollback();
					echo json_encode(array('response' => 400));
						
				} else {
						
					$this->db->trans_commit();
					echo json_encode(array('response' => 200));
						
				}

			} else {

				echo json_encode(array('response' => 404));

			}

		} else {

			echo "Direct Access Not Allowed";

		}

	}

	public function logDataSCard()
	{
		$this->formInput['idScard'] = $this->input->post('idScard', TRUE);
		$rawData 					= $this->userTransaction->listLogSCard($this->formInput['idScard']);
		$simCardNumb 				= $this->userTransaction->getSIMCardNumb($this->formInput['idScard']);

		$logData 					= array();
		$count 						= 1;

		if($rawData->num_rows() > 0){

			foreach ($rawData->result() as $value) {
			
				$rtuID 		= $value->RTU_ID;
				$city 		= $value->CITY_NAME;
				$region 	= $value->REG_NAME;
				$smsDate 	= $value->DATE_SMS; 
				$smsContent = substr($value->SMS_CONTENT, 0,5)."...";

				array_push($logData, array('Numb' 		=> $count,
										   'RTU_ID'		=> $rtuID,
										   'CITY'		=> $city,
										   'REGION' 	=> $region,
										   'SMS_DATE'	=> $smsDate,
										   'SMS_CONTENT'=> $smsContent));
				
				$count++;
			}

			echo json_encode(array('data' 			=> $logData,
								   'simcardNumb'	=> $simCardNumb->row()->SC_NUMB));

		} else {

			echo json_encode(array('data' => $logData));

		}

	}

	public function ExportExcel()
	{
		$this->formInput['fileName'] = $this->input->post('fileName', TRUE);
		echo json_encode(array('link_' => 'UserTransactionController/CreateFileExcel/'.$this->formInput['fileName']));
	}

	public function CreateFileExcel($fileName)
	{
		$fName 			= urldecode($fileName);

		$dataSCLog		= $this->exportexcel->setDataLogSC();
		$dataSCNotFound = $this->exportexcel->setDataLogSCNotFound(); 
				
		$arrayData_LogSC= json_decode($dataSCLog, TRUE);
		$arrData_LogSCNF= json_decode($dataSCNotFound, TRUE);

		$export_data    = $this->exportexcel->exporttoexcel($arrayData_LogSC, $arrData_LogSCNF, $fName);

	}




	public function test()
	{
		$this->formInput['idFile']	= 3;//$this->input->post('idFile', TRUE);
		$id_user					= $this->session->userdata('id_user');

		$full_fileName 		= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_NAME;
		$explode_fName		= explode(" ", $full_fileName);
				
		$fileName 			= $this->filepropertyhandler->setFName($explode_fName);
		$fileType			= $this->userTransaction->getFileProperty($this->formInput['idFile'])->row()->FILE_TYPE;

		$readData			= json_decode($this->readfile->readFileLog($fileType, $fileName), TRUE);
		$insDateColumn		= 'B';
		$smsDateColumn		= 'C';
		$emailDateColumn	= 'D';
		$smsSender			= 'E';
		$smsContent			= 'F';
		echo json_encode($logBatchSCNF);
	}

}

?>