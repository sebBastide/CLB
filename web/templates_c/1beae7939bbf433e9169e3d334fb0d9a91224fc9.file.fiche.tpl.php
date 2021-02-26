<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-11-24 16:36:49
         compiled from "/var/www/html/had/views/boncdes/fiche.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1698338857566a94b2bd54e2-40440969%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1beae7939bbf433e9169e3d334fb0d9a91224fc9' => 
    array (
      0 => '/var/www/html/had/views/boncdes/fiche.tpl',
      1 => 1606232203,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1698338857566a94b2bd54e2-40440969',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_566a94b2cf6a27_60485188',
  'variables' => 
  array (
    'client_had' => 0,
    'element' => 0,
    'patient_had' => 0,
    'groupes' => 0,
    'k' => 0,
    'groupe' => 0,
    'produit' => 0,
    'quantite' => 0,
    'commentaire' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566a94b2cf6a27_60485188')) {function content_566a94b2cf6a27_60485188($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/html/had/core/smarty/plugins/modifier.replace.php';
?><h1>Extranet <?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_donneur_ordre'];?>
</h1>

<form name="editer" method="post" action="/boncdes/enregistrer">
	
	<input type="hidden" name="hide_numcde" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['hide_numcde'];?>
" />
	<input type="hidden" name="numcde" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['numcde'];?>
" />
	<div id="tabs" class="form" style="height:900px">
		<ul>
			<li><a href="#tabs-1">Bon de commande N° <?php echo $_smarty_tpl->tpl_vars['element']->value['numcde'];?>
</a></li>			
		</ul>

		</li>
		<div id="tabs-1" class="form_editer">
			<div class="gauche" style="width:570px" > 
				<fieldset>
					<ol>	
						<li>
							<label style="width:80px">Demandé le</label> <input type="text" name="datdem" id="datdem" class="date" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['datdem'];?>
" readonly/>
							<label style="width:50px">Livré le</label> <input type="text" name="datliv" id="datliv" class="date" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['datliv'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?>/>
							<input type="radio" style="margin-left:10px" name="jrsliv" id="jrsliv1" value="AM" <?php if ($_smarty_tpl->tpl_vars['element']->value['jrsliv']=="AM") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> disabled <?php }?>><label for="jrsliv1" style="width:auto;">Matin &nbsp;</label>
							<input type="radio" style="margin-left:10px" name="jrsliv" id="jrsliv2" value="PM" <?php if ($_smarty_tpl->tpl_vars['element']->value['jrsliv']=="PM") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> disabled<?php }?>><label for="jrsliv2" style="width:auto;">Après-Midi &nbsp;</label>							
						</li>
						
						<li>
							<label style="width:70px">à</label>
							<input type="radio" name="lieliv" id="lieliv1" value="P" <?php if ($_smarty_tpl->tpl_vars['element']->value['lieliv']=="P") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> disabled <?php }?>><label for="lieliv1" style="width:auto;">Domicile &nbsp;</label>
							<input type="radio" name="lieliv" id="lieliv2" value="S" <?php if ($_smarty_tpl->tpl_vars['element']->value['lieliv']=="S") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> disabled <?php }?>><label for="lieliv2" style="width:auto;">HAD &nbsp;</label>
							<input type="radio" name="lieliv" id="lieliv3" value="A" <?php if ($_smarty_tpl->tpl_vars['element']->value['lieliv']=="A") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> disabled <?php }?>><label for="lieliv3" style="width:auto;">si Autre &nbsp;
							<input type="text" id="lielivaut" style="width:190px" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['lielivaut'];?>
"<?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?>/></label>
						</li>
						
						<li><label style="width:90px">Commentaire</label><input  type="text" id="com" name="com"  style="width:400px" maxlength="200" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['com'];?>
"<?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?>/></li>
						<li>
							<label style="width:105px">IDEL Formation</label>
							<input type="radio" name="formidel" id="formidel1" value="O" <?php if ($_smarty_tpl->tpl_vars['element']->value['formidel']=="O") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> disabled <?php }?>><label for="formidel1" style="width:auto;">Oui &nbsp;</label>
							<input type="radio" name="formidel" id="formidel2" value="N" <?php if ($_smarty_tpl->tpl_vars['element']->value['formidel']=="N") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> disabled <?php }?>><label for="formidel2" style="width:auto;">Non &nbsp;</label>
						</li>
						<li>
							<label style="width:75px; margin-left:35px">Contact</label><input  type="text" id="coordidel" name="coordidel" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['coordidel'];?>
" style="width:400px"<?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?>/>
						</li>
						<li>
							<label style="width:75px; margin-left:35px">Téléphone</label><input  type="text" id="telidel"  name="telidel" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['telidel'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?>/></li>
						</li>
					</ol>
				</fieldset>
			</div>
			<div class="droite"  style="width:350px" > 
				<fieldset>
					<ol>
						<input  type="hidden" class="mot" name="numpat" id="numpat" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['numpat'];?>
"/>
						<li><label style="width:90px">Rechercher </label><input  type="text" style="width:230px;" name="rech_patient_had" id="rech_patient_had" class="require" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['rech_patient_had'];?>
" placeholder="Saisir n° interne ou une partie du nom " <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?>/></li>
						<li><label style="width:90px">N°       </label><input  type="text" style="width:120px;" id="patient_ext_patient"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['ext_patient'];?>
"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Nom       </label><input  type="text" style="width:230px;" id="patient_lb_nom"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_nom'];?>
"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Adresse   </label><input  type="text" style="width:230px;" id="patient_lb_adresse"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_adresse'];?>
"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Code postal </label><input  type="text"style="width:45px;"  id="patient_lb_codepostal"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_codepostal'];?>
"    readonly tabindex="-1"/><input  type="text" style="width:180px;" id="patient_lb_ville"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_ville'];?>
"    readonly tabindex="-1"/></li>
						<li><label style="width:90px">Téléphone  </label><input  type="text" style="width:230px;" id="patient_lb_telephone"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_telephone'];?>
"    readonly tabindex="-1"/></li>
						<?php if (isset($_smarty_tpl->tpl_vars['patient_had']->value['nb_Commande'])) {?>
							<li><label style="width:90px">NB Commande  </label><input  type="text" style="width:230px;" id="patient_lb_nbCommande"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['nb_Commande'];?>
"    readonly tabindex="-1"/></li>
						<?php }?>
					</ol>
				</fieldset>
			</div>	
			<div class="h_5 separe"></div>
			<div>
				<fieldset>
				<div style="overflow-y:auto; height:12px; width:890px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
				<table>
							<thead>
								<th width='320'>Produit</th>				
								<th width='306'>Commentaire</th>				
								<th width='86'>Réf.</th>	
								<th width='82'>Qté cdée</th>	
								<th width='50'>Date</th>
							</thead>
						</table >
						</div>
					<div style="overflow-y:auto; height:370px; width:890px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
					<ol>
						
						<table>
		
							<tbody >
								<?php  $_smarty_tpl->tpl_vars['groupe'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['groupe']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['groupe']->key => $_smarty_tpl->tpl_vars['groupe']->value) {
$_smarty_tpl->tpl_vars['groupe']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['groupe']->key;
?>
									<tr id="tr_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" class="lig1">
										<td> <h4><?php echo $_smarty_tpl->tpl_vars['groupe']->value['lb_hierachie'];?>
 </h4> </td>
									</tr>
									<?php  $_smarty_tpl->tpl_vars['produit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produit']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupe']->value['produits']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produit']->key => $_smarty_tpl->tpl_vars['produit']->value) {
$_smarty_tpl->tpl_vars['produit']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['produit']->key;
?>	
										
										<?php if (isset($_POST['btn_suivant'])) {?>
										 	<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['quantite']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1>0) {?>
											 <tr>
											<?php } else { ?>
												<tr style="display:none;">
											<?php }?>
										<?php } else { ?>
											<tr>									
										<?php }?>
											<td style="width:360px;"><?php echo $_smarty_tpl->tpl_vars['produit']->value['lb_produit'];?>
</td>
												<td style="width:306px;"><input name="commentaire[<?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
]" class="sk_produit" type="text" value="<?php echo $_smarty_tpl->tpl_vars['commentaire']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']];?>
" style="width:300px " tabindex="-1" <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?>/></td>
												<td style="width:86px;"> <b><?php if ($_smarty_tpl->tpl_vars['produit']->value['sk_produit']>30||$_smarty_tpl->tpl_vars['produit']->value['sk_produit']<1) {?>
																			<?php echo smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['produit']->value['sk_produit'],'FKL55651','FKL5565'),'FKL55652','FKL5565'),'FKL33101','FKL3310'),'FKL33102','FKL3310'),'FKL33103','FKL3310');?>
 
																			<?php }?></b></td>				
												
												<td style="width:82px "><input name="quantite[<?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
]" class="sk_produit <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']==0) {?> spinner<?php }?>" type="text" value="<?php echo $_smarty_tpl->tpl_vars['quantite']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']];?>
" style="width:50px " tabindex="-1" <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> readonly <?php }?> /></td>
												<td style="width:50px "><?php if (isset($_smarty_tpl->tpl_vars['produit']->value['credat'])) {
echo $_smarty_tpl->tpl_vars['produit']->value['credat'];
}?></td>
											
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</ol>
					</div>
				</fieldset>
			</div>
		</div>
	
		<div class="h_20 separe"></div>
		
	
	</div>
	<?php if (isset($_POST['btn_suivant'])) {?>
		<span <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> hidden <?php }?>>
		<input name="btn_retour"  type="submit" class="boutton right" value="Retour" />
		</span>
	<?php } else { ?>
	<span <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> hidden <?php }?>>
		<input name="btn_suivant"  type="submit" class="boutton right" value="APERCU" />
		</span>
	<?php }?>
	<span <?php if ($_smarty_tpl->tpl_vars['element']->value['datfinhad']!=0) {?> hidden <?php }?>>
	<input name="btn_enregistrer"  type="submit" class="boutton right" value="ENREGISTRER" />
	</span>
	<input name="btn_annuler" type="submit" class="boutton left"  value="FERMER"  />
	<div class="h_20 separe"></div>
	
</form>


	<?php echo '<script'; ?>
>
		$('.spinner').spinner({min:0});

		$('#tabs').tabs({heightStyle: "auto", 
		});
		
		$('#rech_patient_had').autocomplete({
			source: '/boncdes/rech_patient_had',
			autoFocus: true,
			minLength: 2,
			select: function (event, ui) {	
				$('#patient_ext_patient').val(ui.item.ext_patient);				
				$('#numpat').val(ui.item.ext_patient);
				$('#patient_lb_nom').val(ui.item.lb_nom);
				$('#patient_lb_adresse').val(ui.item.lb_adresse);
				$('#patient_lb_ville').val(ui.item.lb_ville);
				$('#patient_lb_codepostal').val(ui.item.lb_codepostal);
				$('#patient_lb_telephone').val(ui.item.lb_telephone);
				$('#patient_lb_nbCommande').val(ui.item.nbCommande);
				<!-- S.SAURY le 10/05/2016 : verification de la présence d'un bon de commande chez le patient selectionné-->
				if (ui.item.nbCommande >= 1)
				{
					var answer = confirm("Voulez vous charger le dernier bon de commande du patient " + ui.item.lb_nom + " ?" );					
					if (answer)
					{
						window.location.href='/boncdes/modifier/'+ui.item.numcde;
					}
				}				
			}			
		}
		);
		
	<?php echo '</script'; ?>
>
	

<?php }} ?>
