<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$baza = 'moja_strona';

	$link = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$link) echo '<b>przerwane po��czenia</b>';
	if (!mysql_select_db($baza)) echo 'nie wybarno bazy';
?>
