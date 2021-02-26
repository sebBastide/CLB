<?php /* Smarty version Smarty-3.1.21-dev, created on 2021-02-25 05:33:11
         compiled from "/var/www/html/clb/pages/mailreinitmotdepasse.html" */ ?>
<?php /*%%SmartyHeaderCode:7249634266037a7171c4da7-64140278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ede5266d2b48ef7ec6b05e6351d49cbf79375b1' => 
    array (
      0 => '/var/www/html/clb/pages/mailreinitmotdepasse.html',
      1 => 1614089595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7249634266037a7171c4da7-64140278',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'utilisateur' => 0,
    'lien' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_6037a7171edfd3_90318823',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6037a7171edfd3_90318823')) {function content_6037a7171edfd3_90318823($_smarty_tpl) {?><p><span style="font-family:comic sans ms,cursive">Bonjour <?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['prenom'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['nom'];?>
,</span></p>

<p><span style="font-family:comic sans ms,cursive">Vous avez demand&eacute; la reinitialisation de votre mot de passe à l'EXTRANET HAD.</span></p>

<p><span style="font-family:comic sans ms,cursive">Voici vos informations :</span></p>

<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">Code &nbsp;: <?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['coduti'];?>
</div>

<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">Mot de passe :&nbsp;<span style="font-family:comic sans ms,cursive"><a href="<?php echo $_smarty_tpl->tpl_vars['lien']->value;?>
">Vous pouvez changer&nbsp;votre mot de passe en cliquant ici.</a></span></div>

<p>&nbsp;</p>

<p><span style="font-family:comic sans ms,cursive">Salutations distingu&eacute;es.</span></p>

<p><span style="font-family:comic sans ms,cursive">l'Administrateur de l'EXTRANET HAD</span></p>
<?php }} ?>
