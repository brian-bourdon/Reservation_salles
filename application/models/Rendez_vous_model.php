<?php
class Rendez_vous_model extends CI_Model
{
	private $table = 'rendez_vous';

	
	public function insert_rdv($data)
	{
		return $this->db->insert($this->table, $data);
	}
	
	public function get_salles($num_salles=null, $date=null, $heure_debut=null) // null = arguments facultatifs
    {
        $this->db->select('*');
        $this->db->from('salle');
        $this->db->join($this->table, 'salle.titre = '.$this->table.'.titre');
        if(isset($date) && isset($heure_debut))
        {
            //$this->db->where($this->table.'.Date', $date);
            //$this->db->where($this->table.'.HeureDebut >=', $heure_debut);
        }
        if(isset($num_salles)) $this->db->like('salle.titre', $num_salles);

        return $this->db->get();
    }
}


?>