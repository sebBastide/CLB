function fenetre(url,height,width) {
	if (typeof(height)=="undefined") height="800";
	if (typeof(width)=="undefined") width="600";
	window.open(url, "_blank", "toolbar=no,menubar=no,resizable=yes,scrollbars=yes,titlebar=no,status=no,height="+height+",width="+width);
}

function boite_menu(titre, chaine) {
	$('.contenu').unbind('click');
	$dial=$("#dialog-confirm");
	if (typeof $dial.dialog('instance')!="undefined") $dial.dialog('close');
	$dial.html(chaine).dialog({
		resizable: false,
		modal: false,
		title:  titre,
		height: "auto",
		width: "auto",
		open: function(event, ui) {
				setTimeout(function(){
					$('.contenu').bind('click', function(e){
					$dial.dialog('close');
					}); 
				},500);
		}
	});
}
function boite_modale(titre, chaine) {

	$("#dialog-confirm").html(chaine).dialog({
		resizable: false,
		modal: true,
		title: titre,
		height: 200,
		width: 350
	});
}
function confirm_url(chaine, url) {

	$("#dialog-confirm").html(chaine);

	// Define the Dialog and its properties.
	$("#dialog-confirm").dialog({
		dialogClass: "bloc-identification",
		resizable: false,
		modal: true,
		title: "Confirmation",
		height: 150,
		width: 350,
		closeText: "hide",
		buttons: {
			"Oui": function () {
				$(this).dialog('close');
				window.location.href = url;
			},
			"Non": function () {
				$(this).dialog('close');
			}
		}
	});
}

function confirm_url_ajax(chaine, url, matable) {

	$("#dialog-confirm").html(chaine);

	// Define the Dialog and its properties.
	$("#dialog-confirm").dialog({
		dialogClass: "bloc-identification",
		resizable: false,
		modal: true,
		title: "Confirmation",
		height: 150,
		width: 350,
		closeText: "hide",
		buttons: {
			"Oui": function () {
				$(this).dialog('close');
				$.get(url, function () {
					$(matable).DataTable().ajax.reload(null, false);
				});
			},
			"Non": function () {
				$(this).dialog('close');
			}
		}
	});
}
function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ')
			c = c.substring(1);
		if (c.indexOf(name) != -1)
			return c.substring(name.length, c.length);
	}
	return "";
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}


// Champ date : afficher calendrier
$(function () {
	$("input.date").attr("autocomplete","off");
	$("input[readonly!='readonly'].date ").datepicker(
			{
				dateFormat: "dd/mm/yy",
				changeYear: true, firstDay: 1,
				showAnim : "puff",
				dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
				monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"]
			});
});
