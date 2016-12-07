<?php

include('../db/db.php');
//Update após receber os dados de form para editar

if(isset($_POST['editado'])){
    if(is_numeric($_POST['cod_area'])){
        $area = preg_replace("/[^a-zA-Z0-9 ,]/", '', $_POST['area']);
        
     if(odbc_exec($db, "UPDATE Area SET descricao = '$area' WHERE codArea = {$_GET['ecod']}")){
         $msg = 'Sucesso! Área atualizada com sucesso \o/';
     } else {
         $erro = 'ERRO: Não foi possível atualizar';
     }   
    } else {
        $erro = 'ERRO: Não foi possível atualizar: Código Inválido';
    }
}



//Form para Editar
else if(isset($_GET['ecod']) && is_numeric($_GET['ecod']) && !isset($_POST['inserir'])){
    $query = odbc_exec($db, 'SELECT codArea, descricao FROM Area WHERE codArea ='.$_GET['ecod']);
    
    $result = odbc_fetch_array($query);
    
    $cod_area = $result['codArea'];
    
    $area = $result ['descricao'];
    
    include('templates/index_edit_tpl.php');
    exit();
}

//Apaga

if (isset($_GET['dcod'])) {
    if (is_numeric($_GET['dcod'])) {
        //verifica se existe dependencia
        $query = odbc_exec($db, 'SELECT descricao FROM Assunto WHERE codArea ='.$_GET['dcod']);
        
        if(odbc_num_rows($query) > 0){
            $erro = 'ERRO: Existe assunto relacionado a esta área.';
        } else {
            
        
        if (!odbc_exec($db, 'DELETE FROM Area WHERE codArea =' . $_GET['dcod'])) {
            $erro = 'ERRO: Problema ao apagar registro.';
        } else {
            $msg = 'Registro apagado com sucesso!';
        }
    } 
} else {
        $erro = 'ERRO: Código Inválido';
    }
}
//Inserir
if(isset($_POST['inserir'])){
    $area = preg_replace("/[^a-zA-Z0-9 ,]/", '', $_POST['area']);
    
    if(odbc_exec($db,"INSERT INTO Area (descricao) VALUES ('$area')")){
        $msg = 'Área: '.$area.', inserida com sucesso';
    } else {
        $erro = 'ERRO: Não foi possível inserir '.$area;
    }
}

//Lista
$query = odbc_exec($db, 'SELECT codArea, descricao FROM Area');

while ($result = odbc_fetch_array($query)) {
    $areas[$result['codArea']] = utf8_encode($result['descricao']);
}



include('templates/index_tpl.php');
?>