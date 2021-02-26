<h1>Extranet {$client_had.lb_donneur_ordre}</h1>

<form name="editer" method="post" action="/boncdeskit/enregistrer">
	
	<input type="hidden" name="hide_numcdekit" value="{$element.hide_numcdekit}" />
	<input type="hidden" name="numcdekit" value="{$element.numcdekit}" />
	
	<div id="tabs" class="form" style="height:700px">
		<ul>
			<li><a href="#tabs-1">Bon de commande kit N° {$element.numcdekit}</a></li>			
		</ul>

		</li>
		<div id="tabs-1" class="form_editer">
			<div class="gauche" style="width:570px" > 
				<fieldset>
					<ol>	
						<li>
							<label style="width:80px">Demandé le</label> <input type="text" name="datdem" id="datdem" class="date" maxlength="50" value="{$element.datdem}" readonly/>
							<label style="width:50px">Livré le</label> <input type="text" name="datliv" id="datliv" class="date" maxlength="50" value="{$element.datliv}" />
							<input type="radio" style="margin-left:10px" name="jrsliv" id="jrsliv1" value="AM" {if $element.jrsliv EQ "AM"} checked {/if}><label for="jrsliv1" style="width:auto;">Matin &nbsp;</label>
							<input type="radio" style="margin-left:10px" name="jrsliv" id="jrsliv2" value="PM" {if $element.jrsliv EQ "PM"} checked {/if}><label for="jrsliv2" style="width:auto;">Après-Midi &nbsp;</label>							
						</li>
						
						<li>
							<label style="width:70px">à</label>
							<input type="radio" name="lieliv" id="lieliv1" value="P" {if $element.lieliv EQ "P"} checked {/if}><label for="lieliv1" style="width:auto;">Domicile &nbsp;</label>
							<input type="radio" name="lieliv" id="lieliv2" value="S" {if $element.lieliv EQ "S"} checked {/if}><label for="lieliv2" style="width:auto;">HAD &nbsp;</label>
							<input type="radio" name="lieliv" id="lieliv3" value="A" {if $element.lieliv EQ "A"} checked {/if}><label for="lieliv3" style="width:auto;">si Autre &nbsp;
							<input type="text" id="lielivaut" style="width:190px" value="{$element.lielivaut}"/></label>
						</li>
						
						<li><label style="width:90px">Tél.</label><input  type="text" id="tel" name="tel"  value="{$element.tel}"/></li>
						<li>
							<label style="width:105px">IDEL Formation</label>
							<input type="radio" name="formidel" id="formidel1" value="O" {if $element.formidel EQ "O"} checked {/if}><label for="formidel1" style="width:auto;">Oui &nbsp;</label>
							<input type="radio" name="formidel" id="formidel2" value="N" {if $element.formidel EQ "N"} checked {/if}><label for="formidel2" style="width:auto;">Non &nbsp;</label>
						</li>
						<li>
							<label style="width:75px; margin-left:35px">Contact</label><input  type="text" id="coordidel" name="coordidel" value="{$element.coordidel}" style="width:400px"/>
						</li>
						<li>
							<label style="width:75px; margin-left:35px">Téléphone</label><input  type="text" id="telidel"  name="telidel" value="{$element.telidel}"/></li>
						</li>
					</ol>
				</fieldset>
			</div>
			<div class="droite"  style="width:350px" > 
				<fieldset>
					<ol>
						<input  type="hidden" class="mot" name="numpat" id="numpat" value="{$element.numpat}"/>
						<li><label style="width:90px">Rechercher </label><input  type="text" style="width:230px;" name="rech_patient_had" id="rech_patient_had" class="require" value="{$element.rech_patient_had}" placeholder="Saisir n° interne ou une partie du nom " /></li>
						<li><label style="width:90px">N°       </label><input  type="text" style="width:120px;" id="patient_ext_patient"  value="{$patient_had.ext_patient}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Nom       </label><input  type="text" style="width:230px;" id="patient_lb_nom"  value="{$patient_had.lb_nom}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Adresse   </label><input  type="text" style="width:230px;" id="patient_lb_adresse"  value="{$patient_had.lb_adresse}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Code postal </label><input  type="text"style="width:45px;"  id="patient_lb_codepostal"  value="{$patient_had.lb_codepostal}"    readonly tabindex="-1"/><input  type="text" style="width:180px;" id="patient_lb_ville"  value="{$patient_had.lb_ville}"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Téléphone  </label><input  type="text" style="width:230px;" id="patient_lb_telephone"  value="{$patient_had.lb_telephone}"    readonly tabindex="-1"/></li>
					</ol>
				</fieldset>
			</div>	
			<div class="h_5 separe"></div>
			<fieldset>
			<div class="gauche" style="width:450px" > 
			
					<div style="overflow-y:auto; height:400px; width:400px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
					<ol>
						<table>
							<thead>
								<th>Kit(s)</th>				
								<th>Qté cdée</th>	
							</thead>
						
							<tbody >
								{foreach $kits as $k => $kit}
									<tr id="tr_{$k}" class="lig1">
										<td style="width:350px; padding-left:5px; size:8px">{$kit.hierarchie}</td>
										<td> <input name="qtekit[{$kit.hierarchie}]" class="sk_produit spinner" type="text" value="{$qtekit[$kit.hierarchie]}" style="width:50px " tabindex="-1" /></td>
									</tr>
								{/foreach}
							</tbody>
						</table>
					</ol>
					</div>
			
			</div>
			<div class="droite" style="width:450px" > 				
				
					<div style="overflow-y:auto; height:400px; width:440px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
					<ol>
						<table>
							<thead>
								<th>Produit(s) supplémentaire(s)</th>	
								<th>Réf.</th>	
								<th>Qté cdée</th>	
							</thead>
							<tbody >
								{foreach $produits as $k => $produit}
									<tr id="tr_{$k}" class="lig1">
										<td style="width:400px; padding-left:5px; size:8px">{$produit.libelle} </td>
										<td style="width:80px; text-align:center;  size:8px">{$produit.Reference} </td>
										<td> <input name="qtepdt[{$produit.Reference}]" class="sk_produit spinner" type="text" value="{$qtepdt[$produit.Reference]}" style="width:50px " tabindex="-1" /></td>
									</tr>
								{/foreach}
							</tbody>
						</table>
					</ol>
					</div>
			</div>
		</fieldset>

		</div>
	
		<div class="h_20 separe"></div>
		
	
	</div>
	
	<input name="btn_enregistrer"  type="submit" class="boutton right" value="ENREGISTRER" />
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
			}
		}
		);
	
	</script>
{/literal}
