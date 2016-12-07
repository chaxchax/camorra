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

$msg = "";
$erro = "";

//Update após receber os dados de form para editar
if (isset($_POST['editado'])) {
    if (is_numeric($_POST['ecod'])) {
        $updateProfessor = odbc_prepare($db, "           UPDATE
          Professor
          SET
          nome = ?,
          email = ?,
          idSenac = ?,
          senha = ?,
          tipo = ?
          WHERE
          codProfessor = {$_POST['ecod']}");
    }
    if (odbc_execute($updateProfessor, array(
        $_POST['nome_professor'],
        $_POST['email_professor'],
        $_POST['idsenac_professor'],
        "HASHBYTES('SHA1', {$_POST['senha_professor']})",
        $_POST['tipo_professor']
        ))) {
        $msg = 'Professor atualizado com sucesso';
} else {
    $erro = 'ERRO: N&atilde;o foi poss&iacute;vel atualizar';
}
} else if (isset($_GET['ecod']) && is_numeric($_GET['ecod']) && !isset($_POST['inserir'])) {
    $query = odbc_exec($db, 'SELECT codProfessor, nome, email, idSenac, senha, tipo FROM Professor WHERE codProfessor =' . $_GET['ecod']);

    $result = odbc_fetch_array($query);
    $cod_professor = $result['codProfessor'];
    $nome_professor = $result['nome'];
    $email_professor = $result['email'];
    $idsenac_professor = $result['idSenac'];
    $senha_professor = $result['senha'];
    $tipo_professor = $result['tipo'];

    include 'templates/index_edit_tpl.php';
    exit();
}


//Apagar Professor
if (isset($_GET['dcod'])) {
    if($_SESSION['tipoProfessor'] != 'A'){
        $erro = "Voc&ecirc; n&atilde;o tem permiss&atilde;o para apagar Professores";
    } else {

        if (is_numeric($_GET['dcod'])) {
            if (!odbc_exec($db, 'DELETE FROM Professor WHERE codProfessor =' . $_GET['dcod'])) {
                $erro = 'ERRO: Problema ao apagar o registro';
            } else {
                $msg = 'Registro apagado com sucesso';
            }
        } else {
            $erro = 'ERRO: C&oacute;digo Inv&aacute;lido';
        }
    }
}

//INSERIR PROFESSOR
if (isset($_POST['inserir'])) {
    if ($_SESSION['tipoProfessor'] != 'A'){
        $erro = "ERRO: Voc&ecirc; n&atilde;o tem permiss&atilde;o para adicionar outros professores";
    } else {
        $cadastroProfessor = odbc_prepare($db, "INSERT INTO Professor (nome, email, senha, idSenac, tipo) VALUES (?, ?, ?, ?, ?)");
        if (@odbc_execute($cadastroProfessor, array(
            $_POST['nome_professor'],
            $_POST['email_professor'],
            "HASHBYTES('SHA1', {$_POST['senha_professor']})",
            $_POST['idsenac_professor'],
            $_POST['tipo_professor']))) {
            $msg = "Professor: {$_POST['nome_professor']} inserido com sucesso";
    } else {
        $erro = "ERRO: N&atilde;o foi poss&iacute;vel adicionar o Professor {$_POST['nome_professor']}";
    }
}
}


//Lista
if (isset($_GET['qtdRegistro'])) {
    $registros = $_GET['qtdRegistro'];
} else {
    $registros = 10;
}
$query = odbc_exec($db, "SELECT count(*) AS total FROM Professor");
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
    $ordenacao = "ORDER BY codProfessor DESC";
break;
case 1:
    $ordenacao = "ORDER BY codProfessor ASC";
    break;
case 2:
    $ordenacao = "ORDER BY nome";
    break;
case 3:
    $ordenacao = "ORDER BY nome DESC";
    break;
}

$query = odbc_exec($db, "SELECT codProfessor, nome, email, idSenac FROM Professor $ordenacao OFFSET $offset ROWS FETCH NEXT $registros ROWS ONLY");

while ($result = odbc_fetch_array($query)) {
    $listarProfessores[$result['codProfessor']] = htmlentities($result['nome']);
    $listarEmail[$result['codProfessor']] = htmlentities($result['email']);
    $listarIdSenac[$result['codProfessor']] = htmlentities($result['idSenac']);
}


include('templates/index_tpl.php');
?>
