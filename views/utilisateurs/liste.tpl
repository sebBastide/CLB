<h1>Extranet {$client.lb_donneur_ordre}</h1>

<form name="recherche" class="form l150" method="post" action="/utilisateurs/liste">
		<fieldset class="bloc_recherche">
		<legend>Recherche des utilisateurs</legend>
		<div class="gauche">
			<ol>
				<li><label>Nom </label> <input type="text" value="{$r_utilisateurs.r_nom}" name="r_nom" /></li>
				<li><label>Identifiant</label> <input type="text" value="{$r_utilisateurs.r_coduti}" name="r_coduti" /></li>
			</ol>
		</div>
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 150px;">
						<option value="T" {if $r_utilisateurs.r_statut EQ "T"}selected{/if}>- Tous -</option>
						<option value="A" {if $r_utilisateurs.r_statut EQ "A"}selected{/if}>Actifs</option>
						<option value="D" {if $r_utilisateurs.r_statut EQ "D"}selected{/if}>Inactifs</option>
				</select></li>
			</ol>
		</div>
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER">
		<input name="btn_ajouter" style="float: right" class="boutton" type="button" value="AJOUTER" onclick="window.location='/utilisateurs/ajouter'">
	</fieldset>


	<table id="tableau_resultat" class="display" style="color: black;">
		<thead>
			<tr>
				<th>Donneur d'ordre</th>
				<th>Identifiant</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Mail</th>
				<th>Statut</th>	
				<th></th>	
				<th></th>	
				
			</tr>
		</thead>
	</table>

	</form>
	{literal}
<script type="text/javascript">
var table = $('#tableau_resultat').dataTable( {
    "autoWidth" : true,
    "processing": true,
    "scrollX": "100%",
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
                  exclude: [0, 1, 6, 7, 8]
                },
    "language": { "url": "/js/dataTables.french.lang" },
	"columns": [
	               {name:"sk_client", "visible":false},
				   {name:"coduti"},
	               {name:"nom"},
	               {name:"prenom"},
	               {name:"mail"},
	               {name:"statut" },
	               { "orderable": false },
	               { "orderable": false }
	             ],
     "ajax": "/utilisateurs/tableau_json",
     "serverSide": true,
   	 "stateSave": true   	 
});	
	
function activer(coduti){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment réactiver ce code d\'accès ?'+coduti,
				     '/utilisateurs/activer/'+coduti,'#tableau_resultat');
				 }
function desactiver(coduti){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment désactiver ce code d\'accès ?'+coduti,
					 '/utilisateurs/desactiver/'+coduti,'#tableau_resultat');
			 
	}      
function editer(coduti){
//appel fonction editer	   
	   window.location.href='/utilisateurs/modifier/'+coduti;
}
	
</script>
{/literal}