<div>
	<div class="modal-header">
		<a class="close" href="index.php"><span aria-hidden="true">&times;</span></a>
		<p class="modal-title">Digite Abaixo as Alterações que Deseja Fazer</p>
	</div>
	<div class="modal-body">
		<form method="post" enctype="multipart/form-data">

			<input  type="hidden"   name="cod_questao" value="<?php echo "{$questao['codQuestao']}"; ?>">
			<input  type="hidden" name="ativo" value="<?php echo "{$questao['ativo']}"; ?>">
			<input  type="hidden" name="cod_professor" value="<?php echo "{$questao['codProfessor']}"; ?>">
			<input  type="hidden" name="tipo" value="A">
			<div class="box-frm-campos ativa">
				<label class="legenda">Questão Ativa?:</label>
				<div class="box">
					<input type="radio" name="ativo" value="1" <?php echo ($questao['ativo'] == '1') ? 'checked="checked"' : null; ?>>
					<label class="legenda2" for="sim" value="1">Sim</label>
				</div>
				<div class="box">
					<input type="radio" name="ativo" value="0" <?php echo ($questao['ativo'] == '0') ? 'checked="checked"' : null; ?>>
					<label class="legenda2" for="nao">Não</label>
				</div>
			</div>
			<div class="box-frm-campos">
				<label for="assunto" class="legenda">Assunto:</label>
				<select name="assunto">
					<?php
					foreach ($selectAssunto as $cod => $assunto) {
						echo "<option value='$cod'";
						echo ($cod == $questao['codAssunto']) ? 'selected="selected"' : null;
						echo ">$assunto</option>";
					}
					?>
				</select>
			</div>
			<div class="box-frm-campos">
				<label for="enunciado" class="legenda">Enunciado:</label>
				<textarea class="mens" name="enunciado"><?php echo ($questao['textoQuestao']);?></textarea>
			</div>
			<div class="box-frm-campos">
				<label for="idsenac_professor" class="legenda">Imagem:</label>
				<input class="imagem" type="file" name="imagem">
				<img class="img-responsive center-block" src="data:image;base64,<?php echo $bitmap ?>" >
			</div>
			<div class="box-frm-campos">
				<label for="tipo_professor" class="legenda">Descrição da Imagem:</label>
				<input type="text" name="titulo_imagem" value="<?php
				if (isset($titulo)) {
					echo $titulo;
				}
				?>">
			</div>
			<div class="box-frm-campos alternativa">
				<label class="legenda2">Correta</label>
				<div class="box">
					<input type="radio" name="correta" value="1" <?php echo ($alternativas[1]['correta'] == 1) ? 'checked="checked"' : null; ?> >
					<label for="texto_alternativa1" class="legenda">Questão 1:</label>
					<input  type="text" name="texto_alternativa1" value=<?php echo '"'.htmlentities($alternativas[1]['textoAlternativa']).'"' ?>>
				</div>
				<div class="box">
					<input    type="radio" name="correta" value="2" <?php echo ($alternativas[2]['correta'] == 1) ? 'checked="checked"' : null; ?> >
					<label for="texto_alternativa2" class="legenda">Questão 2:</label>
					<input type="text" name="texto_alternativa2" value=<?php echo '"'.htmlentities($alternativas[2]['textoAlternativa']).'"' ?>>
				</div>
				<div class="box">
					<input type="radio" name="correta" value="3" <?php echo ($alternativas[3]['correta'] == 1) ? 'checked="checked"' : null; ?> >
					<label for="texto_alternativa3" class="legenda">Questão 3:</label>
					<input  type="text" name="texto_alternativa3" value=<?php echo '"'.htmlentities($alternativas[3]['textoAlternativa']).'"' ?>>
				</div>
				<div class="box">
				<input type="radio" name="correta" value="4" <?php echo ($alternativas[4]['correta'] == 1) ? 'checked="checked"' : null; ?> >
					<label for="texto_alternativa4" class="legenda">Questão 4:</label>
					<input  type="text" name="texto_alternativa4" value=<?php echo '"'.htmlentities($alternativas[4]['textoAlternativa']).'"' ?>>
				</div>
			</div>
			<div class="box-frm-campos dificuldade">
				<label class="legenda">Dificuldade:</label>
				<div class="box">
					<input type="radio" name="dificuldade" value="F" <?php echo ($questao['dificuldade'] == 'F') ? 'checked="checked"' : null; ?> >
					<label class="legenda2" for="facil">Fácil</label>
				</div>
				<div class="box">
					<input type="radio" name="dificuldade" value="M" <?php echo ($questao['dificuldade'] == 'M') ? 'checked="checked"' : null; ?> >
					<label class="legenda2" for="medio">Médio</label>
				</div>
				<div class="box">
					<input type="radio" name="dificuldade" value="D" <?php echo ($questao['dificuldade'] == 'D') ? 'checked="checked"' : null; ?> >
					<label class="legenda2" for="dificil">Difícil</label>
				</div>
			</div>
			<div class="box-frm-campos">
				<a href="index.php" class="fechar btn">Cancelar</a>
				<input type="submit" name="editado" value="Confirmar" class="btn">
			</div>
		</form>
	</div><i class="icono-forbidden"></i>
</div>
