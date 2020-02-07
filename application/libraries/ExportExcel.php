<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcel {


	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
        $this->ci->load->model('UserTransactionModel','userTransaction');
	}

	public function setDataLogSC()
	{
		$arrayData  = array();

		$data_scard = $this->ci->userTransaction->listSCard();

		foreach ($data_scard->result() as $data) {
			
			$arrayTemp = array();

			$sc_numb 	= $data->SC_NUMB;
			$rtu_id  	= $data->RTU_ID;
			$latest_read= $data->LATEST_READING;
			$city 		= $data->CITY_NAME;
			$region		= $data->REG_NAME;
			$id_simcard	= $data->SC_ID;

			$log 		= $this->ci->userTransaction->logSCard($id_simcard);	
			$log_amount = $log->num_rows();

			if($log_amount > 0){

				foreach ($log->result() as $logSC) {
					
					$date_ins 	= $logSC->DATE_INS;
					$date_sms 	= $logSC->DATE_SMS;
					$date_email = $logSC->DATE_EMAIL;
					$sms_content= $logSC->SMS_CONTENT; 

					array_push($arrayTemp, array('DATE_INS' 	=> $date_ins,
											 	 'DATE_SMS'		=> $date_sms,
											 	 'DATE_EMAIL'	=> $date_email,
											 	 'SMS_CONTENT'	=> $sms_content));
				}


				array_push($arrayData, array('SIMCARD_NUMBER'	=> $sc_numb,
										 	 'RTU_ID'			=> $rtu_id,
										 	 'LATEST_READ'		=> $latest_read,
										 	 'CITY'				=> $city,
										 	 'REGION'			=> $region,
										 	 'LOG_AMOUNT'		=> $log_amount,
										 	 'LOG'				=> $arrayTemp));
			} else {

				array_push($arrayData, array('SIMCARD_NUMBER'	=> $sc_numb,
										 	 'RTU_ID'			=> $rtu_id,
										 	 'LATEST_READ'		=> $latest_read,
										 	 'CITY'				=> $city,
										 	 'REGION'			=> $region,
										 	 'LOG_AMOUNT'		=> $log_amount,
										 	 'LOG'				=> $arrayTemp));
			}

		}


		return json_encode($arrayData);

	}

	public function setDataLogSCNotFound()
	{
		$arrayData	= array();

		$data_scard = $this->ci->userTransaction->listSCardNFound();

		if ($data_scard->num_rows() > 0) {
			
			foreach ($data_scard->result() as $data) {
			$arrayTemp  = array();

			$simcard 	= $data->SC_NUMBER;
			$scard_id 	= $data->SC_ID;

			$log 	 	= $this->ci->userTransaction->LogSCardNFound($scard_id);
			$log_amount = $log->num_rows();

			foreach ($log->result() as $data_log) {
				
				$date_ins 	= $data_log->DATE_INS;
				$date_sms 	= $data_log->DATE_SMS;
				$date_email = $data_log->DATE_EMAIL;
				$sms_content= $data_log->SMS_CONTENT; 

				array_push($arrayTemp, array('DATE_INS' 	=> $date_ins,
											 'DATE_SMS'		=> $date_sms,
											 'DATE_EMAIL'	=> $date_email,
											 'SMS_CONTENT'	=> $sms_content));
			}

			array_push($arrayData, array('SIMCARD_NUMBER' => $simcard,
										 'LOG'			  => $arrayTemp,
										 'LOG_AMOUNT'	  => $log_amount));
			}

		}

		return json_encode($arrayData);
	}


	public function ExportToExcel($arrayData_LogSC, $arrData_LogSCNF, $fileName)
	{
		$spreadsheet = new Spreadsheet();

		$total_SC_NotFound = count($arrData_LogSCNF);

		if ($total_SC_NotFound == 0) {
			
			$this->createSheet1($spreadsheet, $arrayData_LogSC);
			$this->createSheet2($spreadsheet, $arrayData_LogSC);

		} else {

			$this->createSheet1($spreadsheet, $arrayData_LogSC);
			$this->createSheet2($spreadsheet, $arrayData_LogSC);
			$this->createSheet3($spreadsheet, $arrData_LogSCNF);

		}

		/* Proses cetak data */
		$this->WriteFile($spreadsheet, $fileName);
	}

	private function createSheet1($spreadsheet, $arrayData_LogSC)
	{

		$sheet 		 = $spreadsheet->getActiveSheet()
								   ->setTitle("LOG DATA I");
		
		$title 		 = 'LOG DATA SIM CARD (SIM CARD ADA DI MASTER DATA)';
		$sheet->setCellValue('A2', $title);

		/* variabel untuk header */
		$sc_title_col 	= $latest_read_col = $region_title_col = 'A';
		$simcard 		= $latest_read 	   = $region 		   = 'B';

		$rtu_title_col 	= $city_title_col  = $total_log_col    = 'D';
		$rtu_id 		= $city 		   = $tot_log 		   = 'E';

		$sc_row			= $rtu_row 		 = 4;
		$latest_read_row= $city_row		 = 5;
		$region_row		= $total_log_row = 6;
		/* variabel untuk header */

		/* variabel untuk header log */
		$number 			  = 'A';
		$date_mail_title      = 'B';
		$date_mail_title_row  = 8;
		/* variabel untuk header log */
		
		$date_mail = 9;

		/* Proses cetak data */
		//$index 		= 0;
		//$total_log  = count($arrayData_LogSC);

		$index		= 0;

		$totalData  = count($arrayData_LogSC);	

		$counter = 0;

		for ($index; $index < $totalData; $index++) {
			$numb = 1;

			if($arrayData_LogSC[$index]['LOG_AMOUNT'] > 0){
				
					$sheet->setCellValue($sc_title_col.($sc_row+$counter), 'Nomor SIM Card');
					$sheet->setCellValue($latest_read_col.($latest_read_row+$counter), 'Latest Read');
					$sheet->setCellValue($region_title_col.($region_row+$counter), 'Provinsi');

					$sheet->setCellValue($simcard.($sc_row+$counter), $arrayData_LogSC[$index]['SIMCARD_NUMBER']);
					$sheet->setCellValue($latest_read.($latest_read_row+$counter), $arrayData_LogSC[$index]['LATEST_READ']);
					$sheet->setCellValue($region.($region_row+$counter), $arrayData_LogSC[$index]['REGION']);

					$sheet->setCellValue($rtu_title_col.($rtu_row+$counter), 'RTU ID');
					$sheet->setCellValue($city_title_col.($city_row+$counter), 'Kota');
					$sheet->setCellValue($total_log_col.($total_log_row+$counter), 'Total Log');

					$sheet->setCellValue($rtu_id.($rtu_row+$counter), $arrayData_LogSC[$index]['RTU_ID']);
					$sheet->setCellValue($city.($city_row+$counter), $arrayData_LogSC[$index]['CITY']);
					$sheet->setCellValue($tot_log.($total_log_row+$counter), $arrayData_LogSC[$index]['LOG_AMOUNT']);

					$sheet->setCellValue($number.($date_mail_title_row+$counter), 'No.');
					$sheet->setCellValue($date_mail_title.($date_mail_title_row+$counter), 'Tanggal Email');

					$idx_log  = 0;
					$totalLog = count($arrayData_LogSC[$index]['LOG']);

					for ($idx_log; $idx_log < $totalLog; $idx_log++) { 

						$row_data = $date_mail+$idx_log+$counter;

						$sheet->setCellValue($number.$row_data, $numb);
						$sheet->setCellValue($date_mail_title.$row_data, $arrayData_LogSC[$index]['LOG'][$idx_log]['DATE_EMAIL']);
						
						$numb++;
					}


					$adder_row= 6+$totalLog;
					$counter += $adder_row;
			}

		}
	}


	private function createSheet2($spreadsheet, $arrayData_LogSC)
	{

		$sheet 		 = $spreadsheet->createSheet()
								   ->setTitle("LOG DATA MISSING");
		
		$title 		 = 'LOG DATA SIM CARD (SIM CARD ADA DI MASTER DATA)';
		$sheet->setCellValue('A2', $title);

		/* variabel untuk header */
		$sc_title_col 	= $latest_read_col = $region_title_col = 'A';
		$simcard 		= $latest_read 	   = $region 		   = 'B';

		$rtu_title_col 	= $city_title_col  = $total_log_col    = 'D';
		$rtu_id 		= $city 		   = $tot_log 		   = 'E';

		$sc_row			= $rtu_row 		 = 4;
		$latest_read_row= $city_row		 = 5;
		$region_row		= $total_log_row = 6;
		/* variabel untuk header */

		/* variabel untuk header log */
		$date_ins_col	= $date_ins 	= 'A';
		$date_sms_col 	= $date_sms 	= 'B';
		$date_email_col	= $date_email 	= 'C';
		$sms_content_col= $sms_content 	= 'D';
		$header_log_row = 8;
		$log_row 		= 9;
		/* variabel untuk header log */
		

		/* variabel untuk isi log*/
		$log_row = 9;


		$index		= 0;

		$totalData  = count($arrayData_LogSC);	

		$counter = 0;

		for ($index; $index < $totalData; $index++) {

			if($arrayData_LogSC[$index]['LOG_AMOUNT'] == 0){

					$sheet->setCellValue($sc_title_col.($sc_row+$counter), 'Nomor SIM Card');
					$sheet->setCellValue($latest_read_col.($latest_read_row+$counter), 'Latest Read');
					$sheet->setCellValue($region_title_col.($region_row+$counter), 'Provinsi');

					$sheet->setCellValue($simcard.($sc_row+$counter), $arrayData_LogSC[$index]['SIMCARD_NUMBER']);
					$sheet->setCellValue($latest_read.($latest_read_row+$counter), $arrayData_LogSC[$index]['LATEST_READ']);
					$sheet->setCellValue($region.($region_row+$counter), $arrayData_LogSC[$index]['REGION']);

					$sheet->setCellValue($rtu_title_col.($rtu_row+$counter), 'RTU ID');
					$sheet->setCellValue($city_title_col.($city_row+$counter), 'Kota');
					$sheet->setCellValue($total_log_col.($total_log_row+$counter), 'Total Log');

					$sheet->setCellValue($rtu_id.($rtu_row+$counter), $arrayData_LogSC[$index]['RTU_ID']);
					$sheet->setCellValue($city.($city_row+$counter), $arrayData_LogSC[$index]['CITY']);
					$sheet->setCellValue($tot_log.($total_log_row+$counter), $arrayData_LogSC[$index]['LOG_AMOUNT']);

					$counter += 5;
			}
		}

	}


	private function createSheet3($spreadsheet, $arrData_LogSCNF)
	{
		$sheet 		 = $spreadsheet->createSheet()
								   ->setTitle("LOG DATA II");
		
		$title 		 = 'LOG DATA SIM CARD (SIM CARD TIDAK ADA DI MASTER DATA)';
		$sheet->setCellValue('A2', $title);

		/* variabel untuk header */
		$sc_title_col 	= $latest_read_col = $region_title_col = 'A';
		$simcard 		= $latest_read 	   = $region 		   = 'B';

		$rtu_title_col 	= $city_title_col  = $total_log_col    = 'D';
		$rtu_id 		= $city 		   = $tot_log 		   = 'E';

		$sc_row			= $rtu_row 		 = 4;
		$latest_read_row= $city_row		 = 5;
		$region_row		= $total_log_row = 6;
		/* variabel untuk header */

		/* variabel untuk header log */
		$number 			  = 'A';
		$date_mail_title      = 'B';
		$date_mail_title_row  = 8;
		/* variabel untuk header log */
		
		$date_mail = 9;

		/* Proses cetak data */
		//$index 		= 0;
		//$total_log  = count($arrayData_LogSC);

		$index		= 0;

		$totalData  = count($arrData_LogSCNF);	

		$counter = 0;

		for ($index; $index < $totalData; $index++) {
			$numb = 1;

			if($arrData_LogSCNF[$index]['LOG_AMOUNT'] > 0){
				
					$sheet->setCellValue($sc_title_col.($sc_row+$counter), 'Nomor SIM Card');
					$sheet->setCellValue($latest_read_col.($latest_read_row+$counter), 'Latest Read');
					$sheet->setCellValue($region_title_col.($region_row+$counter), 'Provinsi');

					$sheet->setCellValue($simcard.($sc_row+$counter), $arrData_LogSCNF[$index]['SIMCARD_NUMBER']);
					$sheet->setCellValue($latest_read.($latest_read_row+$counter), "-");
					$sheet->setCellValue($region.($region_row+$counter), "-");

					$sheet->setCellValue($rtu_title_col.($rtu_row+$counter), 'RTU ID');
					$sheet->setCellValue($city_title_col.($city_row+$counter), 'Kota');
					$sheet->setCellValue($total_log_col.($total_log_row+$counter), 'Total Log');

					$sheet->setCellValue($rtu_id.($rtu_row+$counter), "-");
					$sheet->setCellValue($city.($city_row+$counter), "-");
					$sheet->setCellValue($tot_log.($total_log_row+$counter), $arrData_LogSCNF[$index]['LOG_AMOUNT']);

					$sheet->setCellValue($number.($date_mail_title_row+$counter), 'No.');
					$sheet->setCellValue($date_mail_title.($date_mail_title_row+$counter), 'Tanggal Email');

					$idx_log  = 0;
					$totalLog = count($arrData_LogSCNF[$index]['LOG']);

					for ($idx_log; $idx_log < $totalLog; $idx_log++) { 

						$row_data = $date_mail+$idx_log+$counter;

						$sheet->setCellValue($number.$row_data, $numb);
						$sheet->setCellValue($date_mail_title.$row_data, $arrData_LogSCNF[$index]['LOG'][$idx_log]['DATE_EMAIL']);
						
						$numb++;
					}


					$adder_row= 6+$totalLog;
					$counter += $adder_row;
			}

		}

	}


	private function WriteFile($spreadsheet, $fname)
	{
		$writer 	 = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $fname .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}



	/*
	public function ExportToExcel()
	{
		$spreadsheet = new Spreadsheet();
		$sheet 		 = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World');

		$this->WriteFile($spreadsheet, 'Coba');
	}

	private function WriteFile($spreadsheet, $fname)
	{
		$writer 	 = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $fname .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	*/


}

?>