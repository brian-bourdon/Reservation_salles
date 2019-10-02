<?php
class Rendez_vous_model extends CI_Model
{
	private $table = 'rendez_vous';

	public function get_rdv($num_salle, $date, $heure_debut)
    {
          return $this->db->select('*')
                        ->from($this->table)
                        ->where('idSalle', $num_salle)
                        ->where('Date', $date)
                        ->where('HeureDebut', $heure_debut)
                        ->get();
    }

    public function get_rdv_by_id($idRdv)
    {
          return $this->db->select('*')
                        ->from($this->table)
                        ->where('idRdv', $idRdv)
                        ->get();
    }

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
        //$this->distinct();
        $this->db->from($this->table);
        $this->db->where('titre', $num_salle);
        $this->db->where('Date', $date);
        $this->db->where('AllowGroups', 'false');
        //$this->db->where('HeureDebut <=', $heure_debut);
        $this->db->where('HeureFin >', $heure_debut);
		$this->db->where('statut', 'accepted');
        $this->db->order_by('HeureFin ASC');
        $this->db->group_by(array("idDemandeur", "Date", "HeureDebut", "HeureFin", "idSalle", "statut", "titre", "AllowGroups"));

        return $this->db->get();
    }

    public function isSalleTotallyAvailable($num_salle, $date, $heure_debut)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('idSalle', $num_salle);
        $this->db->where('Date', $date);
        //$this->db->where('HeureDebut <=', $heure_debut);
        $this->db->where('HeureFin >', $heure_debut);
        $this->db->where('statut', 'accepted');
        $this->db->order_by('HeureFin ASC');

        return $this->db->get();
    }

    public function get_rdv_for_user($id)
    {
        $where = "statut='accepted' AND (idInterlocuteur='$id' OR idDemandeur='$id')";

        return $this->db->select('idDemandeur, Date, HeureDebut, HeureFin, idSalle')
                        ->distinct()
                        ->from($this->table)
                        ->where($where)
                        ->get();
    }

    public function get_interlocuteur_rdv($idDemandeur, $Date, $HeureDebut, $idSalle) // enlevé id demandeur
    {
                return $this->db->select('idInterlocuteur')
                        ->from($this->table)
                        ->where('idDemandeur', $idDemandeur)
                        ->where('Date', $Date)
                        ->where('HeureDebut', $HeureDebut)
                        ->where('idSalle', $idSalle)
                        ->get();
    }
    public function get_all_interlocuteur_rdv($Date, $HeureDemandee, $idSalle, $HeureFin)
    {
                return $this->db->select('idInterlocuteur, idDemandeur')
                        ->from($this->table)
                        ->where('Date', $Date)
                        ->where('HeureDebut <=', $HeureDemandee)
                        ->where('HeureFin >=', $HeureFin)
                        ->where('idSalle', $idSalle)
                        ->where('statut', 'accepted')
                        ->get();
    }

    public function get_rdv_by_id_salle($idSalle, $Date, $HeureDebut)
    {
        return $this->db->select('*')
                ->from($this->table)
                ->where('idSalle', $idSalle)
                ->where('Date', $Date)
                ->where()
                ->get();
    }

    public function annuler_rdv($date, $heure_debut, $idSalle, $idInterlocuteur)
    {
        $where = "Date = '$date' and HeureDebut = '$heure_debut' and idSalle = '$idSalle' and (idInterlocuteur = '$idInterlocuteur' OR idDemandeur = '$idInterlocuteur')";

        $this->db->where($where);
        return $this->db->delete($this->table);
    }




}


?>