$(document).ready(function () {

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function startTime() {
        function addZero(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        var dt = new Date();
        var time = addZero(dt.getHours()) + ":" + addZero(dt.getMinutes());
        $("#heure_debut").val(time);
    }
    startTime();

    function totalTimes(times) {
        var totalM = times.map(function (hhmm) {
            var parts = hhmm.split(":");
            return (+parts[0] * 60) + (+parts[1]);
        }).reduce(function (m1, m2) {
            return m1 + m2;
        }, 0),
                h = Math.floor(totalM / 60),
                m = totalM % 60;

        return h + ':' + (m < 10 ? '0' : '') + m;
    }

    $("#form_rdv").hide();
    $("#btn_retour_demande_rdv").hide();

    $("body").on("click", ".demande_rdv", function () {
        var num = $(this).val();
        var res = num.split("/");
        $("#mes_rdv").hide();
        $("#form_rdv").show();
        $("#btn_retour_demande_rdv").show();
        $("#btn_close_demande_rdv").hide();
        $("#titresalle").val(res[0]);
        $("#datesalle").val(res[1]);
        $("#heure_debut1").val(res[2]);
        //$("#heure_fin1").attr("min", totalTimes([res[2], "1:00"]));
        //$("#heure_fin1").val(totalTimes([res[2], "1:00"]));

    });
    $("body").on("click", "#btn_retour_demande_rdv", function () {
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


    $("#form_rdv").on("click", ".ok", function () {
        var mail = $(this).val();
        var taglist = $("#nom_prof").val().replace(($("#nom_prof").val().split("; "))[($("#nom_prof").val().split("; ")).length - 1], "");

        $("#nom_prof").val(taglist + mail + '; ');
    });


});