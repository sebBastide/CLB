<h1>Extranet {$client_had.lb_donneur_ordre}</h1>

<form name="editer" method="post" action="/boncdes/enregistrer">
	
	<input type="hidden" name="hide_numcde" value="{$element.hide_numcde}" />
	<input type="hidden" name="numcde" value="{$element.numcde}" />
	<div id="tabs" class="form" style="height:900px">
		<ul>
			<li><a href="#tabs-1">Bon de commande N° {$element.numcde}</a></li>			
		</ul>

		</li>
		<div id="tabs-1" class="form_editer">
			<div class="gauche" style="width:570px" > 
				<fieldset>
					<ol>	
						<li>
							<label style="width:80px">Demandé le</label> <input type="text" name="datdem" id="datdem" class="date" maxlength="50" value="{$element.datdem}" readonly/>
							<label style="width:50px">Livré le</label> <input type="text" name="datliv" id="datliv" class="date" maxlength="50" value="{$element.datliv}" {if $element.datfinhad NE 0} readonly {/if}/>
							<input type="radio" style="margin-left:10px" name="jrsliv" id="jrsliv1" value="AM" {if $element.jrsliv EQ "AM"} checked {/if}{if $element.datfinhad NE 0} disabled {/if}><label for="jrsliv1" style="width:auto;">Matin &nbsp;</label>
							<input type="radio" style="margin-left:10px" name="jrsliv" id="jrsliv2" value="PM" {if $element.jrsliv EQ "PM"} checked {/if}{if $element.datfinhad NE 0} disabled{/if}><label for="jrsliv2" style="width:auto;">Après-Midi &nbsp;</label>							
						</li>
						
						<li>
							<label style="width:70px">à</label>
							<input type="radio" name="lieliv" id="lieliv1" value="P" {if $element.lieliv EQ "P"} checked {/if}{if $element.datfinhad NE 0} disabled {/if}><label for="lieliv1" style="width:auto;">Domicile &nbsp;</label>
							<input type="radio" name="lieliv" id="lieliv2" value="S" {if $element.lieliv EQ "S"} checked {/if}{if $element.datfinhad NE 0} disabled {/if}><label for="lieliv2" style="width:auto;">HAD &nbsp;</label>
							<input type="radio" name="lieliv" id="lieliv3" value="A" {if $element.lieliv EQ "A"} checked {/if}{if $element.datfinhad NE 0} disabled {/if}><label for="lieliv3" style="width:auto;">si Autre &nbsp;
							<input type="text" id="lielivaut" style="width:190px" value="{$element.lielivaut}"{if $element.datfinhad NE 0} readonly {/if}/></label>
						</li>
						
						<li><label style="width:90px">Commentaire</label><input  type="text" id="com" name="com"  style="width:400px" maxlength="200" value="{$element.com}"{if $element.datfinhad NE 0} readonly {/if}/></li>
						<li>
							<label style="width:105px">IDEL Formation</label>
							<input type="radio" name="formidel" id="formidel1" value="O" {if $element.formidel EQ "O"} checked {/if}{if $element.datfinhad NE 0} disabled {/if}><label for="formidel1" style="width:auto;">Oui &nbsp;</label>
							<input type="radio" name="formidel" id="formidel2" value="N" {if $element.formidel EQ "N"} checked {/if}{if $element.datfinhad NE 0} disabled {/if}><label for="formidel2" style="width:auto;">Non &nbsp;</label>
						</li>
						<li>
							<label style="width:75px; margin-left:35px">Contact</label><input  type="text" id="coordidel" name="coordidel" value="{$element.coordidel}" style="width:400px"{if $element.datfinhad NE 0} readonly {/if}/>
						</li>
						<li>
							<label style="width:75px; margin-left:35px">Téléphone</label><input  type="text" id="telidel"  name="telidel" value="{$element.telidel}" {if $element.datfinhad NE 0} readonly {/if}/></li>
						</li>
					</ol>
				</fieldset>
			</div>
			<div class="droite"  style="width:350px" > 
				<fieldset>
					<ol>
						<input  type="hidden" class="mot" name="numpat" id="numpat" value="{$element.numpat}"/>
						<li><label style="width:90px">Rechercher </label><input  type="text" style="width:230px;" name="rech_patient_had" id="rech_patient_had" class="require" value="{$element.rech_patient_had}" placeholder="Saisir n° interne ou une partie du nom " {if $element.datfinhad NE 0} readonly {/if}/></li>
						<li><label style="width:90px">N°       </label><input  type="text" style="width:120px;" id="patient_ext_patient"  value="{$patient_had.ext_patient}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Nom       </label><input  type="text" style="width:230px;" id="patient_lb_nom"  value="{$patient_had.lb_nom}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Adresse   </label><input  type="text" style="width:230px;" id="patient_lb_adresse"  value="{$patient_had.lb_adresse}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Code postal </label><input  type="text"style="width:45px;"  id="patient_lb_codepostal"  value="{$patient_had.lb_codepostal}"    readonly tabindex="-1"/><input  type="text" style="width:180px;" id="patient_lb_ville"  value="{$patient_had.lb_ville}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Téléphone  </label><input  type="text" style="width:230px;" id="patient_lb_telephone"  value="{$patient_had.lb_telephone}"    readonly tabindex="-1"/></li>
						{if isset($patient_had.nb_Commande)}
							<li><label style="width:90px">NB Commande  </label><input  type="text" style="width:230px;" id="patient_lb_nbCommande"  value="{$patient_had.nb_Commande}"    readonly tabindex="-1"/></li>
						{/if}
					</ol>
				</fieldset>
			</div>	
			<div class="h_5 separe"></div>
			<div>
				<fieldset>
				<div style="overflow-y:auto; height:12px; width:890px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
				<table>
							<thead>
								<th width='320'>Produit</th>				
								<th width='306'>Commentaire</th>				
								<th width='86'>Réf.</th>	
								<th width='82'>Qté cdée</th>	
								<th width='50'>Date</th>
							</thead>
						</table >
						</div>
					<div style="overflow-y:auto; height:370px; width:890px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
					<ol>
						
						<table>
		
							<tbody >
								{foreach $groupes as $k => $groupe}
									<tr id="tr_{$k}" class="lig1">
										<td> <h4>{$groupe.lb_hierachie} </h4> </td>
									</tr>
									{foreach $groupe.produits as $k => $produit}	
										
										{if isset($smarty.post.btn_suivant)}
										 	{if {$quantite[$produit.sk_produit]}>0 }
											 <tr>
											{else}
												<tr style="display:none;">
											{/if}
										{else}
											<tr>									
										{/if}
											<td style="width:360px;">{$produit.lb_produit}</td>
												<td style="width:306px;"><input name="commentaire[{$produit.sk_produit}]" class="sk_produit" type="text" value="{$commentaire[$produit.sk_produit]}" style="width:300px " tabindex="-1" {if $element.datfinhad NE 0} readonly {/if}/></td>
												<td style="width:86px;"> <b>{if $produit.sk_produit >30 || $produit.sk_produit <1  }
																			{$produit.sk_produit|replace:'FKL55651':'FKL5565'|replace:'FKL55652':'FKL5565'|replace:'FKL33101':'FKL3310'|replace:'FKL33102':'FKL3310'|replace:'FKL33103':'FKL3310'} 
																			{/if}</b></td>				
												
												<td style="width:82px "><input name="quantite[{$produit.sk_produit}]" class="sk_produit {if $element.datfinhad EQ 0} spinner{/if}" type="text" value="{$quantite[$produit.sk_produit]}" style="width:50px " tabindex="-1" {if $element.datfinhad NE 0} readonly {/if} /></td>
												<td style="width:50px ">{if isset($produit.credat)}{$produit.credat}{/if}</td>
											
										</tr>
									{/foreach}
								{/foreach}
							</tbody>
						</table>
					</ol>
					</div>
				</fieldset>
			</div>
		</div>
	
		<div class="h_20 separe"></div>
		
	
	</div>
	{if isset($smarty.post.btn_suivant)}
		<span {if $element.datfinhad NE 0} hidden {/if}>
		<input name="btn_retour"  type="submit" class="boutton right" value="Retour" />
		</span>
	{else}
	<span {if $element.datfinhad NE 0} hidden {/if}>
		<input name="btn_suivant"  type="submit" class="boutton right" value="APERCU" />
		</span>
	{/if}
	<span {if $element.datfinhad NE 0} hidden {/if}>
	<input name="btn_enregistrer"  type="submit" class="boutton right" value="ENREGISTRER" />
	</span>
	<input name="btn_annuler" type="submit" class="boutton left"  value="FERMER"  />
	<div class="h_20 separe"></div>
	
</form>

{literal}
	<script>
		$('.spinner').spinner({min:0});

		$('#tabs').tabs({heightStyle: "auto", 
		});
		
		$('#rech_patient_had').autocomplete({
			source: '/boncdes/rech_patient_had',
			autoFocus: true,
			minLength: 2,
			select: function (event, ui) {	
				$('#patient_ext_patient').val(ui.item.ext_patient);				
				$('#numpat').val(ui.item.ext_patient);
				$('#patient_lb_nom').val(ui.item.lb_nom);
				$('#patient_lb_adresse').val(ui.item.lb_adresse);
				$('#patient_lb_ville').val(ui.item.lb_ville);
				$('#patient_lb_codepostal').val(ui.item.lb_codepostal);
				$('#patient_lb_telephone').val(ui.item.lb_telephone);
				$('#patient_lb_nbCommande').val(ui.item.nbCommande);
				<!-- S.SAURY le 10/05/2016 : verification de la présence d'un bon de commande chez le patient selectionné-->
				if (ui.item.nbCommande >= 1)
				{
					var answer = confirm("Voulez vous charger le dernier bon de commande du patient " + ui.item.lb_nom + " ?" );					
					if (answer)
					{
						window.location.href='/boncdes/modifier/'+ui.item.numcde;
					}
				}				
			}			
		}
		);
		
	</script>
{/literal}	

