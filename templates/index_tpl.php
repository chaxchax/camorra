<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senaquiz - Sistemas para Internet</title>


    <!-- CSS -->
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Customizacoes -->
    <link rel="stylesheet" href="css/custom.css">

</head>
<body class="navegacao">

    <div class="container">
        <div class="box-menu">
            <a href="area/"><span class="glyphicon glyphicon-tags"></span>&Aacute;rea</a>
            <a href="assunto/"><span class="glyphicon glyphicon-book"></span>Assunto</a>      
            <a href="professor/"><span class="glyphicon glyphicon-education"></span>Professor</a>
            <a href="questoes/"><span class="glyphicon glyphicon-pencil"></span>Quest&otilde;es</a>
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
