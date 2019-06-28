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

            
            if(!empty($num_salles))
            {
                $this->db->like('salle.titre', $num_salles);
            }
            if(!empty($date) && !empty($heure_debut))
            {
                //$this->db->join($this->table, 'salle.titre = '.$this->table.'.titre');
            }
        
        return $this->db->get();
    }

    public function isSalleAvailable($num_salle, $date, $heure_debut)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('titre', $num_salle);
        $this->db->where('Date', $date);
        //$this->db->where('HeureDebut <=', $heure_debut);
        $this->db->where('HeureFin >', $heure_debut);
        $this->db->order_by('HeureFin ASC');

        return $this->db->get();
    }

    public function get_rdv_by_id($id)
    {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('idInterlocuteur', $id)
                        ->or_where('IdDemandeur', $id)
                        ->get();

    }


}


?>