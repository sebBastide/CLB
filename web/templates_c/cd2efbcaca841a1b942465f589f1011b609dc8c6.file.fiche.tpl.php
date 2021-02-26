<?php /* Smarty version Smarty-3.1.21-dev, created on 2019-11-04 12:05:53
         compiled from "/var/www/html/had/views/bonrmat/fiche.tpl" */ ?>
<?php /*%%SmartyHeaderCode:121904745556014e154b6b17-69671546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cd2efbcaca841a1b942465f589f1011b609dc8c6' => 
    array (
      0 => '/var/www/html/had/views/bonrmat/fiche.tpl',
      1 => 1572865163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121904745556014e154b6b17-69671546',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56014e15668ad7_97142903',
  'variables' => 
  array (
    'client_had' => 0,
    'element' => 0,
    'raisons' => 0,
    'raison' => 0,
    'patient_had' => 0,
    'groupes' => 0,
    'k' => 0,
    'groupe' => 0,
    'p' => 0,
    'produit' => 0,
    'arecup' => 0,
    'coche' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56014e15668ad7_97142903')) {function content_56014e15668ad7_97142903($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/html/had/core/smarty/plugins/modifier.replace.php';
?><h1>Extranet <?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_donneur_ordre'];?>
</h1>

<form name="editer" method="post" action="/bonrmat/enregistrer">
	
	<input type="hidden" name="hide_numbrmat" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['hide_numbrmat'];?>
" />
	<input type="hidden" name="hide_datfinhad" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['hide_datfinhad'];?>
" />
	<input type="hidden" name="numbrmat" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['numbrmat'];?>
" />
	
	<div id="tabs" class="form" style="height:700px">
		<ul>
			<li><a href="#tabs-1">Bon de récupération matériel N° <?php echo $_smarty_tpl->tpl_vars['element']->value['numbrmat'];?>
</a></li>			
		</ul>

		<div id="tabs-1" class="form_editer">
			<div> 
				<fieldset>
					<ol>	
						<li>
							<label style="width:100px">Demande le</label> <input type="text" name="datdem" id="datdem" class="date" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['datdem'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?> />
							<label style="margin-left:210px; width:150px">Nom demandeur</label><input type="text" style="width:300px" name="nomdem" id="nomdem"  value="<?php echo $_smarty_tpl->tpl_vars['element']->value['nomdem'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>/>
						</li>
						<li> <label style="width:100px">Fin HAD le</label> <input type="text" name="datfinhad" id="datfinhad" class="date" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['datfinhad'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>/>
							<label style="margin-left:20px; width:130px">Raison fin HAD</label>
							<select name="raifinhad" id="raifinhad" style="width:250px" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>>
							<option value="" >- Sélectionnez une raison -</option>
							<?php  $_smarty_tpl->tpl_vars['raison'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['raison']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['raisons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['raison']->key => $_smarty_tpl->tpl_vars['raison']->value) {
$_smarty_tpl->tpl_vars['raison']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['raison']->value['codrai'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['raifinhad']==$_smarty_tpl->tpl_vars['raison']->value['codrai']) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['raison']->value['librai'];?>
 </option>
							<?php } ?>
							</select>
							<label style="margin-left:20px; width:125px">Passage SAD le</label> <input type="text" name="passsad" id="passsad" class="date" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['passsad'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>/>
						</li>
						
						<div class="h_5 separe"></div>						
						<fieldset>
							<legend> Demande de récupération de matériel / déchet</legend>
								<li>
									<input type="checkbox" name="r_materiel"  id="r_materiel" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_materiel']=="O") {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>/>  <label style="width:100px" >Matériels</label> 
									<input type="checkbox" name="r_dossoins"  id="r_dossoins" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_dossoins']=="O") {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>/> <label style="width:120px" >Dossier de soins</label> 
									<input type="checkbox" name="r_malchimio" id="r_malchimio" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_malchimio']=="O") {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>/> <label style="width:150px" >Malette chimiothèrapie</label> 
									<input type="checkbox" name="r_conso"     id="r_conso" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_conso']=="O") {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>/> <label style="width:120px" >Consommables</label> 
									<input type="checkbox" name="r_medic"     id="r_medic" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_medic']=="O") {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>/> <label style="width:120px" >Médicaments</label> 
									<input type="checkbox" name="r_dechet"     id="r_dechet" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_dechet']=="O") {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>/> <label style="width:100px" >Déchets</label> 
								</li>
						</fieldset>
						<div class="h_5 separe"></div>
						<label style="width:125px">A effectuer le</label> <input type="text" name="datrec" id="datrec" class="date" maxlength="50" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['datrec'];?>
" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>/>
							<input type="radio" style="margin-left:75px" name="jrsrec" id="jrsrec1" value="AM" <?php if ($_smarty_tpl->tpl_vars['element']->value['jrsrec']=="AM") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="jrsrec1" style="width:auto;">Matin &nbsp;</label>
							<input type="radio" style="margin-left:10px" name="jrsrec" id="jrsrec2" value="PM" <?php if ($_smarty_tpl->tpl_vars['element']->value['jrsrec']=="PM") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="jrsrec2" style="width:auto;">Après-Midi &nbsp;</label>							
							<input type="radio" style="margin-left:10px" name="jrsrec" id="jrsrec3" value="DJ" <?php if ($_smarty_tpl->tpl_vars['element']->value['jrsrec']=="DJ") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="jrsrec3" style="width:auto;">Dans la journée &nbsp;</label>							
						</li>
						<div class="h_5 separe"></div>	
						<fieldset>
							<legend> Patient n° <?php echo $_smarty_tpl->tpl_vars['patient_had']->value['ext_patient'];?>
 - né le <?php echo $_smarty_tpl->tpl_vars['patient_had']->value['dt_naissance'];?>
 </legend>
							<div class="gauche" style="width:450px" > 
								<li>
									<input  type="hidden" class="mot" name="numpat" id="numpat" value="<?php echo $_smarty_tpl->tpl_vars['element']->value['numpat'];?>
"/>
									<label style="width:120px">Nom/prénom</label><input  type="text" style="width:290px;" id="patient_lb_nom"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_nom'];?>
"    readonly tabindex="-1"/>
								</li>
								<li>
									<label style="width:120px">Adresse</label><input  type="text" style="width:290px;" id="patient_lb_adresse"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_adresse'];?>
"    readonly tabindex="-1"/>
								</li>
								<li>
									<label style="width:120px">Code postal/ville</label><input  type="text"style="width:50px;"  id="patient_lb_codepostal"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_codepostal'];?>
"    readonly tabindex="-1"/>
									<input  type="text" style="width:180px;" id="patient_lb_ville"  value="<?php echo $_smarty_tpl->tpl_vars['patient_had']->value['lb_ville'];?>
"    readonly tabindex="-1"/>
								</li>
							</div>
							
							<div class="droite" style="width:430px" > 
								<fieldset style="height:100px;">
									<legend>Autres coordonnées</legend>	
									<li> <textarea name="lierecaut" id="lierecaut" maxlength="500" style="height:70px; width:400px" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>><?php echo $_smarty_tpl->tpl_vars['element']->value['lierecaut'];?>
</textarea></li>	
								</fieldset>
							</div>
							
						<!--	<li>
								<input type="radio" name="r_maison" id="r_maison1" value="O" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_maison']=="O") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="r_maison1" style="width:auto;">Maison &nbsp;</label>
								<input type="radio" name="r_maison" id="r_maison2" value="N" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_maison']=="N") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="r_maison2" style="width:auto;">Appartement &nbsp;</label>
								<input type="radio" name="r_maison" id="r_maison3" value="M" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_maison']=="M") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="r_maison3" style="width:auto;">HAD &nbsp;</label>

								<input  style="margin-left:50px;" type="radio" name="r_rdc" id="r_rdc1" value="O" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_rdc']=="O") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="r_rdc1" style="width:auto;">RDC &nbsp;</label>
								<input type="radio" name="r_rdc" id="r_rdc2" value="N" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_rdc']=="N") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="r_rdc2" style="width:auto;">Etage &nbsp;</label>

								<label style="margin-left:100px; width:150px">Ascenseur</label>
								<input type="radio" name="r_ascen" id="r_ascen1" value="O" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_ascen']=="O") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="r_ascen1" style="width:auto;">Oui &nbsp;</label>
								<input type="radio" name="r_ascen" id="r_ascen2" value="N" <?php if ($_smarty_tpl->tpl_vars['element']->value['r_ascen']=="N") {?> checked <?php }
if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>><label for="r_ascen2" style="width:auto;">Non &nbsp;</label>
							</li>-->
						</fieldset>
						<div class="h_5 separe"></div>						
						
						<div>
							<div class="gauche" style="width:450px" > 
								<fieldset style="height:260px;" >
									<legend>Produits</legend>
										<fieldset>
											<div style="overflow-y:auto; height:150px; width:400px; color:black;padding:5px 5px 5px 5px; border:0px solid; BORDER-TOP-COLOR: #000000; BORDER-LEFT-COLOR: #000000; BORDER-RIGHT-COLOR: #000000;BORDER-BOTTOM-COLOR: #000000;">
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
																<input type="hidden" name="groupes[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
][lb_hierachie]" value="<?php echo $_smarty_tpl->tpl_vars['groupe']->value['lb_hierachie'];?>
"<?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?> />
																<td> <h4><?php echo $_smarty_tpl->tpl_vars['groupe']->value['lb_hierachie'];?>
 </h4> </td>
															</tr>
															<?php  $_smarty_tpl->tpl_vars['produit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['produit']->_loop = false;
 $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupe']->value['produits']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['produit']->key => $_smarty_tpl->tpl_vars['produit']->value) {
$_smarty_tpl->tpl_vars['produit']->_loop = true;
 $_smarty_tpl->tpl_vars['p']->value = $_smarty_tpl->tpl_vars['produit']->key;
?>	
																<tr>																
																	<input type="hidden" name="groupes[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
][produits][<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
][lb_produit]" value="<?php echo $_smarty_tpl->tpl_vars['produit']->value['lb_produit'];?>
" />
																	<input type="hidden" name="groupes[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
][produits][<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
][sk_produit]" value="<?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
" />
																	<input type="hidden" name="acde[<?php echo $_smarty_tpl->tpl_vars['produit']->value['sk_produit'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['produit']->value['numcde'];?>
" />																			
																	
																	<td style="width:250px; padding-left:10px; size:8px;"><?php echo $_smarty_tpl->tpl_vars['produit']->value['lb_produit'];?>
</td>
																	<td style="width:100px "> <b><?php echo smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['produit']->value['sk_produit'],'FKL55651','FKL5565'),'FKL55652','FKL5565'),'FKL33101','FKL3310'),'FKL33102','FKL3310'),'FKL33103','FKL3310');?>
  </b></td>																		
																	
																	<!--<?php $_smarty_tpl->tpl_vars['coche'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['arecup']->value[$_smarty_tpl->tpl_vars['produit']->value['sk_produit']])===null||$tmp==='' ? 'off' : $tmp), null, 0);?>-->
																	<?php $_smarty_tpl->tpl_vars['coche'] = new Smarty_variable(1, null, 0);?>
																	<td><input type="checkbox" name="arecup[<?php echo $_smarty_tpl->tpl_vars['produit']->value['produitCommande'];?>
]" class="sk_produit cocher" style="width:50px " tabindex="-1" <?php if ($_smarty_tpl->tpl_vars['coche']->value==1) {?> checked <?php }?> <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> disabled <?php }?>/></td>
																</tr>
															<?php } ?>
														<?php } ?>
													</tbody>
												</table>
											</ol>
											</div>
										</fieldset>
									<label style="width:130px" > Autres (à préciser)</label> 
									<li> <textarea name="r_autre" id="r_autre" maxlength="500"  style="height:30px; width:420px"<?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>> <?php echo $_smarty_tpl->tpl_vars['element']->value['r_autre'];?>
</textarea></li>	
								</fieldset>
								
							</div>
							<div class="droite" style="width:450px" > 
								<fieldset style="height:260px;">
									<legend>Commentaires</legend>
											<li> <label>Divers</label></li>
											<li> <textarea name="com_div" id="com_div" maxlength="500" style="height:70px; width:420px" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>><?php echo $_smarty_tpl->tpl_vars['element']->value['com_div'];?>
</textarea></li>	
											<li> <label>Interne</label></li>
											<li> <textarea name="com_int" id="com_int" maxlength="500" style="height:70px; width:420px" <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> readonly <?php }?>><?php echo $_smarty_tpl->tpl_vars['element']->value['com_int'];?>
</textarea></li>	
								</fieldset>
							</div>
						</div>
						<div class="h_5 separe"></div>
					</ol>
				</fieldset>
			</div>
			<div class="h_5 separe"></div>
		</div>
	
		<div class="h_20 separe"></div>	
	</div>
	<span <?php if ($_smarty_tpl->tpl_vars['element']->value['hide_datfinhad']!=0) {?> hidden <?php }?>>
		<input name="btn_enregistrer" type="submit" class="boutton right" value="ENREGISTRER" onClick="verif();"/>
	</span>
	<input name="btn_annuler" type="submit" class="boutton left"  value="FERMER"  />
	<div class="h_20 separe"></div>

</form>

	<?php echo '<script'; ?>
 type="text/javascript">
		$('#tabs').tabs({heightStyle: "auto", 
		});	
		
		function finhad() {
			$('.cocher').attr('checked', true);
		}
	
	<?php echo '</script'; ?>
>

<?php }} ?>
