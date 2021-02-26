<?php /* Smarty version Smarty-3.1.21-dev, created on 2018-06-21 15:42:33
         compiled from "/var/www/html/had/views/boncdes/pdf.tpl" */ ?>
<?php /*%%SmartyHeaderCode:101815855556014d436c0051-71855402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5aee7160cb80170a8bcd5cab84c71dd8a99e951f' => 
    array (
      0 => '/var/www/html/had/views/boncdes/pdf.tpl',
      1 => 1529588237,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101815855556014d436c0051-71855402',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56014d4377ed04_27216818',
  'variables' => 
  array (
    'titrepage' => 0,
    'base_url' => 0,
    'element' => 0,
    'client' => 0,
    'patient' => 0,
    'groupes' => 0,
    'groupe' => 0,
    'produit' => 0,
    'quantite' => 0,
    'commentaire' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56014d4377ed04_27216818')) {function content_56014d4377ed04_27216818($_smarty_tpl) {?><!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $_smarty_tpl->tpl_vars['titrepage']->value;?>
</title>
		<style type="text/css">
			body {
				margin:0;padding:0;
				font-size: 10pt;
			}
			table {
				border-collapse: collapse;
				border-spacing: 0;
				margin: 0;
				padding: 0;
			}

			.titre {
				font-weight: bolder;
				font-size: 12pt;
				text-align: center;
				background: #08B6CE;
				color: #FFF;
			}
			td {
				margin: 0;
				padding-left: 3px;
				border : none;
				overflow: hidden;

			}
			.fl{
				float:left;
			}
			.hc{
				text-align : center;
			}
			.hr{
				text-align : right;
			}
			.vt{
				vertical-align : top;
			}
			.vb{
				vertical-align : bottom;
			}
			.bt{
				border-top : 1px solid black;
			}
			.bb{
				border-bottom : 1px solid black;
			}
			.bl{
				border-left : 1px solid black;
			}
			.br{
				border-right : 1px solid black;
			}
			.ba{
				border: 1px solid black;
			}
			.case{
				display:inline;
				padding:0px;
				width:10px;height:12px;
				border: 1px solid black;
				margin-left:15px;
				margin-right:3px;
				text-align: center;
				font-size: 9pt;
			}
			.bgg{
				background : #D4D4D4;
			}
			.small .case{
				display:inline;
				padding:0px;
				width:8px;height:10px;
				border: 1px solid black;
				margin-left:15px;
				margin-right:3px;
				text-align: center;
				font-size: 7pt;
			}
			.xlarge {
				font-size: 14pt;
			}
			.large {
				font-size: 12pt;
			}
			.small {
				font-size: 8pt;
			}
			.xsmall {
				font-size: 6pt;
			}
			.xxsmall {
				font-size: 5pt;
			}
			p {
				padding: 0;
				margin: 0;
			}
			.bb.bl.br.bt.small {
			}
		</style>
	</head>

	<body>
		<table style="width:100%">
			<tbody>
				<tr>
					<td style="width:2%" >&nbsp;</td>
					<td style="width:73%" >	<img src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
img/charte/blcm-logo.jpg" style="width:100px" alt=""/><br></td>
					<td style="width:25%" class="hc"><p class="large hr">le <?php echo $_smarty_tpl->tpl_vars['element']->value['datdem'];?>
 </p><br>	</td>
				</tr>
				<tr>
					<td  colspan="2" > <br/> </td>
				</tr>
				<tr>
					<td style="width:100%;height:18px" class="titre" colspan="3"> <strong>BON DE COMMANDE N° &nbsp;<?php echo $_smarty_tpl->tpl_vars['element']->value['numcde'];?>
</strong> </td>
				</tr>
				<tr>
					<td style="width:100%" class="hc" colspan="3"></td>
				</tr>

				<tr>
					<td class="bt bb bl br bgg hc small" >
						C<br/>
						L<br/>
						I<br/>
						E<br/>
						N<br/>
						T
					</td>
					<td class="bt bb bl br" colspan="2" >
						<em>Donneur ordre : &nbsp;</em><?php echo $_smarty_tpl->tpl_vars['client']->value['lb_donneur_ordre'];?>
<br/><br/><br/>
					</td>
				</tr>
				<tr>
					<td class="bt bb bl br bgg hc small">
						P<br/>
						A<br/>
						T<br/>
						I<br/>
						E<br/>
						N<br/>
						T
					</td>
					<td class="bt bb bl br"  colspan="2" >
						<em>N° :&nbsp;</em><?php echo $_smarty_tpl->tpl_vars['patient']->value['ext_patient'];?>
<br/> <br/>
						<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_titre'];?>
 <?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_nom'];?>
<br/>
						<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_adresse'];?>
<br/>
						<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_codepostal'];?>
 &nbsp;<?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_ville'];?>
<br/><br/>
						<em>Téléphone :&nbsp;</em><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_telephone'];?>
<br/><br/>
					</td>
				</tr>
				<tr>
					<td class="bt bb bl br bgg hc small">

					</td>
					<td class="bt bb bl br"  colspan="2" >
						<em>Livré &agrave; : &nbsp;</em><?php if ($_smarty_tpl->tpl_vars['element']->value['lieliv']=="P") {?>Domicile<?php }
if ($_smarty_tpl->tpl_vars['element']->value['lieliv']=="S") {?>HAD<?php }
if ($_smarty_tpl->tpl_vars['element']->value['lieliv']=="A") {
echo $_smarty_tpl->tpl_vars['element']->value['lielivaut'];
}?><br/><br/>
						<em>Date Livraison :</em><?php echo $_smarty_tpl->tpl_vars['element']->value['datliv'];?>
 - <?php if ($_smarty_tpl->tpl_vars['element']->value['jrsliv']=="PM") {?>Apres-midi<?php }
if ($_smarty_tpl->tpl_vars['element']->value['jrsliv']=="AM") {?>Matin<?php }?><br/><br/>
						<em>Commentaire :&nbsp;</em><?php echo $_smarty_tpl->tpl_vars['element']->value['com'];?>
<br/><br/>
						IDE Formation :<br>
						&nbsp;&nbsp;&nbsp;Contact . :<?php echo $_smarty_tpl->tpl_vars['element']->value['coordidel'];?>

						&nbsp;&nbsp;&nbsp;Téléphone :<?php echo $_smarty_tpl->tpl_vars['element']->value['telidel'];?>

					</td>
				</tr>
			</tbody>
		</table>
		<table style="width:100%">
			<tbody>
				<tr>
					<td style="width:100%" colspan="4" class="bb bl br bgg">
						<strong>Produit(s) commandé(s) pour le <?php echo $_smarty_tpl->tpl_vars['element']->value['datliv'];?>
</strong>
					</td>
				</tr>
				<tr>
					<td style="width:10%;height:30px"  class="hc bb bl br bt small">N° de produit</td>
					<td style="width:50%" class="hc bb bl br bt small">Dénomination du produit</td>
					<td style="width:10%"  class="hc bb bl br bt small">Quantité</td>
					<td style="width:30%"  class="hc bb bl br bt small">Commentaire</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['groupe'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['groupe']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['groupe']->key => $_smarty_tpl->tpl_vars['groupe']->value) {
$_smarty_tpl->tpl_vars['groupe']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['groupe']->key;
?>
					<tr>
						<td style="width:100%" colspan="4" class="bb bl br bgg">
							<strong><?php echo $_smarty_tpl->tpl_vars['groupe']->value['lb_hierachie'];?>
 </strong><br />
						</td>
					</tr>
					<?php  $_smarty_tpl->tpl_vars['produit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produit']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groupe']->value['produits']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produit']->key => $_smarty_tpl->tpl_vars['produit']->value) {
$_smarty_tpl->tpl_vars['produit']->_loop = true;
?>
						<tr>
							<td style="width:5%;height:20px" class="br bt bl bb small">   <?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
</td>
							<td style="width:27%"            class="br bt bl bb small">   <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['produit']->value['lb_produit'], ENT_QUOTES, 'UTF-8', true);?>
</td>
							<td style="width:6%"             class="br bt bl bb small hc">   <?php echo $_smarty_tpl->tpl_vars['quantite']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']];?>
</td>
							<td style="width:4%"             class="br bt bl bb small">   <?php echo $_smarty_tpl->tpl_vars['commentaire']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']];?>
</td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</body>
</html>
<?php }} ?>
