<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-16 13:01:50
         compiled from "/var/www/html/had/pages/mailboncdeeve.html" */ ?>
<?php /*%%SmartyHeaderCode:4800527545603a0d5e4adf4-47401236%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '668227d8f2416e4815ec9f60b74b4a992d5b960e' => 
    array (
      0 => '/var/www/html/had/pages/mailboncdeeve.html',
      1 => 1450078994,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4800527545603a0d5e4adf4-47401236',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5603a0d60777b7_33651346',
  'variables' => 
  array (
    'boncde' => 0,
    'patient' => 0,
    'raison' => 0,
    'utilisateur' => 0,
    'client' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5603a0d60777b7_33651346')) {function content_5603a0d60777b7_33651346($_smarty_tpl) {?><p><span style="font-family:comic sans ms,cursive">Bonjour,</span></p>

<p><span style="font-family:comic sans ms,cursive">Changement statut du bon de commande&nbsp;<?php echo $_smarty_tpl->tpl_vars['boncde']->value['numcde'];?>
&nbsp; : &nbsp; <?php echo $_smarty_tpl->tpl_vars['boncde']->value['raison'];?>
 le <?php echo $_smarty_tpl->tpl_vars['boncde']->value['moddat'];?>
&nbsp</span></p>

<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">
	<span style="font-family:comic sans ms,cursive"><u>Patient n° <?php echo $_smarty_tpl->tpl_vars['patient']->value['ext_patient'];?>
 :</u><br />
	<br />
	<?php if ($_smarty_tpl->tpl_vars['boncde']->value['datfinhad']!=0) {?> Fin de HAD le <?php echo $_smarty_tpl->tpl_vars['boncde']->value['datfinhad'];?>
 - Raison : <?php echo $_smarty_tpl->tpl_vars['raison']->value['librai'];?>

	<br />
	<br />
	 <?php }?>	
	<strong><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_titre'];?>
 <?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_nom'];?>
</strong> </span><br />
	<br />
	<strong><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_adresse'];?>
</strong><br />
	<strong><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_codepostal'];?>
 <?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_ville'];?>
</strong><br />
	<br />
	<strong><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_telephone'];?>
</strong><br />
	<br />
	<br />

	<p><span style="font-family:comic sans ms,cursive">Cordialement.</span></p>

	<p><span style="font-family:comic sans ms,cursive">Salutations distingu&eacute;es.</span></p>

	<p><span style="font-family:comic sans ms,cursive"><?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['nom'];?>
</span></p>
	<p>&nbsp;</p>

	<span style="font-family:comic sans ms,cursive"><u><?php echo $_smarty_tpl->tpl_vars['client']->value['lb_donneur_ordre'];?>
</u><br />
<?php }} ?>
