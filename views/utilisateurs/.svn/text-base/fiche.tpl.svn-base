<form name="editer" method="post" action="/utilisateurs/enregistrer">

	<input type="hidden" name="hide_coduti" value="{$element.hide_coduti}" />

	{if $element.hide_coduti NE ''}
		<h3>Identifiant : {$element.coduti} / {$element.nom}, {$element.prenom} - {$element.mail}</h3>
	{/if}

	<div id="tabs" class="form" style="height:500px">
		<ul>
			<li><a href="#tabs-1">Identité</a></li>			
		</ul>

		</li>
		<div id="tabs-1" class="form_editer">
			<div class="gauche" > 
				<ol>
					<li><label>Identifiant</label> <input type="text" name="coduti" maxlength="30" value="{$element.coduti}" {if $element.hide_coduti NE ''} readonly {/if} /> &nbsp;</li>			

						<span {if auth::$auth['grputi'] EQ 'U'} hidden {/if}>
							<li><label>Groupe </label> 
								<select name="grputi" >
									<option value="A" {if $element.grputi EQ 'A'}selected{/if}>Administrateur</option>
									<option value="U" {if $element.grputi EQ 'U'}selected{/if}>Utilisateur</option>
								</select>
							</li>
						</span>

					<li><label>Nom</label> <input type="text" name="nom" maxlength="50" value="{$element.nom}" /></li>
					<li><label>Prénom</label> <input type="text" name="prenom" maxlength="50" value="{$element.prenom}"/></li>
					<li><label>Mot de passe</label> <input type="password" name="mdp1" maxlength="50" /></li>
					<li><label>Confirmer</label> <input type="password" name="mdp2" maxlength="50" /></li>
					<li><label>Adresse Mail</label> <input type="text" class="mail" name="mail" maxlength="250" value="{$element.mail}" /></li>

					<li></li>
				</ol>
			</div>
			<div class="droite" > 
				<fieldset>
					<legend> Donneur d'ordre - {$element.sk_client}</legend>
					<ol>
						<input  type="hidden" class="mot" name="sk_client" id="sk_client" value="{$element.sk_client}"/>
						<span {if auth::$auth['grputi'] EQ 'U'} hidden{/if}>
							<li><label>Rechercher</label><input  type="text" name="rech_client_had" id="rech_client_had" class="require" value="{$element.rech_client_had}" placeholder="Saisir une partie du nom" /></li>
						</span>
						<li><label>Nom       </label><input  type="text" id="client_lb_donneur_ordre"  value="{$client_had.lb_donneur_ordre}"    readonly tabindex="-1"/></li>
						<li><label>Adresse   </label><input  type="text" id="client_lb_adresse"  value="{$client_had.lb_adresse}"    readonly tabindex="-1"/></li>
						<li><label>Code postal </label><input  type="text" id="client_lb_cd_postal"  value="{$client_had.lb_cd_postal}"    readonly tabindex="-1"/></li>
						<li><label>Ville      </label><input  type="text" id="client_lb_ville"  value="{$client_had.lb_ville}"    readonly tabindex="-1"/></li>
						<li><label>Téléphone  </label><input  type="text" id="client_lb_telephone"  value="{$client_had.lb_telephone}"    readonly tabindex="-1"/></li>
					</ol>
				</fieldset>
			</div>	

		</div>

		<div class="h_20 separe"></div>
		<input name="btn_enregistrer"  type="submit" class="boutton right" value="ENREGISTRER" />
		<input name="btn_annuler" type="submit" class="boutton left"  value="FERMER"  />
	</div>

	<div class="h_20 separe"></div>

</form>
{literal}
	<script>
		$('#tabs').tabs({heightStyle: "auto",
		});

		$('#rech_client_had').autocomplete({
			source: '/utilisateurs/rech_client_had',
			autoFocus: true,
			minLength: 2,
			select: function (event, ui) {
				$('#sk_client').val(ui.item.sk_client);
				$('#client_lb_donneur_ordre').val(ui.item.lb_donneur_ordre);
				$('#client_lb_adresse').val(ui.item.lb_adresse);
				$('#client_lb_ville').val(ui.item.lb_ville);
				$('#client_lb_cd_postal').val(ui.item.lb_cd_postal);
				$('#client_lb_telephone').val(ui.item.lb_telephone);
			}
		}
		);

	</script>
{/literal}
