<?php
header('Content-type: text/html; charset=utf-8');
//INICIAR A SESSÃO//
session_start();
$_SESSION['codProfessor'] = 24;
$_SESSION['tipoProfessor'] = 'A';

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

ini_set('odbc.defaultlrl', '1M');
$erro = '';
$msg = '';


//CHAMA OS ASSUNTOS PARA INSERT E UPDATE
$pesquisaSelectAssunto = odbc_exec($db, 'SELECT codAssunto, descricao FROM Assunto');
while ($resultado = odbc_fetch_array($pesquisaSelectAssunto)) {
  $selectAssunto[$resultado['codAssunto']] = htmlentities($resultado['descricao']);
}


//INSERE IMAGEM
if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
    $imagem = basename($_FILES['imagem']['tmp_name']);
    $handle = fopen($imagem, 'rb');
    $data = fread($handle, $_FILES['imagem']['size']);
    fclose($handle);
    $cadastroImagemPrep = odbc_prepare($db, ' INSERT INTO
        Imagem(
        tituloImagem,
        bitmapImagem)
        OUTPUT
        INSERTED.codImagem
        VALUES
        (?,?)');
    $titulo = $_POST['titulo_imagem'];

    $params = array($titulo, $data, );
    $cadastroImagemExec = (odbc_execute($cadastroImagemPrep, $params));
    $resultImagem = (odbc_fetch_array($cadastroImagemPrep));
} else {
  $resultImagem['codImagem'] = null;
}
//INSERE DEMAIS DADOS DA QUESTÃO
if (isset($_POST['inserir'])) {
  $cadastroQuestao = odbc_prepare($db, '  INSERT INTO
    Questao(
    textoQuestao,
    codAssunto,
    codImagem,
    codTipoQuestao,
    codProfessor,
    ativo,
    dificuldade)
    OUTPUT
    INSERTED.codQuestao
    VALUES
    (?, ?, ?, ?, ?, ?, ?)');
  $enunciado = htmlentities($_POST['enunciado']);
  $assunto = htmlentities($_POST['assunto']);
  $codImagem = $resultImagem['codImagem'];
  $tipo = htmlentities($_POST['tipo']);
  $codProfessor = $_SESSION['codProfessor'];
  $ativo = $_POST['ativo'];
  $dificuldade = $_POST['dificuldade'];
  $params = array(
    $enunciado,
    $assunto,
    $codImagem,
    $tipo,
    $codProfessor,
    $ativo,
    $dificuldade,
    );
  if ($cadastroQuestaoExec = odbc_execute($cadastroQuestao, $params)) {
    $msg = 'Questão cadastrada com sucesso';
  } else {
    $erro = 'ERRO: Não foi possível cadastrar a questão';
  }
  $resultQuestao = (odbc_fetch_array($cadastroQuestao));
  $codQuestao = $resultQuestao['codQuestao'];
  for ($i = 1; $i <= 4; ++$i) {
    $cadastroAlternativa = odbc_prepare($db, ' INSERT INTO
      Alternativa(
      codQuestao,
      codAlternativa,
      textoAlternativa,
      correta)
      VALUES
      (?,?,?,?)');
    $correta = ($_POST['correta'] == $i) ? 1 : 0;
    $alternativa = htmlentities($_POST['texto_alternativa' . $i]);
    $params = array($codQuestao,
      $i,
      "$alternativa",
      $correta);
    odbc_execute($cadastroAlternativa, $params);
    echo odbc_errormsg($db);
  }
}


//UPDATE
if (isset($_POST['editado'])) {
  if (($_SESSION['tipoProfessor'] == 'A') || ($_SESSION['codProfessor'] == $_POST['cod_professor'])) {
  if (is_numeric($_POST['cod_questao'])) {
    $updateQuestao = odbc_prepare($db, "           UPDATE
      Questao
      SET
      textoQuestao = ?,
      codAssunto = ?,
      codImagem = ?,
      codProfessor = ?,
      ativo = ?,
      dificuldade = ?
      WHERE
      codQuestao = {$_POST['cod_questao']}");
    for ($i = 1; $i <= 4; ++$i) {
      $updateAlternativa[$i] = odbc_prepare($db, "   UPDATE
        Alternativa
        SET
        textoAlternativa=?,
        correta=?
        WHERE
        codQuestao = {$_POST['cod_questao']}
        AND
        codAlternativa = $i");
      ($_POST['correta'] == $i) ? $correta = 1 : $correta = 0;
      (@odbc_execute($updateAlternativa[$i], array(
        htmlentities($_POST['texto_alternativa' . $i]),
        $correta,
        )));
    }
    if (odbc_execute($updateQuestao, array(
      htmlentities($_POST['enunciado']),
      $_POST['assunto'],
      $resultImagem['codImagem'],
      $_POST['cod_professor'],
      $_POST['ativo'],
      "{$_POST['dificuldade']}",
      ))) {
      $msg = 'Questão atualizado com sucesso';
  } else {
    $erro = 'ERRO: Não foi possível atualizar';
  }
} else {
  $erro = 'ERRO: código inválido';
}
} else {
  $erro = 'Você não tem permissão para editar essa questão!';
}
    //FORMULARIO PARA DAR UPDATE NA QUESTÃO
} elseif (isset($_GET['ecod']) && is_numeric($_GET['ecod']) && !isset($_POST['inserir'])) {
  $query = odbc_exec($db, ' SELECT
    codQuestao,
    textoQuestao,
    codAssunto,
    codImagem,
    codTipoQuestao,
    codProfessor,
    dificuldade,
    ativo
    FROM
    Questao
    WHERE
    codQuestao =' . $_GET['ecod']);
  $questao = odbc_fetch_array($query);
  if ($questao['codImagem']) {
    $queryImagem = odbc_exec($db, "  SELECT
      tituloImagem,
      bitmapImagem
      FROM
      imagem
      WHERE
      codImagem={$questao['codImagem']}");
    $result = odbc_fetch_array($queryImagem);
    $bitmap = base64_encode($result['bitmapImagem']);
    $titulo = $result['tituloImagem'];
  }
  $requisicao = odbc_exec($db, '  SELECT
    codQuestao,
    codAlternativa,
    textoAlternativa,
    correta
    FROM
    Alternativa
    WHERE
    codQuestao =' . $_GET['ecod']);
  while ($resultado = odbc_fetch_array($requisicao)) {
    $alternativas[$resultado['codAlternativa']] = $resultado;
  }
  include 'templates/index_edit_tpl.php';
  exit();
}
//Apaga
if (isset($_GET['dcod']) && !isset($_POST['inserir'])) {
  if (is_numeric($_GET['dcod'])) {
    $verificarQuestao = @odbc_exec($db, ' SELECT codQuestao FROM QuestaoEvento WHERE codQuestao =' . $_GET['dcod']);
      if (odbc_num_rows($verificarQuestao) > 0) {
        $erro = 'ERRO: Existe Evento relacionado a esta Questão';
      } else {
          $params = array($_GET['dcod']);
          $query = odbc_exec($db, "SELECT
                                          *
            FROM
            QuestaoEvento
            WHERE
            codQuestao = {$_GET['dcod']}");
          if (odbc_num_rows($query) > 0) {
            $delete = odbc_prepare($db, ' UPDATE
              Questao
              SET
              ativo = 0
              WHERE
              codQuestao = ?');
          } else {
            $delete = odbc_prepare($db, ' DELETE FROM
              Questao
              WHERE
              codQuestao = ?');
            $deleteAlternativas = odbc_prepare($db, ' DELETE FROM
              Alternativa
              WHERE
              codQuestao = ?');
            odbc_execute($deleteAlternativas, $params);
          }
          if (!odbc_execute($delete, $params)) {
            $erro = 'ERRO: Problema ao apagar o registro';
          } else {
            $msg = 'Registro apagado com sucesso';
          }
    }
  } else {
    $erro = 'ERRO: Código Inválido';
}
}

//Lista todos os itens da tabela "Questao"
if (isset($_GET['qtdRegistro'])) {
    $registros = $_GET['qtdRegistro'];
} else {
    $registros = 10;
}
$queryQuestao = odbc_exec($db, "SELECT count(*) AS total FROM Questao");
$result = odbc_fetch_array($queryQuestao);
$totalRegistros = $result['total'];
$totalPaginas = ceil($totalRegistros / $registros);
if (isset($_GET['numPagina'])) {
    $paginaSolicitada = $_GET['numPagina'];
} else {
    $paginaSolicitada = 1;
}
$offset = ($paginaSolicitada * $registros) - $registros;

$queryQuestao = odbc_exec($db, "  SELECT
  codQuestao,
  textoQuestao,
  codAssunto,
  codImagem,
  codProfessor,
  dificuldade,
  ativo
  FROM
  Questao
  ORDER BY
  codQuestao OFFSET $offset ROWS FETCH NEXT $registros ROWS ONLY");
while ($result = odbc_fetch_array($queryQuestao)) {
  $questoes[$result['codQuestao']] = $result;
    //busca o nome do Assunto da Questao
  $queryAssunto = odbc_exec($db, "  SELECT
    descricao
    FROM
    Assunto
    WHERE
    codAssunto = {$questoes[$result['codQuestao']]['codAssunto']}");
  $assunto = odbc_fetch_array($queryAssunto);
  $assuntoDaQuestao[$result['codQuestao']] = htmlentities($assunto['descricao']);
    //busca o nome da Imagem relacionada à Questao.
  if (!is_null($questoes[$result['codQuestao']]['codImagem'])) {
    if ($queryAssunto = odbc_exec($db, "  SELECT
      tituloImagem
      FROM
      Imagem
      WHERE
      codImagem = {$questoes[$result['codQuestao']]['codImagem']}")) {
      while ($resultQueryAssunto = odbc_fetch_array($queryAssunto)) {
        $imagemDaQuestao[$result['codQuestao']] = htmlentities($resultQueryAssunto['tituloImagem']);
      }
    }
  } else {
    $imagemDaQuestao[$result['codQuestao']] = '';
  }
}
include 'templates/index_tpl.php';
?>
