<?php
class Rendez_vous_model extends CI_Model
{
	private $table = 'rendez_vous';

	
	public function insert_rdv($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function get_salles($num_salle=null, $date=null, $heure_debut=null)
    {
    	// Permet de filter par date num salle, date et heure de debut
    	$this->db->select('*');
        $this->db->from($this->table, "rendez_vous");
        if(isset($num_salle)) $this->db->where('titre', $num_salle);
        if(isset($date) && isset($heure_debut))
        {
        	$where = "(Date, HeureDebut) != ('".$date."','".$heure_debut."')";
			$this->db->where($where);
		}
        return $this->db->get(); 
    }

	
	
}


?>