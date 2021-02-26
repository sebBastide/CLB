<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-06-21 15:48:52
         compiled from "/var/www/html/had/pages/mailboncde.html" */ ?>
<?php /*%%SmartyHeaderCode:70566011756014d4358f4b3-01238916%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24bda031ce2d291f3b19e372e8a8172d3d02b8d5' => 
    array (
      0 => '/var/www/html/had/pages/mailboncde.html',
      1 => 1529588264,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70566011756014d4358f4b3-01238916',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56014d436a90d1_62522885',
  'variables' => 
  array (
    'boncde' => 0,
    'patient' => 0,
    'raison' => 0,
    'produitsajout' => 0,
    'produitssupp' => 0,
    'produitsmaj' => 0,
    'groupes' => 0,
    'groupe' => 0,
    'produit' => 0,
    'commentaire' => 0,
    'quantite' => 0,
    'utilisateur' => 0,
    'client' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56014d436a90d1_62522885')) {function content_56014d436a90d1_62522885($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/html/had/core/smarty/plugins/modifier.replace.php';
?><p><span style="font-family:comic sans ms,cursive">Bonjour,</span></p>

<p><span style="font-family:comic sans ms,cursive">Veuillez trouvez ci-joint le&nbsp;bon de commande&nbsp;<?php echo $_smarty_tpl->tpl_vars['boncde']->value['numcde'];?>
&nbsp;</span></p>

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
		
	<em>Livré &agrave; : &nbsp;</em><?php if ($_smarty_tpl->tpl_vars['boncde']->value['lieliv']=="P") {?>Domicile<?php }
if ($_smarty_tpl->tpl_vars['boncde']->value['lieliv']=="S") {?>HAD<?php }
if ($_smarty_tpl->tpl_vars['boncde']->value['lieliv']=="A") {?>Autres :<?php }
echo $_smarty_tpl->tpl_vars['boncde']->value['lielivaut'];?>
<br/><br/><em>Date Livraison :</em><?php echo $_smarty_tpl->tpl_vars['boncde']->value['datliv'];?>
 - <?php if ($_smarty_tpl->tpl_vars['boncde']->value['jrsliv']=="PM") {?>Apres-midi<?php }
if ($_smarty_tpl->tpl_vars['boncde']->value['jrsliv']=="AM") {?>Matin<?php }?><br/><br/><em>Commentaire :&nbsp;</em><?php echo $_smarty_tpl->tpl_vars['boncde']->value['com'];?>
<br/><br/>
		IDE Formation :<br>
		&nbsp;&nbsp;&nbsp;Contact . :<?php echo $_smarty_tpl->tpl_vars['boncde']->value['coordidel'];?>
<br>
		&nbsp;&nbsp;&nbsp;Téléphone :<?php echo $_smarty_tpl->tpl_vars['boncde']->value['telidel'];?>


	<br />

	<?php if (empty($_smarty_tpl->tpl_vars['produitsajout']->value)&&empty($_smarty_tpl->tpl_vars['produitssupp']->value)&&empty($_smarty_tpl->tpl_vars['produitsmaj']->value)) {?>
	<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">
		<span style="font-family:comic sans ms,cursive"><u>Produit(s) commandé(s) le <?php echo $_smarty_tpl->tpl_vars['boncde']->value['datdem'];?>
 pour le <?php echo $_smarty_tpl->tpl_vars['boncde']->value['datliv'];?>
 :</u> <br />
			<br />
			<?php  $_smarty_tpl->tpl_vars['groupe'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['groupe']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['groupe']->key => $_smarty_tpl->tpl_vars['groupe']->value) {
$_smarty_tpl->tpl_vars['groupe']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['groupe']->key;
?>
			<br />
			<strong><?php echo $_smarty_tpl->tpl_vars['groupe']->value['lb_hierachie'];?>
 </strong><br />
			<br />
			<?php  $_smarty_tpl->tpl_vars['produit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produit']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupe']->value['produits']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produit']->key => $_smarty_tpl->tpl_vars['produit']->value) {
$_smarty_tpl->tpl_vars['produit']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['produit']->key;
?>	
			<strong><?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['produit']->value['sk_produit'],'FKL55651','FKL5565'),'FKL55652','FKL5565');?>
 - <?php echo $_smarty_tpl->tpl_vars['produit']->value['lb_produit'];?>
 - commentaire : <?php echo $_smarty_tpl->tpl_vars['commentaire']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']];?>
 - qté(s) : <?php echo $_smarty_tpl->tpl_vars['quantite']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']];?>
 </strong><br />
			<?php } ?>
			<?php } ?>
		</span>
	</div>
	<?php }?>

	<?php if (!empty($_smarty_tpl->tpl_vars['produitsajout']->value)||!empty($_smarty_tpl->tpl_vars['produitssupp']->value)||!empty($_smarty_tpl->tpl_vars['produitsmaj']->value)) {?>
	<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">
		<?php if (!empty($_smarty_tpl->tpl_vars['produitsajout']->value)) {?>
		<span style="font-family:comic sans ms,cursive"><u>Produit(s) ajouté(s) :</u> <br />
			<br />
			<?php  $_smarty_tpl->tpl_vars['produit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produit']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['produitsajout']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produit']->key => $_smarty_tpl->tpl_vars['produit']->value) {
$_smarty_tpl->tpl_vars['produit']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['produit']->key;
?>	
			<strong><?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
 - <?php echo $_smarty_tpl->tpl_vars['produit']->value['lb_produit'];?>
 - commentaire : <?php echo $_smarty_tpl->tpl_vars['produit']->value['co_produit'];?>
 - qté(s) : <?php echo $_smarty_tpl->tpl_vars['produit']->value['qt_ecart'];?>
 </strong><br />
			<?php } ?>

		</span>
		<br />
		<?php }?>

		<?php if (!empty($_smarty_tpl->tpl_vars['produitssupp']->value)) {?> 
		<span style="font-family:comic sans ms,cursive"><u>Produit(s) supprimé(s) :</u> <br />
			<br />
			<?php  $_smarty_tpl->tpl_vars['produit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produit']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['produitssupp']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produit']->key => $_smarty_tpl->tpl_vars['produit']->value) {
$_smarty_tpl->tpl_vars['produit']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['produit']->key;
?>	
			<strong><?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
 - <?php echo $_smarty_tpl->tpl_vars['produit']->value['lb_produit'];?>
 - qté(s) : <?php echo $_smarty_tpl->tpl_vars['produit']->value['qt_ecart'];?>
 </strong><br />
			<?php } ?>	
		</span>
		<br />
		<?php }?>
		<?php if (!empty($_smarty_tpl->tpl_vars['produitsmaj']->value)) {?>
		<span style="font-family:comic sans ms,cursive"><u>Produit(s) modifié(s) :</u> <br />
			<br />
			<?php  $_smarty_tpl->tpl_vars['produit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produit']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['produitsmaj']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produit']->key => $_smarty_tpl->tpl_vars['produit']->value) {
$_smarty_tpl->tpl_vars['produit']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['produit']->key;
?>	
			<strong><?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
 - <?php echo $_smarty_tpl->tpl_vars['produit']->value['lb_produit'];?>
 - commentaire : <?php echo $_smarty_tpl->tpl_vars['produit']->value['co_produit'];?>
 - qté(s) : <?php echo $_smarty_tpl->tpl_vars['produit']->value['qt_ecart'];?>
 </strong><br />
			<?php } ?>
		</span>
		<?php }?>
	</div>
	<?php }?>

	<p><span style="font-family:comic sans ms,cursive">Cordialement.</span></p>

	<p><span style="font-family:comic sans ms,cursive">Salutations distingu&eacute;es.</span></p>

	<p><span style="font-family:comic sans ms,cursive"><?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['nom'];?>
</span></p>
	<p>&nbsp;</p>

	<span style="font-family:comic sans ms,cursive"><u><?php echo $_smarty_tpl->tpl_vars['client']->value['lb_donneur_ordre'];?>
</u><br /></span>
<?php }} ?>
