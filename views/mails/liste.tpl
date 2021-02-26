<form name="recherche" class="form" method="post" action="/mails/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche des mails</legend>
		<div class="gauche">
			<ol>
				<li><label>Sujet :</label>      <input type="text" value="{$r_mails.r_subject}" name="r_subject" /></li>
				<li><label>Destinataire</label> <input type="text" value="{$r_mails.r_mailto}" name="r_mailto" /></li>
				<li><label>Expéditeur</label>   <input type="text" value="{$r_mails.r_mailfrom}" name="r_mailfrom" /></li>
			</ol>
		</div>
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER"> 
		<div class="separe"></div>

	</fieldset>
	</form>	
	<input name="btn_ajouter" style="position:relative;margin-bottom:-35px;z-index:999" class="boutton" type="button" value="NOUVEAU" onclick="window.location='/mails/ajouter'">
	<table id="tableau_resultat" class="display" style="color: black;">
		<thead>
			<tr>
				<th>id</th>
				<th>Date</th>
				<th>Heure</th>
				<th>Expediteur</th>
				<th>Destinataire</th>
				<th>Sujet</th>
				<th>Erreur</th>
 				<th></th> 
			</tr>
		</thead>
		</table>

{literal}
<script type="text/javascript">
var table = $('#tableau_resultat').dataTable( {
	"autoWidth" : true,
    "processing": true,
    "scrollCollapse": true,
    "scrollY": "400px",
	"scrollX": "100%",
 	"dom": 'C<"clear">RtiS',
	"paging":true,
    "deferRender":true,
    "scroller": {
          "loadingIndicator": true
      },
     "colReorder": {
          "fixedColumns": 1 ,
          "fixedColumnsRight": 1
                },
    "colVis": {
           exclude: [ 0, 7 ]
                },
            
    "language": { "url": "/js/dataTables.french.lang" },
  	"columns": [
  	       		{ "visible": false , "name" : "id" },
  	            { "name" : "credat"},
  	            { "name" : "creheu"},
 	            { "name" : "mailfrom"},
  	            { "name" : "mailto"},
  	           	{ "name" : "subject"},
  	         	{ "name" : "mailerror"},
   	            { "orderable": false , className:"textecentre"}
  	             ],
 	 "ajax": "/mails/tableau_json",
 	 "serverSide" : true,
 	 "stateSave"  : true
});	

function editer(mailfrom){
	//appel edition 
	  window.location.href='/mails/modifier/'+mailfrom;		}

	

</script>
{/literal}