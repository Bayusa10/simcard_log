<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class SIMCardHandler {

	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
        $this->ci->load->model('UserTransactionModel','userTransaction');
	}

	public function setRawBatchData($readData, $rtuColumn, $cityColumn, $regionColumn, $simcardColumn, $latestRead)
	{
		$arrayTemp = array();
		$firstRow = 2;
		$lastRow  = count($readData)+1;

		while ($firstRow < $lastRow) {
			
			if($firstRow == 2){
				
				array_push($arrayTemp, array('RTU ID' 		=> $readData[$firstRow][$rtuColumn],
										     'CITY'			=> $readData[$firstRow][$cityColumn],
											 'REGION'		=> $readData[$firstRow][$regionColumn],
											 'SIM CARD NUMB'=> $readData[$firstRow][$simcardColumn],
											 'LATEST READ'	=> $readData[$firstRow][$latestRead]));
				$firstRow++;
			
			} else {

				$simcardNumb = $readData[$firstRow][$rtuColumn];
				$isFind 	 = FALSE;	

				foreach ($arrayTemp as $data) {
					if($data['RTU ID'] == $simcardNumb){
						$isFind = TRUE;
						break;
					}
				}

				if($isFind == FALSE){

					array_push($arrayTemp, array('RTU ID' 		=> $readData[$firstRow][$rtuColumn],
												 'CITY'			=> $readData[$firstRow][$cityColumn],
												 'REGION'		=> $readData[$firstRow][$regionColumn],
												 'SIM CARD NUMB'=> $readData[$firstRow][$simcardColumn],
												 'LATEST READ'	=> $readData[$firstRow][$latestRead]));

					$firstRow++;		
				
				} else {

					$firstRow++;	

				}

			}

		}


		return $arrayTemp;

	}


	public function setBatchData($rawBatchData, $id_user)
	{
		$arrayData = array();

		foreach ($rawBatchData as $value) {
			
			$checkSimCard = $this->ci->userTransaction->checkCardNumb($value['RTU ID'], $value['SIM CARD NUMB']);

			if ($checkSimCard->num_rows() == 0) {
				
				$city 		= $this->setCityName($value['CITY']);
				$region 	= $value['REGION'];
				$rtuID 		= $value['RTU ID'];
				$scNumb 	= $value['SIM CARD NUMB'];
				$latestRead = $value['LATEST READ'];

				$getCityID	= $this->ci->userTransaction->getCityID($city, $region)->row()->CITY_ID;

				array_push($arrayData, array('RTU_ID'			=> $rtuID,
											 'CITY_ID'			=> $getCityID,
											 'SC_NUMB'			=> '62'.$scNumb,
											 'U_INS'			=> $id_user,
											 'LATEST_READING'	=> date("Y-m-d H:i:s", strtotime($latestRead))
											));
			}

		}

		return $arrayData;

	}


	public function setLatestReading($rawBatchData)
	{
		$arrayData = array();


		foreach ($rawBatchData as $value) {

			$rtuID 		= $value['RTU ID'];
			$latestRead = $value['LATEST READ'];

			array_push($arrayData, array('RTU_ID'			=> $rtuID,
										 'LATEST_READING'	=> date("Y-m-d H:i:s", strtotime($latestRead))
										));
		}

		return $arrayData;
	}

	private function setCityName($cityName)
	{
		if($cityName == null){
		
			return "NOT FOUND";
		
		} else {

			return $cityName;

		}
	}


	public function listSIMCard($slug)
	{
		$arrayData 	= array();

		if($slug == 0){

			$data 		= $this->ci->userTransaction->listSIMCard();
			$count 		= 1;

			foreach ($data as $value) {
				
				$rtuID 			= $value->RTU_ID;
				$simcardNumb 	= $value->SC_NUMB;
				$city 			= $value->CITY_NAME;
				$region 		= $value->REG_NAME;
				$latestRead 	= $value->LATEST_READING;
				$u_ins 			= $value->USERNAME;

				array_push($arrayData, array('Numb' 		=> $count,
											 'RTU ID'		=> $rtuID,
											 'SIM Number'	=> $simcardNumb,
											 'City'			=> $city,
											 'Region'		=> $region,
											 'Latest Read'	=> $latestRead,
											 'User Insert'	=> $u_ins));

				$count++;
			}

			return $arrayData;
		
		} else {

			$data 		= $this->ci->userTransaction->listSIMCard();
			$count 		= 1;

			foreach ($data as $value) {
				
				$idSIMCard 		= $value->SC_ID;
				$simcardNumb 	= $value->SC_NUMB;
				$latestRead 	= $value->LATEST_READING;
				$city 			= $value->CITY_NAME;
				$region 		= $value->REG_NAME;

				array_push($arrayData, array('Numb' 		=> $count,
											 'SIM Number'	=> $simcardNumb,
											 'City'			=> $city,
											 'Region'		=> $region,
											 'Latest Read'	=> $latestRead,
											 'Action'		=> '<button name="scardChoosen" id="scardChoosen" class="btn btn-primary"  data-id='.$idSIMCard.' > Lihat Log </button>'

											));
				$count++;
			}

			return $arrayData;

		}

	}


	public function setBatchDataSCNotFound($batchDataNotFound, $user_id)
	{
		$arrayTemp 	= array();
		$index		= 1;
		$totalData  = count($batchDataNotFound);

		if($totalData > 0){

			foreach ($batchDataNotFound as $value) {
				
				$scNumb = $value['SIMCARD_ID'];

				if($index == 1){

					array_push($arrayTemp, array('SC_NUMBER' => $scNumb,
											 	 'U_INS'	 => $user_id));

					$index++;
				
				} else {

					$isFind = FALSE;

					foreach ($arrayTemp as $data) {

						$scCheck = $data['SC_NUMBER'];

						if($scNumb == $scCheck){

							$isFind = TRUE;
							break;
						}
					}

					if($isFind == FALSE){

						$postalCode    = substr($scNumb, 0,2);

						if($postalCode == '62'){

							array_push($arrayTemp, array('SC_NUMBER' => $scNumb,
												 	 	 'U_INS'	 => $user_id));
							$index++;

						} else {

							$index++;

						}

					} else {

						$index++;

					}

				} 
			}

		}


		return $arrayTemp;
	}

}

?>