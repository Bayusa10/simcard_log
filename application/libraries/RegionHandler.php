<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class RegionHandler {

	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
        $this->ci->load->model('UserTransactionModel','userTransaction');
	}

	public function setRawBatchRegional($readData, $regionColumn)
	{
		$tempBatchArray = array();

		for ($i=2; $i < count($readData)+1; $i++) { 
				
			$region = $readData[$i][$regionColumn];
			
			if($i == 2){

				array_push($tempBatchArray, array('REG_NAME' => $region));
			
			} else {
				
				$isFind = FALSE;

				for ($j=0; $j < count($tempBatchArray); $j++) { 
					if($tempBatchArray[$j]['REG_NAME'] == $region){
						$isFind = TRUE;
						break;
					}
				}

				if($isFind == FALSE){
					array_push($tempBatchArray, array('REG_NAME' => $region));
				}

			}
			
		}

		return $tempBatchArray;
	}

	public function setRegionalBatch($rawRegionalBatch, $id_user)
	{
		$arrayData = array();

		for ($i=0; $i < count($rawRegionalBatch); $i++) { 
			
			$checkRegion = $this->ci->userTransaction->checkRegion($rawRegionalBatch[$i]['REG_NAME']);

			if($checkRegion->num_rows() == 0){
				array_push($arrayData, array('REG_NAME' => $rawRegionalBatch[$i]['REG_NAME'],
											 'U_INS'	=> $id_user));
			}
		}

		return $arrayData;
	}

	public function listRegion()
	{
		$arrayData 	= array();

		$dataRegion	= $this->ci->userTransaction->getRegion();
		$arrayData[]= "<option value=0> -- Pilih Provinsi --</option>";

		foreach ($dataRegion as $value) {
			
			$idRegion 	= $value->REG_ID;
			$regionName	= strtoupper($value->REG_NAME);


			$arrayData[] = "<option value=".$idRegion.">".$regionName."</option>";

		}

		return $arrayData;

	}

}

?>