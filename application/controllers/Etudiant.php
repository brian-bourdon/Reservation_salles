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
	
	// Mettre dans user
	public function demande_rdv()
	{
		var_dump($_POST);
		$now = new DateTime('now');
		$date = new DateTime($_POST['date']);
		$data = array(
					'idDemandeur'	=> $this->session->userdata('idUser'),
					'idInterlocuteur'  => $_POST['idProf'],
					'Date'		=> $date->format('Y-m-d'),
					'HeureDebut'     => $_POST['heure_debut'],
					'HeureFin'		=> $_POST['heure_fin'],
					'titre'	  => $_POST['salle']
		);


		//TODO: Verif salle
		$info = array();
		if($this->Rendez_vous_model->insert_rdv($data)) 
		{
			$info['msg'] = "Votre rendez-vous a bien été crée";
			$info['statut'] = "success";
		}
		else 
		{
			$info['msg'] = 'Rendez-vous non crée';
			$info['statut'] = "danger";
		}
		$this->session->set_flashdata('create_rdv', $info);
		redirect('Site/accueil');


	}

	
}