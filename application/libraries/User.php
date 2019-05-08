<?php
class User {
    
    private $idUser;
    private $email;   
    private $nom;
    private $prenom;
    private $pwd;
    private $statut;

    public function __construct($parameters=null) {

		if(isset($parameters['idUser'])) $this->idUser = $parameters['idUser'];
		$this->nom = $parameters['nom'];
		$this->prenom = $parameters['prenom'];
		$this->email = $parameters['email'];
		$this->statut = $parameters['statut'];
		$this->pwd = $parameters['pwd'];
		
    }
		
    function getIdUser() {
        return $this->idUser;
    }

    function getEmail() {
        return $this->email;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getPwd() {
        return $this->pwd;
    }

    function getStatut() {
        return $this->statut;
    }

    function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setPwd($pwd) {
        $this->pwd = $pwd;
    }

    function setStatut($statut) {
        $this->statut = $statut;
    }

}

?>