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
    $(".searchUser").keyup(function () {

        var search = $(".searchUser").val();
        $.ajax({
            url: "<?= base_url("Site/selectUser") ?>?search=" + search,
            type: 'GET',
            success: function (html) {
                $('#result').html(html);
            }
        });

    });

    // ajax liste des salles
    $(document).ready(function() {
        $(".searchnum").keyup(function () {

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

        }).keyup();
    });

</script>

</body>
</html>
