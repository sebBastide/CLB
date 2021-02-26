<div id="bloc_identification" style="width:550px;">
	<form name="login_rapide" class="form" method="post" action="/login/initmdp_conf/{$element.codrei}">
		<h4>Merci de préciser ci-dessous :</h4>
		<table cellpadding="0" cellspacing="5" width="100%">
			<tr>
				<td>Votre identifiant </td>
				<td>:</td>
				<td><input class="input" type="text" name="coduti" style="width: 170px;" value="{$element.coduti}" readonly/></td>
			</tr>
			<tr>
				<td>Nouveau mot de passe</td>
				<td>:</td>
				<td><input class="input" type="password" name="mdp1" maxlength=20 style="width: 170px;"  /></td>
			</tr>
			<tr>
				<td>Confirmer le mot de passe</td>
				<td>:</td>
				<td><input class="input" type="password" name="mdp2" maxlength=20 style="width: 170px;" /></td>
			</tr>
		</table>
		<div class="h_5"></div>
		<center>
			<input class="boutton" type="submit" name="btp_enregistrer" value="ENREGISTRER" />
		</center>
		<br />
		<br />
	</form>
</div>