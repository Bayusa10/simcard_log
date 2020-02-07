<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class FilePropertyHandler {

	public function setFName($explode_fName)
	{
		$fname 			= null;
		$length_data	= count($explode_fName);

		if($length_data == 1){

			$fname = $explode_fName;

		} else {

			for ($i=0; $i < count($explode_fName); $i++) { 
				if($i < count($explode_fName)-1){
					$fname .= $explode_fName[$i]."_";
				} else {
					$fname .= $explode_fName[$i];
				}
			}

		}
		
		return $fname;
	}


	public function setDescription($rawDescription, $newDescription)
	{

		$arrNewDesc 	= array();
		$oldDescription = $rawDescription;

		if ($oldDescription == 'BELUM') {
			
			$arrNewDesc['file_desc'] 	= $newDescription;
			$arrNewDesc['upload_time'] 	= date('Y-m-d H:i:s');
			return $arrNewDesc;
		
		} else {


			$arrNewDesc['file_desc'] 	= $oldDescription." , ".$newDescription;
			$arrNewDesc['upload_time'] 	= date('Y-m-d H:i:s');
			return $arrNewDesc;
		}
		
	}



}

?>