<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-14 08:45:58
         compiled from "/var/www/html/had/views/accueil/defaut.tpl" */ ?>
<?php /*%%SmartyHeaderCode:824891066566a93ba53f6a9-35690896%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46bcacef3b782b1b2ce11e498b282603a46e9c25' => 
    array (
      0 => '/var/www/html/had/views/accueil/defaut.tpl',
      1 => 1450078995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '824891066566a93ba53f6a9-35690896',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_566a93ba75d278_23659201',
  'variables' => 
  array (
    'element' => 0,
    'datlim' => 0,
    'bons' => 0,
    'bon' => 0,
    'boncdes_entete' => 0,
    'boncde_entete' => 0,
    'bonrecs_dechet' => 0,
    'bonrec_dechet' => 0,
    'bonrecs_materiel' => 0,
    'bonrec_materiel' => 0,
    'nbcde' => 0,
    'nbdec' => 0,
    'nbmat' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566a93ba75d278_23659201')) {function content_566a93ba75d278_23659201($_smarty_tpl) {?>
<h1>Extranet <?php echo $_smarty_tpl->tpl_vars['element']->value['lb_donneur_ordre'];?>
</h1>

<h2>Bienvenue sur l'interface de gestion des bons de commandes HAD Bastide</h2>

<h4>Vous pouvez rechercher un patient pour gérer un bon de commande ou faire une recherche par numéro de bon de commande</h4>

<form name="tableaudebord" class="form l150" method="post" action="/accueil/recherche">
	
	<div class="separe h_5"></div>
	
	<div class="gauche" style="width: 430px">
		<div id="tabsGH" class="form" style="height: 200px;" >
			<ul>
				<li><a href="#tabs-GH1">Recherche / Patient</a></li>
				<li><a href="#tabs-GH2">Recherche / Bon de cde</a></li>
			</ul>

			<div id="tabs-GH1">
				<ol>
					<li><label>N° de patient </label> <input type="text"  name="r_numero"  id="r_numero" style="width: 120px"/></li>
					<li><label>Nom </label> <input type="text"  name="r_nom" id="r_nom"  style="width: 200px" /></li>
					<li><label>Date de naissance</label> <input type="text" class="date"  name="r_datenaissance"  id="r_datenaissance"  style="width: 125px"/></li>
				</ol>
				<div class="separe h_5"></div>
				<label>&nbsp</label> <input name="btn_recherche_patient" class="boutton right" type="submit" value="Rechercher">
			</div>
			
			<div id="tabs-GH2">
				<ol>
					<li>
						<label>Type commande </label>
						<select name="r_typcde" style="width: 200px;">
							<option value="C" <?php if ('r_typcde'=="C") {?>selected<?php }?>>Commandes</option>
							<option value="D" <?php if ('r_typcde'=="D") {?>selected<?php }?>>Récupération déchets</option>
							<option value="M" <?php if ('r_typcde'=="M") {?>selected<?php }?>>Récupération matériels</option>
						</select>
					</li>
					<li><label>N° de bon</label> <input type="text"  name="r_numbon"  id="r_numbon" style="width: 120px"/></li>
					<li><label>Date de demande</label> <input type="text" class="date"  name="r_datdem"  id="r_datdem"   /></li>
					<li><label>Date liv./récup.</label> <input type="text" class="date"  name="r_datint"  id="r_datint"  />
				
					<input name="btn_recherche_cde" class="boutton right" type="submit" value="Rechercher"></li>
				</ol>
			</div>
		</div>	
		
		<div class="separe h_10"></div>		
		
		<div id="tabsGB" class="form" style="height: 300px;" >
				<ul>
					<li><a href="#tabs-GB">Livraison(s) J+2 au <?php echo dat($_smarty_tpl->tpl_vars['datlim']->value);?>
</a></li>
				</ul>
				<ol>	
					<div class="separe h_10"></div>		
					<div style="overflow-y:auto; height:240px; width:410px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° bon </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date liv./recup.</h5> </th>
						</thead>
			
						<tbody>
					
						<?php  $_smarty_tpl->tpl_vars['bon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bon']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bon']->key => $_smarty_tpl->tpl_vars['bon']->value) {
$_smarty_tpl->tpl_vars['bon']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['bon']->key;
?>	
							<input type="hidden" name="element[numbon][$k]" value="<?php echo $_smarty_tpl->tpl_vars['bon']->value['numbon'];?>
">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> <?php echo $_smarty_tpl->tpl_vars['bon']->value['numbon'];?>
  </td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bon']->value['datdem'];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1!='0000-00-00') {
echo dat($_smarty_tpl->tpl_vars['bon']->value['datdem']);
}?>  </td>
								<td style="border:1px dotted; text-align:center;"> <?php echo $_smarty_tpl->tpl_vars['bon']->value['lb_titre'];?>
 <?php echo $_smarty_tpl->tpl_vars['bon']->value['lb_nom'];?>
 </td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bon']->value['datint'];?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp2!='0000-00-00') {?> <?php echo dat($_smarty_tpl->tpl_vars['bon']->value['datint']);?>
 <?php }?> </td>
							</tr>
						<?php } ?>
					
						</tbody>
						</table>
					</div>
				</ol>
		</div>
	</div>
	
	<div class="droite" style="width: 530px;">
			<div id="tabsDH" class="form" style="height: 300px;" >
				<ul>
					<li><a href="#tabs-D1">Dern. cdes saisies</a></li>
					<li><a href="#tabs-D2">Dern. récup. déchets</a></li>
					<li><a href="#tabs-D3">Dern. récup. matériels</a></li>
				</ul>

				<div id="tabs-D1">
					<div style="overflow-y:auto; margin-left:-15px; height:235px; width:500px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
						
						<h5>Dernière(s) commande(s)</h5>
						
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° Cde </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date livraison </h5> </th>
						</thead>
			
						<tbody>
					
						<?php  $_smarty_tpl->tpl_vars['boncde_entete'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['boncde_entete']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['boncdes_entete']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['boncde_entete']->key => $_smarty_tpl->tpl_vars['boncde_entete']->value) {
$_smarty_tpl->tpl_vars['boncde_entete']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['boncde_entete']->key;
?>	
							<input type="hidden" name="element[numcde][$k]" value="<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> <a class="nounderline" href="/boncdes/modifier/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
"><?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numcde'];?>
</a></td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['datdem'];?>
<?php $_tmp3=ob_get_clean();?><?php if ($_tmp3!='0000-00-00') {
echo dat($_smarty_tpl->tpl_vars['boncde_entete']->value['datdem']);
}?>  </td>
								<td style="border:1px dotted; text-align:center;"><a class="nounderline" href="/patients/gerer/<?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['numpat'];?>
"> <?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['lb_titre'];?>
 <?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['lb_nom'];?>
 </a></td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['boncde_entete']->value['datliv'];?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp4!='0000-00-00') {?> <?php echo dat($_smarty_tpl->tpl_vars['boncde_entete']->value['datliv']);?>
 <?php }?> </td>
							</tr>
						<?php } ?>
					
						</tbody>
						</table>
					</div>
				</div>
					
		
				<div id="tabs-D2">
					<ol>
						<div style="overflow-y:auto; margin-left:-15px; height:235px; width:500px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
	
						<h5>Dernière(s) récup. déchet(s)</h5>
						
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° bon </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date récupération </h5> </th>
						</thead>
			
						<tbody>
					
						<?php  $_smarty_tpl->tpl_vars['bonrec_dechet'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bonrec_dechet']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bonrecs_dechet']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bonrec_dechet']->key => $_smarty_tpl->tpl_vars['bonrec_dechet']->value) {
$_smarty_tpl->tpl_vars['bonrec_dechet']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['bonrec_dechet']->key;
?>	
							<input type="hidden" name="element[numbrdec][$k]" value="<?php echo $_smarty_tpl->tpl_vars['bonrec_dechet']->value['numbrdec'];?>
">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> <?php echo $_smarty_tpl->tpl_vars['bonrec_dechet']->value['numbrdec'];?>
  </td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bonrec_dechet']->value['datdem'];?>
<?php $_tmp5=ob_get_clean();?><?php if ($_tmp5!='0000-00-00') {
echo dat($_smarty_tpl->tpl_vars['bonrec_dechet']->value['datdem']);
}?>  </td>
								<td style="border:1px dotted; text-align:center;"> <?php echo $_smarty_tpl->tpl_vars['bonrec_dechet']->value['lb_titre'];?>
 <?php echo $_smarty_tpl->tpl_vars['bonrec_dechet']->value['lb_nom'];?>
 </td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bonrec_dechet']->value['datrec'];?>
<?php $_tmp6=ob_get_clean();?><?php if ($_tmp6!='0000-00-00') {?> <?php echo dat($_smarty_tpl->tpl_vars['bonrec_dechet']->value['datrec']);?>
 <?php }?> </td>
							</tr>
						<?php } ?>
					
						</tbody>
						</table>
					</div>
					</ol>	
				</div>
			
				<div id="tabs-D3">
					<ol>
					<div style="overflow-y:auto; margin-left:-15px; height:235px; width:500px; color:black;padding:5px 5px 5px 5px; border:1px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
	
						<h5>Dernière(s) récup. matériel(s)</h5>
						
						<table  style="border-collapse: collapse;">	
						
						<thead>
						<th style="border:1px dotted; width: 100px;"> <h5>N° bon </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date demande </h5> </th>
						<th style="border:1px dotted; width: 250px;"> <h5>Patient </h5> </th>
						<th style="border:1px dotted; width: 100px;"> <h5>Date récupération </h5> </th>
						</thead>
			
						<tbody>
					
						<?php  $_smarty_tpl->tpl_vars['bonrec_materiel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bonrec_materiel']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bonrecs_materiel']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bonrec_materiel']->key => $_smarty_tpl->tpl_vars['bonrec_materiel']->value) {
$_smarty_tpl->tpl_vars['bonrec_materiel']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['bonrec_materiel']->key;
?>	
							<input type="hidden" name="element[numbrmat][$k]" value="<?php echo $_smarty_tpl->tpl_vars['bonrec_materiel']->value['numbrmat'];?>
">
						
							<tr>				
								<td style="border:1px dotted; text-align:center;"> <?php echo $_smarty_tpl->tpl_vars['bonrec_materiel']->value['numbrmat'];?>
  </td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bonrec_materiel']->value['datdem'];?>
<?php $_tmp7=ob_get_clean();?><?php if ($_tmp7!='0000-00-00') {
echo dat($_smarty_tpl->tpl_vars['bonrec_materiel']->value['datdem']);
}?>  </td>
								<td style="border:1px dotted; text-align:center;"> <?php echo $_smarty_tpl->tpl_vars['bonrec_materiel']->value['lb_titre'];?>
 <?php echo $_smarty_tpl->tpl_vars['bonrec_materiel']->value['lb_nom'];?>
 </td>
								<td style="border:1px dotted; text-align:center;"> <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bonrec_materiel']->value['datrec'];?>
<?php $_tmp8=ob_get_clean();?><?php if ($_tmp8!='0000-00-00') {?> <?php echo dat($_smarty_tpl->tpl_vars['bonrec_materiel']->value['datrec']);?>
 <?php }?> </td>
							</tr>
						<?php } ?>
					
						</tbody>
						</table>
					</div>
					</ol>
				</div>
			</div>
						
			<div class="separe h_10"></div>		
		
			<div id="tabsDB" class="form" style="height: 200px;" >
				<ul>
					<li><a href="#tabs-DB">Tableau de bord au <?php echo dat(date('d-m-Y'));?>
</a></li>
				</ul>
				<ol>	
					<label>&nbsp</label> 
					<h5><?php echo $_smarty_tpl->tpl_vars['nbcde']->value['nb'];?>
 bon(s) de commande(s) ont été saisis depuis le 01/01/<?php echo date('Y');?>
</h5>
					<h5><?php echo $_smarty_tpl->tpl_vars['nbdec']->value['nb'];?>
 demande(s) de récupérations de déchets ont été faites depuis le 01/01/<?php echo date('Y');?>
 </h5>
					<h5><?php echo $_smarty_tpl->tpl_vars['nbmat']->value['nb'];?>
 demande(s) de récupérations de matériels ont été faites depuis le 01/01/<?php echo date('Y');?>
 </h5>
				</ol>
			</div>
				
	   </div>
	
	<div class="separe"></div>


	
	</form>


<?php echo '<script'; ?>
 type="text/javascript">
	    $(function () {
            $('#tabsGH').tabs({heightStyle: "auto"});
	        $('#tabsGB').tabs({heightStyle: "auto"});
	        $('#tabsDH').tabs({heightStyle: "auto"});
			$('#tabsDB').tabs({heightStyle: "auto"});
        });
		
<?php echo '</script'; ?>
>
<?php }} ?>
