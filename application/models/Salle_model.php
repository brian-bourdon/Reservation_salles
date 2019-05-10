<?php

class Salle_model extends CI_Model {

    private $table = 'salle';

    public function get_salles($num_salle=null, $date=null, $heure_debut=null)
    {
    	// Permet de filter par date num salle, date et heure de debut
    	$this->db->select('*');
        $this->db->from($this->table, "rendez_vous");
        if(isset($num_salle)) $this->db->where('titre', $num_salle);
        if(isset($date)) $this->db->where('date', $date);
        if(isset($heure_debut)) $this->db->where('HeureDebut', $heure_debut);
        return $this->db->get();
    }







}

?>