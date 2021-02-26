{assign var='tabactif' value=$tabactif|default:0}
{assign var='zoneerr' value=$zoneerr|default:'*'}

<form name="editer" id="editer" method="post" action="/raisons_had/enregistrer">

	<!-- onSubmit="verifform();" -->
	<input type="hidden" name="hide_codrai" value="{$raison.hide_codrai}" />

	<div id="tabs" class="form" style="height: 300infodial	px" >
		<ul id="enttabs" hidden>
			<li><a href="#tabs-1">Raison fin HAD</a></li>
		</ul>
		
		<div id="tabs-1">		
				<ol>
					<li><label>Code</label> <input type="text" name="codrai" style="width: 100px" maxlength="10" value="{$raison.codrai}" {if $raison.hide_codrai NE ""} readonly{/if}/></li>
					<li><label>Libellé</label> <input type="text" name="librai"  style="width: 500px" maxlength="100" value="{$raison.librai}" /></li>
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
