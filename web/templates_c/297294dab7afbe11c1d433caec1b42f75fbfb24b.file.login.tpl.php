<?php /* Smarty version Smarty-3.1.21-dev, created on 2021-02-25 01:58:55
         compiled from "/var/www/html/clb/views/login/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1219131628603774df2da723-10653420%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '297294dab7afbe11c1d433caec1b42f75fbfb24b' => 
    array (
      0 => '/var/www/html/clb/views/login/login.tpl',
      1 => 1614089561,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1219131628603774df2da723-10653420',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_603774df33fab5_56738884',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_603774df33fab5_56738884')) {function content_603774df33fab5_56738884($_smarty_tpl) {?><div id="bloc_identification">
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
