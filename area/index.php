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

//Update após receber os dados de form para editar

if(isset($_POST['editado'])){
    if($_SESSION['tipoProfessor'] != 'A'){
        $erro = "Voc&ecirc; n&atilde;o tem permiss&atilde;o editar &Aacute;rea";
    } else {
        if(is_numeric($_POST['ecod'])){
            $area = $_POST['area'];

            if(odbc_exec($db, "UPDATE Area SET descricao = '$area' WHERE codArea = {$_POST['ecod']}")){
               $msg = '&Aacute;rea atualizada com sucesso';
           } else {
               $erro = 'ERRO: N&atilde;o foi poss&iacute;vel atualizar';
           }
       } else {
        $erro = 'ERRO: N&atilde;o foi poss&iacute;vel atualizar: C&oacute;digo Inv&aacute;lido';
    }
}
}



//Form para Editar
else if(isset($_GET['ecod']) && is_numeric($_GET['ecod']) && !isset($_POST['inserir'])){
    $query = odbc_exec($db, 'SELECT codArea, descricao FROM Area WHERE codArea ='.$_GET['ecod']);

    $result = odbc_fetch_array($query);

    $cod_area = $result['codArea'];

    $area = htmlentities($result['descricao']);

    include('templates/index_edit_tpl.php');
    exit();
}

//Apaga

if (isset($_GET['dcod'])) {
    if($_SESSION['tipoProfessor'] != 'A'){
        $erro = "Voc&ecirc; n&atilde;o tem permiss&atilde;o editar &Aacute;rea";
    } else {
        if (is_numeric($_GET['dcod'])) {
        //verifica se existe dependencia
            $query = odbc_exec($db, 'SELECT descricao FROM Assunto WHERE codArea ='.$_GET['dcod']);

            if(odbc_num_rows($query) > 0){
                $erro = 'ERRO: Existe assunto relacionado a esta &Aacute;rea';
            } else {


                if (!odbc_exec($db, 'DELETE FROM Area WHERE codArea =' . $_GET['dcod'])) {
                    $erro = 'ERRO: Problema ao apagar registro';
                } else {
                    $msg = 'Registro apagado com sucesso!';
                }
            }
        } else {
            $erro = 'ERRO: C&oacute;digo Inv&aacute;lido';
        }
    }
}

//Inserir
if(isset($_POST['inserir'])){
    if($_SESSION['tipoProfessor'] != 'A'){
        $erro = "Voc&ecirc; n&atilde;o tem permiss&atilde;o editar &Aacute;rea";
    } else {
        $area = $_POST['area'];

        if(odbc_exec($db,"INSERT INTO Area (descricao) VALUES ('$area')")){
            $msg = '&Aacute;rea: '.$area.' inserida com sucesso';
        } else {
            $erro = 'ERRO: N&atilde;o foi poss&iacute;vel inserir '.$area;
        }
    }
}

//LISTAGEM

//PAGINAÇÃO
if (isset($_GET['qtdRegistro'])) {
    $registros = $_GET['qtdRegistro'];
} else {
    $registros = 10;
}
$query = odbc_exec($db, "SELECT count(*) AS total FROM Area");
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
    $ordenacao = "ORDER BY codArea DESC";
break;
case 1:
    $ordenacao = "ORDER BY codArea ASC";
    break;
case 2:
    $ordenacao = "ORDER BY descricao";
    break;
case 3:
    $ordenacao = "ORDER BY descricao DESC";
    break;
}

//QUERY
$query = odbc_exec($db, "SELECT codArea, descricao FROM Area $ordenacao OFFSET $offset ROWS FETCH NEXT $registros ROWS ONLY");

while ($result = odbc_fetch_array($query)) {
    $areas[$result['codArea']] = htmlentities($result['descricao']);
}



include('templates/index_tpl.php');

?>