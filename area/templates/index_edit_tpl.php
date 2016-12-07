<div>
    <div class="modal-header">
        <a class="close" href="index.php"><span aria-hidden="true">&times;</span></a>
        <p class="modal-title">Digite Abaixo a Altera&ccedil;&atilde;o que Deseja Fazer</p>
    </div>
    <div class="modal-body">
        <form method="post">
            <input type="hidden" name="ecod" value="<?php echo $cod_area; ?>">
            <div class="box-frm-campos">
                <label for="area" class="legenda">&Aacute;rea:</label>
                <input type="text" name="area" value="<?php echo $area; ?>">
            </div>
            <div class="box-frm-campos">
                <a href="index.php" class="fechar btn">Cancelar</a>
                <input type="submit" name="editado" value="Confirmar" class="btn">
            </div>
        </form>
    </div><i class="icono-forbidden"></i>
</div>
