<?php

class Salle_model extends CI_Model {

    public function getAllSalles() {

        return $this->db->select('*')
                        ->from($this->table)
                        ->get();
    }

}

?>