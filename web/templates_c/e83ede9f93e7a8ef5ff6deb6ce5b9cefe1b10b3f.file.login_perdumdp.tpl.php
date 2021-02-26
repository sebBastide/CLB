<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-01-19 16:07:12
         compiled from "/var/www/html/had/views/login/login_perdumdp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:68982167956308c85626062-54269623%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e83ede9f93e7a8ef5ff6deb6ce5b9cefe1b10b3f' => 
    array (
      0 => '/var/www/html/had/views/login/login_perdumdp.tpl',
      1 => 1450078995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68982167956308c85626062-54269623',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56308c857988c5_63636823',
  'variables' => 
  array (
    'element' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56308c857988c5_63636823')) {function content_56308c857988c5_63636823($_smarty_tpl) {?><div id="bloc_identification" style="width:550px;">
	<form name="login_rapide" class="form" method="post" action="/login/initmdp">
		<h4>Saississez votre email pour recevoir votre mot de passe</h4>
		<table cellpadding="0" cellspacing="5" width="100%">
			<tr>
				<td>Votre adresse mail</td>
				<td> </td>
				<td><input class="input" type="text" name="login" style="width: 170px;" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['login'];?>
"/></td>
			</tr>
			
		</table>
		<div class="h_5"></div>
		<center>
			<input class="boutton" type="submit" name="reinit" value="ENVOYER" />
		</center>
		<br />
		<br />
		
	</form>
</div><?php }} ?>
