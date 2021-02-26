<h1>Extranet {$element.lb_donneur_ordre}</h1>

<form name="recherche" class="form l150" method="post" action="/raisons_had/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche raisons fin HAD</legend>
		
		<div class="gauche">
			<ol>
				<li><label>Code</label> <input type="text" value="{$r_raisons_had.r_codrai}" name="r_codrai"  style="width:100px"/></li>
				<li><label>Libellé</label> <input type="text" value="{$r_raisons_had.r_librai}" name="r_librai" /></li>	
				
			</ol>
		</div>
				
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 150px;">
					<option value="T" {if $r_raisons_had.r_statut EQ "T"}selected{/if}>- Tous -</option>
					<option value="A" {if $r_raisons_had.r_statut EQ "A"}selected{/if}>En cours</option>
					<option value="D" {if $r_raisons_had.r_statut EQ "D"}selected{/if}>Supprimées</option>
				</select></li>			
			</ol>
		</div>		
		<div class="separe h_20"></div>		
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER"> 
		<input name="btn_ajouter" style="float: right" class="boutton" type="button" value="AJOUTER" onclick="window.location='/raisons_had/ajouter'">		
	</fieldset>

	<table id="tableau_resultat" class="display" style="color: black;">
		<thead>
			<tr>
				<th>Code</th>
				<th>Libellé</th>
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
                  exclude: [0, 3, 4]
                },
    "language": { "url": "/js/dataTables.french.lang" },
	"columns": [
	               {name:"codrai"},
     			   {name:"librai"},
				   {name:"statut" , "visible": true},
	               { "orderable": false },
	               { "orderable": false }
	             ],
     "ajax": "/raisons_had/tableau_json",
     "serverSide": true,
   	 "stateSave":true       	 
});	

function activer(codrai){
	//appel reactivation avec confirmation
	  confirm_url_ajax('Voulez-vous vraiment réactiver cette raison '+codrai+'?',
			  '/raisons_had/activer/'+codrai,'#tableau_resultat');
	} 
	          
function desactiver(codrai){
	//appel désactivation avec confirmation
	  confirm_url_ajax('Voulez-vous vraiment supprimer cette raison '+codrai+'?',
			  '/raisons_had/desactiver/'+codrai,'#tableau_resultat');  		 
	}
	
</script>
{/literal}