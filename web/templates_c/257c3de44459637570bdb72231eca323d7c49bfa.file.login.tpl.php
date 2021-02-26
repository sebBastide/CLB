<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-14 08:45:51
         compiled from "/var/www/html/had/views/login/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1594725317566a93cdb2b831-17203879%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '257c3de44459637570bdb72231eca323d7c49bfa' => 
    array (
      0 => '/var/www/html/had/views/login/login.tpl',
      1 => 1450078995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1594725317566a93cdb2b831-17203879',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_566a93cdb36498_06156193',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566a93cdb36498_06156193')) {function content_566a93cdb36498_06156193($_smarty_tpl) {?><div id="bloc_identification">
	<form name="login_rapide" class="form" method="post" action="/login/verif">
		<center>
		<h2>Authentification</h2>
		</center>
		<p><label>Identifiant</label><input class="input" type="text" name="login"  /></p>
		<p><label>Mot de passe</label><input class="input" type="password" name="mdp"  /></p>
		<a href="/login/perdumdp" style="margin-left:130px">Mot de passe oublié ?</a>
		<br>
		<br>
		<div class="h_5"></div>
		<center>
			<input class="boutton" type="submit" name="envoyer" value=" ENTRER " />
		
		</center>
	</form>
</div><?php }} ?>
