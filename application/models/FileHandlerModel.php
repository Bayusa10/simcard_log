<?php
defined('BASEPATH') OR exit('Direct Scripts Not Allowed');


class FileHandlerModel extends CI_Model
{
	
	private $query, $runQuery;

	/* Fungsi insert file log data */
	public function insertLogDataFile($array_data)
	{
		$this->query 	= $this->db->insert('log_data_files', $array_data);
		return $this->query;
	}

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

	



}

?>