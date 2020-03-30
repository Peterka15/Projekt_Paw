<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
		<meta charset="utf-8" />
		<title>Kalkulator walutowy</title>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php" class="pure-button">kolejna chroniona strona</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

<div style="width:90%; margin: 2em auto;">

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
	<label for="id_x">Kwota w PLN: </label>
	<input id="id_x" type="text" name="x" value="<?php out($x); ?>" /><br />
	<label for="id_op">Waluta: </label>
	<select name="op">
		<option value="EUR">EUR</option>
		<option value="USD">USD</option>
		<option value="GBP">GBP</option>
		<option value="CHF">CHF</option>
	</select><br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #FA8072; width:300px;">
<?php echo 'Kwota w wybranej walucie: '.$result; ?>
</div>
<?php } ?>

</body>
</html>