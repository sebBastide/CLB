<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-01-18 11:04:47
         compiled from "/var/www/html/had/views/patients/fiche.tpl" */ ?>
<?php /*%%SmartyHeaderCode:33712827456014ece147b80-47807913%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09263b7b3abf372fcfd288f335dd9535af74d443' => 
    array (
      0 => '/var/www/html/had/views/patients/fiche.tpl',
      1 => 1450078995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '33712827456014ece147b80-47807913',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56014ece1b5213_34074319',
  'variables' => 
  array (
    'tabactif' => 0,
    'zoneerr' => 0,
    'patient' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56014ece1b5213_34074319')) {function content_56014ece1b5213_34074319($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['tabactif'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['tabactif']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
<?php $_smarty_tpl->tpl_vars['zoneerr'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['zoneerr']->value)===null||$tmp==='' ? '*' : $tmp), null, 0);?>

<form name="editer" id="editer" method="post" action="/patients/enregistrer">

	<!-- onSubmit="verifform();" -->
	<input type="hidden" name="hide_ext_patient" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['hide_ext_patient'];?>
" />

	<div id="tabs" class="form" style="height: 500px" >
		<ul id="enttabs" hidden>
			<li><a href="#tabs-1">Patient HAD </a></li>
		</ul>

		<div id="tabs-1">
			

				<ol>
					<li><label>N°</label> <input type="text" name="ext_patient" style="width: 100px" maxlength="10" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['ext_patient'];?>
" <?php if ($_smarty_tpl->tpl_vars['patient']->value['hide_ext_patient']!='') {?> readonly <?php }?>/></li>

					<li><label>Titre </label> 
						<select name="lb_titre" >
							<option value="M." <?php if ($_smarty_tpl->tpl_vars['patient']->value['lb_titre']=='M.') {?>selected<?php }?>>Monsieur </option>
							<option value="Mme" <?php if ($_smarty_tpl->tpl_vars['patient']->value['lb_titre']=='Mme') {?>selected<?php }?>>Madame</option>
							<option value="Mlle" <?php if ($_smarty_tpl->tpl_vars['patient']->value['lb_titre']=='Mlle') {?>selected<?php }?>>Mademoiselle</option>
						</select>
					</li>		
					
					<li><label>Nom</label> <input type="text" name="lb_nom"  style="width: 500px" maxlength="35" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_nom'];?>
" /></li>
					<li><label>&nbsp;</label> <input type="text" name="lb_nom2"  style="width: 500px" maxlength="35" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_nom2'];?>
" /></li>
					<li><label>Nom jeune fille</label> <input type="text" name="lb_nomjf"  style="width: 500px" maxlength="35" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_nomjf'];?>
" /></li>
					<li><label>Adresse</label> <input type="text" name="lb_adresse" style="width: 500px" maxlength="35" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_adresse'];?>
" /></li>
					<li><label>Code postal/Ville</label> <input type="text" id="lb_codepostal" name="lb_codepostal"  style="width: 50px" maxlength="10" class="code" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_codepostal'];?>
" />
						<input type="text" id="lb_ville" name="lb_ville" maxlength="50" style="width: 207px" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_ville'];?>
" /></li>
					<li><label>Téléphone</label> <input type="text" name="lb_telephone" maxlength="30" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_telephone'];?>
" /></li>
					<li><label>Date naissance</label> <input type="text" name="dt_naissance"  class="date" maxlength="10" value="<?php echo dat($_smarty_tpl->tpl_vars['patient']->value['dt_naissance']);?>
" /></li>
				</ol>
			<div class="separe h_20"></div>
		</div>
</div>
		<input name="btn_enregistrer" id="btn_gen_enregistrer" type="submit" class="boutton right"  value="ENREGISTRER" />
		<input name="btn_annuler"     id="btn_gen_annuler"     type="submit" class="boutton left" value="FERMER" /> 
	

</div>	
</form>


<?php echo '<script'; ?>
>
//=================================================================
// ONGLET + erreur
//=================================================================
	var tab = $('#tabs').tabs({
		heightStyle: "fill",
				active: <?php echo $_smarty_tpl->tpl_vars['tabactif']->value;?>
,

		activate: function (event, ui) {
				$('#tabactif').val(tab.tabs("option", "active"));
						$('#btn_gen_enregistrer').show();
						$('#btn_gen_annuler').show();
				}
		});
				$('#enttabs').show();
				zoneerr = '<?php echo $_smarty_tpl->tpl_vars['zoneerr']->value;?>
';
				if (zoneerr != '') {
				$('input[name="' + zoneerr + '"]').css("border", "solid 2px red");
				$('input[name="' + zoneerr + '"]').focus();
				$('select[name="' + zoneerr + '"]').css("border", "solid 2px red");
				$('select[name="' + zoneerr + '"]').focus();
		}

<?php echo '</script'; ?>
>

<?php }} ?>
