<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class CityHandler {

	private $ci;
	private $arrayData = array();

	public function __construct()
	{
		$this->ci =& get_instance();
        $this->ci->load->model('UserTransactionModel','userTransaction');
	}

	public function setRawBatchCity($firstRow, $lastRow, $readData, $cityColumn, $regionColumn)
	{
		$arrayTemp = array();

		for ($firstRow; $firstRow < $lastRow ; $firstRow++) { 
			
			$city 	= $readData[$firstRow][$cityColumn];	
			$region = $readData[$firstRow][$regionColumn];


			if($firstRow == 2){

				if($city == NULL){

					$city = "NOT FOUND";

					array_push($arrayTemp, array('CITY_NAME' 	=> $city,
											 	 'REGION_NAME'	=> $region));

				} else {

					array_push($arrayTemp, array('CITY_NAME' 	=> $city,
											 	 'REGION_NAME'	=> $region));
				}

				

			} else {

				$firstRowTempArray = 0;
				$lastRowTempArray  = count($arrayTemp);
				$isFind 		   = FALSE;

				for ($firstRowTempArray; $firstRowTempArray < $lastRowTempArray; $firstRowTempArray++) { 
					
					if($city == NULL){
						$city = "NOT FOUND";

						if($arrayTemp[$firstRowTempArray]['CITY_NAME'] == $city && $arrayTemp[$firstRowTempArray]['REGION_NAME'] == $region){
							$isFind = TRUE;
							break;
						}

					} else {

						if($arrayTemp[$firstRowTempArray]['CITY_NAME'] == $city && $arrayTemp[$firstRowTempArray]['REGION_NAME'] == $region){
							$isFind = TRUE;
							break;
						}


					}


				}	

				if($isFind == FALSE){

					if($city == NULL){
						array_push($arrayTemp, array('CITY_NAME' 	=> "NOT FOUND",
													 'REGION_NAME' 	=> $region));
					} else {
						array_push($arrayTemp, array('CITY_NAME' 	=> $city,
													 'REGION_NAME' 	=> $region));
					}
					
				}

			}
		
		}

		return $arrayTemp;
	}

	public function setBatchCity($rawData, $idUser)
	{
		$arrayTemp 	= array();

		foreach ($rawData as $data) {

			$city 		= $data['CITY_NAME'];
			$region 	= $data['REGION_NAME'];

			$checkCity	= $this->ci->userTransaction->checkCity($region, $city);
			
			if($checkCity->num_rows() == 0){

				$regionID = $this->ci->userTransaction->getRegionID($region)->row()->REG_ID;

				array_push($arrayTemp, array('CITY_NAME' => $city,
											 'REG_ID'	 => $regionID,
											 'U_INS'	 => $idUser));

			}

		}

		return $arrayTemp;
	}

	public function listCity()
	{
		$rawData = $this->ci->userTransaction->getListCity();
		$numb	 = 1;

		foreach ($rawData as $value) {
			
			$province 	= strtoupper($value->REG_NAME);
			$city 		= strtoupper($value->CITY_NAME);
			$uinsert	= strtoupper($value->USERNAME);

			array_push($this->arrayData, array('Numb' 		=> $numb,
											   'Province'	=> $province,
											   'City'		=> $city,
											   'UInsert'	=> $uinsert));
			$numb++;
		}	

		return $this->arrayData;

	}


	public function getCity($idRegion)
	{
		$rawData 	= $this->ci->userTransaction->getCityID_($idRegion);
		$arrayData	= array();

		$arrayData[] = "<option value=0>-- Pilih Kota --</option>";		

		foreach ($rawData as $value) {

			$cityID 	= $value->CITY_ID;
			$cityName 	= strtoupper($value->CITY_NAME);

			$arrayData[] = "<option value=".$cityID.">".$cityName."</option>";
		}

		return $arrayData;	
	}



}

?>