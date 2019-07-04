<!--==========================
  Footer
============================-->
<footer id="footer">

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Groupe 4</strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=BizPage
            -->
            Designed by <a href="Admin/index.php">Groupe 4</a>
        </div>
    </div>
</footer><!-- #footer -->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- JavaScript Libraries -->
<script src="<?php echo base_url('assets/lib/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/jquery/jquery-migrate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/easing/easing.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/superfish/hoverIntent.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/superfish/superfish.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/wow/wow.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/waypoints/waypoints.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/counterup/counterup.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/owlcarousel/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/isotope/isotope.pkgd.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/lightbox/js/lightbox.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/touchSwipe/jquery.touchSwipe.min.js'); ?>"></script>
<!-- Contact Form JavaScript File -->
<script src="<?php echo base_url('assets/js/contactform/contactform.js'); ?>"></script>


<!-- Template Main Javascript File -->
<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
<!-- Etudiant Javascript File -->
<script src="<?php echo base_url('assets/js/accueil_etudiant.js'); ?>"></script>

<script> //brian voici l'exemple de ajax

    $(document).ready(function () {


        $(".searchUser").keyup(function () {

            var taglist = $("#nom_prof").val();
            var dernier_mot = taglist.split('; ').pop();
            $.ajax({
                url: "<?= base_url("Site/selectUser") ?>?search=" + dernier_mot,
                type: 'GET',
                success: function (html) {
                    $('#result').html(html);
                }
            });

        });

        function recherche() {

            var num_salles = $("#num_salles").val();
            var date = $("#date").val();
            var heure_debut = $("#heure_debut").val();
            $.ajax({
                url: "<?= base_url("Site/visionner_salles") ?>?num_salles=" + num_salles + "&date=" + date + "&heure_debut=" + heure_debut,
                type: 'GET',
                dataType: 'html',
                success: function (html) {
                    $('.view_salles').remove();
                    $(html).appendTo('#vue_salles');
                }
            });
        }
        
        function reload_count_notif()
        {
            $.ajax({
                url: "<?= base_url("Site/reload_count_notif") ?>",
                type: 'GET',
                dataType: 'html',
                success: function (html) {
                    $('#real_counter_notif').remove();
                    $(html).appendTo('#counter_notif');
                }
            });
        }

        function reload_notif() {
            $.ajax({
                url: "<?= base_url("Site/reload_notif") ?>",
                type: 'GET',
                dataType: 'html',
                success: function (html) {
                    reload_count_notif();
                    $('.notifs').remove();
                    $(html).appendTo('#notif_body');
                }
            });
        }
        function accepted_notif() {
            idNotif = $('#idNotif').val();
            idRdv = $('#idRdv').val();
            $.ajax({
                url: "<?= base_url("Etudiant/notif_accepted") ?>?id=" + idNotif + "&idRdv=" + idRdv,
                type: 'GET',
                dataType: 'html',
                success: function (html) {
                    reload_notif();
                    $('#myMod').modal('toggle'); 
                    $(html).appendTo('.section-header');
                }
            });
        }

        function refused_notif() {
            idNotif = $('#idNotif').val();
            idRdv = $('#idRdv').val();
            $.ajax({
                url: "<?= base_url("Etudiant/notif_refused") ?>?id=" + idNotif + "&idRdv=" + idRdv,
                type: 'GET',
                dataType: 'html',
                success: function (html) {
                    reload_notif();
                    $('#myMod').modal('toggle'); 
                    $(html).appendTo('.section-header');
                }
            });
        }

        $(document).on('click','#accepted_notif',function () {
            accepted_notif();
        });
        $(document).on('click','#refused_notif',function () {
            refused_notif();
        });
        $( document ).ready(function() {
            reload_notif();
        });

        function addZero(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        // ajax liste des salles
        $(".searchnum").blur(function () {
            recherche();
        }).blur();

        $(".searchnum").change(function () {
            recherche();
        });

        $(".searchnum").keyup(function () {
            recherche();
        });

        $("#date").change(function () {
            var ok = new Date();
            var now = addZero(ok.getFullYear()) + "-" + addZero(ok.getMonth() + 1) + "-" + addZero(ok.getDate());
            var time = addZero(ok.getHours()) + ":" + addZero(ok.getMinutes());
            if ($("#date").val() === now) {
                $("#heure_debut").attr("min", time);
                $("#heure_debut").val(time);
            } else {
                $("#heure_debut").attr("min", "00:00");
                $("#heure_debut").val("00:00");
            }
        });


    });

</script>

</body>
</html>
