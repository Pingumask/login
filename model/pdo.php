<?php
require_once("../.env/database.php");
// On vérifie les données
try {
    $database = new PDO('mysql:host=' . DBHOST . ';port='. DBPORT .';dbname=' . DBNAME, DBUSER, DBPASSWORD);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->exec("SET NAMES 'utf8'");
}
catch(Exception $e)
{
    echo 'Erreur de connexion à la base de données !';
    var_dump($GLOBALS);
	die();
}