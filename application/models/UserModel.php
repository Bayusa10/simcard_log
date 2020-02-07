<?php

defined('BASEPATH') OR exit('Direct Scripts Not Allowed');

class UserModel extends CI_Model
{
	
	private $query, $runQuery;

	/* Fungsi Check Login */
	public function checkUser($username, $password)
	{
		$this->query 	= $this->db->select('user_table.*')
								   ->from('user_table')
								   ->where('user_table.username', $username)
								   ->where('user_table.password', $password);

		$this->runQuery	= $this->db->get();

		return $this->runQuery;
	}

	public function updateLoginStat($userID, $logStatus)
	{
		$this->query 	= $this->db->set('user_table.IS_LOGIN', $logStatus)
								   ->where('user_table.U_ID', $userID);

		$this->runQuery	= $this->query->update('user_table');

		return $this->runQuery;
	}

	public function checkIsLogin($idUser)
	{
		$this->query 	= $this->db->select('user_table.IS_LOGIN')
								   ->from('user_table')
								   ->where('user_table.U_ID', $idUser);

		$this->runQuery	= $this->db->get();

		return $this->runQuery;
	}
	/* Fungsi Check Login */

}

?>