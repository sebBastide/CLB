
<h1>Extranet {$element.lb_donneur_ordre}</h1>

<h2>Bienvenue sur l'interface de gestion des bons de commandes HAD Bastide</h2>

<h4>Vous pouvez rechercher un patient pour gérer un bon de commande ou faire une recherche par numéro de bon de commande</h4>

<form name="tableaudebord" class="form l150" method="post" action="/accueil/recherche">
	
	<div class="separe h_5"></div>
	
	<div class="gauche" style="width: 430px">
		<div id="tabsGH" class="form" style="height: 200px;" >
			<ul>
				<li><a href="#tabs-GH1">Recherche / Patient</a></li>
				<li><a href="#tabs-GH2">Recherche / Bon de cde</a></li>
			</ul>

			<div id="tabs-GH1">
				<ol>
					<li><label>N° de patient </label> <input type="text"  name="r_numero"  id="r_numero" style="width: 120px"/></li>
					<li><label>Nom </label> <input type="text"  name="r_nom" id="r_nom"  style="width: 200px" /></li>
					<li><label>Date de naissance</label> <input type="text" class="date"  name="r_datenaissance"  id="r_datenaissance"  style="width: 125px"/></li>
				</ol>
				<div class="separe h_5"></div>
				<label>&nbsp</label> <input name="btn_recherche_patient" class="boutton right" type="submit" value="Rechercher">
			</div>
			
			<div id="tabs-GH2">
				<ol>
					<li>
						<label>Type commande </label>
						<select name="r_typcde" style="width: 200px;">
							<option value="C" {if r_typcde EQ "C"}selected{/if}>Commandes</option>
							<option value="D" {if r_typcde EQ "D"}selected{/if}>Récupération déchets</option>
							<option value="M" {if r_typcde EQ "M"}selected{/if}>Récupération matériels</option>
						</select>
					</li>
					<li><label>N° de bon</label> <input type="text"  name="r_numbon"  id="r_numbon" style="width: 120px"/></li>
					<li><label>Date de demande</label> <input type="text" class="date"  name="r_datdem"  id="r_datdem"   /></li>
					<li><label>Date liv./récup.</label> <input type="text" class="date"  name="r_datint"  id="r_datint"  />
				
					<input name="btn_recherche_cde" class="boutton right" type="submit" value="Rechercher"></li>
				</ol>
			</div>
		</div>	
		
		<div class="separe h_10"></div>		
		
		<div id="tabsGB" class="form" style="height: 300px;" >
				<ul>
					<li><a href="#tabs-GB">Livraison(s) J+2 au {$datlim|dat}</a></li>
				</ul>
				<ol>	
					<div class="separe h_10"></div>		
					<div style="overflow-y:auto; height:240px; width:410px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° bon </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date liv./recup.</h5> </th>
						</thead>
			
						<tbody>
					
						{foreach $bons as $k => $bon}	
							<input type="hidden" name="element[numbon][$k]" value="{$bon.numbon}">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> {$bon.numbon}  </td>
								<td style="border:1px dotted; text-align:center;"> {if {$bon.datdem}!='0000-00-00' }{$bon.datdem|dat}{/if}  </td>
								<td style="border:1px dotted; text-align:center;"> {$bon.lb_titre} {$bon.lb_nom} </td>
								<td style="border:1px dotted; text-align:center;"> {if {$bon.datint}!='0000-00-00' } {$bon.datint|dat} {/if} </td>
							</tr>
						{/foreach}
					
						</tbody>
						</table>
					</div>
				</ol>
		</div>
	</div>
	
	<div class="droite" style="width: 530px;">
			<div id="tabsDH" class="form" style="height: 300px;" >
				<ul>
					<li><a href="#tabs-D1">Dern. cdes saisies</a></li>
					<li><a href="#tabs-D2">Dern. récup. déchets</a></li>
					<li><a href="#tabs-D3">Dern. récup. matériels</a></li>
				</ul>

				<div id="tabs-D1">
					<div style="overflow-y:auto; margin-left:-15px; height:235px; width:500px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
						
						<h5>Dernière(s) commande(s)</h5>
						
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° Cde </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date livraison </h5> </th>
						</thead>
			
						<tbody>
					
						{foreach $boncdes_entete as $k => $boncde_entete}	
							<input type="hidden" name="element[numcde][$k]" value="{$boncde_entete.numcde}">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> <a class="nounderline" href="/boncdes/modifier/{$boncde_entete.numcde}">{$boncde_entete.numcde}</a></td>
								<td style="border:1px dotted; text-align:center;"> {if {$boncde_entete.datdem}!='0000-00-00' }{$boncde_entete.datdem|dat}{/if}  </td>
								<td style="border:1px dotted; text-align:center;"><a class="nounderline" href="/patients/gerer/{$boncde_entete.numpat}"> {$boncde_entete.lb_titre} {$boncde_entete.lb_nom} </a></td>
								<td style="border:1px dotted; text-align:center;"> {if {$boncde_entete.datliv}!='0000-00-00' } {$boncde_entete.datliv|dat} {/if} </td>
							</tr>
						{/foreach}
					
						</tbody>
						</table>
					</div>
				</div>
					
		
				<div id="tabs-D2">
					<ol>
						<div style="overflow-y:auto; margin-left:-15px; height:235px; width:500px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
	
						<h5>Dernière(s) récup. déchet(s)</h5>
						
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° bon </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date récupération </h5> </th>
						</thead>
			
						<tbody>
					
						{foreach $bonrecs_dechet as $k => $bonrec_dechet}	
							<input type="hidden" name="element[numbrdec][$k]" value="{$bonrec_dechet.numbrdec}">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> {$bonrec_dechet.numbrdec}  </td>
								<td style="border:1px dotted; text-align:center;"> {if {$bonrec_dechet.datdem}!='0000-00-00' }{$bonrec_dechet.datdem|dat}{/if}  </td>
								<td style="border:1px dotted; text-align:center;"> {$bonrec_dechet.lb_titre} {$bonrec_dechet.lb_nom} </td>
								<td style="border:1px dotted; text-align:center;"> {if {$bonrec_dechet.datrec}!='0000-00-00' } {$bonrec_dechet.datrec|dat} {/if} </td>
							</tr>
						{/foreach}
					
						</tbody>
						</table>
					</div>
					</ol>	
				</div>
			
				<div id="tabs-D3">
					<ol>
					<div style="overflow-y:auto; margin-left:-15px; height:235px; width:500px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
	
						<h5>Dernière(s) récup. matériel(s)</h5>
						
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° bon </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date récupération </h5> </th>
						</thead>
			
						<tbody>
					
						{foreach $bonrecs_materiel as $k => $bonrec_materiel}	
							<input type="hidden" name="element[numbrmat][$k]" value="{$bonrec_materiel.numbrmat}">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> {$bonrec_materiel.numbrmat}  </td>
								<td style="border:1px dotted; text-align:center;"> {if {$bonrec_materiel.datdem}!='0000-00-00' }{$bonrec_materiel.datdem|dat}{/if}  </td>
								<td style="border:1px dotted; text-align:center;"> {$bonrec_materiel.lb_titre} {$bonrec_materiel.lb_nom} </td>
								<td style="border:1px dotted; text-align:center;"> {if {$bonrec_materiel.datrec}!='0000-00-00' } {$bonrec_materiel.datrec|dat} {/if} </td>
							</tr>
						{/foreach}
					
						</tbody>
						</table>
					</div>
					</ol>
				</div>
			</div>
						
			<div class="separe h_10"></div>		
		
			<div id="tabsDB" class="form" style="height: 200px;" >
				<ul>
					<li><a href="#tabs-DB">Tableau de bord au {date('d-m-Y')|dat}</a></li>
				</ul>
				<ol>	
					<label>&nbsp</label> 
					<h5>{$nbcde.nb} bon(s) de commande(s) ont été saisis depuis le 01/01/{date(Y)}</h5>
					<h5>{$nbdec.nb} demande(s) de récupérations de déchets ont été faites depuis le 01/01/{date(Y)} </h5>
					<h5>{$nbmat.nb} demande(s) de récupérations de matériels ont été faites depuis le 01/01/{date(Y)} </h5>
				</ol>
			</div>
				
	   </div>
	
	<div class="separe"></div>


	
	</form>

{literal}
<script type="text/javascript">
	    $(function () {
            $('#tabsGH').tabs({heightStyle: "auto"});
	        $('#tabsGB').tabs({heightStyle: "auto"});
	        $('#tabsDH').tabs({heightStyle: "auto"});
			$('#tabsDB').tabs({heightStyle: "auto"});
        });
		
</script>
{/literal}