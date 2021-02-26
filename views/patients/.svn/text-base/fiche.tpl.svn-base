{assign var='tabactif' value=$tabactif|default:0}
{assign var='zoneerr' value=$zoneerr|default:'*'}

<form name="editer" id="editer" method="post" action="/patients/enregistrer">

	<!-- onSubmit="verifform();" -->
	<input type="hidden" name="hide_ext_patient" value="{$patient.hide_ext_patient}" />

	<div id="tabs" class="form" style="height: 500px" >
		<ul id="enttabs" hidden>
			<li><a href="#tabs-1">Patient HAD </a></li>
		</ul>

		<div id="tabs-1">
			

				<ol>
					<li><label>N°</label> <input type="text" name="ext_patient" style="width: 100px" maxlength="10" value="{$patient.ext_patient}" {if $patient.hide_ext_patient NE ''} readonly {/if}/></li>

					<li><label>Titre </label> 
						<select name="lb_titre" >
							<option value="M." {if $patient.lb_titre EQ 'M.'}selected{/if}>Monsieur </option>
							<option value="Mme" {if $patient.lb_titre EQ 'Mme'}selected{/if}>Madame</option>
							<option value="Mlle" {if $patient.lb_titre EQ 'Mlle'}selected{/if}>Mademoiselle</option>
						</select>
					</li>		
					
					<li><label>Nom</label> <input type="text" name="lb_nom"  style="width: 500px" maxlength="35" value="{$patient.lb_nom}" /></li>
					<li><label>&nbsp;</label> <input type="text" name="lb_nom2"  style="width: 500px" maxlength="35" value="{$patient.lb_nom2}" /></li>
					<li><label>Nom jeune fille</label> <input type="text" name="lb_nomjf"  style="width: 500px" maxlength="35" value="{$patient.lb_nomjf}" /></li>
					<li><label>Adresse</label> <input type="text" name="lb_adresse" style="width: 500px" maxlength="35" value="{$patient.lb_adresse}" /></li>
					<li><label>Code postal/Ville</label> <input type="text" id="lb_codepostal" name="lb_codepostal"  style="width: 50px" maxlength="10" class="code" value="{$patient.lb_codepostal}" />
						<input type="text" id="lb_ville" name="lb_ville" maxlength="50" style="width: 207px" value="{$patient.lb_ville}" /></li>
					<li><label>Téléphone</label> <input type="text" name="lb_telephone" maxlength="30" value="{$patient.lb_telephone}" /></li>
					<li><label>Date naissance</label> <input type="text" name="dt_naissance"  class="date" maxlength="10" value="{$patient.dt_naissance|dat}" /></li>
				</ol>
			<div class="separe h_20"></div>
		</div>
</div>
		<input name="btn_enregistrer" id="btn_gen_enregistrer" type="submit" class="boutton right"  value="ENREGISTRER" />
		<input name="btn_annuler"     id="btn_gen_annuler"     type="submit" class="boutton left" value="FERMER" /> 
	

</div>	
</form>

{literal}
<script>
//=================================================================
// ONGLET + erreur
//=================================================================
	var tab = $('#tabs').tabs({
		heightStyle: "fill",
				active: {/literal}{$tabactif}{literal},

		activate: function (event, ui) {
				$('#tabactif').val(tab.tabs("option", "active"));
						$('#btn_gen_enregistrer').show();
						$('#btn_gen_annuler').show();
				}
		});
				$('#enttabs').show();
				zoneerr = '{/literal}{$zoneerr}{literal}';
				if (zoneerr != '') {
				$('input[name="' + zoneerr + '"]').css("border", "solid 2px red");
				$('input[name="' + zoneerr + '"]').focus();
				$('select[name="' + zoneerr + '"]').css("border", "solid 2px red");
				$('select[name="' + zoneerr + '"]').focus();
		}

</script>
{/literal}
