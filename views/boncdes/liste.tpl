<h1>Extranet {$client_had.lb_donneur_ordre}</h1>

<form name="recherche" class="form l150" method="post" action="/boncdes/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche des bons de commandes</legend>
		<div class="gauche">
			<ol>
				<li><label>N° de bon </label> <input type="text" style="width:200px" value="{$r_boncde_entete.r_numcde}" name="r_numcde" /></li>
				<li><label>N° de patient </label> <input type="text"   style="width:100px" value="{$r_boncde_entete.r_numpat}" name="r_numpat" /></li>
				<li><label>Nom du patient </label> <input type="text"  value="{$r_boncde_entete.r_lb_nom}" name="r_lb_nom" /></li>
			</ol>
		</div>
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 200px;">
					<option value="T" {if $r_boncde_entete.r_statut EQ "T"}selected{/if}>- Tous -</option>
					<option value="A" {if $r_boncde_entete.r_statut EQ "A"}selected{/if}>En cours</option>
					<option value="D" {if $r_boncde_entete.r_statut EQ "D"}selected{/if}>Hospitalisation</option>
					<option value="H" {if $r_boncde_entete.r_statut EQ "H"}selected{/if}>Fin HAD</option>
					
				</select></li>
				<li><label>Date de la demande</label> <input type="text" class="date" value="{$r_boncde_entete.r_datdem}" name="r_datdem" /></li>
				<li><label>Date de la livraison</label> <input type="text" class="date" value="{$r_boncde_entete.r_datliv}" name="r_datliv" /></li>
			
			</ol>
		</div>
				
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER"> 
		<!-- <input name="btn_ajouter" style="float: right" class="boutton" type="button" value="AJOUTER" onclick="window.location='/boncdes/ajouter'" >
		-->
		<div class="separe"></div>

	</fieldset>

	<table id="tableau_resultat" class="display clickable" style="color: black;">
		<thead>
			<tr>
				<th>Donneur d'ordre</th>
				<th>N° cde</th>
				<th>Date demande</th>
				<th>Patient</th>
				<th>Date livraison</th>
				<th>Date envoi mail</th>
				<th>Heure envoi mail</th>
				<th>Date fin HAD</th>
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
	 order : [[ 1 , 'desc' ]],
	"columns": [
	               {name:"B.sk_client", "visible":false},
				   {name:"numcde"},
	               {name:"datdem", className: "textecentre"},
				   {name:"lb_nom"},				   
				   {name:"datliv", className: "textecentre"},
				   {name:"datenvmail", className: "textecentre"},
				   {name:"hrsenvmail", className: "textecentre"},
				   {name:"B.datfinhad", className: "textecentre"},
	               {name:"B.statut" , "visible":false}
	             ],
     "ajax": "/boncdes/tableau_json",
     "serverSide": true,
   	 "stateSave":true       	 
	});	
	
	$('#tableau_resultat tbody').on('click', 'tr', function () {
		table.$('tr.selected').removeClass('selected');
		$(this).addClass('selected');
		data = table.fnGetData(this);
		numcde = data[1];
		datfinhad = data[7];
		statut = data[8];
		action(numcde, datfinhad, statut);
	});

function activer(numcde){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment réactiver (retour d hospitalisation du patient) ce bon de commande n° '+numcde+' ?',
				     '/boncdes/activer/'+numcde,table);
				 }
function desactiver(numcde){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment désactiver (hospitalisation du patient) ce bon de commande n° '+numcde+' ?',
					 '/boncdes/desactiver/'+numcde,table);		 
	}
  function supprimer(numcde){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment suppimer ce bon de commande n° '+numcde+' ?',
					 '/boncdes/supprimer/'+numcde,table);		 
	}     
function editer(numcde){
//appel fonction editer	 
	   autreact = true;
	   window.location.href='/boncdes/modifier/'+numcde;
}
function imprimer(numcde) {
			fenetre("/boncdes/imprimer/" + numcde, 1000, 800);
}
		
function action(numcde, datfinhad, statut) {
		//appel reactivation avec confirmation
		if (statut=='En cours'||statut=='Hospitalisation') chaine = '<a href="/boncdes/modifier/' + numcde + '"><img src="/img/pictos/edit.gif"> Modifier / Rajouter</a><br><br>';
		if (statut=='Fin HAD') chaine = '<a href="/boncdes/modifier/' + numcde + '"><img src="/img/pictos/edit.gif"> Visualiser</a><br><br>';
		if (statut=='En cours')	chaine +='<a href="#" onclick=desactiver("' + numcde + '");><img src="/img/pictos/hopital.jpg"> Hospitalisation </a><br><br>';
		if (statut=='Hospitalisation') chaine +='<a href="#" onclick=activer("' + numcde + '");><img src="/img/pictos/react.png"> Retour Hospitalisation </a><br><br>';		
		if (statut=='En cours')	chaine +='<a href="#" onclick=supprimer("' + numcde + '");><img src="/img/pictos/del.png"> Supprimer </a><br><br>';	
		if (statut=='En cours'||statut=='Fin HAD') chaine += '<a href="#" onclick=imprimer("' + numcde + '");><img src="/img/pictos/pdf.gif"> Imprimer le bon de commande</a><br><br>' 
		if (statut=='En cours'||statut=='Fin HAD') chaine += '<br><a href="/boncdes/mailbcde/' + numcde + '/0" onclick="$(\'#loader\').show();"><img src="/img/pictos/mail.png"> Valider commande</a><br><br><br>';
		if (!autreact)
			boite_menu("Bon de cde n° " + numcde, chaine);
		autreact = false;
}
</script>
{/literal}