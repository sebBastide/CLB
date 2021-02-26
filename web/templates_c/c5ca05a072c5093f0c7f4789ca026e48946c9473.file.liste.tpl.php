<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-14 08:46:39
         compiled from "/var/www/html/had/views/boncdes/liste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:995963427566a949fbd33d3-62573905%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5ca05a072c5093f0c7f4789ca026e48946c9473' => 
    array (
      0 => '/var/www/html/had/views/boncdes/liste.tpl',
      1 => 1450078995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '995963427566a949fbd33d3-62573905',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_566a949fc2af50_17979514',
  'variables' => 
  array (
    'client_had' => 0,
    'r_boncde_entete' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566a949fc2af50_17979514')) {function content_566a949fc2af50_17979514($_smarty_tpl) {?><h1>Extranet <?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_donneur_ordre'];?>
</h1>

<form name="recherche" class="form l150" method="post" action="/boncdes/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche des bons de commandes</legend>
		<div class="gauche">
			<ol>
				<li><label>N° de bon </label> <input type="text" style="width:200px" value="<?php echo $_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_numcde'];?>
" name="r_numcde" /></li>
				<li><label>N° de patient </label> <input type="text"   style="width:100px" value="<?php echo $_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_numpat'];?>
" name="r_numpat" /></li>
				<li><label>Nom du patient </label> <input type="text"  value="<?php echo $_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_lb_nom'];?>
" name="r_lb_nom" /></li>
			</ol>
		</div>
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 200px;">
					<option value="T" <?php if ($_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_statut']=="T") {?>selected<?php }?>>- Tous -</option>
					<option value="A" <?php if ($_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_statut']=="A") {?>selected<?php }?>>En cours</option>
					<option value="D" <?php if ($_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_statut']=="D") {?>selected<?php }?>>Hospitalisation</option>
					<option value="H" <?php if ($_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_statut']=="H") {?>selected<?php }?>>Fin HAD</option>
					
				</select></li>
				<li><label>Date de la demande</label> <input type="text" class="date" value="<?php echo $_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_datdem'];?>
" name="r_datdem" /></li>
				<li><label>Date de la livraison</label> <input type="text" class="date" value="<?php echo $_smarty_tpl->tpl_vars['r_boncde_entete']->value['r_datliv'];?>
" name="r_datliv" /></li>
			
			</ol>
		</div>
				
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER"> 
		<!-- <input name="btn_ajouter" style="float: right" class="boutton" type="button" value="AJOUTER" onclick="window.location='/boncdes/ajouter'" >
		-->
		<div class="separe"></div>

	</fieldset>

	<table id="tableau_resultat" class="display" style="color: black;">
		<thead>
			<tr>
				<th>Donneur d'ordre</th>
				<th>N° cde</th>
				<th>Date demande</th>
				<th>Patient</th>
				<th>Date livraison</th>
				<th>Date envoi mail</th>
				<th>Heure envoi mail</th>
				<th>Date fin HAD</th>
				<th>Statut</th>
			</tr>
		</thead>
	</table>

	</form>


<?php echo '<script'; ?>
 type="text/javascript">
var autreact = false;
var table = $('#tableau_resultat').dataTable( {
    "autoWidth" : true,
    "processing": true,
    "scrollY": "400px",
     "scrollCollapse": true,
 	"dom": 'C<"clear">RtiS',
    "deferRender":true,
    "scroller": {
          "loadingIndicator": true
      },
     "colReorder": {
          "fixedColumns": 1 ,      //colonnes non deplacables a droite
          "fixedColumnsRight": 1   //colonnes non deplacables a droite
                },
     "colVis": {
                    exclude: [0, 1]
                },
    "language": { "url": "/js/dataTables.french.lang" },
	 order : [[ 1 , 'desc' ]],
	"columns": [
	               {name:"B.sk_client", "visible":false},
				   {name:"numcde"},
	               {name:"datdem", className: "textecentre"},
				   {name:"lb_nom"},				   
				   {name:"datliv", className: "textecentre"},
				   {name:"datenvmail", className: "textecentre"},
				   {name:"hrsenvmail", className: "textecentre"},
				   {name:"B.datfinhad", className: "textecentre"},
	               {name:"B.statut" , "visible":false}
	             ],
     "ajax": "/boncdes/tableau_json",
     "serverSide": true,
   	 "stateSave":true       	 
	});	
	
	$('#tableau_resultat tbody').on('click', 'tr', function () {
			if ($(this).hasClass('selected')) {
				$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				data = table.fnGetData(this);
				numcde = data[1];
				datfinhad = data[7];
				statut = data[8];
				action(numcde, datfinhad, statut);
			}
	});

function activer(numcde){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment réactiver (retour d hospitalisation du patient) ce bon de commande n° '+numcde+' ?',
				     '/boncdes/activer/'+numcde,table);
				 }
function desactiver(numcde){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment désactiver (hospitalisation du patient) ce bon de commande n° '+numcde+' ?',
					 '/boncdes/desactiver/'+numcde,table);		 
	}
  function supprimer(numcde){
	autreact = true;
	confirm_url_ajax('Voulez-vous vraiment suppimer ce bon de commande n° '+numcde+' ?',
					 '/boncdes/supprimer/'+numcde,table);		 
	}     
function editer(numcde){
//appel fonction editer	 
	   autreact = true;
	   window.location.href='/boncdes/modifier/'+numcde;
}
function imprimer(numcde) {
			fenetre("/boncdes/imprimer/" + numcde, 1000, 800);
}
		
function action(numcde, datfinhad, statut) {
		//appel reactivation avec confirmation
		if (statut=='En cours'||statut=='Hospitalisation') chaine = '<a href="/boncdes/modifier/' + numcde + '"><img src="/img/pictos/edit.gif"> Modifier / Rajouter</a><br><br>';
		if (statut=='Fin HAD') chaine = '<a href="/boncdes/modifier/' + numcde + '"><img src="/img/pictos/edit.gif"> Visualiser</a><br><br>';
		if (statut=='En cours')	chaine +='<a href="#" onclick=desactiver("' + numcde + '");><img src="/img/pictos/hopital.jpg"> Hospitalisation </a><br><br>';
		if (statut=='Hospitalisation') chaine +='<a href="#" onclick=activer("' + numcde + '");><img src="/img/pictos/react.png"> Retour Hospitalisation </a><br><br>';		
		if (statut=='En cours')	chaine +='<a href="#" onclick=supprimer("' + numcde + '");><img src="/img/pictos/del.png"> Supprimer </a><br><br>';	
		if (statut=='En cours'||statut=='Fin HAD') chaine += '<a href="#" onclick=imprimer("' + numcde + '");><img src="/img/pictos/pdf.gif"> Imprimer le bon de commande</a><br><br>' 
		if (statut=='En cours'||statut=='Fin HAD') chaine += '<br><a href="/boncdes/mailbcde/' + numcde + '/0" onclick="$(\'#loader\').show();"><img src="/img/pictos/mail.png"> Valider commande</a><br><br><br>';
		if (!autreact)
			boite_menu("Bon de cde n° " + numcde, chaine);
		autreact = false;
}
<?php echo '</script'; ?>
>
<?php }} ?>
