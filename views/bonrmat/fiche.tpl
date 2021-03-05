<h1>Extranet {$client_had.lb_donneur_ordre}</h1>

<form name="editer" method="post" action="/bonrmat/enregistrer">
	
	<input type="hidden" name="hide_numbrmat" value="{$element.hide_numbrmat}" />
	<input type="hidden" name="hide_datfinhad" value="{$element.hide_datfinhad}" />
	<input type="hidden" name="numbrmat" value="{$element.numbrmat}" />
	
	<div id="tabs" class="form" style="height:700px">
		<ul>
			<li><a href="#tabs-1">Bon de récupération matériel N° {$element.numbrmat}</a></li>			
		</ul>

		<div id="tabs-1" class="form_editer">
			<div> 
				<fieldset>
					<ol>	
						<li>
							<label style="width:100px">Demande le</label> <input type="text" name="datdem" id="datdem" class="date" maxlength="50" value="{$element.datdem}" {if $element.hide_datfinhad NE 0} readonly {/if} />
							<label style="margin-left:210px; width:150px">Nom demandeur</label><input type="text" style="width:300px" name="nomdem" id="nomdem"  value="{$element.nomdem}" {if $element.hide_datfinhad NE 0} readonly {/if}/>
						</li>
						<li> <label style="width:100px">Fin HAD le</label> <input type="text" name="datfinhad" id="datfinhad" class="date" maxlength="50" value="{$element.datfinhad}" {if $element.hide_datfinhad NE 0} readonly {/if}/>
							<label style="margin-left:20px; width:130px">Raison fin HAD</label>
							<select name="raifinhad" id="raifinhad" style="width:250px" {if $element.hide_datfinhad NE 0} disabled {/if}>
							<option value="" >- Sélectionnez une raison -</option>
							{foreach $raisons as $raison}
								<option value="{$raison.codrai}" {if $element.raifinhad EQ $raison.codrai} selected {/if}>{$raison.librai} </option>
							{/foreach}
							</select>
							<label style="margin-left:20px; width:125px">Passage SAD le</label> <input type="text" name="passsad" id="passsad" class="date" maxlength="50" value="{$element.passsad}" {if $element.hide_datfinhad NE 0} readonly {/if}/>
						</li>

						<div class="h_5 separe"></div>
						<label style="width:125px">A effectuer le</label> <input type="text" name="datrec" id="datrec" class="date" maxlength="50" value="{$element.datrec}" {if $element.hide_datfinhad NE 0} readonly {/if}/>
							<input type="radio" style="margin-left:75px" name="jrsrec" id="jrsrec1" value="AM" {if $element.jrsrec EQ "AM"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="jrsrec1" style="width:auto;">Matin &nbsp;</label>
							<input type="radio" style="margin-left:10px" name="jrsrec" id="jrsrec2" value="PM" {if $element.jrsrec EQ "PM"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="jrsrec2" style="width:auto;">Après-Midi &nbsp;</label>							
							<input type="radio" style="margin-left:10px" name="jrsrec" id="jrsrec3" value="DJ" {if $element.jrsrec EQ "DJ"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="jrsrec3" style="width:auto;">Dans la journée &nbsp;</label>							
						</li>
						<div class="h_5 separe"></div>	
						<fieldset>
							<legend> Patient n° {$patient_had.ext_patient} {if !empty($patient_had.dt_naissance)}- né le {$patient_had.dt_naissance}{/if}</legend>
							<div class="gauche" style="width:450px" > 
								<li>
									<input  type="hidden" class="mot" name="numpat" id="numpat" value="{$element.numpat}"/>
									<label style="width:120px">Nom/prénom</label><input  type="text" style="width:290px;" id="patient_lb_nom"  value="{$patient_had.lb_nom}"    readonly tabindex="-1"/>
								</li>
								<li>
									<label style="width:120px">Adresse</label><input  type="text" style="width:290px;" id="patient_lb_adresse"  value="{$patient_had.lb_adresse}"    readonly tabindex="-1"/>
								</li>
								<li>
									<label style="width:120px">Code postal/ville</label><input  type="text"style="width:50px;"  id="patient_lb_codepostal"  value="{$patient_had.lb_codepostal}"    readonly tabindex="-1"/>
									<input  type="text" style="width:180px;" id="patient_lb_ville"  value="{$patient_had.lb_ville}"    readonly tabindex="-1"/>
								</li>
							</div>
							
							<div class="droite" style="width:430px" > 
								<fieldset style="height:100px;">
									<legend>Autres coordonnées</legend>	
									<li> <textarea name="lierecaut" id="lierecaut" maxlength="500" style="height:70px; width:400px" {if $element.hide_datfinhad NE 0} readonly {/if}>{$element.lierecaut}</textarea></li>	
								</fieldset>
							</div>
							
						<!--	<li>
								<input type="radio" name="r_maison" id="r_maison1" value="O" {if $element.r_maison EQ "O"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="r_maison1" style="width:auto;">Maison &nbsp;</label>
								<input type="radio" name="r_maison" id="r_maison2" value="N" {if $element.r_maison EQ "N"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="r_maison2" style="width:auto;">Appartement &nbsp;</label>
								<input type="radio" name="r_maison" id="r_maison3" value="M" {if $element.r_maison EQ "M"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="r_maison3" style="width:auto;">HAD &nbsp;</label>

								<input  style="margin-left:50px;" type="radio" name="r_rdc" id="r_rdc1" value="O" {if $element.r_rdc EQ "O"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="r_rdc1" style="width:auto;">RDC &nbsp;</label>
								<input type="radio" name="r_rdc" id="r_rdc2" value="N" {if $element.r_rdc EQ "N"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="r_rdc2" style="width:auto;">Etage &nbsp;</label>

								<label style="margin-left:100px; width:150px">Ascenseur</label>
								<input type="radio" name="r_ascen" id="r_ascen1" value="O" {if $element.r_ascen EQ "O"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="r_ascen1" style="width:auto;">Oui &nbsp;</label>
								<input type="radio" name="r_ascen" id="r_ascen2" value="N" {if $element.r_ascen EQ "N"} checked {/if}{if $element.hide_datfinhad NE 0} disabled {/if}><label for="r_ascen2" style="width:auto;">Non &nbsp;</label>
							</li>-->
						</fieldset>
						<div class="h_5 separe"></div>						
						
						<div>
							<div class="gauche" style="width:450px" > 
								<fieldset style="height:260px;" >
									<legend>Produits</legend>
										<fieldset>
											<div style="overflow-y:auto; height:150px; width:400px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
											<ol>
												<table>													
													<tbody >
														{foreach $groupes as $k => $groupe}
															<tr id="tr_{$k}" class="lig1">
																<input type="hidden" name="groupes[{$k}][lb_hierachie]" value="{$groupe.lb_hierachie}"{if $element.hide_datfinhad NE 0} readonly {/if} />
																<td> <h4>{$groupe.lb_hierachie} </h4> </td>
															</tr>
															{foreach $groupe.produits as $p => $produit}	
																<tr>																
																	<input type="hidden" name="groupes[{$k}][produits][{$p}][lb_produit]" value="{$produit.lb_produit}" />
																	<input type="hidden" name="groupes[{$k}][produits][{$p}][sk_produit]" value="{$produit.sk_produit}" />
																	<input type="hidden" name="acde[{$produit.sk_produit}]" value="{$produit.numcde}" />																			
																	
																	<td style="width:250px; padding-left:10px; size:8px;">{$produit.lb_produit}</td>
																	<td style="width:100px "> <b>{$produit.sk_produit|replace:'FKL55651':'FKL5565'|replace:'FKL55652':'FKL5565'|replace:'FKL33101':'FKL3310'|replace:'FKL33102':'FKL3310'|replace:'FKL33103':'FKL3310'}  </b></td>																		
																	
																	<!--{assign var='coche' value=$arecup[$produit.sk_produit]|default:'off'}-->
																	{assign var='coche' value=1}
																	<td><input type="checkbox" name="arecup[{$produit.produitCommande}]" class="sk_produit cocher" style="width:50px " tabindex="-1" {if $coche==1} checked {/if} {if $element.hide_datfinhad NE 0} disabled {/if}/></td>
																</tr>
															{/foreach}
														{/foreach}
													</tbody>
												</table>
											</ol>
											</div>
										</fieldset>
									<label style="width:130px" > Autres (à préciser)</label> 
									<li> <textarea name="r_autre" id="r_autre" maxlength="500"  style="height:30px; width:420px"{if $element.hide_datfinhad NE 0} readonly {/if}> {$element.r_autre}</textarea></li>	
								</fieldset>
								
							</div>
							<div class="droite" style="width:450px" > 
								<fieldset style="height:260px;">
									<legend>Commentaires</legend>
											<li> <label>Divers</label></li>
											<li> <textarea name="com_div" id="com_div" maxlength="500" style="height:70px; width:420px" {if $element.hide_datfinhad NE 0} readonly {/if}>{$element.com_div}</textarea></li>	
											<li> <label>Interne</label></li>
											<li> <textarea name="com_int" id="com_int" maxlength="500" style="height:70px; width:420px" {if $element.hide_datfinhad NE 0} readonly {/if}>{$element.com_int}</textarea></li>	
								</fieldset>
							</div>
						</div>
						<div class="h_5 separe"></div>
					</ol>
				</fieldset>
			</div>
			<div class="h_5 separe"></div>
		</div>
	
		<div class="h_20 separe"></div>	
	</div>
	<span {if $element.hide_datfinhad NE 0} hidden {/if}>
		<input name="btn_enregistrer" type="submit" class="boutton right" value="ENREGISTRER" onClick="verif();"/>
	</span>
	<input name="btn_annuler" type="submit" class="boutton left"  value="FERMER"  />
	<div class="h_20 separe"></div>

</form>
{literal}
	<script type="text/javascript">
		$('#tabs').tabs({heightStyle: "auto", 
		});	
		
		function finhad() {
			$('.cocher').attr('checked', true);
		}
	
	</script>
{/literal}
