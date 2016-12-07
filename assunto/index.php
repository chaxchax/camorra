<?php
//INICIAR A SESSÃO//
session_start();

//INTEGRAÇÃO//
include('../integracao/loginFunc.php');
lidaBasicAuthentication ('../../portal/naoautorizado.php');

//CONEXÃO BANCO DE DADOS//
include('../db/db.php');

//CONTROLE DE ACESSO//
if(!isset($_SESSION['codProfessor']) || !@is_numeric($_SESSION['codProfessor'])){
  echo "<br><center>Acesso Negado!</center>";
  exit();
}


//Código para a tag select da área
$pesquisaSelect = odbc_exec($db, 'SELECT codArea, descricao FROM Area');
while ($resultado = odbc_fetch_array($pesquisaSelect)) {
  $selectAreas[$resultado['codArea']] = htmlentities($resultado['descricao']);
}


// Inserir assunto  =============================================================================
if(isset($_POST['inserir'])){
  $assunto = str_replace(';', '', str_replace("'", '', str_replace('"', '', $_POST['assunto'])));

  /*  if(odbc_exec($db,"INSERT INTO Assunto (descricao, codArea) VALUES ('$assunto')","")){
        $msg = 'Assunto: '.$assunto.', inserida com sucesso';
    } else {
        $erro = 'ERRO: Não foi possível inserir '.$assunto;
    }
  } */

  if (!array_key_exists($_POST['area'], $selectAreas)) {
    $erro = 'ERRO: N&atilde;o foi poss&iacute;vel inserir Assunto, a &Aacute;rea informada n&atilde;o existe '.$selectAreas[$_POST['area']];
  } else {
    $area = $_POST['area'];

    $statement = odbc_prepare($db, 'INSERT INTO Assunto (descricao, codArea) VALUES (?, ?)');
    if (@odbc_execute($statement, array($_POST['assunto'], $_POST['area']))) {
      $msg = "Assunto $assunto inserido com sucesso";
    } else {
      $erro = "ERRO: N&atilde;o foi poss&iacute;vel inserir o Assunto $assunto";
    }
  }
}


//Apagar "Assunto"
if (isset($_GET['dcod'])) {
  if (is_numeric($_GET['dcod'])) {
    $verificarQuestao = @odbc_exec($db, ' SELECT codAssunto FROM QUESTAO WHERE codAssunto =' . $_GET['dcod']);

    if (odbc_num_rows($verificarQuestao) > 0) {
      $erro = 'ERRO: Existe Quest&atilde;o relacionado a este Assunto';

    } else if (!odbc_exec($db, ' DELETE FROM Assunto WHERE codAssunto =' .$_GET['dcod'])) {
      $erro = "ERRO: Problema ao apagar o registro";
    } else {
      $msg = "Registro apagado com sucesso";
    }
  }  else {
    $erro = "ERRO: C&oacute;digo Inv&aacute;lido";

  }
}


//Update após receber os dados de form para editar

if (isset($_POST['editado'])) {
  if (is_numeric($_POST['ecod'])) {
    $assunto = str_replace(';', '', str_replace("'", '', str_replace('"', '', $_POST['assunto'])));
        //Validação
    if (!array_key_exists($_POST['area'], $selectAreas)) {
      $erro = 'ERRO: N&atilde;o existe a &Aacute;rea '.$selectAreas[$_POST['area']];
    }
    $area = $_POST['area'];
        //Alteração
    if (odbc_exec($db, "UPDATE 
      Assunto 
      SET descricao = '$assunto', 
      codArea = '$area' 
      WHERE codAssunto = {$_POST['ecod']}")) {
      $msg = "Assunto $assunto atualizado com sucesso";
  } else {
    $erro = "ERRO: N&atilde;o foi poss&iacute;vel atualizar Assunto $assunto";
  }
} else {
  $erro = "ERRO: N&atilde;o foi poss&iacute;vel atualizar $assunto, C&oacute;digo Inv&aacute;lido";
}
}

//Form para Editar
else if (isset($_GET['ecod']) && is_numeric($_GET['ecod']) && !isset($_POST['inserir'])) {
  $query = odbc_exec($db, 'SELECT codAssunto, codArea, descricao FROM Assunto WHERE codAssunto =' .$_GET['ecod']);

  $result = odbc_fetch_array($query);
  $codArea = $result['codArea'];
  $cod_assunto = $result['codAssunto'];
  $assunto = $result['descricao'];

  include 'templates/index_edit_tpl.php';
  exit();
}


//Lista todos os itens da tabela "Assunto"
if (isset($_GET['qtdRegistro'])) {
  $registros = $_GET['qtdRegistro'];
} else {
  $registros = 10;
}
$query = odbc_exec($db, "SELECT count(*) AS total FROM Assunto");
$result = odbc_fetch_array($query);
$totalRegistros = $result['total'];
$totalPaginas = ceil($totalRegistros / $registros);
if (isset($_GET['numPagina'])) {
  $paginaSolicitada = $_GET['numPagina'];
} else {
  $paginaSolicitada = 1;
}
$offset = ($paginaSolicitada * $registros) - $registros;


//ORDENAÇÃO 
if(isset($_GET['ordenacao'])){
    $_SESSION['ordenacao'] = $_GET['ordenacao'];
}
$ordenacao = isset($_SESSION['ordenacao']) ? $_SESSION['ordenacao'] : '';
switch ($ordenacao) {
case 0:
    $ordenacao = "ORDER BY codAssunto DESC";
break;
case 1:
    $ordenacao = "ORDER BY codAssunto ASC";
    break;
case 2:
    $ordenacao = "ORDER BY descricao";
    break;
case 3:
    $ordenacao = "ORDER BY descricao DESC";
    break;
}

$query = odbc_exec($db, "SELECT codAssunto, descricao, codArea FROM Assunto $ordenacao OFFSET $offset ROWS FETCH NEXT $registros ROWS ONLY");

while ($result = odbc_fetch_array($query)) {
  $listarAssuntos[$result['codAssunto']] = htmlentities($result['descricao']);
  $listarAreas = odbc_fetch_array(odbc_exec($db, ' SELECT descricao FROM Area WHERE codArea='.$result['codArea']));
  $areas[$result['codAssunto']] = htmlentities($listarAreas['descricao']);
}


include 'templates/index_tpl.php';

?>