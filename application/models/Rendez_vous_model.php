<?php
class Rendez_vous_model extends CI_Model
{
	private $table = 'rendez_vous';

	
	public function insert_rdv($data)
	{
		return $this->db->insert($this->table, $data);
	}
	
	
}


?>