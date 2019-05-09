<?php
class User_model extends CI_Model
{
	private $table = 'user';

	public function get_user_by_id($id)
	{
		return $this->db->select('*')
				->from($this->table)
				->where('idUser', $id)
				->get();
	}
	
	public function get_user_by_mail($mail)
	{
		return $this->db->select('*')
				->from($this->table)
				->where('email', $mail)
				->get();
	}
	
	public function get_user_by_name($nom)
	{
		return $this->db->select('*')
				->from($this->table)
				->where('nom', $nom)
				->get();
	}
	
	public function get_user_by_firstname($prenom)
	{
		return $this->db->select('*')
				->from($this->table)
				->where('prenom', $prenom)
				->get();
	}
	
	
	public function insert_user($user)
	{
		$data = array(
					'prenom'  => $user->getPrenom(),
					'nom'     => $user->getNom(),
					'email'	  => $user->getEmail(),
					'pwd'  		=> $user->getPwd(),
					'statut'  => $user->getStatut()
		);
		
		$res = $this->db->insert($this->table, $data);
		$idUser = $this->db->insert_id();
		return array($res, $idUser);
	}

}
?>