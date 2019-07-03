<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etudiant extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('User_model');
		$this->load->model('Rendez_vous_model');
		$this->load->model('Salle_model');
		$this->load->model('Notification_model');
		//$this->load->library('User');
	}
	
	public function inscription_etudiant()
	{
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$email = $_POST['email'];
		$pwd = md5($_POST['pass']);
		

		$data = array(
					'prenom'  => $prenom,
					'nom'     => $nom,
					'email'	  => $email,
					'pwd'  => $pwd,
					'statut'  => 'etudiant'
		);
		$this->load->library('User', $data);

		//var_dump($this->user);
		//TODO: Mettre regle de verif champs
		
		$test = $this->User_model->insert_user($this->user);
		
		redirect('');
		
	}
	// Mettre dans user
	public function demande_rdv()
	{
		$mails_demandeurs = explode(";", $_POST['nom_prof']);
		$tab_verif_mail = array();
		$now = new DateTime('now');
		$date = new DateTime($_POST['date']);

		$salle = $this->Salle_model->getSalleByNumSalles($_POST['salle']);
		$idSalle = "";
		if ($salle->num_rows() == 1) {
			$idSalle = $salle->result_array()[0]['idSalle'];
		}

		foreach ($mails_demandeurs as $key => $mail) {
			if(!empty(trim($mail)))
			{
				if(!in_array(trim($mail), $tab_verif_mail))
				{
					array_push($tab_verif_mail, trim($mail));
				}
			}
		}

		foreach ($tab_verif_mail as $key => $value) {
			$user = $this->User_model->get_user_by_mail($value)->result_array()[0];
			$this->load->library('User');

			$this->user->setIdUser($user['idUser']);
			$this->user->setEmail($user['email']);
			$this->user->setNom($user['nom']);
			$this->user->setPrenom($user['prenom']);
			$this->user->setPwd($user['pwd']);
			$this->user->setStatut($user['statut']);

			if($_POST['heure_fin'] == "00:00") $heure_fin = "23:59";
			else $heure_fin = $_POST["heure_fin"];

			$data = array(
					'idDemandeur'	=> $this->session->userdata('idUser'),
					'idInterlocuteur'  => $this->user->getIdUser(),
					'Date'		=> $date->format('Y-m-d'),
					'HeureDebut'     => $_POST['heure_debut'],
					'HeureFin'		=> $heure_fin,
					'titre'	  => $_POST['salle'],
					'idSalle' => $idSalle
			);

			//TODO: Verif salle
			$info = array();
			$info['statut'] = true;
			if($this->Rendez_vous_model->insert_rdv($data)) 
			{
				$info['msg'] = "Votre rendez-vous a bien été crée.</br>Les éleves/professeurs concernés ont reçus une notification.";
				$info['statut'] &= true;
				$idRdv = $this->db->insert_id();
				$this->Notification_model->insertNotif($idRdv, $this->user->getIdUser()); //Envoi notif
			}
			else 
			{
				$info['msg'] = 'Rendez-vous non crée';
				$info['statut'] &= false;
			}
		}

		if($info['statut']) $info['statut'] = "success";
		else $info['statut'] = "danger";

		$this->session->set_flashdata('create_rdv', $info);
		redirect('Site/accueil');
	}

	public function getSallesById($id)
	{
		$data = array(
					'prenom'  => $prenom,
					'nom'     => $nom,
					'email'	  => $email,
					'pwd'  => $pwd,
					'statut'  => 'etudiant'
		);
		
		$test = $this->User_model->insert_user($this->user);
		
		redirect('');	
	}

	public function notif_accepted()
	{
		if(isset($_GET['id']) && !empty($_GET['id'])) $this->Notification_model->delete_by_id($_GET['id']); // Supprime notif
		if(isset($_GET['idRdv']) && !empty($_GET['idRdv'])) $this->Notification_model->update_rdv_after_notif($_GET['idRdv'], "accepted"); // Maj rdv
		redirect(base_url('Site/accueil'));
	}

	public function notif_refused()
	{
		if(isset($_GET['id']) && !empty($_GET['id'])) $this->Notification_model->delete_by_id($_GET['id']); // Supprime notif
		if(isset($_GET['idRdv']) && !empty($_GET['idRdv'])) $this->Notification_model->update_rdv_after_notif($_GET['idRdv'], "refused"); // Maj rdv
		redirect(base_url('Site/accueil'));
	}



}