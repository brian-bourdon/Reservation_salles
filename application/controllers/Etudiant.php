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
		if(isset($_POST['value_check_allow_group'])) $allow_other_group = $_POST['value_check_allow_group'];
		else
		{
			if(isset($_POST['allow_other_group']) && $_POST['allow_other_group']) $allow_other_group = $_POST['allow_other_group'];
			else $allow_other_group = "false";
		}

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
					'idSalle' => $idSalle,
					'AllowGroups' => $allow_other_group
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
		$res = true;
		if(isset($_GET['id']) && !empty($_GET['id'])) $res &= $this->Notification_model->delete_by_id($_GET['id']); // Supprime notif
		if(isset($_GET['idRdv']) && !empty($_GET['idRdv'])) $res &= $this->Notification_model->update_rdv_after_notif($_GET['idRdv'], "accepted"); // Maj rdv
		if($res)
		{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			  Vous avez bien rejoins le groupe
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
		}
		//redirect(base_url('Site/accueil'));
	}

	public function notif_refused()
	{
		$res = true;
		if(isset($_GET['id']) && !empty($_GET['id'])) $res &= $this->Notification_model->delete_by_id($_GET['id']); // Supprime notif
		if(isset($_GET['idRdv']) && !empty($_GET['idRdv'])) $res &= $this->Notification_model->update_rdv_after_notif($_GET['idRdv'], "refused"); // Maj rdv
		if($res)
		{
			echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
			  Vous avez bien quitté le groupe
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
		}
		//redirect(base_url('Site/accueil'));
	}

	public function annuler_rdv()
	{
		if(isset($_GET['date'])) $date = $_GET['date'];
		if(isset($_GET['heure_debut'])) $heure_debut = $_GET['heure_debut'];
		if(isset($_GET['idSalle'])) $idSalle = $_GET['idSalle'];
		if(isset($_GET['idInterlocuteur'])) $idInterlocuteur = $_GET['idInterlocuteur'];

		$res = $this->Rendez_vous_model->annuler_rdv($date, $heure_debut, $idSalle, $idInterlocuteur);
		$this->session->set_flashdata('annuler_rdv', $res);

		redirect('Site/accueil');
	}
	// Inscription etudiant pour l'appli android
	public function ApiInscriptionEtudiant()
	{
		if(isset($_GET['nom']) && !empty(trim($_GET['nom'])) && isset($_GET['prenom']) && !empty(trim($_GET['prenom']))
		&& isset($_GET['mail']) && !empty(trim($_GET['mail'])) && isset($_GET['pwd']) && !empty(trim($_GET['pwd'])))
		{
			echo "test";
			$data = array(
						'prenom'  => $_GET['prenom'],
						'nom'     => $_GET['nom'],
						'email'	  => $_GET['mail'],
						'pwd'  	  => $_GET['pwd'],
						'statut'  => 'etudiant'
			);
			$this->load->library('User', $data);

			//var_dump($this->user);
			//TODO: Mettre regle de verif champs
			
			$res = $this->User_model->insert_user($this->user);
			
			if(isset($res) && !empty($res[0])) echo $res[0];
			else echo 0;
		}


	}



}