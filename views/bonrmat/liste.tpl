<h1>Extranet {$client_had.lb_donneur_ordre}</h1>

<form name="recherche" class="form l150" method="post" action="/bonrmat/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche des bons de récupérations matériels</legend>
		<div class="gauche">
			<ol>
				<li><label>N° de bon </label> <input type="text" style="width:200px" value="{$r_bonrec_materiel.r_numbrmat}" name="r_nom" /></li>
				<li><label>N° de patient </label> <input type="text"   style="width:100px" value="{$r_bonrec_materiel.r_numpat}" name="r_numpat" /></li>
				<li><label>Nom du patient </label> <input type="text"  value="{$r_bonrec_materiel.r_lb_nom}" name="r_lb_nom" /></li>
				
			</ol>
		</div>
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 200px;">
					<option value="T" {if $r_bonrec_materiel.r_statut EQ "T"}selected{/if}>- Tous -</option>
					<option value="A" {if $r_bonrec_materiel.r_statut EQ "A"}selected{/if}>En cours</option>
					<option value="D" {if $r_bonrec_materiel.r_statut EQ "D"}selected{/if}>Supprimés</option>
					<option value="H" {if $r_bonrec_materiel.r_statut EQ "H"}selected{/if}>Fin HAD</option>
				</select></li>
				<li><label>Date de la demande</label> <input type="text" class="date" value="{$r_bonrec_materiel.r_datdem}" name="r_datdem" /></li>
				<li><label>Date de la récupération</label> <input type="text" class="date" value="{$r_bonrec_materiel.r_datrec}" name="r_datrec" /></li>
			</ol>
		</div>
				
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER">
		<div class="separe"></div>

	</fieldset>

	<table id="tableau_resultat" class="display clickable" style="color: black;">
		<thead>
			<tr>
				<th>Donneur d'ordre</th>
				<th>N° bon</th>
				<th>Date demande</th>
				<th>Patient</th>
				<th>Date récupération</th>
				<th>Date envoi mail</th>
				<th>Heure envoi mail</th>
				<th>Date fin HAD</th>
				<th>Statut commande</th>
				<th>Date du statut</th>
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
    "deferRender": true,
    "scroller": {
		"loadingIndicator": true
	},
	"colReorder": {
		"fixedColumns": 1 ,      //colonnes non deplacables a droite
		"fixedColumnsRight": 3  //colonnes non deplacables a droite
	},
	"colVis": {
		exclude: [0, 1, 8, 9, 10]
	},
    "language": { "url": "/js/dataTables.french.lang" },
	"order" : [[ 1 , 'desc' ]],
	"columns": [
		{name:"B.sk_client", "visible": false},
		{name:"numbrmat"},
		{name:"datdem", className: "textecentre"},
		{name:"lb_nom"},
		{name:"datrec", className: "textecentre"},
		{name:"datenvmail", className: "textecentre"},
		{name:"hrsenvmail", className: "textecentre"},
		{name:"datfinhad", className: "textecentre"},
		{name:"s.label", className: "textecentre"},
		{name:"dateStatus", className: "textecentre"},
		{name:"B.statut" , "visible": false},
	],
	"ajax": "/bonrmat/tableau_json",
	"serverSide": true
});	
$('#tableau_resultat tbody').on('click', 'tr', function () {
	table.$('tr.selected').removeClass('selected');
	$(this).addClass('selected');
	data = table.fnGetData(this);
	numbrmat =  data[1];
	datfinhad = data[7];
	statut = data[10];
	action(numbrmat, datfinhad, statut);
});
function activer(numbrmat){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment réactiver ce bon de récupération matériel n° '+numbrmat+' ?',
				     '/bonrmat/activer/'+numbrmat,table);
				 }
function desactiver(numbrmat){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment supprimer ce bon de récupération matériel n° '+numbrmat+' ?',
					 '/bonrmat/desactiver/'+numbrmat,table);
			 
	}
       
function editer(numbrmat){
//appel fonction editer	   
	   window.location.href='/bonrmat/modifier/'+numbrmat;
}

function action(numbrmat, datfinhad, statut) {
		//appel reactivation avec confirmation
		if (datfinhad==0) chaine = '<a href="/bonrmat/modifier/' + numbrmat + '"><img src="/img/pictos/edit.gif"> Modifier / Rajouter</a><br><br>';
		if (datfinhad!=0) chaine = '<a href="/bonrmat/modifier/' + numbrmat + '"><img src="/img/pictos/edit.gif"> Visualiser</a><br><br>';
		if (statut=='A') chaine +='<a href="#" onclick=desactiver("' + numbrmat + '");><img src="/img/pictos/del.png"> Supprimer </a><br><br>';
		if (statut=='D') chaine +='<a href="#" onclick=activer("' + numbrmat + '");><img src="/img/pictos/react.png"> Réactiver </a><br><br>';		
		chaine += '<br><a href="/bonrmat/mailbrmat/' + numbrmat + '/0" onclick="$(\'#loader\').show();"><img src="/img/pictos/mail.png"> Valider bon</a><br><br><br>';
		if (!autreact)
			boite_menu("Bon récup. matériel " + numbrmat, chaine);
		autreact = false;
}
</script>
{/literal}