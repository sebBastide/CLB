<h1>Extranet {$client.lb_donneur_ordre}</h1>

<form name="gerer" class="form l150" method="post" action="/patients/gerer">
	<div style=" height:110px; width:900px; color:black;padding:5px 5px 5px 60px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
		<div class="droite" style="width:300px;">
			<ol>
				<h4> ( Patient n° {$patient.ext_patient} )</h4>
				<input type="hidden" name="hide_ext_patient" value="{$patient.hide_ext_patient}" />
				<input type="hidden" name="hide_sk_patient" value="{$patient.hide_sk_patient}" />
				
			</ol>
		</div>
		<div class="gauche"style="width:600px;" >
			<ol>
				<h4>{$patient.lb_titre} {$patient.lb_nom} {if !empty($patient.dt_naissance)} - né(e) le : {datevershtml($patient.dt_naissance, 'Y-m-d H:i:s')} {/if} - tél. {$patient.lb_telephone}</h4>				
				<h4>{$patient.lb_adresse} </h4>
				<h4>{$patient.lb_codepostal} - {$patient.lb_ville} </h4>
			</ol>
		</div>
	
	
</div>
<div class="separe h_20"></div>
<div style=" height:auto; width:965px; color:black; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">

				<div style="overflow-y:auto;  width:965px; color:black;border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
					<ol>
						<table class="display dataTable no-footer" role="grid" style="font-size: 11px;font-family: Verdana,Helvetica,sans-serif;color: black; margin-left: 0px; ">
								<thead>
									<th width='86'>Réf.</th>	
									<th width='420'>Produit</th>				
									<th width='346'>Commentaire</th>				
									<th width='82'>Qté cdée</th>	
									<th width='50'>Date</th>
									<th width='150'>Num Commande</th>
									<td width='80' align='center'><b>Récupérer<b><input type="checkbox" name="arecupTout" tabindex="-1" title="Tout sélectionner/déselectionner" onClick = "cocherDecocher();"/></td>
								</thead>
								<tbody >								
									{foreach $boncde as $k => $bonc} 											
										<tr>
											<td style="">
											{if $bonc.sk_produit >30 || $bonc.sk_produit <1  }
												{$bonc.sk_produit|replace:'FKL55651':'FKL5565'|replace:'FKL55652':'FKL5565'|replace:'FKL33101':'FKL3310'|replace:'FKL33102':'FKL3310'|replace:'FKL33103':'FKL3310'} 
											{/if}
											</td>
											<td>{$bonc.lb_produit}</td>
											<td>{$bonc.co_produit}</td>
											<td>{$bonc.qt_produit}</td>
											<td>{if isset($bonc.credat)}{$bonc.credat}{/if}</td>	
											<td><a  href="/boncdes/modifier/{$bonc.numcde}">{$bonc.numcde}</td>	
											<td align="center"><input type="checkbox" name="arecup" tabindex="-1" /></td>
											<input type="hidden" name="id_produit" value="{$bonc.sk_produit}" />
											<input type="hidden" name="id_commande" value="{$bonc.numcde}" />
										</tr>
									{/foreach}									
								</tbody>
							</table>
						</ol>
					</div>									
					<span>
						<input name="btn_recuperer" type="button" class="boutton right" value="RECUPERER LE MATERIEL SELECTIONNE" onClick="recup();" />						
					</span>

</div>
	<div class="separe h_20"></div>
	
	<div style="overflow-y:auto; height:600px; width:900px; color:black;padding:5px 5px 5px 60px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
		<ol>
			<li> <a href="/boncdes/ajouter?numpat={$patient.ext_patient}"  style="color:black; margin-left:5px;"> >> Nouveau bon de commande </a>
			</li>
					
			{foreach $boncdes_entete as $k => $boncde_entete}	
				<li>
					<input type="hidden" name="element[numcde][$k]" value="{$boncde_entete.numcde}">
					{if !empty({$boncde_entete.numcde})}
						<img src="/img/pictos/commande.png" title="Bon de commande" >
						<b> > Commande n° </b> {$boncde_entete.numcde} du  {$boncde_entete.datdem|dat} pour le {$boncde_entete.datliv|dat} <em class="orderStatus">({$boncde_entete.status} depuis le {$boncde_entete.dateStatus})</em>
						<a href="/boncdes/modifier/{$boncde_entete.numcde}"  style="color:black;  text-decoration:none">
							<img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier / Rajouter commande">
						</a>

						{foreach $boncde_entete.brm as $k => $brm}	
							{if !empty({$brm.numbrmat})}
								<li> 
									<img src="/img/pictos/materiel.png" title="Bon de récupération matériel" style="margin-left: 50px;">
									<b>Récup. matériel n° </b> {$brm.numbrmat} du {$brm.datdem|dat} pour le {$brm.datrec|dat} <em class="orderStatus">({$brm.status} depuis le {$brm.dateStatus})</em>
									<a href="/bonrmat/modifier/{$brm.numbrmat}"  style="color:black;  text-decoration:none">
										<img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier / Rajouter bon de récupération matériel">
									</a>
								</li>
							{/if}
						{/foreach}
					{/if}
				</li>
			{/foreach}
		</ol>
	</div>
</form>

{literal}
<script type="text/javascript">
function editer_bcde(numcde){
//appel fonction editer	   
	   window.location.href='/boncdes/modifier/'+numcde;
}

function recup()
{
	var i = 0;
	var lienRecup = '?';
	var commandes='';
	var produits='';
	for (i=0;i<document.getElementsByName('arecup').length;i++)
	{
		if(document.getElementsByName('arecup').item(i).checked)
		{						
			if (document.getElementsByName('id_commande').item(i).value.trim() != '')
			{
				commandes = commandes + "'"+ document.getElementsByName('id_commande').item(i).value + "',";
				produits = produits + "'" + document.getElementsByName('id_produit').item(i).value + "',";	
			}				
		}
	}
	if (commandes != '') 
	{
		commandes = commandes.substring(0,commandes.length-1);
		produits = produits.substring(0,produits.length-1);
		window.location.href='/bonrmat/ajouter_Multi/?id_commande='+commandes + '&id_produit='+produits;
	}
	else
	{
		alert('Veuillez sélectionner des produits à récupérer');
	}
}

function cocherDecocher()
{	
	for (i=0;i<document.getElementsByName('arecup').length;i++)
	{
		if (document.getElementsByName('arecup').item(i).checked)
		{
			document.getElementsByName('arecup').item(i).checked = false;
		}
		else
		{
			document.getElementsByName('arecup').item(i).checked = true;
		} 
	}
}

</script>
{/literal}