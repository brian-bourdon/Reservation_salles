<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etudiant extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('User_model');
		$this->load->model('Rendez_vous_model');
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
	
	public function demande_rdv_prof()
	{
		$data = array(
					'idDemandeur'	=> $this->session->userdata('idUser'),
					'idInterlocuteur'  => $_POST['nom_prof'], 
					'HeureDebut'     => $_POST['heure_debut'],
					'HeureFin'     => $_POST['heure_fin'],
					'Salle'	  => $_POST['salle']
		);
		
		//TODO: Verif salle
		
		return $this->Rendez_vous_model->insert_rdv($data);
		// Kyriel: je pense que tu devrais pouvoir appeler cette fonction en ajax pour insérer un rdv en BDD et sa devrais le faire

	}

	
}