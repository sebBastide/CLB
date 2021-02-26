<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-12-14 13:30:13
         compiled from "/var/www/html/had/views/bonrmat/liste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1186776103566a94a38ea405-12268318%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad6200fa3bc224f4ddd255241d2f56a90962a09e' => 
    array (
      0 => '/var/www/html/had/views/bonrmat/liste.tpl',
      1 => 1450078995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1186776103566a94a38ea405-12268318',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_566a94a39417e6_27958826',
  'variables' => 
  array (
    'client_had' => 0,
    'r_bonrec_materiel' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_566a94a39417e6_27958826')) {function content_566a94a39417e6_27958826($_smarty_tpl) {?><h1>Extranet <?php echo $_smarty_tpl->tpl_vars['client_had']->value['lb_donneur_ordre'];?>
</h1>

<form name="recherche" class="form l150" method="post" action="/bonrmat/liste">
	<fieldset class="bloc_recherche">
		<legend>Recherche des bons de récupérations matériels</legend>
		<div class="gauche">
			<ol>
				<li><label>N° de bon </label> <input type="text" style="width:200px" value="<?php echo $_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_numbrmat'];?>
" name="r_nom" /></li>
				<li><label>N° de patient </label> <input type="text"   style="width:100px" value="<?php echo $_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_numpat'];?>
" name="r_numpat" /></li>
				<li><label>Nom du patient </label> <input type="text"  value="<?php echo $_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_lb_nom'];?>
" name="r_lb_nom" /></li>
				
			</ol>
		</div>
		<div class="droite">
			<ol>
				<li><label>Statut </label> <select name="r_statut" style="width: 200px;">
					<option value="T" <?php if ($_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_statut']=="T") {?>selected<?php }?>>- Tous -</option>
					<option value="A" <?php if ($_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_statut']=="A") {?>selected<?php }?>>En cours</option>
					<option value="D" <?php if ($_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_statut']=="D") {?>selected<?php }?>>Supprimés</option>
					<option value="H" <?php if ($_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_statut']=="H") {?>selected<?php }?>>Fin HAD</option>
				</select></li>
				<li><label>Date de la demande</label> <input type="text" class="date" value="<?php echo $_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_datdem'];?>
" name="r_datdem" /></li>
				<li><label>Date de la récupération</label> <input type="text" class="date" value="<?php echo $_smarty_tpl->tpl_vars['r_bonrec_materiel']->value['r_datrec'];?>
" name="r_datrec" /></li>
			</ol>
		</div>
				
		<div class="separe h_20"></div>
		<input name="btn_recherche" class="boutton" type="submit" value="RECHERCHER">
		<div class="separe"></div>

	</fieldset>

	<table id="tableau_resultat" class="display" style="color: black;">
		<thead>
			<tr>
				<th>Donneur d'ordre</th>
				<th>N° bon</th>
				<th>Date demande</th>
				<th>Patient</th>
				<th>Date récupération</th>
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
          "fixedColumnsRight": 3  //colonnes non deplacables a droite
                },
     "colVis": {
                    exclude: [0, 1, 8, 9, 10]
                },
    "language": { "url": "/js/dataTables.french.lang" },
	"columns": [
	               {name:"B.sk_client", "visible":false},
				   {name:"numbrmat"},
	               {name:"datdem", className: "textecentre"},
				   {name:"lb_nom"},
				   {name:"datrec", className: "textecentre"},
				   {name:"datenvmail", className: "textecentre"},
				   {name:"hrsenvmail", className: "textecentre"},
				   {name:"datfinhad", className: "textecentre"},
	               {name:"B.statut" , "visible":false}
	             ],
     "ajax": "/bonrmat/tableau_json",
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
				numbrmat =  data[1];
				datfinhad = data[7];
				statut = data[8];
				action(numbrmat, datfinhad, statut);
			}
});
function activer(numbrmat){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment réactiver ce bon de récupération matériel n° '+numbrmat+' ?',
				     '/bonrmat/activer/'+numbrmat,table);
				 }
function desactiver(numbrmat){
	//appel suppression avec confirmation
	confirm_url_ajax('Voulez-vous vraiment supprimer ce bon de récupération matériel n° '+numbrmat+' ?',
					 '/bonrmat/desactiver/'+numbrmat,table);
			 
	}
       
function editer(numbrmat){
//appel fonction editer	   
	   window.location.href='/bonrmat/modifier/'+numbrmat;
}

function action(numbrmat, datfinhad, statut) {
		//appel reactivation avec confirmation
		if (datfinhad==0) chaine = '<a href="/bonrmat/modifier/' + numbrmat + '"><img src="/img/pictos/edit.gif"> Modifier / Rajouter</a><br><br>';
		if (datfinhad!=0) chaine = '<a href="/bonrmat/modifier/' + numbrmat + '"><img src="/img/pictos/edit.gif"> Visualiser</a><br><br>';
		if (statut=='A') chaine +='<a href="#" onclick=desactiver("' + numbrmat + '");><img src="/img/pictos/del.png"> Supprimer </a><br><br>';
		if (statut=='D') chaine +='<a href="#" onclick=activer("' + numbrmat + '");><img src="/img/pictos/react.png"> Réactiver </a><br><br>';		
		chaine += '<br><a href="/bonrmat/mailbrmat/' + numbrmat + '/0" onclick="$(\'#loader\').show();"><img src="/img/pictos/mail.png"> Valider bon</a><br><br><br>';
		if (!autreact)
			boite_menu("Bon récup. matériel " + numbrmat, chaine);
		autreact = false;
}
<?php echo '</script'; ?>
>
<?php }} ?>
