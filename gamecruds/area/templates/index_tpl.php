<html>
    <body>
        <div>
            <?php
            if (!empty($erro)) {
                echo "<br><br><font color='red'>$erro</font><br><br>";
            }
            if (!empty($msg)) {
                echo "<br><br><font color='green'>$msg</font><br><br>";
            }
            ?>
            <table border='1'>
                <tr>
                    <td>C&oacute;digo</td>
                    <td>Descri&ccedil;&atilde;o</td>
                    <td>Editar</td>
                    <td>Apagar</td>
                </tr>
                <?php
                foreach ($areas as $cod => $area) {
                    echo "<tr>
                            <td>$cod</td>
                            <td>$area</td>
                            <td><a href='?ecod=$cod'>Editar</a></td>
                            <td><a href='?dcod=$cod'>X</a></td>
			  </tr>";
                }
                ?>
            </table>
        </div>
        <div>
            <form method="post">
                <p>
                    Área: <input type="text" name="area">
                </p>
                <p>
                    <input type="submit" name="inserir" value="Gravar">
                </p>
            </form>
        </div>
    </body>
</html>