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

        date_default_timezone_set('Europe/Paris');
        $this->load->model('User_model');
        $this->load->model('Rendez_vous_model');
        $this->load->model('Salle_model');
        $this->load->model('Notification_model');
        //$this->load->library('User');
    }

    public function index() {
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])
        {
            $this->accueil();
        }
        $data['contents'] = 'index';
        $data['controller'] = "site";
        $this->load->view('templates/template_etudiant', $data);
    }

    public function accueil() {
        // TODO: Modif à faire en fonctions que ce soit un prof, etudiant ou admin
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
            $data['contents'] = 'accueil';
            //var_dump($data);
        } else {
            $data['contents'] = 'index';
        }
        $data['controller'] = "site";
        $this->load->view('templates/template_etudiant', $data);
    }

    public function reload_notif()
    {
        $notif = $this->Notification_model->get_notif_by_user($_SESSION['idUser'])->result_array();
        foreach ($notif as $key => $value) {
            $rdv_query = $this->Rendez_vous_model->get_rdv_by_id($value['idRdv']);
            if($rdv_query->num_rows() == 1)
            {
                $rdv = $rdv_query->result_array()[0];
                if($rdv['statut'] == "waiting")
                {
                    $interlocuteurs = $this->Rendez_vous_model->get_interlocuteur_rdv($rdv['idDemandeur'], $rdv['Date'], $rdv['HeureDebut'], $rdv['idSalle']);
                    echo "<tr class='notifs'>";
                    echo "<th scope='row'>".$rdv['titre']."</th>";
                    echo "<td>";
                    foreach($interlocuteurs->result_array() as $key2 => $value2)
                    {
                        $user = $this->User_model->get_user_by_id($value2['idInterlocuteur'])->result();
                        echo '<a href="#">@'.$user[0]->prenom.$user[0]->nom."</a>";
                    }
                    echo "</td>";
                    echo "<td>".$rdv['Date']."</td>";
                    echo "<td>".$rdv['HeureDebut']."</td>";
                    echo "<td>";
                    /*echo "<button id='accepted_notif' onclick=\"window.location.href='".base_url('Etudiant/notif_accepted')."?id=".$value['idNotif']."&idRdv=".$value['idRdv']."'\" class='btn btn-success'> <i class='fa fa-play'></i> oui </button>";
                    echo "<button id='refused_notif' onclick=\"window.location.href='".base_url('Etudiant/notif_refused')."?id=".$value['idNotif']."&idRdv=".$value['idRdv']."'\" class='btn btn-danger' > <i class='fa fa-stop'></i> non </button>";*/
                    echo "<button id='accepted_notif' class='btn btn-success' > <i class='fa fa-play'></i> oui </button>";
                    echo "<button id='refused_notif' class='btn btn-danger' > <i class='fa fa-stop'></i> non </button>";
                    echo "<input type='hidden' id='idNotif' value='".$value['idNotif']."'/>";
                    echo "<input type='hidden' id='idRdv' value='".$value['idRdv']."'/>";

                    echo "</td>";
                    echo "</tr>";
                }
            }
        }
    }

    public function load_rdv()
    {
        $mes_rdv = $this->Rendez_vous_model->get_rdv_for_user($_SESSION['idUser'])->result_array();
        foreach($mes_rdv as $key => $value)
        {
            $titre_salle = $this->Salle_model->getSalleByIdSalles($value['idSalle'])->result()[0];
            $demandeur = $this->User_model->get_user_by_id($value['idDemandeur'])->result_array()[0];
            echo "<tr class='rdv_value'>";
            echo "<th scope='row'>".$titre_salle->titre."</th>";
            echo "<td><a href='#'>@".$demandeur['nom'].$demandeur['prenom']."</a></td>";
            echo "<td>";
            $interlocuteurs = $this->Rendez_vous_model->get_interlocuteur_rdv($value['idDemandeur'], $value['Date'], $value['HeureDebut'], $value['idSalle']);

            foreach($interlocuteurs->result_array() as $key2 => $value2)
            {
                $user = $this->User_model->get_user_by_id($value2['idInterlocuteur'])->result();
                echo '<a href="#"">@'.$user[0]->prenom.$user[0]->nom."</a>";
            }
            echo"</td>";
            echo "<td>".$value['Date']."</td>";
            echo "<td>".$value['HeureDebut']."</td>";
            echo "<td>";
            echo "<button class='btn btn-danger'> <i class='fa fa-stop'></i> Annuler </button>";

            echo "</td>";
            echo "</tr>";

        }
    }

    public function reload_count_notif()
    {
        echo "<span id='real_counter_notif'>".$this->Notification_model->get_notif_by_user($_SESSION['idUser'])->num_rows()."</span>";
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

            //var_dump($this->user);

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
        $html = "";
        $query = $this->User_model->get_users($search);

        if ($query->num_rows() > 0 && !empty($search) && strlen($search) > 1) {
            $this->load->library('User', $query->result_array()[0]);
            
            if($this->user->getStatut() == "etudiant") $type_btn = "primary";
            else if($this->user->getStatut() == "professeur") $type_btn = "warning";
            else if($this->user->getStatut() == "admin") $type_btn = "danger";
            else $type_btn = "primary";

            foreach ($query->result_array() as $key => $value) {
                if($this->user->getIdUser() != $_SESSION['idUser'])
                {
                    $html .= '<button type="button" class="btn btn-'.$type_btn.' ok" value="'.$this->user->getEmail().'">' 
                            .$this->user->getNom()." ".$this->user->getPrenom().
                            '</button>';
                }
            }
            echo $html;
        }
        $this->db->close();
    }

    // Function appelé par ajax
    //TODO: filtre date heure + bug duplication des affichages de salles a chaque appel ajax
    public function visionner_salles() {
        if (isset($_GET['num_salles']))
            $num_salles = $_GET['num_salles'];
        else
            $num_salles = null;
        if (isset($_GET['date']))
            $date = $_GET['date'];
        else
            $date = null;
        if (isset($_GET['heure_debut']))
            $heure_debut = $_GET['heure_debut'];
        else
            $heure_debut = null;
        $html = "";

        $query_get_salles = $this->Rendez_vous_model->get_salles($num_salles, $date, $heure_debut);
        foreach ($query_get_salles->result_array() as $key => $value) {
            if (!empty($date) && !empty($heure_debut)) {

                $real_date_obj = new DateTime($date);
                $real_date = $real_date_obj->format('d-m-Y');

                $real_heure_debut_obj = new DateTime($heure_debut);
                $min = $real_heure_debut_obj->format('i');

                if($min > 0 && explode(':', $heure_debut)[0] < 23)
                {
                    $real_heure_debut_obj->modify("+ 1 hour");
                }

                $real_heure_debut = $real_heure_debut_obj->format('H:00');

            } else {

                $real_date_obj = new DateTime();
                $min = $real_date_obj->format('i');
                echo "test".$heure_debut;
                if($min > 0 && explode(':', $heure_debut)[0] < 23)
                {

                    $real_date_obj->modify("+ 1 hour");
                }
                $real_date = $real_date_obj->format('d-m-Y');
                $real_heure_debut = $real_date_obj->format('H:00');

            }

            $html .= '<tr class= "view_salles">
                       	<th scope="row">' . $value['titre'] . '</th>
                        <td>' . $real_date . '</td>
                        <td>' . $real_heure_debut  . '</td>
                        <td>';
            //echo "test ".$this->_isAvailable($value['titre'], $real_date_obj->format('Y-m-d'), $real_heure_debut);
            $data = $this->_isAvailable($value['titre'], $real_date_obj->format('Y-m-d'), $real_heure_debut);
            //var_dump($data);
            if($data['statut'])
            {
                $html .= '<button class="btn btn-success demande_rdv" value="' . $value['titre'] . '/' . $real_date . '/' . $real_heure_debut . '">
                                <i class="fa fa-play"></i> Réserver
                            </button>
                            </td>
                        </tr>';
            }
            else
            {
                $res = $this->_nextAvailableHour($data['data']);


                if(!$res)
                {
                    $html .= '<span style="color:red">Occupée toute la journée</span>';
                }
                else
                {
                    $html .= '<span style="color:red">Se libère à '.$res.'</span>';
                }
            }
        }
        echo $html;
    }

    private function _isAvailable($num_salles, $date, $heure_debut)
    {
        $query = $this->Rendez_vous_model->isSalleAvailable($num_salles, $date, $heure_debut);
        $data = array();
        if($query->num_rows() == 0)
        {
            $data['statut'] = true;
        }
        else
        {
            $data['statut'] = false;
            $data['data'] = $query->result_array();
        }
        return $data;
    }

    private function _nextAvailableHour($res_array)
    {
        $i = 1;

        if(count($res_array) > 1)
        {
            for($i=1; $i < count($res_array); $i++)
            {
                if($res_array[$i-1]['HeureFin'] < $res_array[$i]['HeureDebut']) return $res_array[$i-1]['HeureFin'];
            }
            if($res_array[$i-1]['HeureFin']  <= '23:00:00') return $res_array[$i-1]['HeureFin'];
            else return false;
        }
        else
        {
            if($res_array[$i-1]['HeureFin'] <= '23:00:00') return $res_array[0]['HeureFin'];
            else return false;
        }
    }


}

?>