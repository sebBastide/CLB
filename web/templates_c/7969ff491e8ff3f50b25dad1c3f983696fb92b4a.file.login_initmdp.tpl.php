<?php /* Smarty version Smarty-3.1.21-dev, created on 2021-02-25 05:33:29
         compiled from "/var/www/html/clb/views/login/login_initmdp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9237540236037a729574c04-99104331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7969ff491e8ff3f50b25dad1c3f983696fb92b4a' => 
    array (
      0 => '/var/www/html/clb/views/login/login_initmdp.tpl',
      1 => 1614089560,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9237540236037a729574c04-99104331',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'element' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_6037a729592842_13567231',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6037a729592842_13567231')) {function content_6037a729592842_13567231($_smarty_tpl) {?><div id="bloc_identification" style="width:550px;">
	<form name="login_rapide" class="form" method="post" action="/login/initmdp_conf/<?php echo $_smarty_tpl->tpl_vars['element']->value['codrei'];?>
">
		<h4>Merci de préciser ci-dessous :</h4>
		<table cellpadding="0" cellspacing="5" width="100%">
			<tr>
				<td>Votre identifiant </td>
				<td>:</td>
				<td><input class="input" type="text" name="coduti" style="width: 170px;" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['coduti'];?>
" readonly/></td>
			</tr>
			<tr>
				<td>Nouveau mot de passe</td>
				<td>:</td>
				<td><input class="input" type="password" name="mdp1" maxlength=20 style="width: 170px;"  /></td>
			</tr>
			<tr>
				<td>Confirmer le mot de passe</td>
				<td>:</td>
				<td><input class="input" type="password" name="mdp2" maxlength=20 style="width: 170px;" /></td>
			</tr>
		</table>
		<div class="h_5"></div>
		<center>
			<input class="boutton" type="submit" name="btp_enregistrer" value="ENREGISTRER" />
		</center>
		<br />
		<br />
	</form>
</div><?php }} ?>
