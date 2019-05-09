$(document).ready(function () {
    $("#form_rdv").hide();
    $("#btn_retour_demande_rdv").hide();
    $("#demande_rdv").click(function () {
        $("#mes_rdv").hide();
        $("#form_rdv").show();
        $("#btn_retour_demande_rdv").show();
        $("#btn_close_demande_rdv").hide();

    });
    $("#btn_retour_demande_rdv").click(function () {
        $("#btn_retour_demande_rdv").hide();
        $("#btn_close_demande_rdv").show();
        $("#mes_rdv").show();
        $("#form_rdv").hide();
    });

    $("#connectProf").click(function () {
        $("#connectEtudform").hide();
        $("#Incriptionform").hide();
        $("#exampleModalLongTitle").text("Se connecter en tant que prof");
        $("#connectProfform").show();
    });

    $("#inscrire").click(function () {
        $("#connectEtudform").hide();
        $("#connectProfform").hide();
        $("#exampleModalLongTitle").text("Inscription étudiant");
        $("#Incriptionform").show();
    });

    $("#connectEtud").click(function () {
        $("#Incriptionform").hide();
        $("#connectProfform").hide();
        $("#exampleModalLongTitle").text("Se connecter en tant qu'étudiant");
        $("#connectEtudform").show();
    });


    let scanner = new Instascan.Scanner({video: document.getElementById('preview')});

    $("#startscan").click(function () {
        $("#normal").hide();
        $("#preview").show();
        $("#stopscan").show();
        $("#startscan").hide();

        scanner.addListener('scan', function (content) {
            alert(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });

    });

    $("#stopscan").click(function () {
        $("#preview").hide();
        $("#normal").show();
        $("#stopscan").hide();
        $("#startscan").show();
        scanner.stop();
    });



});