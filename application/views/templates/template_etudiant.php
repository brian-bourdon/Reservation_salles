<?php
	$this->load->view("templates/header"); 
	$this->load->view($controller."/".$contents);
	$this->load->view("templates/footer");
?>
