<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listagem das &Aacute;reas</title>


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
            <!-- <div class="col-md-8">
                <h3 class="sub-titulo">
                    <a onclick="Mudarestado('box-filtros-busca')"><span class="glyphicon glyphicon-search"></span>Busca</a>
                </h3>
            </div> -->

            <!-- 1.3 - BOTOES DE ACOES -->
            <div class="box-acoes out">
                <div class="acoes">
                    <a class="adicionar" data-toggle="modal" data-target="#modalAdicionar"><span class="glyphicon glyphicon-plus"></span>Adicionar</a>

                    <a href="http://senaquizcamorra.esy.es" class="btn-documentacao" target="_blank"><span class="glyphicon glyphicon-book"></span>Manual</a>

                    <!-- 1.5 - MODAL PARA ACOES - ADICIONAR -->
                    <div class="modal fade" id="modalAdicionar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p class="modal-title">Digite o Nome da <span class="destaque">&Aacute;rea</span> que Deseja Adicionar</p>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div class="box-frm-campos">
                                            <input type="text" name="area" required>
                                            <span class="floating-label">&Aacute;rea:</span>
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
            <!-- <div id="box-filtros-busca">
                <div class="col-md-3 box1">
                    <form action="post">
                    <h4>Escreva o que deseja:</h4>
                    <input type="text">
                    <input type="submit" class="btn-busca">
                    </form>
                </div>
            </div> -->
        </div>

        <!-- 1.2 - FILTROS -->
        <div class="row box-filtros top">

            <!-- ordem / ordenar -->
            <div class="col-md-6 box-opt ordenar">
                <p>Ordenar por:</p>
                <div class="box-opt-ordem">
                    <a id="opt-ordem1" href="?ordenacao=0">Mais Recentes</a>
                    <a id="opt-ordem2" href="?ordenacao=1">Mais Antigos</a>
                    <a id="opt-ordem3" href="?ordenacao=2">A - Z</a>
                    <a id="opt-ordem4" href="?ordenacao=3">Z - A</a>
                </div>
            </div>

            <!-- quantidade / qtd -->
            <form method="get">
                <div class="col-md-6 box-opt qtd">
                    <div class="opts">
                        <p>Qtd:</p>
                        <a href="?qtdRegistro=10">10</a>
                        <a href="?qtdRegistro=30">30</a>
                        <a href="?qtdRegistro=50">50</a>
                        <p>por p&aacute;gina | Total de <?php echo "$totalRegistros"; ?> registros encontrados</p>
                    </div>
                </div>
            </form>
        </div>

        <!-- 1.4 - TABELA DE INFORMACOES -->
        <div class="row box-tabela">
            <table class="table table-striped acoes-inline">
                <thead>
                    <tr>
                        <th>C&oacute;digo</th>
                        <th>Descri&ccedil;&atilde;o</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        foreach ($areas as $cod => $area) {
                            echo"
                            <tr>
                                <td>$cod</td>
                                <td>$area</td>
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
                <div class="modal-content">
                    <!-- conteudo em index_edit_tpl.php -->
                </div>
            </div>
        </div>

        <!-- 1.2 - FILTROS -->
        <div class="row box-filtros bottom">
            <!-- paginacao / paginas -->
            <div class="col-md-12 box-opt paginacao">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                <span>P&aacute;g</span>
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

    <!-- Mudar Selecao de Ordenacao -->
    <script type="text/javascript">
    var endereco = location.search; 
    var res = endereco.substring(11, 12);
    if (res == 0) {
        document.getElementById("opt-ordem1").addEventListener("click", window.onload = function(){
            document.getElementById("opt-ordem1").style.order = "1";
        });
    } else if ( res == 1) {
        document.getElementById("opt-ordem2").addEventListener("click", window.onload = function(){
            document.getElementById("opt-ordem2").style.order = "1";
        });
    } else if (res == 2) {
        document.getElementById("opt-ordem3").addEventListener("click", window.onload = function(){
            document.getElementById("opt-ordem3").style.order = "1";
        });
    } else if (res == 3) {
        document.getElementById("opt-ordem4").addEventListener("click", window.onload = function(){
            document.getElementById("opt-ordem4").style.order = "1";
        });
    } else {
        document.getElementById("opt-ordem1").addEventListener("click", window.onload = function(){
            document.getElementById("opt-ordem1").style.order = "1";
        });
    }
    </script>
</body>
</html>
