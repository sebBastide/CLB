<?php /* Smarty version Smarty-3.1.21-dev, created on 2019-11-04 12:05:51
         compiled from "/var/www/html/had/views/patients/gerer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:734018088566a958fe7ada5-87157465%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05ecd4f205ad48fee75a7d50ff8653368d80c95e' => 
    array (
      0 => '/var/www/html/had/views/patients/gerer.tpl',
      1 => 1572865175,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '734018088566a958fe7ada5-87157465',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_566a958ff3bde3_12163889',
  'variables' => 
  array (
    'client' => 0,
    'patient' => 0,
    'boncde' => 0,
    'bonc' => 0,
    'boncdes_entete' => 0,
    'boncde_entete' => 0,
    'brm' => 0,
    'brd' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566a958ff3bde3_12163889')) {function content_566a958ff3bde3_12163889($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/html/had/core/smarty/plugins/modifier.replace.php';
?><h1>Extranet <?php echo $_smarty_tpl->tpl_vars['client']->value['lb_donneur_ordre'];?>
</h1>

<form name="gerer" class="form l150" method="post" action="/patients/gerer">
	<div style=" height:110px; width:900px; color:black;padding:5px 5px 5px 60px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
		<div class="droite" style="width:300px;">
			<ol>
				<h4> ( Patient n° <?php echo $_smarty_tpl->tpl_vars['patient']->value['ext_patient'];?>
 )</h4>
				<input type="hidden" name="hide_ext_patient" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['hide_ext_patient'];?>
" />
				<input type="hidden" name="hide_sk_patient" value="<?php echo $_smarty_tpl->tpl_vars['patient']->value['hide_sk_patient'];?>
" />
				
			</ol>
		</div>
		<div class="gauche"style="width:600px;" >
			<ol>
				<h4><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_titre'];?>
 <?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_nom'];?>
 <?php if (!empty($_smarty_tpl->tpl_vars['patient']->value['dt_naissance'])) {?> - né(e) le : <?php echo datevershtml($_smarty_tpl->tpl_vars['patient']->value['dt_naissance'],'Y-m-d H:i:s');?>
 <?php }?> - tél. <?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_telephone'];?>
</h4>				
				<h4><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_adresse'];?>
 </h4>
				<h4><?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_codepostal'];?>
 - <?php echo $_smarty_tpl->tpl_vars['patient']->value['lb_ville'];?>
 </h4>
			</ol>
		</div>
	
	
</div>
<div class="separe h_20"></div>
<div style=" height:auto; width:965px; color:black; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">

				<div style="overflow-y:auto;  width:965px; color:black;border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
					<ol>
						<table class="display dataTable no-footer" role="grid" style="font-size: 11px;font-family: Verdana,Helvetica,sans-serif;color: black; margin-left: 0px; ">
								<thead>
									<th width='86'>Réf.</th>	
									<th width='420'>Produit</th>				
									<th width='346'>Commentaire</th>				
									<th width='82'>Qté cdée</th>	
									<th width='50'>Date</th>
									<th width='150'>Num Commande</th>
									<td width='80' align='center'><b>Récupérer<b><input type="checkbox" name="arecupTout" tabindex="-1" title="Tout sélectionner/déselectionner" onClick = "cocherDecocher();"/></td>
								</thead>
								<tbody >								
									<?php  $_smarty_tpl->tpl_vars['bonc'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bonc']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['boncde']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bonc']->key => $_smarty_tpl->tpl_vars['bonc']->value) {
$_smarty_tpl->tpl_vars['bonc']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['bonc']->key;
?> 											
										<tr>
											<td style="">
											<?php if ($_smarty_tpl->tpl_vars['bonc']->value['sk_produit']>30||$_smarty_tpl->tpl_vars['bonc']->value['sk_produit']<1) {?>
												<?php echo smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['bonc']->value['sk_produit'],'FKL55651','FKL5565'),'FKL55652','FKL5565'),'FKL33101','FKL3310'),'FKL33102','FKL3310'),'FKL33103','FKL3310');?>
 
											<?php }?>
											</td>
											<td><?php echo $_smarty_tpl->tpl_vars['bonc']->value['lb_produit'];?>
</td>
											<td><?php echo $_smarty_tpl->tpl_vars['bonc']->value['co_produit'];?>
</td>
											<td><?php echo $_smarty_tpl->tpl_vars['bonc']->value['qt_produit'];?>
</td>
											<td><?php if (isset($_smarty_tpl->tpl_vars['bonc']->value['credat'])) {
echo $_smarty_tpl->tpl_vars['bonc']->value['credat'];
}?></td>	
											<td><a  href="/boncdes/modifier/<?php echo $_smarty_tpl->tpl_vars['bonc']->value['numcde'];?>
"><?php echo $_smarty_tpl->tpl_vars['bonc']->value['numcde'];?>
</td>	
											<td align="center"><input type="checkbox" name="arecup" tabindex="-1" /></td>
											<input type="hidden" name="id_produit" value="<?php echo $_smarty_tpl->tpl_vars['bonc']->value['sk_produit'];?>
" />
											<input type="hidden" name="id_commande" value="<?php echo $_smarty_tpl->tpl_vars['bonc']->value['numcde'];?>
" />
										</tr>
									<?php } ?>									
								</tbody>
							</table>
						</ol>
					</div>									
					<span>
						<input name="btn_recuperer" type="button" class="boutton right" value="RECUPERER LE MATERIEL SELECTIONNE" onClick="recup();" />						
					</span>

</div>
	<div class="separe h_20"></div>
	
	<div style="overflow-y:auto; height:600px; width:900px; color:black;padding:5px 5px 5px 60px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
		<ol>
			<li> <a href="/boncdes/ajouter?numpat=<?php echo $_smarty_tpl->tpl_vars['patient']->value['ext_patient'];?>
"  style="color:black; margin-left:5px;"> >> Nouveau bon de commande </a>
			</li>
					
			<?php  $_smarty_tpl->tpl_vars['boncde_entete'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['boncde_entete']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['boncdes_entete']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['boncde_entete']->key => $_smarty_tpl->tpl_vars['boncde_entete']->value) {
$_smarty_tpl->tpl_vars['boncde_entete']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['boncde_entete']->key;
?>	
				<li> <input type="hidden" name="element[numcde][$k]" value="<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
">
					<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
<?php $_tmp1=ob_get_clean();?><?php if (!empty($_tmp1)) {?>
						<!--<li>
							<a href="/bonrmat/ajouter/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
" style="color:black; text-decoration:none">  <img src="/img/pictos/materiel.png" alt="Ajouter" title="Ajouter bon de récupération matériel" > Récupérer le matériel sélectionné</a>
							<a href="/bonrdec/ajouter/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
" style="color:black; text-decoration:none">  <img src="/img/pictos/dechet.png" alt="Ajouter" title="Ajouter bon de récupération déchet" </a>
						</li>-->
						<img src="/img/pictos/commande.png" title="Bon de commande" > <b> > Commande n° </b> <?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
 du  <?php echo dat($_smarty_tpl->tpl_vars['boncde_entete']->value['datdem']);?>
 pour le <?php echo dat($_smarty_tpl->tpl_vars['boncde_entete']->value['datliv']);?>

						<a href="/boncdes/modifier/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
"  style="color:black;  text-decoration:none"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier / Rajouter commande"> </a>
						<!-- B.OCHUDLO le 23/11/2015 <a href="/boncdes/envmailbcde/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
/0"> <img src="/img/pictos/mail.png" alt="Envoyer mail" title="Valider commande"></a>-->
						<!--<b>......</b>
						<a href="/bonrmat/ajouter/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
" style="color:black; text-decoration:none"> <img src="/img/pictos/materiel.png" alt="Ajouter" title="Ajouter bon de récupération matériel" > </a>
						<a href="/bonrdec/ajouter/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
" style="color:black; text-decoration:none"> <img src="/img/pictos/dechet.png" alt="Ajouter" title="Ajouter bon de récupération déchet" </a>
						-->
						<?php  $_smarty_tpl->tpl_vars['brm'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['brm']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['boncde_entete']->value['brm']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['brm']->key => $_smarty_tpl->tpl_vars['brm']->value) {
$_smarty_tpl->tpl_vars['brm']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['brm']->key;
?>	
							<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['brm']->value['numbrmat'];?>
<?php $_tmp2=ob_get_clean();?><?php if (!empty($_tmp2)) {?>
								<li> 
									<img src="/img/pictos/materiel.png" title="Bon de récupération matériel" style="margin-left: 50px;"> <b>Récup. matériel n° </b> <?php echo $_smarty_tpl->tpl_vars['brm']->value['numbrmat'];?>
 du <?php echo dat($_smarty_tpl->tpl_vars['brm']->value['datdem']);?>
 pour le <?php echo dat($_smarty_tpl->tpl_vars['brm']->value['datrec']);?>

									<a href="/bonrmat/modifier/<?php echo $_smarty_tpl->tpl_vars['brm']->value['numbrmat'];?>
"  style="color:black;  text-decoration:none"><img src="/img/pictos/edit.gif" alt="Modifier" title="Modifier / Rajouter bon de récupération matériel"> </a>
									<!-- B.OCHUDLO le 23/11/2015 <a href="/bonrmat/envmailbrmat/<?php echo $_smarty_tpl->tpl_vars['brm']->value['numbrmat'];?>
"> <img src="/img/pictos/mail.png" alt="Envoyer mail" title="Valider bon"></a>-->
								</li>
							<?php }?>
						<?php } ?>

						<!-- <?php  $_smarty_tpl->tpl_vars['brd'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['brd']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['boncde_entete']->value['brd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['brd']->key => $_smarty_tpl->tpl_vars['brd']->value) {
$_smarty_tpl->tpl_vars['brd']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['brd']->key;
?>	
							<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['brd']->value['numbrdec'];?>
<?php $_tmp3=ob_get_clean();?><?php if (!empty($_tmp3)) {?>
								<li> <img src="/img/pictos/dechet.png" title="Bon de récupération dechet"  style="margin-left: 50px;"> <b>Récup. déchet n° </b> <?php echo $_smarty_tpl->tpl_vars['brd']->value['numbrdec'];?>
 du <?php echo dat($_smarty_tpl->tpl_vars['brd']->value['datdem']);?>
 pour le <?php echo dat($_smarty_tpl->tpl_vars['brd']->value['datrec']);?>

									<a href="/bonrdec/modifier/<?php echo $_smarty_tpl->tpl_vars['brd']->value['numbrdec'];?>
"  style="color:black;  text-decoration:none"><img src="/img/pictos/edit.gif" alt="Modifier" title="Editer bon de récupération déchet"> </a>
									<!-- B.OCHUDLO le 23/11/2015 <a href="/bonrdec/envmailbrdec/<?php echo $_smarty_tpl->tpl_vars['brd']->value['numbrdec'];?>
"> <img src="/img/pictos/mail.png" alt="Envoyer mail" title="Envoyer mail"></a>-->
								</li>
							<?php }?>
						<?php } ?>
						-->
					<?php }?>
					
				</li>
			<?php } ?>
					
		</ol>
	</div>
</form>


<?php echo '<script'; ?>
 type="text/javascript">
function editer_bcde(numcde){
//appel fonction editer	   
	   window.location.href='/boncdes/modifier/'+numcde;
}

function recup()
{
	var i = 0;
	var lienRecup = '?';
	var commandes='';
	var produits='';
	for (i=0;i<document.getElementsByName('arecup').length;i++)
	{
		if(document.getElementsByName('arecup').item(i).checked)
		{						
			if (document.getElementsByName('id_commande').item(i).value.trim() != '')
			{
				commandes = commandes + "'"+ document.getElementsByName('id_commande').item(i).value + "',";
				produits = produits + "'" + document.getElementsByName('id_produit').item(i).value + "',";	
			}				
		}
	}
	if (commandes != '') 
	{
		commandes = commandes.substring(0,commandes.length-1);
		produits = produits.substring(0,produits.length-1);
		window.location.href='/bonrmat/ajouter_Multi/?id_commande='+commandes + '&id_produit='+produits;
	}
	else
	{
		alert('Veuillez sélectionner des produits à récupérer');
	}
}

function cocherDecocher()
{	
	for (i=0;i<document.getElementsByName('arecup').length;i++)
	{
		if (document.getElementsByName('arecup').item(i).checked)
		{
			document.getElementsByName('arecup').item(i).checked = false;
		}
		else
		{
			document.getElementsByName('arecup').item(i).checked = true;
		} 
	}
}

<?php echo '</script'; ?>
>
<?php }} ?>
