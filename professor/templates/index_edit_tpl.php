<div>
    <div class="modal-header">
        <a class="close" href="index.php"><span aria-hidden="true">&times;</span></a>
        <p class="modal-title">Digite Abaixo as Altera&ccedil;&otilde;es que Deseja Fazer</p>
    </div>
    <div class="modal-body modal-professor">
        <form method="post">
            <input type="hidden" name="ecod" value="<?php echo $cod_professor; ?>">
            <div class="box-frm-campos">
                <label for="nome_professor" class="legenda">Nome:</label>
                <input type="text" name="nome_professor" value="<?php echo $nome_professor; ?>">
            </div>
            <div class="box-frm-campos">
                <label for="email_professor" class="legenda">E-mail:</label>
                <input type="text" name="email_professor" value="<?php echo $email_professor; ?>">
            </div>
            <div class="box-frm-campos">
                <label for="senha_professor" class="legenda">Senha:</label>
                <input type="password" name="senha_professor">
            </div>
            <div class="box-frm-campos">
                <label for="idsenac_professor" class="legenda">ID Senac:</label>
               <input type="text" name="idsenac_professor" value="<?php echo $idsenac_professor; ?>">
            </div>
            <div class="box-frm-campos">
                <label for="tipo_professor" class="legenda">Tipo de professor:</label>
                <div class="box">
                    <input type="radio" name="tipo_professor" id="Admin" value="A">
                    <label class="legenda2" for="Admin">Administrador</label>
                </div>
                <div class="box">
                    <input type="radio" name="tipo_professor" id="Professor" value="P">
                    <label class="legenda2" for="Professor">Professor</label>
                </div>
            </div>
            <div class="box-frm-campos">
                <a href="index.php" class="fechar btn">Cancelar</a>
                <input type="submit" name="editado" value="Confirmar" class="btn">
            </div>
        </form>
    </div><i class="icono-forbidden"></i>
</div>
