<?php 

include('../inc/inc_start.php'); 
ContainerDi::getObject('UsuarioCMS')->autentica();

$usuario = ContainerDi::getObject('UsuarioCMS')->find($con_cms_user->id);
echo "user " .$usuario->id;
if($_POST['enviar']==1) 
{
	if(!Authenticate::confere_email($_POST['email']))
	{
		$erro = 'E-mail inválido.';
	}

	if(!isset($erro))
	{
		// verifica se não tem outro usuário registrado com o mesmo e-mail
		$result = ContainerDi::getObject('UsuarioCMS')
				->getAll("WHERE email = '{$_POST['email']}' AND id <> {$usuario->id}");
		if(count($result) > 0)
		{
			$erro = 'Já existe um usuário cadastrado com este e-mail.';
		}
	}
	if(!isset($erro) && $_POST['senha1']!='')
	{
		$senha_enc = Utils::pwenc($_POST['senha1']);
		if($senha_enc===false)
		{
			$erro = 'A senha digitada só pode ter números e letras não acentuadas.';
		}
		elseif($_POST['senha1']!=$_POST['senha2'])
		{
			$erro = 'A confirmação da senha deve ser idêntica à senha digitada.';
		}
		
		$_POST['senha'] = $senha_enc;
	}
	
	
	
	if(!isset($erro))
	{		
		if($bool_avisar)
		{
			$usuario->avisar(2);
		}
		
		// salva
		$usuario->update(array(
			'nome' => $_POST['nome'],
			'email' => $_POST['email'],
			'senha' => $_POST['senha'],
			'id' => $usuario->id
		),$usuario->id);
		
		$id_usuario = $usuario->id;
		
		// monta o vetor de permissões
		foreach($_POST as $chave=>$valor)
		{
			if(substr($chave, 0, 5)=="perm_" && $valor)
			{
				$vetor_perm[] = substr($chave, 5);
			}
		}
		
		//atualiza as permissões
		$usuario->atualiza_permissoes($vetor_perm, $_POST['id']);
	
		// atualiza o vetor de dados do usuário, reiniciando a sessão
		$usuario->inicia_sessao();

		//header('Location: listar_usuarios.php');
		header('Location: perfil.php');
	}
}
else
{
	$nome = $usuario->nome;
	$email = $usuario->email;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd>
<html>
<head>
	<?php include(DIR_CMS_ROOT . 'inc/inc_header.php'); ?>
	<?php include(DIR_CMS_ROOT . 'inc/inc_uploader.php'); ?>
</head>

<body>
<?php include(DIR_CMS_ROOT . 'inc/inc_topo.php'); ?>
<div id="central">
<?php include(DIR_CMS_ROOT . 'inc/inc_menu.php'); ?>
<div id="conteudo">


<h1>Editar perfil <span class="botoes"><em>*</em> Campos obrigatórios</span></h1>


<?php Utils::escreve_alerta(); ?>

<form method="post" name="form_ins" id="form_ins" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return checar(this)">

<div class="caixa">
<h3>Dados do usuário</h3>
    <div class="field">
        <label for="nome"><span>Nome</span> <strong><em>*</em></strong></label>
		<input id="nome" name="nome" class="obr" value="<?php echo $nome;?>" type="text" maxlength="100" />
	</div>

	<div class="field">
		<label for="email"><span>E-mail</span> <strong><em>*</em></strong></label> 
		<input id="email" name="email" value="<?php echo $email;?>" type="text" class="obr" maxlength="200" /> 
	</div>

	<div class="field half">
		<label for="senha1"><span>Nova senha</span></label> 
		<input id="senha1" name="senha1" type="password" maxlength="20" /> 
	</div>

	<div class="field half">
		<label for="senha2"><span>Confirme a senha</span></label> 
		<input id="senha2" name="senha2" type="password" maxlength="20" /> 
	</div>

	
</div>



<div class="caixa">
<h3>Permissões do usuário</h3>

	<?php
	$lista = ContainerDi::getObject('ModuloCMS')->getAll("WHERE bool_ativo = 1");
	?>
	
	<table class="resumo" id="table_permissoes"> 
	<thead>
		<tr>
			<?php 
			foreach ($lista as $modulo)
			{
				?>
				<th><img src="<?php echo $modulo->imagem; ?>" title="<?php echo $modulo->nome; ?>" /></th>
				<?php
			}
			?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php 
			if($_POST['enviar']==1)
			{
				foreach ($lista as $modulo)
				{
					$name_check = 'perm_' . $modulo->id;
					$seleciona = ${'perm_' . $modulo->id} ? 'checked' : '';
					?>
					<td><input type="checkbox" id="<?php echo $name_check; ?>" name="<?php echo $name_check; ?>" <?php echo $seleciona; ?> class="perm" /></td>
					<?php
				}
			}
			else										
			{
				$vetor_perm = (array) $usuario->lista_permissoes();
				foreach ($lista as $modulo)
				{
					$name_check = 'perm_' . $modulo->id;
					$seleciona = in_array($modulo->id, $vetor_perm) ? 'checked' : '';
					?>
					<td><input type="checkbox" id="<?php echo $name_check; ?>" name="<?php echo $name_check; ?>" <?php echo $seleciona; ?> class="perm" /></td>
					<?php
				}
			}
			?>
		</tr>
	</tbody>
	</table>
				
</div>





<div class="field full controles">
	<a href="#" onclick="$('#form_ins').submit(); return false;" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-disk"></span>Salvar</a>
	<a href="perfil.php" class="bt_padrao ui-state-default ui-corner-all"><span class="ui-icon ui-icon-closethick"></span>Cancelar</a>
	<input type="submit" class="submit" />
</div>


<input type="hidden" name="enviar" value="1" />
</form>





</div>
</div>
<?php include(DIR_CMS_ROOT . 'inc/inc_rodape.php'); ?>
</body>
</html>
