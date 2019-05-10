<?php

class Salle_model extends CI_Model {

    private $table = 'salle';

    /* public function get_salles($num_salle=null, $date=null, $heure_debut=null)
      {
      $sql = "SELECT * FROM ".$this->table;
      if(isset($date) && isset($heure_debut)) $sql .= ", rendez_vous";
      if(isset($num_salle) || isset($date) || isset($heure_debut)) $sql .= " WHERE";
      if(isset($num_salle))
      {
      $sql .= " titre = ".$num_salle;
      if(isset($date) && isset($heure_debut)) $sql .= " AND rendez_vous.Date, rendez_vous.HeureDebut NOT EXISTS ( SELECT * FROM rendez_vous WHERE Date =".$date." AND "."HeureDebut = ".$heure_debut." AND titre = ".$num_salle.")";

      }
      else
      {

      if(isset($date) && isset($heure_debut)) $sql .= " rendez_vous.Date, rendez_vous.HeureDebut NOT EXISTS ( SELECT * FROM rendez_vous WHERE Date =".$date." AND "."HeureDebut = ".$heure_debut.")";
      }
      $sql .= ";";

      return $this->db->query($sql);





      // Permet de filter par date num salle, date et heure de debut
      $this->db->select('*');
      $this->db->from($this->table, "rendez_vous");
      if(isset($num_salle)) $this->db->where('titre', $num_salle);
      if(isset($date)) $this->db->where('date', $date);
      if(isset($heure_debut)) $this->db->where('HeureDebut', $heure_debut);
      return $this->db->get();
      } */

    public function getAllSalles() {

        return $this->db->select('*')
                        ->from($this->table)
                        ->get();
    }

}

?>