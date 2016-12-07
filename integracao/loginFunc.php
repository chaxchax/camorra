<?php
include 'database.php';
function confereLogin ($email, $pass) {
	$cx = conn ();
	$stmt = $cx->prepare("select * from Professor where email = :email AND convert (varchar(64),Professor.senha,2) = :pass");
	$pass= sha1($pass,false);
	$pass = strtoupper ($pass);
	$stmt->bindValue(':email', $email,PDO::PARAM_STR);
	$stmt->bindValue(':pass', $pass,PDO::PARAM_STR );
	$ret = $stmt->execute();
	foreach ($stmt as $row) {
		$_SESSION["showMenu"] = FALSE;
		$_SESSION["nomeProfessor"] = $row["nome"];
		$_SESSION["tipoProfessor"] = $row["tipo"];
		$_SESSION["codProfessor"] = $row["codProfessor"];
		return true;
	}
	return false;
}

function lidaBasicAuthentication ($naoautorizado=null) {
	if (!isset($_GET['hideMenu']))
		return;
	$na = null;
	if (isset ($naoautorizado)){
		$na = $naoautorizado;
	} else
		$na = 'naoautorizado.php';
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		header('WWW-Authenticate: Basic realm="SenaQuiz"');
		header('HTTP/1.0 401 Unauthorized');
		echo '<script> document.location="'.$na.'";</script>';
		exit;
	} else {
		if (!confereLogin ($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])) {
			header('WWW-Authenticate: Basic realm="SenaQuiz"');
			header('HTTP/1.0 401 Unauthorized');
			echo '<script> document.location="'.$na.'";</script>';
			exit;
		} 		
	}
}



function testaLogin () {
	session_start();
	if ($_SESSION["logado"]!=TRUE)
		header('Location: '.$uri.'/pi/piloto/index.php');
}

?>

