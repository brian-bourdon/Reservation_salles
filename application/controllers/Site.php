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
            redirect('Site/accueil');
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


        echo '<div class="tab-content tab_rdv">';
        echo '<div id="home" class="tab-pane fade in active show">';
        echo '<table class="table table-hover ">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Numéro de salle</th>';
        echo '<th scope="col">Créateur du groupe</th>';
        echo '<th scope="col">Membres du groupe</th>';
        echo '<th scope="col">Date</th>';
        echo '<th scope="col">Heure de début</th>';
        echo '<th scope="col">Heure de Fin</th>';
        echo '<th scope="col" class="">Action </th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach($mes_rdv as $key => $value)
        {
            $titre_salle = $this->Salle_model->getSalleByIdSalles($value['idSalle'])->result()[0];
            $demandeur = $this->User_model->get_user_by_id($value['idDemandeur'])->result_array()[0];
            $datetime = new DateTime($value['Date']." ".$value['HeureDebut']);
            if($datetime->format('Y-m-d H:i:s') >= date('Y-m-d H:i:s'))
            {
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
                echo "<td>".$value['HeureFin']."</td>";
                echo "<td>";
                echo "<a href='".base_url('Etudiant/annuler_rdv?date='.$value['Date'].'&heure_debut='.$value['HeureDebut'].'&idSalle='.$value['idSalle'].'&idInterlocuteur='.$_SESSION['idUser'])."'><button class='btn btn-danger'> <i class='fa fa-stop'></i> Annuler </button></a>";

                echo "</td>";
                echo "</tr>";
            }
        }
        echo '</tbody>';
        echo'</table>';
        echo '</div>';
        echo '<div id="menu1" class="tab-pane fade">';
        echo '<table class="table table-hover tab_rdv">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Numéro de salle</th>';
        echo '<th scope="col">Créateur du groupe</th>';
        echo '<th scope="col">Membres du groupe</th>';
        echo '<th scope="col">Date</th>';
        echo '<th scope="col">Heure de début</th>';
        echo '<th scope="col">Heure de Fin</th>';
        //echo '<th scope="col" class="">Action </th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach($mes_rdv as $key => $value)
        {
            $titre_salle = $this->Salle_model->getSalleByIdSalles($value['idSalle'])->result()[0];
            $demandeur = $this->User_model->get_user_by_id($value['idDemandeur'])->result_array()[0];
            $datetime = new DateTime($value['Date']." ".$value['HeureDebut']);

            if($datetime->format('Y-m-d H:i:s') < date('Y-m-d H:i:s') /*|| ($value['Date'] == date('Y-m-d') && date('H:i:s') > $value['HeureDebut'])*/)
            {
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
                echo "<td>".$value['HeureFin']."</td>";
                echo "<td>";
                //echo "<button class='btn btn-danger'> <i class='fa fa-stop'></i> Annuler </button>";

                echo "</td>";
                echo "</tr>";
            }
        }
        echo '</tbody>';
        echo'</table>';
        echo '</div>';
        echo '</div>';
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
            $api_data = array();
            foreach ($query->result_array() as $key => $value) {
                //var_dump($value);
                $this->load->library('User', $value);

                if($this->user->getIdUser() != $_SESSION['idUser'])
                {
                    if(isset($_GET['type']) && trim($_GET['type']) == 'API')
                    {
                        array_push($api_data, 
                            array('idUser' => $this->user->getIdUser(), 'email' => $this->user->getEmail(),
                             'nom' => $this->user->getNom(), 'prenom' => $this->user->getPrenom(), 'statut' => $this->user->getStatut()));
                    } 
                    else 
                    {
                        if($this->user->getStatut() == "etudiant") $type_btn = "primary";
                        else if($this->user->getStatut() == "professeur") $type_btn = "warning";
                        else if($this->user->getStatut() == "admin") $type_btn = "danger";
                        else $type_btn = "primary";

                        $html .= '<button type="button" class="btn btn-'.$type_btn.' ok" value="'.$this->user->getEmail().'" style="margin-bottom: 22px; margin-left: 3px;">' 
                                .$this->user->getNom()." ".$this->user->getPrenom().
                                '</button>';
                    }
                }
                unset($this->user);
            }
            //echo $html;
            if(isset($_GET['type']) && trim($_GET['type']) == 'API') echo json_encode($api_data);
            else echo $html;
        }
        $this->db->close();
    }

    // Function appelé par ajax
    //TODO: filtre date heure + bug duplication des affichages de salles a chaque appel ajax
    public function visionner_salles($app_json=null) {
        if(isset($app_json) && $app_json['json'])
        {
            $num_salles = $app_json['idSalle'];
            $date = $app_json['Date'];
            $heure_debut = $app_json['HeureDebut'];
        }
        else
        {
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
        }


       
        $html = "";
        $value_json = array();


        $query_get_salles = $this->Rendez_vous_model->get_salles($num_salles);
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
                //echo "test".$heure_debut;
                if($min > 0 && explode(':', $heure_debut)[0] < 23)
                {

                    $real_date_obj->modify("+ 1 hour");
                }
                $real_date = $real_date_obj->format('d-m-Y');
                $real_heure_debut = $real_date_obj->format('H:00');

            }
            
            // Ajout des dispo salle pour les renvoyer en json pour l'app
            if(isset($app_json) && $app_json['json'])
            {
                $value_json['idSalle'] = $value['idSalle'];
                $value_json['Date'] = $real_date;
                $value_json['HeureDebut'] = $real_heure_debut;
            }

            $html .= '<tr class= "view_salles">
                       	<th scope="row">' . $value['titre'] . '</th>
                        <td>' . $real_date . '</td>
                        <td>' . $real_heure_debut  . '</td>
                        <td>'.$value['capacite'].'</td>
                        <td>';

            //echo "test ".$this->_isAvailable($value['titre'], $real_date_obj->format('Y-m-d'), $real_heure_debut);
            $data = $this->_isAvailable($value['titre'], $real_date_obj->format('Y-m-d'), $real_heure_debut);
            //var_dump($data);
            if($data['statut'])
            {
                $value_json['statut'] = "libre";
                $html .= '<button class="btn btn-success demande_rdv" value="' . $value['titre'] . '/' . $real_date . '/' . $real_heure_debut . '">
                                <i class="fa fa-play"></i> Réserver
                            </button>
                            </td>
                        </tr>';
            }
            else
            {
                //echo "test";
                $value_json['statut'] = "non libre";
                $res = $this->_nextAvailableHour($data['data']);
                //var_dump($res);

                if(!$res)
                {
                    $html .= '<span style="color:red">Occupée toute la journée</span>';
                }
                else
                {
                        if(explode(':',$real_heure_debut)[0] < explode(':', $res['heure_debut'])[0])
                        {
                            $value_json['statut'] = "libre";
                            $html .= '<button class="btn btn-success demande_rdv" value="' . $value['titre'] . '/' . $real_date . '/' . $real_heure_debut . '">
                                    <i class="fa fa-play"></i> Réserver
                                </button>
                                </td>
                            </tr>';
                        }
                        else $html .= '<span style="color:red">Se libère à '.$res['heure_fin'].'</span>';
                    

                }
            }
        }
        if(isset($app_json) && $app_json['json']) return $value_json;
        else echo $html;
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
        //echo "test";
        $i = 1;
        //var_dump($res_array);
        if(count($res_array) > 1)
        {
            for($i=1; $i < count($res_array); $i++)
            {

                if($res_array[$i-1]['HeureFin'] < $res_array[$i]['HeureDebut']) return $res_array[$i-1]['HeureFin'];
            }
            if($res_array[$i-1]['HeureFin']  <= '23:00:00') return array("heure_debut" => $res_array[$i-1]['HeureDebut'], "heure_fin" =>  $res_array[$i-1]['HeureFin']); // peut etre a changer
            else return false;
        }
        else
        {
            if($res_array[$i-1]['HeureFin'] <= '23:00:00') {

                return array("heure_debut" => $res_array[0]['HeureDebut'], "heure_fin" =>  $res_array[0]['HeureFin']); // peut etre a changer
            }
            else return false;
        }
    }

    public function load_modal_resa()
    {
        $query_salles = $this->Salle_model->getSalleByNumSalles($_GET['num_salles'])->result_array();
        $num_salles = $query_salles[0]['idSalle'];
        $capacite = $query_salles[0]['capacite'];
        $date = new DateTime($_GET['date']);
        $real_date = $date->format('Y-m-d');
        $heure_debut = $_GET['heure_debut'];
        $rdv = $this->Rendez_vous_model->isSalleTotallyAvailable($num_salles, $real_date, $heure_debut);

        if($rdv->num_rows() == 0)
        {
            $etat = "";
            $statut = "";
        }
        elseif($rdv->num_rows() > 0)
        {
            $personnes_presentes = $this->getPlacesRestantes($real_date, $rdv->result_array()[0]['HeureDebut'], $num_salles);
            $places_restantes_salle = $capacite - count($personnes_presentes);
            //var_dump($personnes_presentes); // RESULTAT COHERENT, A FINIR
            $etat = "disabled";
            if($rdv->result_array()[0]['AllowGroups'])
            {
                //var_dump($rdv->result_array());
                $heure_fin = $rdv->result_array()[0]['HeureFin'];
                $heure_debut_rdv = $rdv->result_array()[0]['HeureDebut'];
                $etat_heure_fin = "readonly";
                $statut = "checked";
                $hidden_value = '<input type="hidden" name="value_check_allow_group" value="true" />';
                $label_info = '<div class="alert alert-warning" role="alert">
                  <b>Un autre groupe à déja réservé cette salle mais celui-ci autorise d\'autre groupes à rejoindre la même salle</b>
                </div>';
                $infos_groupe = 
                '<div id="accordion">
                <div class="card">
                <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Personnes présentes | Reste '.$places_restantes_salle.' places
                </button>
              </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">';
                foreach ($personnes_presentes as $p => $p_val) {
                    $query = $this->User_model->get_user_by_id($p_val);

                    if($query->num_rows() > 0 && $query) 
                    {
                        $this->load->library('User', $query->result_array()[0]);
                        if($this->user->getStatut() == "etudiant") $color = "blue";
                        else if($this->user->getStatut() == "professeur") $color = "orange";
                        else if($this->user->getStatut() == "admin") $color = "red";
                        else $color = "blue";
                        $infos_groupe .= "<span style='color:".$color."'>@".$this->user->getNom().$this->user->getPrenom()."</span></br>";
                        unset($this->user);
                    }
                }
            $infos_groupe .= '
                    </div>
                </div>
            </div>';
            }
            else 
            {
                $statut = "";
                echo '<input type="hidden" name="value_check_allow_group" value="false" />';
            }
        }

        if(isset($script)) echo $script;
        echo '<form class="form real_form_rdv" action="'.base_url("Etudiant/demande_rdv").'" method="post">';                         
        echo '<input class="form-control" type="text" id="titresalle" name="salle"  value="'.$_GET['num_salles'].'"placeholder="Salle" required="" readonly/><br>'; 
        echo '<input class="form-control" type="text" name="date" id="datesalle"  value="'.$real_date.'"placeholder="date" required="" readonly/><br>';
        echo '<input class="form-control" type="time" name="heure_debut" id="heure_debut1"  value="';
        if(isset($heure_debut_rdv) && !empty($heure_debut_rdv)) echo $heure_debut_rdv;
        else echo $heure_debut;
        echo '" placeholder="Heure de début" required="" readonly/><br>';
        echo '<input class="form-control" type="time"  min="" max="23:59" name="heure_fin" value="';
        if(isset($heure_fin) && !empty(trim($heure_fin))) echo $heure_fin;
        else echo strftime('%H:%M', strtotime($heure_debut)+3600);
        echo '" id="heure_fin1" value="" required="" ';
        if(isset($etat_heure_fin)) echo $etat_heure_fin;
        echo '/><br>';
        echo '<input class="form-control searchUser" type="text" id="nom_prof" name="nom_prof" value="" placeholder="Nom du professeur et/ou nom des membres de votre groupe" required=""/><br>';
        echo '<input class="form-control searchUser" type="hidden" id="idProf" name="idProf" value=""/>';
        echo '<div id="result"></div>';
        echo '<div id="allow_group">';
        echo '<div id="allow_checked_group">';
        if(isset($label_info)) echo $label_info;
        if(isset($infos_groupe)) echo $infos_groupe;
        echo '<div class="form-check" style="margin-top: 16px;">';
        echo '<input class="form-check-input" type="checkbox" value="true" id="allow_other_group" name="allow_other_group"'.$statut.' '.$etat.'>';
        echo '<label class="form-check-label" for="allow_other_group">';
        echo 'Autoriser d\'autres groupes à travailler dans la même salle';
        if(isset($hidden_value)) echo $hidden_value;
        echo '</label>';
        echo '</div>';
        echo "</div>";
        echo '</div>';
        echo '<div id="membre" class="form-check form-check-inline">';    
        echo '</div>';
        echo '<input class="btn btn-block btn-success active " type="submit" value="Faire la demande" /><br>';
        echo '</form>';
    }
    public function getPlacesRestantes($Date, $HeureDebut, $idSalle )
    {

        $rdv = $this->Rendez_vous_model->get_rdv($idSalle, $Date, $HeureDebut)->result_array()[0];

        $interlocuteurs = $this->Rendez_vous_model->get_all_interlocuteur_rdv($rdv['Date'], $HeureDebut, $rdv['idSalle'], $rdv['HeureFin']);

        $tab_places = array();

        foreach ($interlocuteurs->result_array() as $key => $rdvv) {
            if(!in_array($rdvv['idDemandeur'], $tab_places))
            {
                array_push($tab_places,$rdvv['idDemandeur']);
            }
            if(!in_array($rdvv['idInterlocuteur'], $tab_places))
            {
                array_push($tab_places,$rdvv['idInterlocuteur']);
            }
        }
        return $tab_places;
    }

    // Obtenir la dispo d'une salle pour la journéee => pour l'appli android
    public function getDispoSalleAPP() {
        if(isset($_GET['num_salles']) && isset($_GET['date']) && !empty($_GET['num_salles']) && !empty($_GET['date']))
        {
            $data['json'] = true;
            $data['idSalle'] = $_GET['num_salles'];
            $data['Date'] = $_GET['date'];
            $real_dispo_salle = array();
            $d = new DateTime("00:00");
            for($i = 0; $i<=23; $i++)
            {
                $data['HeureDebut'] = $d->format('H:00');
                $dispo_salle = $this->visionner_salles($data);
                array_push($real_dispo_salle, $dispo_salle);
                $d->modify("+1 hour");
            }
            echo json_encode($real_dispo_salle);
        }
    }
    // Connection pour l'appli android
    public function ApiConnection() {
        if(isset($_GET['email']) && isset($_GET['pwd']) && isset($_GET['statut']) && !empty(trim($_GET['email'])) && !empty(trim($_GET['pwd'])) && !empty(trim($_GET['statut'])))
        {
            $this->load->database();

            $query = $this->User_model->get_user_by_mail(trim($_GET['email']));

            if ($query->num_rows() >= 1) {

                $this->load->library('User', $query->result_array()[0]);

                //var_dump($this->user);

                if (null !== $this->user->getPwd() && $this->user->getPwd() === trim($_GET['pwd']) && trim($_GET['statut']) == $this->user->getStatut()) {
                    $user_data = array(
                        'prenom' => $this->user->getPrenom(),
                        'nom' => $this->user->getNom(),
                        'mail' => $this->user->getEmail(),
                        'idUser' => $this->user->getIdUser(),
                        'statut' => $this->user->getStatut(),
                        'logged_in' => TRUE
                    );
                    echo json_encode($user_data);
                } else {
                    echo "BAD_IDENTIFIERS";
                }
            } else {
                echo "WRONG_EMAIL";
            }
            $this->db->close();
        }
    }

}
?>