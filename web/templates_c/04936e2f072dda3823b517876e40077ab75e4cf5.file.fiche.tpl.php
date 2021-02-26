<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-14 15:04:12
         compiled from "/var/www/html/had/views/utilisateurs/fiche.tpl" */ ?>
<?php /*%%SmartyHeaderCode:184554518756014c2e448086-33108096%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04936e2f072dda3823b517876e40077ab75e4cf5' => 
    array (
      0 => '/var/www/html/had/views/utilisateurs/fiche.tpl',
      1 => 1450078995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '184554518756014c2e448086-33108096',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56014c2e4f00f7_38442624',
  'variables' => 
  array (
    'element' => 0,
    'client_had' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56014c2e4f00f7_38442624')) {function content_56014c2e4f00f7_38442624($_smarty_tpl) {?><form name="editer" method="post" action="/utilisateurs/enregistrer">

	<input type="hidden" name="hide_coduti" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['hide_coduti'];?>
" />

	<?php if ($_smarty_tpl->tpl_vars['element']->value['hide_coduti']!='') {?>
		<h3>Identifiant : <?php echo $_smarty_tpl->tpl_vars['element']->value['coduti'];?>
 / <?php echo $_smarty_tpl->tpl_vars['element']->value['nom'];?>
, <?php echo $_smarty_tpl->tpl_vars['element']->value['prenom'];?>
 - <?php echo $_smarty_tpl->tpl_vars['element']->value['mail'];?>
</h3>
	<?php }?>

	<div id="tabs" class="form" style="height:500px">
		<ul>
			<li><a href="#tabs-1">Identité</a></li>			
		</ul>

		</li>
		<div id="tabs-1" class="form_editer">
			<div class="gauche" > 
				<ol>
					<li><label>Identifiant</label> <input type="text" name="coduti" maxlength="30" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['coduti'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_coduti']!='') {?> readonly <?php }?> /> &nbsp;</li>			

						<span <?php if (auth::$auth['grputi']=='U') {?> hidden <?php }?>>
							<li><label>Groupe </label> 
								<select name="grputi" >
									<option value="A" <?php if ($_smarty_tpl->tpl_vars['element']->value['grputi']=='A') {?>selected<?php }?>>Administrateur</option>
									<option value="U" <?php if ($_smarty_tpl->tpl_vars['element']->value['grputi']=='U') {?>selected<?php }?>>Utilisateur</option>
								</select>
							</li>
						</span>

					<li><label>Nom</label> <input type="text" name="nom" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['nom'];?>
" /></li>
					<li><label>Prénom</label> <input type="text" name="prenom" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['prenom'];?>
"/></li>
					<li><label>Mot de passe</label> <input type="password" name="mdp1" maxlength="50" /></li>
					<li><label>Confirmer</label> <input type="password" name="mdp2" maxlength="50" /></li>
					<li><label>Adresse Mail</label> <input type="text" class="mail" name="mail" maxlength="250" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['mail'];?>
" /></li>

					<li></li>
				</ol>
			</div>
			<div class="droite" > 
				<fieldset>
					<legend> Donneur d'ordre - <?php echo $_smarty_tpl->tpl_vars['element']->value['sk_client'];?>
</legend>
					<ol>
						<input  type="hidden" class="mot" name="sk_client" id="sk_client" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['sk_client'];?>
"/>
						<span <?php if (auth::$auth['grputi']=='U') {?> hidden<?php }?>>
							<li><label>Rechercher</label><input  type="text" name="rech_client_had" id="rech_client_had" class="require" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['rech_client_had'];?>
" placeholder="Saisir une partie du nom" /></li>
						</span>
						<li><label>Nom       </label><input  type="text" id="client_lb_donneur_ordre"  value="<?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_donneur_ordre'];?>
"    readonly tabindex="-1"/></li>
						<li><label>Adresse   </label><input  type="text" id="client_lb_adresse"  value="<?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_adresse'];?>
"    readonly tabindex="-1"/></li>
						<li><label>Code postal </label><input  type="text" id="client_lb_cd_postal"  value="<?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_cd_postal'];?>
"    readonly tabindex="-1"/></li>
						<li><label>Ville      </label><input  type="text" id="client_lb_ville"  value="<?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_ville'];?>
"    readonly tabindex="-1"/></li>
						<li><label>Téléphone  </label><input  type="text" id="client_lb_telephone"  value="<?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_telephone'];?>
"    readonly tabindex="-1"/></li>
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

	<?php echo '<script'; ?>
>
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

	<?php echo '</script'; ?>
>

<?php }} ?>
