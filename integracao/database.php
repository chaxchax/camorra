<?php

function conn () {
	$user = "TSI@koo2dzw5dy.database.windows.net";
	$pass = "SistemasInternet123";
	$database = "SenaQuiz";
	$dsn = "Driver={SQL Server};Server=koo2dzw5dy.database.windows.net;Port=1433;Database=$database;";
	//$cx = odbc_connect($dsn,$user,$pass);
	$hostname = "koo2dzw5dy.database.windows.net";
	$port = 1433;
	$cx = new PDO ("sqlsrv:Server=$hostname,$port;Database=$database",$user,$pass);
	$cx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $cx;
}

?>

