<?php /* Smarty version Smarty-3.1.21-dev, created on 2021-02-25 05:28:44
         compiled from "/var/www/html/clb/views/login/login_perdumdp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11076648596037a60c08e042-08114933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca3e3e24e26a7f8b21dfc6eb9e9519ee934061f2' => 
    array (
      0 => '/var/www/html/clb/views/login/login_perdumdp.tpl',
      1 => 1614089561,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11076648596037a60c08e042-08114933',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'element' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_6037a60c0ba532_95188359',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6037a60c0ba532_95188359')) {function content_6037a60c0ba532_95188359($_smarty_tpl) {?><div id="bloc_identification" style="width:550px;">
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
