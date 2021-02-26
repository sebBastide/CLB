<h1>Extranet {$client_had.lb_donneur_ordre}</h1>

<form name="recherche" class="form l150" method="post" action="/bonrdec/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche des bons de récupérations déchets</legend>
		<div class="gauche">
			<ol>
				<li><label>N° de bon </label> <input type="text" style="width:200px" value="{$r_bonrec_dechet.r_numbrdec}" name="r_nom" /></li>
				<li><label>Nom patient </label> <input type="text"  value="{$r_bonrec_dechet.r_lb_nom}" name="r_lb_nom" /></li>
				<li><label>Date demande</label> <input type="text" class="date" value="{$r_bonrec_dechet.r_datdem}" name="r_datdem" /></li>
				<li><label>Date recupération</label> <input type="text" class="date" value="{$r_bonrec_dechet.r_datrec}" name="r_datrec" /></li>
			</ol>
		</div>
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 200px;">
					<option value="T" {if $r_bonrec_dechet.r_statut EQ "T"}selected{/if}>- Tous -</option>
					<option value="A" {if $r_bonrec_dechet.r_statut EQ "A"}selected{/if}>En cours</option>
					<option value="D" {if $r_bonrec_dechet.r_statut EQ "D"}selected{/if}>Supprimés</option>
				</select></li>
			</ol>
		</div>
				
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER">
		<div class="separe"></div>

	</fieldset>

	<table id="tableau_resultat" class="display" style="color: black;">
		<thead>
			<tr>
				<th>Donneur d'ordre</th>
				<th>N° bon</th>
				<th>Date demande</th>
				<th>Patient</th>
				<th>Date récupération</th>
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
          "fixedColumnsRight": 3  //colonnes non deplacables a droite
                },
     "colVis": {
                    exclude: [0, 1, 7, 8, 9]
                },
    "language": { "url": "/js/dataTables.french.lang" },
	"columns": [
	               {name:"B.sk_client", "visible":false},
				   {name:"numbrdec"},
	               {name:"datdem", className: "textecentre"},
				   {name:"lb_nom"},
				   {name:"datrec", className: "textecentre"},
				   {name:"datenvmail", className: "textecentre"},
				   {name:"hrsenvmail", className: "textecentre"},
	               {name:"B.statut" , "visible":false}
	             ],
     "ajax": "/bonrdec/tableau_json",
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
				numbrdec =  data[1];
				statut =  data[7];
				action(numbrdec, statut);
			}
		});
function activer(numbrdec){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment réactiver ce bon de récupération déchet n° '+numbrdec+' ?',
				     '/bonrdec/activer/'+numbrdec,table);
				 }
function desactiver(numbrdec){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment supprimer ce bon de récupération déchet n° '+numbrdec +' ?',
					 '/bonrdec/desactiver/'+numbrdec,table);
			 
	}
       
function editer(numbrdec){
//appel fonction editer	   
	   window.location.href='/bonrdec/modifier/'+numbrdec;
}

function action(numbrdec, statut) {
		//appel reactivation avec confirmation
		chaine = '<a href="/bonrdec/modifier/' + numbrdec + '"><img src="/img/pictos/edit.gif"> Modifier</a><br><br>';
		if (statut=='A') chaine +='<a href="#" onclick=desactiver("' + numbrdec + '");><img src="/img/pictos/del.png"> Supprimer </a><br><br>';
		if (statut=='D') chaine +='<a href="#" onclick=activer("' + numbrdec + '");><img src="/img/pictos/react.png"> Réactiver</a><br><br>';		
		chaine += '<br><a href="/bonrdec/mailbrdec/' + numbrdec + '/0" onclick="$(\'#loader\').show();"><img src="/img/pictos/mail.png"> Envoyer par mail</a><br><br><br>';
		if (!autreact)
			boite_menu("Bon récup. déchet " + numbrdec, chaine);
		autreact = false;
}
</script>
{/literal}