<main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
        <div class="container">
            <header class="section-header"> 
                <br> <br>
                <?php
                if (!empty($this->session->flashdata('create_rdv')))
                    echo '<div class="alert alert-' . $this->session->flashdata('create_rdv')['statut'] . '" role="alert">' .
                    $this->session->flashdata('create_rdv')['msg'] .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
                ?>

                <h3>Welcome <?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></h3>
                <br>
            </header>

            <p class="wow"> <?php //var_dump($_SESSION)         ?></p>


            <div class="row about-cols">

                <div class="col-md-4 wow fadeInUp"  data-toggle="modal" data-target="#myModal">
                    <div class="about-col">
                        <div class="img">
                            <img src="<?php echo base_url('assets/img/about-mission.jpg'); ?>" alt="" class="img-fluid">
                            <div class="icon"><i class="ion-ios-speedometer-outline"></i></div>
                        </div>
                        <h2 class="title"><a href="#">Réserver une salle</a></h2>
                        <p>
                            On pourra connaître le nombre de places dispo dans la salle et dire si on
                            est d'accord ou non pour que d'autres groupes travaillent aussi dans la même salle que nous.   </p>
                    </div>
                </div>

                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s" data-toggle="modal" data-target="#rdv">
                    <div class="about-col">
                        <div class="img">
                            <img src="<?php echo base_url('assets/img/about-plan.jpg'); ?>" alt="" class="img-fluid">
                            <div class="icon"><i class="ion-ios-list-outline"></i></div>
                        </div>
                        <h2 class="title"><a href="#">Voir mes rendez-vous</a></h2>
                        <p>
                            Pouvoir faire une demande de prise de rdv avec un prof ou des étudiants: si le prof exepte de vous recevoir la salle sera réserver </p>
                    </div>
                </div>

                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="about-col">
                        <div class="img" id="scanner">
                            <video id="preview" class="img-fluid cacher"></video>
                            <div class="img" >
                                <img src="<?php echo base_url('assets/img/about-vision.jpg'); ?>" id="normal" alt="" class="img-fluid">
                                <div class="icon" id="startscan"><i class="fa fa-qrcode"></i></div>
                                <div class="icon cacher" id="stopscan"><i class="fa fa-stop"></i></div>
                            </div>
                        </div>
                        <h2 class="title"><a href="#">Scannez un code QR</a></h2>
                        <p>Si je scanne une salle occupée par des gens qui ne m'ont pas invité : message m'indiquant 
                            jusqu'à quelle heure la salle est occupée,
                            ou si elle est occupée toute la journée.  </p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- #about -->

    <!--==========================
      Services Section
    ============================-->
    <section id="services">

    </section><!-- #services -->

    <!--==========================
      Team Section
    ============================-->
    <section id="team">
        <div class="container">
            <div class="section-header wow fadeInUp">
                <h3>Team</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6 wow fadeInUp">
                    <div class="member">
                        <img src="<?php echo base_url('assets/img/team-1.jpg'); ?>" class="img-fluid" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Walter White</h4>
                                <span>Chief Executive Officer</span>
                                <div class="social">
                                    <a href=""><i class="fa fa-twitter"></i></a>
                                    <a href=""><i class="fa fa-facebook"></i></a>
                                    <a href=""><i class="fa fa-google-plus"></i></a>
                                    <a href=""><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="member">
                        <img src="<?php echo base_url('assets/img/team-2.jpg'); ?>" class="img-fluid" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Sarah Jhonson</h4>
                                <span>Product Manager</span>
                                <div class="social">
                                    <a href=""><i class="fa fa-twitter"></i></a>
                                    <a href=""><i class="fa fa-facebook"></i></a>
                                    <a href=""><i class="fa fa-google-plus"></i></a>
                                    <a href=""><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="member">
                        <img src="<?php echo base_url('assets/img/team-3.jpg'); ?>" class="img-fluid" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>William Anderson</h4>
                                <span>CTO</span>
                                <div class="social">
                                    <a href=""><i class="fa fa-twitter"></i></a>
                                    <a href=""><i class="fa fa-facebook"></i></a>
                                    <a href=""><i class="fa fa-google-plus"></i></a>
                                    <a href=""><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="member">
                        <img src="<?php echo base_url('assets/img/team-4.jpg'); ?>" class="img-fluid" alt="">
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                                <div class="social">
                                    <a href=""><i class="fa fa-twitter"></i></a>
                                    <a href=""><i class="fa fa-facebook"></i></a>
                                    <a href=""><i class="fa fa-google-plus"></i></a>
                                    <a href=""><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- #team -->

    <!--==========================
     Listes des salles
    ============================-->
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <div class="container">

                        <header class="section-header wow fadeInUp"  id="mes_rdv">
                            <h3>Listes des salles</h3>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Numéro de salle
                                            <input class="form-control searchnum" id="num_salles" type="text" name="searchnum" value="" placeholder="Rechercher" required=""/><br>
                                        </th>
                                        <th scope="col">Date
                                            <input class="form-control searchnum" id="date" type="date" min="<?php echo date('Y-m-d'); ?>" name="date" value="" placeholder="Rechercher a une date" required=""/><br>

                                        </th>
                                        <th scope="col">Heure
                                            <input class="form-control searchnum" id="heure_debut" type="time" min="<?php echo date('H:i'); ?>" max="23:59" name="time" value="" required=""/><br>
                                        </th>
                                        <th scope="col" class="">Option </th>
                                    </tr>
                                </thead>
                                <tbody id="vue_salles">
                                    
                                </tbody>
                            </table>
                        </header>

                        <div id="form_rdv">
                            <form class="form" action="<?php echo base_url("Etudiant/demande_rdv"); ?>" method="post">                           
                                <input class="form-control" type="text" id="titresalle" name="salle" value="" placeholder="Salle" required="" readonly/><br>  
                                <input class="form-control" type="text" name="date" id="datesalle" value="" placeholder="date" required="" readonly/><br>
                                <input class="form-control" type="time" name="heure_debut" id="heure_debut1" value="" placeholder="Heure de début" required="" readonly/><br>
                                <input class="form-control" type="time" name="heure_fin" id="heure_fin1" value="" placeholder="Heure de fin" required=""/><br>
                                <input class="form-control searchUser" type="text" id="nom_prof" name="nom_prof" value="" placeholder="Nom du professeur et/ou nom des membres de votre groupe" required=""/><br>
                                <input class="form-control searchUser" type="hidden" id="idProf" name="idProf" value=""/>
                                <div id="result"></div>

                                <div id="membre" class="form-check form-check-inline">
                                    
                                </div><br>

                                <input class="btn btn-block btn-success active " type="submit" value="Faire la demande" /><br>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-block" id="btn_retour_demande_rdv">Retour</button>
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


</main>