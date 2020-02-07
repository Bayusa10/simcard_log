<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class ReadFile {

	private $spreadsheet = null;

	public function readFileLog($inputFileType, $inputFileName)
	{
		if($inputFileType == 'xlsx'){

			$reader 	= new Xlsx();
			$path_file	= './log_files/';
			$fileLog	= './log_files/'.$inputFileName.'.'.$inputFileType;

			$this->spreadsheet = $reader->load($fileLog);

			$sheetData 	= $this->spreadsheet->getActiveSheet()->toArray(null, true, true, true);

			return json_encode($sheetData);
		
		} else {

			$reader 	= new Xls();
			$path_file	= './log_files/';
			$fileLog	= './log_files/'.$inputFileName.'.'.$inputFileType;

			$this->spreadsheet = $reader->load($fileLog);

			$sheetData 	= $this->spreadsheet->getActiveSheet()->toArray(null, true, true, true);

			return json_encode($sheetData);	

		}

		/*$count 		= 1;
		$i 			= 1;

		while ($count <= count($sheetData)) {
			echo $i." => ".$sheetData[$count]['C'];
			echo "<br>";
			$count++;
			$i++;
		}

		echo $count." ".count($sheetData);*/
	}


}

?>