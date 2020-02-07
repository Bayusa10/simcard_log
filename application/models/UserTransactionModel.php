<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');


class UserTransactionModel extends CI_Model
{
	
	private $query, $runQuery;

	/* Fungsi list file log data */
	public function listFileLogData()
	{
		$this->query 	= $this->db->select('log_data_files.*, user_table.USERNAME')
								   ->from('log_data_files')
								   ->join('user_table','user_table.U_ID = log_data_files.ID_USER')
								   ->order_by('log_data_files.DATE_INSERT', 'DESC');

		$this->runQuery	= $this->db->get()
								   ->result();

		return $this->runQuery;
	}

	/* Fungsi list Provinsi */
	public function listRegion()
	{
		$this->query 	= $this->db->select('regional_table.REG_NAME, user_table.USERNAME')
								   ->from('regional_table')
								   ->join('user_table','regional_table.U_INS = user_table.U_ID')
								   ->order_by('regional_table.REG_NAME','ASC');

		$this->runQuery = $this->db->get()
								   ->result();

		return $this->runQuery;
	}

	/* Fungsi ambil data file berdasar ID */
	public function getFileProperty($idFile)
	{
		$this->query 	= $this->db->select('log_data_files.FILE_NAME, log_data_files.FILE_TYPE')
								   ->from('log_data_files')
								   ->where('log_data_files.ID_FILE', $idFile);

		$this->runQuery	= $this->db->get();

		return $this->runQuery;
	}

	/* Fungsi untuk check region sudah pernah diinput atau belum */
	public function checkRegion($region)
	{
		$this->query 	= $this->db->select('regional_table.REG_NAME')
								   ->from('regional_table')
								   ->where('regional_table.REG_NAME', $region);

		$this->runQuery	= $this->db->get();

		return $this->runQuery;

	}

	/* Fungsi untuk input data provinsi ke database dengan batch data */
	public function insertRegionBatch($array_batch)
	{
		$this->query 	= $this->db->insert_batch('regional_table', $array_batch);
		return $this->query;
	}

	/* Fungsi untuk ambil deskripsi file */
	public function getFileDescription($idFile)
	{
		$this->query 	= $this->db->select('log_data_files.UP_TO_DB')
								   ->from('log_data_files')
								   ->where('log_data_files.ID_FILE', $idFile);

		$this->runQuery	= $this->db->get();

		return $this->runQuery;
	}

	/* Fungsi untuk update deskripsi file */
	public function updateFileDescription($idFile, $arr_desc)
	{
		$this->query 	= $this->db->set('log_data_files.UP_TO_DB', $arr_desc['file_desc'])
								   ->set('log_data_files.DATE_UP_TO_DB', $arr_desc['upload_time'])
								   ->where('log_data_files.ID_FILE', $idFile)
								   ->update('log_data_files');
		return $this->query;
	}	

	/* Fungsi input data provinsi ( satu data ) */
	public function insertRegion($arr_region)
	{
		$this->query 	= $this->db->insert('regional_table', $arr_region);
		return $this->query;
	}

	/* Fungsi ambil list kota */
	public function getListCity()
	{
		$this->query 	= $this->db->select('city_table.CITY_NAME, regional_table.REG_NAME, user_table.USERNAME')
								   ->from('city_table')
								   ->join('regional_table','city_table.REG_ID = regional_table.REG_ID')
								   ->join('user_table','city_table.U_INS = user_table.U_ID ')
								   ->order_by('city_table.CITY_NAME', 'ASC');

		$this->runQuery = $this->db->get()
								   ->result();

		return $this->runQuery;
	}

	/* Fungsi check data kota/kab, sudah diinput atau belum */
	public function checkCity($regionName, $cityName)
	{
		$this->query 	= $this->db->select('city_table.CITY_NAME, regional_table.REG_NAME')
								   ->from('city_table')
								   ->join('regional_table','city_table.REG_ID = regional_table.REG_ID')
								   ->where('city_table.CITY_NAME', $cityName)
								   ->where('regional_table.REG_NAME', $regionName);

		$this->runQuery = $this->db->get();

		return $this->runQuery;
	}

	public function getRegionID($regionName)
	{
		$this->query 	= $this->db->select('regional_table.REG_ID')
								   ->from('regional_table')
								   ->where('regional_table.REG_NAME', $regionName);

		$this->runQuery = $this->db->get();

		return $this->runQuery;
	}

	/* Fungsi untuk input data kota ke database dengan batch data */
	public function insertCityBatch($array_batch)
	{
		$this->query 	= $this->db->insert_batch('city_table', $array_batch);
		return $this->query;
	}


	/* Fungsi untuk ambil data region */
	public function getRegion()
	{
		$this->query 	= $this->db->select('regional_table.*')
								   ->from('regional_table');

		$this->runQuery = $this->db->get()
								   ->result();

		return $this->runQuery;
	}


	/* Fungsi untuk check kota yang diinputkan secara manual */
	public function _checkCity($idRegion, $cityName)
	{
		$this->query 	= $this->db->select('city_table.*')
								   ->from('city_table')
								   ->join('regional_table','city_table.REG_ID = regional_table.REG_ID')
								   ->where('city_table.REG_ID', $idRegion)
								   ->where('city_table.CITY_NAME', $cityName);

		$this->runQuery	= $this->db->get();

		return $this->runQuery;
	}


	public function insertCity($arr_city)
	{
		$this->query 	= $this->db->insert('city_table', $arr_city);
		return $this->query;
	}

	/* Fungsi check nomor kartu */
	public function listSIMCard()
	{
		$this->query 	= $this->db->select('sc_numbers_table.*, city_table.CITY_NAME, regional_table.REG_NAME, user_table.USERNAME')
								   ->from('sc_numbers_table')
								   ->join('city_table','sc_numbers_table.CITY_ID = city_table.CITY_ID')
								   ->join('regional_table','city_table.REG_ID = regional_table.REG_ID')
								   ->join('user_table','sc_numbers_table.U_INS = user_table.U_ID');

		$this->runQuery = $this->db->get()
								   ->result();

		return $this->runQuery;
	}


	public function checkCardNumb($rtuNumb, $cardNumb)
	{
		$this->query 	= $this->db->select('sc_numbers_table.*')
								   ->from('sc_numbers_table')
								   ->where('sc_numbers_table.RTU_ID', $rtuNumb)
								   ->where('sc_numbers_table.SC_NUMB', $cardNumb);

		$this->runQuery = $this->db->get();

		return $this->runQuery;
	}

	public function getCityID($cityName, $regionName)
	{
		$this->query 	= $this->db->select('city_table.CITY_ID')
								   ->from('city_table')
								   ->join('regional_table', 'city_table.REG_ID = regional_table.REG_ID')
								   ->where('regional_table.REG_NAME', $regionName);

		$this->runQuery	= $this->db->get();

		return $this->runQuery;	
	}

	public function insertSIMBatch($arr_simcard)
	{
		$this->query 	= $this->db->insert_batch('sc_numbers_table', $arr_simcard);
		return $this->query;
	}


	public function getCityID_($idRegion)
	{
		$this->query 	= $this->db->select('city_table.CITY_ID, city_table.CITY_NAME')
								   ->from('city_table')
								   ->where('city_table.REG_ID', $idRegion);

		$this->runQuery = $this->db->get()
								   ->result();

		return $this->runQuery;
	}

	public function updateLatestRead($arr_data)
	{
		$this->query = $this->db->update_batch('sc_numbers_table', $arr_data, 'RTU_ID');
		return $this->query;
	}

	public function checkLogScard()
	{
		$this->query 	= $this->db->select('log_simcard_table.*')
								   ->from('log_simcard_table');

		$this->runQuery	= $this->db->get();

		return $this->runQuery;

	}

	public function cleanLogSCard($tableName)
	{
		$this->query = $this->db->empty_table($tableName);
		return $this->query;
	}

	//Fungsi upload log data sms
	public function listLogSCard($idSCard)
	{	
		if($idSCard == 0){

			$this->query 	= $this->db->select('log_simcard_table.*, sc_numbers_table.*, city_table.CITY_NAME, regional_table.REG_NAME, 
											user_table.USERNAME')
									->from('log_simcard_table')
									->join('sc_numbers_table','log_simcard_table.SIMCARD_ID = sc_numbers_table.SC_ID')
									->join('user_table','log_simcard_table.U_INS = user_table.U_ID')
									->join('city_table','sc_numbers_table.CITY_ID = city_table.CITY_ID')
									->join('regional_table','city_table.REG_ID = regional_table.REG_ID');

			$this->runQuery	= $this->db->get();

			return $this->runQuery;

		} else {

			$this->query 	= $this->db->select('log_simcard_table.*, sc_numbers_table.*, city_table.CITY_NAME, regional_table.REG_NAME, 
											user_table.USERNAME')
									->from('log_simcard_table')
									->join('sc_numbers_table','log_simcard_table.SIMCARD_ID = sc_numbers_table.SC_ID')
									->join('user_table','log_simcard_table.U_INS = user_table.U_ID')
									->join('city_table','sc_numbers_table.CITY_ID = city_table.CITY_ID')
									->join('regional_table','city_table.REG_ID = regional_table.REG_ID')
									->where('sc_numbers_table.SC_ID', $idSCard)
									->order_by('log_simcard_table.DATE_SMS','DESC');

			$this->runQuery	= $this->db->get();

			return $this->runQuery;
		}
	}

	public function getSIMCardNumb($idScard)
	{

		$this->query 	= $this->db->select('sc_numbers_table.SC_NUMB')
								   ->from('sc_numbers_table')
								   ->where('sc_numbers_table.SC_ID',$idScard);

		$this->runQuery = $this->db->get();
	
		return $this->runQuery;
			
	}

	public function getSIMCardNFID($simcardNumb)
	{
		$this->query 	= $this->db->select('sc_numbers_notfound.SC_ID')
								   ->from('sc_numbers_notfound')
								   ->where('sc_numbers_notfound.SC_NUMBER',$simcardNumb);

		$this->runQuery = $this->db->get();
	
		return $this->runQuery;
	}


	public function getSIMCardID($simcardNumb)
	{
		$this->query 	= $this->db->select('sc_numbers_table.SC_ID')
								   ->from('sc_numbers_table')
								   ->where('sc_numbers_table.SC_NUMB',$simcardNumb);

		$this->runQuery = $this->db->get();
	
		return $this->runQuery;
	}


	public function insertLogSIMCard($array_batch)
	{

		$this->query 	= $this->db->insert_batch('log_simcard_table', $array_batch);
		return $this->query;

	}


	public function insertSIMCardNF($array_batch)
	{
		$this->query 	= $this->db->insert_batch('sc_numbers_notfound', $array_batch);
		return $this->query;
	}


	public function insertLogSIMCardNF($array_batch)
	{
		$this->query 	= $this->db->insert_batch('log_sc_notfound_table', $array_batch);
		return $this->query;
	}

	public function listSCard()
	{
		$this->query 	= $this->db->select('sc_numbers_table.*, city_table.CITY_NAME, regional_table.REG_NAME')
								   ->from('sc_numbers_table')
								   ->join('city_table','sc_numbers_table.CITY_ID = city_table.CITY_ID')
								   ->join('regional_table','city_table.REG_ID = regional_table.REG_ID');

		$this->runQuery	= $this->db->get();

		return $this->runQuery;
	}


	public function logSCard($id_scard)
	{
		$this->query 	= $this->db->select('log_simcard_table.*')
								   ->from('log_simcard_table')
								   ->where('log_simcard_table.SIMCARD_ID', $id_scard);

		$this->runQuery = $this->db->get();

		return $this->runQuery;
	}


	public function listSCardNFound()
	{
		$this->query 	= $this->db->select('sc_numbers_notfound.*')
								   ->from('sc_numbers_notfound');

		$this->runQuery = $this->db->get();

		return $this->runQuery;
	}



	public function LogSCardNFound($simcardID)
	{
		$this->query 	= $this->db->select('log_sc_notfound_table.*')
								   ->from('log_sc_notfound_table')
								   ->where('log_sc_notfound_table.SIMCARD_ID', $simcardID);

		$this->runQuery = $this->db->get();

		return $this->runQuery;
	}





}

?>