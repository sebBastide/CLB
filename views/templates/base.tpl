<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$titrepage}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Css site -->
{foreach $css as $css1}
<link rel="stylesheet" type="text/css" href="{$css1}" />
{/foreach}
<!-- Javascripts -->
{foreach $js as $js1}
<script type="text/javascript" src="{$js1}"      ></script>
{/foreach}

</head>

<body>
	<script>$('body').css("background-image","url('{$imagefond}')");</script>
	<div style="position:absolute;width:100%;height:100%;top:35%;left:37%;z-index:9999;display:none" id="loader" >
		<img src='/img/loading.gif'/>
	</div>
	<div id="zone_haut">
		<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td style="width:100px;"><<img src="{$imgpath}/charte/blcm-logo.jpg" alt="" /></td>
					<td style="width: 560px;">&nbsp;</td>
					<td style="text-align: right;" >
						<br>
						{if $sessioncoduti NE ''}
						<a style="color:gray;" href="/login/logout">Se déconnecter</a>  ({$sessioncoduti})
						{/if}
					</td>
				</tr>
			</tbody>
		</table>
		{if $env !== 'prod'}
			<p class="env-name">Environnement de {$env}</p>
		{/if}
	</div>
	<div id="zone_menu">
		<div class="centrer">
			<!--  menu de la page -->
			{$listemenu}
		</div>
	</div>
	<div class="h_5 separe"></div>
	{assign var='message' value=$message|default:'<div class="msg"></div>'}
	{$message}
	<div class="contenu">
		<!--  contenu de la page -->
		<div class="separe"></div>
		{$contenuPage}
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
		<div>{$debugs}</div>
	</div>
	<div id="dialog-confirm"></div>
</body>
{literal}
<script type="text/javascript" >
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
</script>
{/literal}</html>