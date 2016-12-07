<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listagem das Questões</title>


    <!-- CSS -->
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Customizacoes -->
    <link rel="stylesheet" href="../css/custom.css">

</head>
<body class="listagem-area">

    <div class="container">
        <!-- 1.6 - MENSAGENS -->
        <?php
        if (!empty($erro)) {
            echo "
            <div class='msg erro'>
                <p>$erro</p>
            </div>
            ";
        }
        if (!empty($msg)) {
            echo "
            <div class='msg sucesso'>
                <p>$msg</p>
            </div>
            ";
        }
        ?>


        <!-- 1.1 - BUSCA -->
        <div class="row box-busca">
            <div class="col-md-8">
                <h3 class="sub-titulo">
                    <a onclick="Mudarestado('box-filtros-busca')"><span class="glyphicon glyphicon-search"></span>Busca</a>
                </h3>
            </div>

            <!-- 1.3 - BOTOES DE ACOES -->
            <div class="box-acoes out">
                <div class="acoes">
                    <a class="adicionar" data-toggle="modal" data-target="#modalAdicionar"><span class="glyphicon glyphicon-plus"></span>Adicionar</a>

                    <a href="senaquizcamorra.esy.es" class="btn-documentacao"><span class="glyphicon glyphicon-book"></span>Manual</a>

                    <!-- 1.5 - MODAL PARA ACOES - ADICIONAR -->
                    <div class="modal fade" id="modalAdicionar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-questao" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p class="modal-title">Digite as Informações <span class="destaque">Questão</span> que Deseja Criar</p>
                                </div>
                                <div class="modal-body">
                                    <form id="form" method="post" enctype="multipart/form-data">
                                      <input  type="hidden" name="ativo" value=	"1">
                                      <input  type="hidden" name="cod_professor" value= "1">
                                      <input  type="hidden" name="tipo" value= "A">                                      
                                      <div class="box-frm-campos assunto">
                                        <label for="assunto" class="legenda">Assunto:</label>
                                        <select name="assunto">
                                            <?php
                                            foreach ($selectAssunto as $cod => $assunto) {
                                              echo "<option value='$cod'";
                                              echo ">$assunto</option>";
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="box-frm-campos enunciado">
                                    <label for="ativo" class="legenda">Enunciado:</label>
                                    <textarea class="mens" name="enunciado" placeholder="Digite aqui..." rows="4"></textarea>
                                </div>
                                <div class="box-frm-campos img">
                                    <label for="ativo" class="legenda">Selecione uma Imagem</label>
                                    <input class="imagem" type="file" name="imagem">
                                </div>
                                <div class="box-frm-campos img">
                                    <input type="text" name="titulo_imagem" required>
                                    <span class="floating-label">Descrição da Imagem:</span>
                                </div>
                                <div class="box-frm-campos alternativa">
                                    <label class="legenda2">Correta</label>
                                    <div class="box">
                                        <input type="text" name="texto_alternativa1" value="" required>
                                        <span class="floating-label">Questão 1:</span>
                                        <input type="radio" name="correta" id="opt1" value="1" checked="checked">
                                    </div>
                                    <div class="box">
                                        <input type="text" name="texto_alternativa2" value="" required>
                                        <span class="floating-label">Questão 2:</span>
                                        <input type="radio" name="correta" id="opt2" value="2">
                                    </div>
                                    <div class="box">
                                        <input type="text" name="texto_alternativa3" value="" required>
                                        <span class="floating-label">Questão 3:</span>
                                        <input type="radio" name="correta" id="opt3" value="3">
                                    </div>
                                    <div class="box">
                                        <input type="text" name="texto_alternativa4" value="" required>
                                        <span class="floating-label">Questão 4:</span>
                                        <input type="radio" name="correta" id="opt4" value="4">
                                    </div>
                                </div>
                                <div class="box-frm-campos dificuldade">
                                    <label class="legenda">Dificuldade:</label>
                                    <div class="box">
                                        <input type="radio" name="dificuldade" id="facil" value="F" checked="checked">
                                        <label class="legenda2" for="facil">Fácil</label>
                                    </div>
                                    <div class="box">
                                        <input type="radio" name="dificuldade" id="medio" value="M">
                                        <label class="legenda2" for="medio">Médio</label>
                                    </div>
                                    <div class="box">
                                        <input type="radio" name="dificuldade" id="dificil" value="D">
                                        <label class="legenda2" for="dificil">Difícil</label>
                                    </div>

                                </div>
                                <div class="box-frm-campos">
                                    <a class="fechar btn" data-dismiss="modal" aria-label="Close">Cancelar</a>
                                    <input type="submit" name="inserir" value="Confirmar" class="btn">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 1.1.1 - Campos da Busca -->
    <div id="box-filtros-busca">
                <div class="col-md-3 box1">
                    <form action="post">
                    <h4>Escreva o que deseja:</h4>
                    <input type="text">
                    <input type="submit" class="btn-busca">
                    </form>
                </div>
            </div>
</div>

<!-- 1.2 - FILTROS -->
<div class="row box-filtros top">

    <!-- ordem / ordenar -->
    <div class="col-md-6 box-opt ordenar">
        <p>Ordenar por:</p>
        <select class="form-control">
            <option>Selecione...</option>
            <option>Mais Recentes</option>
            <option>Mais Antigo</option>
            <option>A - Z</option>
            <option>Z - A</option>
            <option>Ativo</option>
            <option>Inativo</option>
            <!-- <option>Professor</option> -->
        </select>
    </div>

    <!-- quantidade / qtd -->
    <form method="get">
        <div class="col-md-6 box-opt qtd">
            <p>Qtd:</p>
            <div class="opts">
                <a href="?qtdRegistro=10">10</a>
                <a href="?qtdRegistro=30">30</a>
                <a href="?qtdRegistro=50">50</a>
                <p>por página | Total de <?php echo "$totalRegistros"; ?> registros encontrados</p>
            </div>
        </div>
    </form>
</div>

<!-- 1.4 - TABELA DE INFORMACOES -->
<div class="row box-tabela">
    <table class="table table-striped acoes-inline">
        <thead>
            <tr>
                <th style="display: none;">codQuestao</th>
                <th>Enunciado</th>
                <th>Assunto</th>
                <th>Imagem</th>
                <th style="display: none;">codProfessor</th>
                <th>dificuldade</th>
                <th style="display: none;">ativo</th>
                <th>editar</th>
                <th>Apagar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($questoes as $cod => $questao) {
                    $questao['textoQuestao'] = utf8_encode($questao['textoQuestao']);
                    echo"
                    <tr>
                        <td style='display: none;'>{$questao['codQuestao']}</td>
                        <td>{$questao['textoQuestao']}</td>
                        <td>{$assuntoDaQuestao[$cod]}</td>
                        <td>{$imagemDaQuestao[$cod]}</td>
                        <td style='display: none;'>{$questao['codProfessor']}</td>
                        <td>{$questao['dificuldade']}</td>
                        <td style='display: none;'>{$questao['ativo']}</td>
                        <td>
                            <a href='?ecod=$cod' class='acoes editar' data-toggle='modal' data-target='#modalEditar'><span class='glyphicon glyphicon-pencil'></span>Editar</a>
                        </td>
                        <td>
                            <a href='?dcod=$cod'class='acoes excluir'><span class='glyphicon glyphicon-trash'></span>Excluir</a>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tr>
        </tbody>
    </table>
</div>
<!-- 1.5 - MODAL PARA ACOES / ALTERACAO -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-questao">
            <!-- conteudo em index_edit_tpl.php -->
        </div>
    </div>
</div>

<!-- 1.2 - FILTROS -->
<div class="row box-filtros bottom">
    <div class="col-md-12 box-opt paginacao">
        <nav aria-label="Page navigation">
            <ul class="pagination">
            <span>Pag:</span>
                <?php
                for ($i=1; $i <= $totalPaginas ; $i++) {
                    echo "<li><a href='?numPagina=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
  </div>
</div>


<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="../js/bootstrap.min.js"></script>

<!-- Abrir e Fechar Campos da Busca -->
  <script>
      function Mudarestado(el) {
          var display = document.getElementById(el).style.display;

          if(display == "block")
              document.getElementById(el).style.display = 'none';
          else
              document.getElementById(el).style.display = 'block';
      }
  </script>
</body>
</html>
