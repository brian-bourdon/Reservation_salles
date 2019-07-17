<?php
class Notification_model extends CI_Model
{
	private $table = 'notification';

	public function insertNotif($idRdv, $idUser)
	{
		$data = array(
	        'idRdv' => $idRdv,
	        'idUser' => $idUser
		);

		return $this->db->insert($this->table, $data);
	}

	public function get_notif_by_user($idUser)
	{

        return $this->db->select('idRdv, idNotif')
                        ->from($this->table)
                        ->where('idUser', $idUser)
                        ->get();

	}

	public function delete_by_id($id)
	{
		$this->db->where('idNotif', $id);
		return $this->db->delete($this->table);
	}

	public function update_rdv_after_notif($idRdv, $value)
	{
		$data = array(
        	'statut' => $value,
		);
		$this->db->where('idRdv', $idRdv);
		return $this->db->update("rendez_vous", $data);
	}
}

?>