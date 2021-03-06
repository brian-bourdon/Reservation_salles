<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->model('Rendez_vous_model');
        $this->load->model('Salle_model');
        //$this->load->library('User');
    }

    public function index() {
        $data['contents'] = 'index';
        $data['controller'] = "site";
        $this->load->view('templates/template_etudiant', $data);
    }

    public function accueil() {
        // TODO: Modif à faire en fonctions que ce soit un prof, etudiant ou admin
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
            $data['contents'] = 'accueil';
        } else {
            $data['contents'] = 'index';
        }
        $data['controller'] = "site";
        $this->SallesLibre();
    }

    public function connect() {
        $statut = $_POST['statut'];
        $mail = $_POST['mail'];
        $mdp = md5($_POST['pass']); // Mot de passe formulaire
        //echo $mdp;

        $this->load->database();

        $query = $this->User_model->get_user_by_mail($mail);
        if ($query->num_rows() == 1) {

            $this->load->library('User', $query->result_array()[0]);

            var_dump($this->user);

            if (null !== $this->user->getPwd() && $this->user->getPwd() === $mdp && $statut == $this->user->getStatut()) {
                $user_data = array(
                    'prenom' => $this->user->getPrenom(),
                    'nom' => $this->user->getNom(),
                    'mail' => $this->user->getEmail(),
                    'idUser' => $this->user->getIdUser(),
                    'statut' => $this->user->getStatut(),
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($user_data);

                redirect('Site/accueil');
            } else {
                // Mot de passe faux ou mauvais statut (ex: eleve qui se connecte avec ses identifiants en tant que professeur)
                //TODO: Notif
                $this->session->set_flashdata('error', 'Mot de passe invalide');
                redirect('');
            }
        } else {
            // Mail non présent dans la BDD
            //TODO: Notif
            $this->session->set_flashdata('error', 'Mail invalide');
            redirect('');
        }
        $this->db->close();
    }

    public function deconnection() {
        $this->session->sess_destroy(); // Détruit la session
        redirect(base_url()); // Redirige vers la page index
    }

    public function selectUser() {
        $search = $_GET['search'];
        $this->load->database();

        $query = $this->User_model->get_users($search);

        if ($query->num_rows() == 1) {
            $this->load->library('User', $query->result_array()[0]);
            var_dump($this->user);
        }
        $this->db->close();
    }

    public function demande_rdv() {
        $data = array(
            'idDemandeur' => $this->session->userdata('idUser'),
            'idInterlocuteur' => $_POST['nom_prof'],
            'HeureDebut' => $_POST['heure_debut'],
            'HeureFin' => $_POST['heure_fin'],
            'Salle' => $_POST['salle']
        );

        //TODO: Verif salle

        $res = $this->Rendez_vous_model->insert_rdv($data);
        $this->accueil();
        // return $res;
        // Kyriel: je pense que tu devrais pouvoir appeler cette fonction en ajax pour insérer un rdv en BDD et sa devrais le faire
    }

    public function visionner_salles($num_salle = null, $date = null, $heure_debut = null) {//cette fonction sera appeler par ajax
        $query = $this->Rendez_vous_model->get_salles($num_salle, $date, $heure_debut);
        var_dump($query->result_array());
        return $query->result_array();
    }

    public function SallesLibre() {
        //voici la partie que jai ajouter. pour le chargement par defaut. son appel est dan la fonction Accueil
        $query = $this->Salle_model->getAllSalles();
        $salles = $query->result_array();

        $data['contents'] = 'accueil';
        $data['controller'] = "site";
        $data['salles'] = $salles;
        $this->load->view('templates/template_etudiant', $data);
    }

}

?>
