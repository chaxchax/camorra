<?php
ini_set('default_charset','iso-8859-1');
$dbhost = "koo2dzw5dy.database.windows.net";
$db = "SenaQuiz";
$user = "TSI@" . $dbhost;
$password = "SistemasInternet123";
$dsn = "Driver={SQL Server};Server=$dbhost;Port=1433;Database=$db;";

$db = odbc_connect($dsn, $user, $password);
?>