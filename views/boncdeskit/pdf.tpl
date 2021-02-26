<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{$titrepage}</title>
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
					<td style="width:73%" >	<img src="{$base_url}img/charte/blcm-logo.jpg" style="width:100px" alt=""/><br></td>
					<td style="width:25%" class="hc"><p class="large hr">le {$element.datdem } </p><br>	</td>
				</tr>
				<tr>
					<td  colspan="2" > <br/> </td>
				</tr>
				<tr>
					<td style="width:100%;height:18px" class="titre" colspan="3"> <strong>BON DE COMMANDE N° &nbsp;{$element.numcdekit}</strong> </td>
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
						<em>Donneur ordre : &nbsp;</em>{$client.lb_donneur_ordre}<br/><br/><br/>
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
						<em>N° :&nbsp;</em>{$patient.ext_patient}<br/> <br/>
						{$patient.lb_titre} {$patient.lb_nom}<br/>
						{$patient.lb_adresse}<br/>
						{$patient.lb_codepostal} &nbsp;{$patient.lb_ville}<br/><br/>
						<em>Téléphone :&nbsp;</em>{$patient.lb_telephone}<br/><br/>
					</td>
				</tr>
			</tbody>
		</table>
		<table style="width:100%">
			<tbody>
				<tr>
					<td style="width:100%" colspan="4" class="bb bl br bgg">
						<strong>Kit(s) commandé(s) le {$element.datdem } pour le {$element.datliv } </strong>
					</td>
				</tr>
				<tr>
					<td style="width:10%;height:30px"  class="hc bb bl br bt small">N° de produit</td>
					<td style="width:50%" class="hc bb bl br bt small">Dénomination du produit</td>
					<td style="width:10%"  class="hc bb bl br bt small">Composition kit/qté(s) produit(s)</td>
				</tr>
				{foreach $groupes as $k => $groupe}
					<tr>
						<td style="width:100%" colspan="4" class="bb bl br bgg">
							<strong>{$groupe.quantite} * {$groupe.hierarchie} </strong><br />
						</td>
					</tr>
					{foreach $groupe.produits as $produit}
						<tr>
							<td style="width:5%;height:20px" class="br bt bl bb small">   {$produit.sk_produit}</td>
							<td style="width:27%"            class="br bt bl bb small">   {$produit.lb_produit|escape}</td>
							<td style="width:6%"             class="br bt bl bb small hc">   {$produit.co_produit}</td>
						</tr>
					{/foreach}
				{/foreach}
				
				<tr>
					<td style="width:100%" colspan="4" class="bb bl br bgg">
						<strong>Produit(s) supplémentaire(s) commandé(s) le {$element.datdem } pour le {$element.datliv }</strong><br />
					</td>
				</tr>
				{foreach $pdtsup as $k => $produit}
					<tr>
						<td style="width:5%;height:20px" class="br bt bl bb small">   {$produit.sk_produit}</td>
						<td style="width:27%"            class="br bt bl bb small">   {$produit.lb_produit|escape} (composition : {$produit.co_produit})</td>
						<td style="width:6%"             class="br bt bl bb small hc">   {$produit.quantite}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</body>
</html>
