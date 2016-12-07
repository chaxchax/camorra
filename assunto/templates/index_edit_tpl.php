<div>
    <div class="modal-header">
        <a class="close" href="index.php"><span aria-hidden="true">&times;</span></a>
        <p class="modal-title">Digite Abaixo as Altera&ccedil;&otilde;es que Deseja Fazer</p>
    </div>
    <div class="modal-body">
        <form method="post">
            <input type="hidden" name="ecod" value="<?php echo $cod_assunto; ?>">
            <div class="box-frm-campos">
                <label for="area" class="legenda">Assunto:</label>
                <input type="text" name="assunto" value="<?php echo $assunto; ?>">
            </div>
            <div class="box-frm-campos">
                <label for="area" class="legenda">&Aacute;rea a qual o Assunto pertence:</label>
                <select name="area">
                    <?php
                    foreach($selectAreas as $cod => $area){
                        if($cod == $codArea){
                            echo "<option value='$cod' selected>$area</option>";
                        } else {
                            echo "<option value=$cod>$area</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="box-frm-campos">
                <a href="index.php" class="fechar btn">Cancelar</a>
                <input type="submit" name="editado" value="Confirmar" class="btn">
            </div>
        </form>
    </div><i class="icono-forbidden"></i>
</div>
