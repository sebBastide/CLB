<?php

// La variable de connexion est accessible dans tous les scopes par le tableau GLOBALS['connsql']
global $connsql;
try {
	$hostname = DB_HOST_SQL; // host
	$dbname = DB_BDE_SQL; // db name
	$username = DB_USER_SQL; // username like 'sa'
	$pw = DB_PASS_SQL; // password for the user
	$connsql = new PDO("mysql:host=$hostname;dbname=$dbname; charset=utf8", "$username", "$pw");
} catch (PDOException $e) {
	echo "Echec de connexion a la base SQL : " . $e->getMessage() . "\n";
	exit();
}
