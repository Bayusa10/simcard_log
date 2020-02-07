<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class LogDataHandler {

	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
        $this->ci->load->model('UserTransactionModel','userTransaction');
	}


	public function setLogDataBatch($readData, $insDateColumn, $smsDateColumn, $emailDateColumn, $smsSender, $smsContent, $id_user)
	{
		$arrayTemp 	= array();
		$firstRow	= 2;
		$lastRow 	= count($readData);

		for($firstRow; $firstRow <= $lastRow; $firstRow++) {
			
			$rawSIMCardNumb	= $readData[$firstRow][$smsSender];
			$simcardID 		= $this->ci->userTransaction->getSIMCardID($rawSIMCardNumb);

			if($simcardID->num_rows() > 0){

				$cardID			= $simcardID->row()->SC_ID;
				$dateIns 		= $readData[$firstRow][$insDateColumn];
				$dateSMS		= $readData[$firstRow][$smsDateColumn];
				$dateEmail		= $readData[$firstRow][$emailDateColumn];
				$smsCntnt		= $readData[$firstRow][$smsContent];
				$user_id		= $id_user;

				array_push($arrayTemp, array('SIMCARD_ID' 	=> $cardID,
											 'DATE_INS'		=> date("Y-m-d H:i:s", strtotime($dateIns)),
											 'DATE_SMS'		=> date("Y-m-d H:i:s", strtotime($dateSMS)),
											 'DATE_EMAIL'	=> date("Y-m-d H:i:s", strtotime($dateEmail)),
											 'SMS_CONTENT'	=> $smsCntnt,
											 'U_INS'		=> $user_id
											));				
			} 

		}

		return $arrayTemp;
	}


	public function setLogDataNotFoundBatch($readData, $insDateColumn, $smsDateColumn, $emailDateColumn, $smsSender, $smsContent, $id_user)
	{
		$arrayTemp 	= array();
		$firstRow	= 2;
		$lastRow 	= count($readData);
		
		for($firstRow; $firstRow <= $lastRow; $firstRow++) {
			
			$rawSIMCardNumb	= $readData[$firstRow][$smsSender];
			$simcardID 		= $this->ci->userTransaction->getSIMCardID($rawSIMCardNumb);

			if($simcardID->num_rows() == 0){

				$dateIns 		= $readData[$firstRow][$insDateColumn];
				$dateSMS		= $readData[$firstRow][$smsDateColumn];
				$dateEmail		= $readData[$firstRow][$emailDateColumn];
				$smsCntnt		= $readData[$firstRow][$smsContent];
				$user_id		= $id_user;

				array_push($arrayTemp, array('SIMCARD_ID' 	=> $rawSIMCardNumb,
											 'DATE_INS'		=> date("Y-m-d H:i:s", strtotime($dateIns)),
											 'DATE_SMS'		=> date("Y-m-d H:i:s", strtotime($dateSMS)),
											 'DATE_EMAIL'	=> date("Y-m-d H:i:s", strtotime($dateEmail)),
											 'SMS_CONTENT'	=> $smsCntnt,
											 'U_INS'		=> $user_id
											));
			} 

		}

		return $arrayTemp;
	}


	public function logBatchDataNF($batchDataNF)
	{
		$arrayTemp = array();

		foreach ($batchDataNF as $data) {
			
			$simCardNumb = $data['SIMCARD_ID'];
			$simcardID 	 = $this->ci->userTransaction->getSIMCardNFID($simCardNumb);

			if($simcardID->num_rows() > 0){

				$scID 		= $simcardID->row()->SC_ID;
				$date_ins 	= $data['DATE_INS'];
				$date_sms 	= $data['DATE_SMS'];
				$date_email = $data['DATE_EMAIL'];
				$sms_content= $data['SMS_CONTENT'];

				array_push($arrayTemp, array('SIMCARD_ID' 	=> $scID,
											 'DATE_INS'		=> $date_ins,
											 'DATE_SMS'		=> $date_sms,
											 'DATE_EMAIL'	=> $date_email,
											 'SMS_CONTENT'	=> $sms_content));
			}
		}

		return $arrayTemp;

	}


	/*private function setSIMCardNumb($rawSIMCardNumb)
	{
		$tempData 	= str_split($rawSIMCardNumb);
		$firstRow 	= 2;
		$lastRow  	= count($tempData);
		$simCardNumb= null;

		for ($firstRow; $firstRow < $lastRow; $firstRow++) { 
			if ($firstRow == 2) {
				$simCardNumb  = $tempData[$firstRow]."";
			} else {
				$simCardNumb .= $tempData[$firstRow]."";
			}
		}

		return $simCardNumb;
	}*/

	
}

?>