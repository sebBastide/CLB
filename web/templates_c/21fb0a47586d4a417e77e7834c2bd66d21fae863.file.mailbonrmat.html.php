<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-06-30 10:36:36
         compiled from "/var/www/html/had/pages/mailbonrmat.html" */ ?>
<?php /*%%SmartyHeaderCode:207201938156015435e56523-80550026%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21fb0a47586d4a417e77e7834c2bd66d21fae863' => 
    array (
      0 => '/var/www/html/had/pages/mailbonrmat.html',
      1 => 1467229979,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '207201938156015435e56523-80550026',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56015435f07200_93862058',
  'variables' => 
  array (
    'bonrec' => 0,
    'patient' => 0,
    'raison' => 0,
    'groupes' => 0,
    'groupe' => 0,
    'produit' => 0,
    'utilisateur' => 0,
    'client' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56015435f07200_93862058')) {function content_56015435f07200_93862058($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/html/had/core/smarty/plugins/modifier.replace.php';
?><p><span style="font-family:comic sans ms,cursive">Bonjour,</span></p>

<p><span style="font-family:comic sans ms,cursive">Veuillez trouvez ci-joint le&nbsp;bon de récupération de matériels &nbsp;<?php echo $_smarty_tpl->tpl_vars['bonrec']->value['numbrmat'];?>
&nbsp; pour le <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['datrec'];?>

		<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['jrsrec']=="AM") {?> le matin <?php }?>
		<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['jrsrec']=="PM") {?> l'après midi <?php }?>
		<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['jrsrec']=="DJ") {?> dans la journée <?php }?>
		et demandé par <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['nomdem'];?>
 : </span>
</p>

<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">
	<span style="font-family:comic sans ms,cursive"><u>Patient n° <?php echo $_smarty_tpl->tpl_vars['patient']->value['ext_patient'];?>
 : </u><br />
	<br />
	<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['datfinhad']!=0) {?> Fin de HAD le <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['datfinhad'];?>
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

	<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['r_maison']=="O") {?>
	<strong>Maison : Oui</strong><br /> 
	<?php }?>

	<!--<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['r_maison']=="N") {?>
	strong>Appartement : Oui</strong><br />
	<?php }?>
	<br />

	<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['r_rdc']=="O") {?>
	<strong>RDC : Oui</strong><br />
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['r_rdc']=="N") {?>
	<strong>Etage : Oui</strong><br />
	<?php }?>
	<br />
	<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['r_ascen']=="O") {?>
	<strong>Ascenseur : Oui </strong><br />
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['r_ascen']=="N") {?>
	<strong>Ascenseur : Non </strong><br />
	<?php }?>-->

	<br />

	<?php if ($_smarty_tpl->tpl_vars['bonrec']->value['lierecaut']!='') {?>
	<strong>Autres coordonnées : <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['lierecaut'];?>
 </strong><br />
	<?php }?>

	<br />
	<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">
		<span style="font-family:comic sans ms,cursive"><u>Récupération de produit(s) demandé le <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['datdem'];?>
 par <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['nomdem'];?>
 pour le <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['datrec'];?>
 :</u> <br />
			<br />
			<?php  $_smarty_tpl->tpl_vars['groupe'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['groupe']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['groupe']->key => $_smarty_tpl->tpl_vars['groupe']->value) {
$_smarty_tpl->tpl_vars['groupe']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['groupe']->key;
?>
			<strong><u><?php echo $_smarty_tpl->tpl_vars['groupe']->value['lb_hierachie'];?>
</u> </strong><br />
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
 </strong><br />
			<?php } ?>
			<br />
			<?php } ?>
			<br />
			<strong>Autre(s): <?php echo $_smarty_tpl->tpl_vars['bonrec']->value['r_autre'];?>
 </strong><br />
		</span>
	</div>

	<br />

	<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">
		<span style="font-family:comic sans ms,cursive"><u>Commentaire divers :</u> <br />
			<br />
			<strong><?php echo $_smarty_tpl->tpl_vars['bonrec']->value['com_div'];?>
&nbsp;</strong><br />
			<br />
		</span>
	</div>
	<br />
	<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">
		<span style="font-family:comic sans ms,cursive"><u>Commentaire interne :</u> <br />
			<br /> 
			<strong><?php echo $_smarty_tpl->tpl_vars['bonrec']->value['com_int'];?>
&nbsp;</strong><br /> 
		</span>
	</div>

	<p><span style="font-family:comic sans ms,cursive">Cordialement.</span></p>

	<p><span style="font-family:comic sans ms,cursive">Salutations distingu&eacute;es.</span></p>

	<p><span style="font-family:comic sans ms,cursive"><?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['prenom'];?>
 <?php echo $_smarty_tpl->tpl_vars['utilisateur']->value['nom'];?>
</span></p>
	<p>&nbsp;</p>

	<span style="font-family:comic sans ms,cursive"><u><?php echo $_smarty_tpl->tpl_vars['client']->value['lb_donneur_ordre'];?>
</u><br />
<?php }} ?>
