<?php /* Smarty version Smarty-3.1.21-dev, created on 2021-03-24 09:11:56
         compiled from "/var/www/html/clb/views/templates/base.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1504836861603774df374576-28378309%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3649e2efddd6b8b30e27cd07ece3037d6a569472' => 
    array (
      0 => '/var/www/html/clb/views/templates/base.tpl',
      1 => 1616602315,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1504836861603774df374576-28378309',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_603774df3e6ba1_28491553',
  'variables' => 
  array (
    'titrepage' => 0,
    'css' => 0,
    'css1' => 0,
    'js' => 0,
    'js1' => 0,
    'imagefond' => 0,
    'imgpath' => 0,
    'sessioncoduti' => 0,
    'env' => 0,
    'listemenu' => 0,
    'message' => 0,
    'contenuPage' => 0,
    'debugs' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_603774df3e6ba1_28491553')) {function content_603774df3e6ba1_28491553($_smarty_tpl) {?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->tpl_vars['titrepage']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Css site -->
<?php  $_smarty_tpl->tpl_vars['css1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['css1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['css']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['css1']->key => $_smarty_tpl->tpl_vars['css1']->value) {
$_smarty_tpl->tpl_vars['css1']->_loop = true;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['css1']->value;?>
" />
<?php } ?>
<!-- Javascripts -->
<?php  $_smarty_tpl->tpl_vars['js1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js1']->key => $_smarty_tpl->tpl_vars['js1']->value) {
$_smarty_tpl->tpl_vars['js1']->_loop = true;
?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js1']->value;?>
"      ><?php echo '</script'; ?>
>
<?php } ?>

</head>

<body>
	<?php echo '<script'; ?>
>$('body').css("background-image","url('<?php echo $_smarty_tpl->tpl_vars['imagefond']->value;?>
')");<?php echo '</script'; ?>
>
	<div style="position:absolute;width:100%;height:100%;top:35%;left:37%;z-index:9999;display:none" id="loader" >
		<img src='/img/loading.gif'/>
	</div>
	<div id="zone_haut">
		<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td style="width:100px;"><<img src="<?php echo $_smarty_tpl->tpl_vars['imgpath']->value;?>
/charte/blcm-logo.jpg" alt="" /></td>
					<td style="width: 560px;">&nbsp;</td>
					<td style="text-align: right;" >
						<br>
						<?php if ($_smarty_tpl->tpl_vars['sessioncoduti']->value!='') {?>
						<a style="color:gray;" href="/login/logout">Se déconnecter</a>  (<?php echo $_smarty_tpl->tpl_vars['sessioncoduti']->value;?>
)
						<?php }?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php if ($_smarty_tpl->tpl_vars['env']->value!=='prod') {?>
			<p class="env-name">Environnement de <?php echo $_smarty_tpl->tpl_vars['env']->value;?>
</p>
		<?php }?>
	</div>
	<div id="zone_menu">
		<div class="centrer">
			<!--  menu de la page -->
			<?php echo $_smarty_tpl->tpl_vars['listemenu']->value;?>

		</div>
	</div>
	<div class="h_5 separe"></div>
	<?php $_smarty_tpl->tpl_vars['message'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '<div class="msg"></div>' : $tmp), null, 0);?>
	<?php echo $_smarty_tpl->tpl_vars['message']->value;?>

	<div class="contenu">
		<!--  contenu de la page -->
		<div class="separe"></div>
		<?php echo $_smarty_tpl->tpl_vars['contenuPage']->value;?>

	</div>
	<div class="separe"></div>
	<div id="zone_bas">
		<table style="width: 100%;" border="0" cellspacing="0" align="left">
			<tbody>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<br />
		<div class="separe"></div>
		<div><?php echo $_smarty_tpl->tpl_vars['debugs']->value;?>
</div>
	</div>
	<div id="dialog-confirm"></div>
</body>

<?php echo '<script'; ?>
 type="text/javascript" >
	(function($){
		$('#menu > ul').superfish({
			pathClass : 'overideThisToUse',
			delay : 200,
			animation : {
				height : 'show'
			},
			speed : 'normal',
			autoArrows : false,
			dropShadows : false,
			disableHI : false, /* set to true to disable hoverIntent detection */
			onInit : function() {
			},
			onBeforeShow : function() {
			},
			onShow : function() {
			},
			onHide : function() {
			}
		});
		$('#menu > ul').css('display', 'block');
	})(jQuery)
<?php echo '</script'; ?>
>
</html><?php }} ?>
