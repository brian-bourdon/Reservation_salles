<?php

class Salle_model extends CI_Model {

  private $table = "salle";

  public function getAllSalles() {

      return $this->db->select('*')
                        ->from($this->table)
                        ->get();
  }

  public function getSalleByNumSalles($num_salles)
  {
      return $this->db->select('*')
                        ->from($this->table)
                        ->where('titre', $num_salles)
                        ->get();
  }

}

?>