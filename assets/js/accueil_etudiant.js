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
			
    });