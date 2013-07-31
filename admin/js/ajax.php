<?

include('../inc/inc_start.php'); 


//_____executa o m�todo________
$retorno=call_user_func($_REQUEST['metodo']);//, $array_request);

//_____passa o retorno pelo codificador JSON__
$retorno= json_encode($retorno);
echo $retorno; //echo utf8_decode($retorno); // esta linha serve para debugar na tela




/*___________M�TODOS___________*/


function submete_login() 
{
	$email = $_REQUEST['email'];
	$senha = $_REQUEST['senha'];
	
	$vetor_usuario = UsuarioCMS::submete_login($email, $senha);
	
	$erro = $vetor_usuario[0];
	$mensagem_retorno = $vetor_usuario[1];
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($mensagem_retorno);
	return $vetor_retorno;
}

//___________________________________________________


function submete_reenvio() 
{
	$email = $_REQUEST['email'];
	
	$vetor_usuario = UsuarioCMS::submete_reenvio($email);
	
	$erro = $vetor_usuario[0];
	$mensagem_retorno = $vetor_usuario[1];
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($mensagem_retorno);
	return $vetor_retorno;
}

//___________________________________________________


function upload_delete() 
{
	
	$erro = 0;
	$mensagem_retorno = 'Upload exclu�do com sucesso';//$_REQUEST['id_arquivo'];
	
	$upload = new Upload(floor($_REQUEST['id_arquivo']));
	if($upload->id)
	{
		$upload->delete();
	}
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($mensagem_retorno);
	
	return $vetor_retorno;
}

//___________________________________________________


function upload_view()
{
	$upload = new Upload(floor($_REQUEST['id_arquivo']));
	if(!$upload->id)
	{
		$erro = 1;
		$arquivo = 'Arquivo n�o existe.';
	}
	else
	{
		$erro = 0;
		$arquivo = DIR_HTM_ROOT . Upload::DESTINO_ARQUIVO . $upload->nome_arquivo;
	}

	$vetor_img = array('jpg', 'jpeg', 'gif', 'png');
	$bool_imagem = in_array(Utils::extensao($arquivo), $vetor_img) ? true : false;

	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($arquivo);
	$vetor_retorno[] = $bool_imagem;
	
	return $vetor_retorno;
}

//___________________________________________________

function toggle_exibir() 
{
	$objeto = new $_REQUEST['classe']($_REQUEST['id_registro']);
	$objeto->bool_exibir = $objeto->bool_exibir==0 ? 1 : 0;
	$objeto->store();

	$erro=0;
	$mensagem_retorno = $objeto->bool_exibir;
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($mensagem_retorno);
	
	return $vetor_retorno;
}

//___________________________________________________

function toggle_destaque() 
{
	$objeto = new $_REQUEST['classe']($_REQUEST['id_registro']);
	$objeto->bool_destacar = $objeto->bool_destacar==0 ? 1 : 0;
	$objeto->store();

	$erro=0;
	$mensagem_retorno = $objeto->bool_destacar;
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($mensagem_retorno);
	
	return $vetor_retorno;
}

//___________________________________________________



function toggle_destacar() 
{
	$objeto = new $_REQUEST['classe']($_REQUEST['id_registro']);
	$objeto->bool_destacar = $objeto->bool_destacar==0 ? 1 : 0;
	$objeto->store();

	$erro=0;
	$mensagem_retorno = $objeto->bool_destacar;
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($mensagem_retorno);
	
	return $vetor_retorno;
}

//___________________________________________________



function lista_cidades()
{
	$repCidades = new TRepository('BrasilCidade');
	$criterio = new TCriteria();
	$criterio->add(new TFilter('id_estado', '=', "'" . $_REQUEST['estado'] . "'"));
	$criterio->setProperty('order', 'nome');
	$cidades = $repCidades->load($criterio);
	
	
	
	ob_start();
	?>
	<select id="id_cidade" name="id_cidade" class="obr">
		<? 
		foreach ($cidades as $cidade)
		{
			if($_REQUEST['id_cidade_sel']>0)
			{
				$seleciona = $_REQUEST['id_cidade_sel']==$cidade->id ? ' selected' : '';
			}
			else
			{
				$seleciona = $cidade->bool_capital==1 ? ' selected' : '';
			}
			?>
	        <option value="<?=$cidade->id?>"<?=$seleciona?>><?=$cidade->nome?></option>
	        <?
		} 
	    ?>
    </select>
	<?
	$result = ob_get_contents();
	ob_clean();
	
	$erro=0;
	$mensagem_retorno = $result;

	$vetor_retorno[] = $erro;
	$vetor_retorno[] = utf8_encode($mensagem_retorno);
	
	return $vetor_retorno;
}


//___________________________________________________

function get_usuario_ficha()
{
	$id_usuario = floor($_REQUEST['id_usuario']);
	$usuario = new UsuarioCMS($id_usuario);
	$con_usuario = unserialize($_SESSION['con_usuario']);
	
	if(!$usuario->id)
	{
		$vetor_retorno[0] = 1;
		$vetor_retorno[1] = utf8_encode('Usu�rio n�o encontrado');
	}
	else
	{
		$vetor_retorno[0] = 0;
		$vetor_retorno[1] = utf8_encode($usuario->nome);
		$vetor_retorno[2] = utf8_encode($usuario->email);
		$vetor_retorno[3] = utf8_encode($usuario->imagem);
		$vetor_retorno[4] = $con_usuario->id==$usuario->id ? 0 : 1; // s� mostra os bot�es de edi��o se n�o for o pr�prio
		
		if($_REQUEST['bool_delecao']==1)
		{
			// verifica se o usu�rio pode ser deletado
			$vetor_retorno[5] = $usuario->pode_deletar() ? 1 : 0;
		}
	}
	
	return $vetor_retorno;
}

//___________________________________________________


// Executa um m�todo de exclus�o na inst�ncia de uma classe definida no ID do objeto no banco

function exclui_item()
{
	$objeto = new $_REQUEST['exec_classe'](floor($_REQUEST['exec_id']));
	
	if(!$objeto->id)
	{
		$vetor_retorno[0] = 1;
		$vetor_retorno[1] = utf8_encode('Objeto n�o encontrado');
	}
	else
	{
		$retorno_metodo = call_user_func(array($objeto, $_REQUEST['exec_metodo']));
		
		$vetor_retorno[0] = 0;
		$vetor_retorno[1] = utf8_encode('<em>Arquivo exclu�do com sucesso.</em>');
	}
	
	return $vetor_retorno;
}



//___________________________________________________


function exclui_foto_usuario()
{
	$usuario = new UsuarioCMS($_REQUEST['id_usuario']);
	//$usuario = $con_cms_user;
	
	if(!$usuario->id)
	{
		$vetor_retorno[0] = 1;
		$vetor_retorno[1] = utf8_encode('Objeto n�o encontrado');
	}
	else
	{
		$retorno_metodo = $usuario->exclui_foto();
		
		$usuario->store();
		$usuario->inicia_sessao(); // -> atualiza os dados da sess�o do usu�rio 
		
		$vetor_retorno[0] = 0;
		$vetor_retorno[1] = utf8_encode('<em>Arquivo exclu�do com sucesso.</em>');
	}
	
	return $vetor_retorno;
}


//___________________________________________________


function fast_insert() 
{
	$objeto = new $_REQUEST['classe']();
	$objeto->nome = $_REQUEST['nome'];
	$id_objeto = $objeto->store();

	$erro=0;
	$mensagem_retorno = $id_objeto;
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = urlencode($mensagem_retorno);
	
	return $vetor_retorno;
}

//___________________________________________________


function excluir_relacao_oferta()
{
	$relacao = new OfertaRelOferta();
	$relacao->delete($_REQUEST['id_relacao']);
	
	$vetor_retorno[] = 0;
	$vetor_retorno[] = urlencode('Rela��o exclu�da.');
	return $vetor_retorno;
}

//___________________________________________________


function get_perfil_tabloides() 
{
	if($vetor_unidades = TabloidePerfil::get_vetor_unidades(floor($_REQUEST['id_perfil'])))
	{
		$erro = 0;
		$mensagem_retorno = $vetor_unidades;
	}
	else
	{
		$erro = 1;
		$mensagem_retorno = urlencode('Perfil n�o encontrado.');
	}
	
	$vetor_retorno[] = $erro;
	$vetor_retorno[] = $mensagem_retorno;
	return $vetor_retorno;
}

//___________________________________________________












