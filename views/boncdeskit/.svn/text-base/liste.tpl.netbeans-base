<h1>Extranet {$client_had.lb_donneur_ordre}</h1>

<form name="recherche" class="form l150" method="post" action="/boncdeskit/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche des bons de commandes kit</legend>
		<div class="gauche">
			<ol>
				<li><label>N° de bon </label> <input type="text" style="width:200px" value="{$r_boncdekit_entete.r_numcdekit}" name="r_numcdekit" /></li>
				<li><label>N° de patient </label> <input type="text"   style="width:100px" value="{$r_boncdekit_entete.r_numpat}" name="r_numpat" /></li>
				<li><label>Nom du patient </label> <input type="text"  value="{$r_boncdekit_entete.r_lb_nom}" name="r_lb_nom" /></li>
			</ol>
		</div>
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 200px;">
					<option value="T" {if $r_boncdekit_entete.r_statut EQ "T"}selected{/if}>- Tous -</option>
					<option value="A" {if $r_boncdekit_entete.r_statut EQ "A"}selected{/if}>En cours</option>
					<option value="D" {if $r_boncdekit_entete.r_statut EQ "D"}selected{/if}>Hospitalisation</option>
										
				</select></li>
				<li><label>Date de la demande</label> <input type="text" class="date" value="{$r_boncdekit_entete.r_datdem}" name="r_datdem" /></li>
				<li><label>Date de la livraison</label> <input type="text" class="date" value="{$r_boncdekit_entete.r_datliv}" name="r_datliv" /></li>
			
			</ol>
		</div>
				
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER"> 
		<input name="btn_ajouter" style="float: right" class="boutton" type="button" value="AJOUTER" onclick="window.location='/boncdeskit/ajouter'">


		<div class="separe"></div>

	</fieldset>

	<table id="tableau_resultat" class="display" style="color: black;">
		<thead>
			<tr>
				<th>Donneur d'ordre</th>
				<th>N° cde</th>
				<th>Date demande</th>
				<th>Patient</th>
				<th>Date livraison</th>
				<th>Date envoi mail</th>
				<th>Heure envoi mail</th>
				<th>Statut</th>
			</tr>
		</thead>
	</table>

	</form>

{literal}
<script type="text/javascript">
var autreact = false;
var table = $('#tableau_resultat').dataTable( {
    "autoWidth" : true,
    "processing": true,
    "scrollY": "400px",
     "scrollCollapse": true,
 	"dom": 'C<"clear">RtiS',
    "deferRender":true,
    "scroller": {
          "loadingIndicator": true
      },
     "colReorder": {
          "fixedColumns": 1 ,      //colonnes non deplacables a droite
          "fixedColumnsRight": 1   //colonnes non deplacables a droite
                },
     "colVis": {
                    exclude: [0, 1]
                },
    "language": { "url": "/js/dataTables.french.lang" },
	"columns": [
	               {name:"B.sk_client", "visible":false},
				   {name:"numcdekit"},
	               {name:"datdem", className: "textecentre"},
				   {name:"lb_nom"},
				   {name:"datliv", className: "textecentre"},
				   {name:"datenvmail", className: "textecentre"},
				   {name:"hrsenvmail", className: "textecentre"},
	               {name:"B.statut" , "visible":false}
	             ],
     "ajax": "/boncdeskit/tableau_json",
     "serverSide": true,
   	 "stateSave":true       	 
	});	
	
	$('#tableau_resultat tbody').on('click', 'tr', function () {
			if ($(this).hasClass('selected')) {
				$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				data = table.fnGetData(this);
				numcdekit = data[1];
				statut = data[7];
				action(numcdekit, statut);
			}
	});
				 
function activer(numcdekit){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment réactiver (retour d hospitalisation du patient) ce bon de commande kit n° '+numcdekit+' ?',
				     '/boncdeskit/activer/'+numcdekit,table);
				 }
function desactiver(numcdekit){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment désactiver (hospitalisation du patient) ce bon de commande kit n° '+numcdekit+' ?',
					 '/boncdeskit/desactiver/'+numcdekit,table);		 
	}
       
function editer(numcdekit){
//appel fonction editer	 
	   autreact = true;
	   window.location.href='/boncdeskit/modifier/'+numcdekit;
}
function imprimer(numcdekit) {
			fenetre("/boncdeskit/imprimer/" + numcdekit, 1000, 800);
}
		
function action(numcdekit, statut) {
		//appel reactivation avec confirmation
		if (statut=='En cours'||statut=='Hospitalisation') chaine = '<a href="/boncdeskit/modifier/' + numcdekit + '"><img src="/img/pictos/edit.gif"> Modifier</a><br><br>';
		if (statut=='En cours')	chaine +='<a href="#" onclick=desactiver("' + numcdekit + '");><img src="/img/pictos/hopital.jpg"> Hospitalisation </a><br><br>';
		if (statut=='Hospitalisation') chaine +='<a href="#" onclick=activer("' + numcdekit + '");><img src="/img/pictos/react.png"> Retour Hospitalisation </a><br><br>';		
		if (statut=='En cours') chaine += '<a href="#" onclick=imprimer("' + numcdekit + '");><img src="/img/pictos/pdf.gif"> Imprimer le bon de commande kit</a><br><br>' 
		if (statut=='En cours') chaine += '<br><a href="/boncdeskit/mailbcdekit/' + numcdekit + '/0" onclick="$(\'#loader\').show();"><img src="/img/pictos/mail.png"> Envoyer par mail</a><br><br><br>';
		if (!autreact)
			boite_menu("Bon de cde kit n° " + numcdekit, chaine);
		autreact = false;
}
</script>
{/literal}