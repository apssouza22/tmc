<?php

/**
 * @author C�cero Louren�o da Silva
 *
 */
class UsuarioCMS extends CMS
{

	const TABLENAME = 'cms_usuario';
	const NO_IMAGE = 'no_image.gif'; // imagem exibida quando n�o houver imagem do arquivo
	const TAMANHO_ARQUIVO = 1024; // --> tamanho m�ximo do arquivo, em KBytes
	const DESTINO_ARQUIVO = 'userfiles/usuarios/';
	const LARGURA_FOTO = 50; // --> tamanho em pixels (redimensionamento)
	const ALTURA_FOTO = 50; // --> tamanho em pixels (redimensionamento)
	const LARGURA_T1 = 35; // --> tamanho em pixels (redimensionamento)
	const ALTURA_T1 = 35; // --> tamanho em pixels (redimensionamento)


	public function delete($id = null)
	{
		$usuario =  $this;

		if ($usuario->pode_deletar()) {
			$usuario->exclui_arquivos();
			//$usuario->exclui_relacoes();
			return parent::delete($usuario->id);
		}
	}

	/**
	 * Verifica as credenciais do usu�rio
	 * @param string $email
	 * @param string $senha
	 * @return vetor com c�digo de erro na casa [0] (0: sucesso) e mensagem na casa [1]
	 */
	public function submete_login()
	{
		$email = $_REQUEST['email'];
		$senha = Authenticate::pwenc($_REQUEST['senha']);

		// verifica se tem usu�rio com este e-mail
		$sql = "SELECT count(*) total FROM cms_usuario WHERE email = '$email'";
		$result = $this->db->query($sql);


		if ($result[0]['total'] == 0) {
			$erro = 1;
			$mensagem = 'E-mail n�o cadastrado.';
		} else {
			$sql = "SELECT id, nome, email FROM cms_usuario WHERE email = '$email' AND senha = '$senha'";
			$result = $this->db->query($sql);
			if ($result) {
				// inicia a sess�o com o usu�rio atual
				$this->inicia_sessao($result[0]);
				$erro = 0;
				$mensagem = $result[0]['email']; // retorna o e-mail para o caso de usar Ajax (JS define o cookie do �ltimo e-mail digitado)
			} else {
				$erro = 2;
				$mensagem = 'Senha inv�lida';
			}
		}
		$vetor_retorno[] = $erro;
		$vetor_retorno[] = urlencode($mensagem);

		return json_encode($vetor_retorno);
	}

	/**
	 * Responde se o usu�rio est� autenticado na sess�o e verifica e-mail e senha
	 * @return bool $retorno Booleano
	 */
	public function autentica_usuario()
	{
		return $_SESSION['con_usuario'] ? true : false;
	}

	/**
	 * Verifica as credenciais do usu�rio e sua permiss�o � p�gina (m�dulo protegido), 
	 * encerrando sua sess�o em caso negativo.
	 */
	public function autentica()
	{
		// verifica as credenciais
		if (!$this->autentica_usuario()) {
			$this->encerra_sessao();
		} else {
			// verifica se h� necessidade de permiss�o ao diret�rio atual e se o usu�rio tem a permiss�o
			if (!ModuloCMS::autentica($this->db, Authenticate::this_folder_name())) {
				$this->encerra_sessao();
			}
		}
	}

	/**
	 * Inicia a vari�vel de sess�o que cont�m o usu�rio autenticado, 
	 * atribuindo a ela o objeto UsuarioCMS respectivo
	 * @param int $id ID do objeto UsuarioCMS no banco. Se passado, instancia o objeto
	 * @return vetor com c�digo de erro na casa [0] (0: sucesso) e mensagem na casa [1]
	 */
	public function inicia_sessao($user)
	{
		$usuario = new stdClass();
		$usuario->email = $user['email'];
		$usuario->nome = $user['nome'];
		$usuario->id = $user['id'];

		if (!$usuario->id) {
			$erro = 1;
			$mensagem = 'Usu�rio inv�lido.';
		} else {
			// armazena o cookie para preencher o campo e-mail na pr�xima vez que for entrar
			setcookie('ultimo_email_login', $usuario->email, time() + 60 * 60 * 24 * 30);

			// armazena o objeto usu�rio na sess�o
			$_SESSION['con_usuario'] = serialize($usuario);

			$erro = 0;
			$mensagem = 'Sess�o iniciada com sucesso.';
		}

		$vetor_retorno[] = $erro;
		$vetor_retorno[] = $mensagem;

		return $vetor_retorno;
	}

	/**
	 * Elimina a vari�vel que armazenava o usu�rio autenticado
	 */
	public function encerra_sessao()
	{
		session_destroy();
		header('Location: ' . DIR_CMS_HTM_ROOT);
	}

	/**
	 * Reenvia a senha por e-mail
	 * @param string $email
	 */
	public static function submete_reenvio($email)
	{
		// verifica se tem usu�rio com este e-mail
		$rep = new TRepository(__CLASS__);
		$criterio = new TCriteria();
		$criterio->add(new TFilter('email', '=', '"' . $email . '"'));
		$criterio->setProperty('limit', 1);
		$lista = $rep->load($criterio);

		if ($lista) {
			$usuario = $lista[0];

			// envia o e-mail__________
			$mail_msg = new Email();
			$mail_msg->set_template('senha.htm');
			$mail_msg->AddAddress($usuario->email, $usuario->nome);
			$mail_msg->Subject = '[Cliente] Reenvio de senha';
			$vetor[] = array('#senha#', Authenticate::pwdec($usuario->senha));
			$mail_msg->set_vetor_replace($vetor);
			$sucesso_email = $mail_msg->Send();
			//_________________________*/

			if (!$sucesso_email) {
				$erro = 2;
				$mensagem = 'Erro no envio do e-mail.';
			} else {
				$erro = 0;
				$mensagem = 'E-mail enviado com sucesso.';
			}
		} else {
			$erro = 1;
			$mensagem = 'E-mail n�o cadastrado.';
		}

		$vetor_retorno[] = $erro;
		$vetor_retorno[] = $mensagem;

		return $vetor_retorno;
	}

	/**
	 * Atualiza as permiss�es do usu�rio. Chamar o m�todo com NULL no primeiro argumento remover� todas as permiss�es do usu�rio.
	 * @param array $vetor Vetor com os IDs dos m�dulos permitidos para os usu�rio 
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function atualiza_permissoes($vetor = null, $id = null)
	{
		$usuario = $id ? $this->find($id) : $this;
		if($id){
			ContainerDi::getObject('UsuarioModuloCMS')
				->delete('WHERE id_usuario ='. $usuario->id);
		}
		// insere as permiss�es contidas no vetor
		if ($vetor) {
			foreach ($vetor as $id_modulo) {
				$perm = new UsuarioModuloCMS();
				$perm->insert(array(
					'id_usuario' => $usuario->id,
					'id_modulo' => $id_modulo
				));
			}
		}
	}

	/**
	 * Retorna a lista de m�dulos permitidos para o usu�rio ou NULL
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function lista_permissoes($id = null)
	{
		$usuario = $id ? new self($id) : $this;
		$vetor = null;
		
		$lista = ContainerDi::getObject('UsuarioModuloCMS')->getAll("WHERE id_usuario = ". $usuario->id);

		if ($lista) {
			foreach ($lista as $permissao) {
				$vetor[] = $permissao->id_modulo;
			}
		}

		return $vetor;
	}

	/**
	 * @param int $id_modulo ID do m�dulo a ser pesquisado
	 * @param int $id_usuario ID do usu�rio no banco.
	 */
	public function verifica_permissao_modulo($id_modulo, $id_usuario)
	{
		$sql = "SELECT count(*) total FROM cms_usuario_modulo WHERE id_usuario = '$id_usuario' AND id_modulo= '$id_modulo'";
		$lista = $this->db->query($sql);
		return (bool) $lista[0]['total'];
	}

	/**
	 * Retorna o endere�o absoluto da imagem do usu�rio
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function get_imagem($id = null, $t1 = false)
	{
		$usuario = $id ? new self($id) : $this;
		$string_thumb = $t1 ? 't1_' : '';

		//echo $usuario->arquivo . '<br />';
		//echo DIR_ROOT . self::DESTINO_ARQUIVO . $string_thumb . $usuario->arquivo . '<br />';
		if (!$usuario->arquivo || !file_exists(DIR_ROOT . self::DESTINO_ARQUIVO . $string_thumb . $usuario->arquivo)) {
			$arquivo = self::NO_IMAGE;
		} else {
			$arquivo = $usuario->arquivo;
		}

		$retorno = DIR_HTM_ROOT . self::DESTINO_ARQUIVO . $string_thumb . $arquivo;

		return $retorno;
	}

	/**
	 * Avisa a senha do usu�rio por e-mail
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function avisar($tipo = 1, $id = null)
	{
		$usuario = $id ? new self($id) : $this;

		// envia o e-mail__________
		$mail_msg = new Email();
		if ($tipo == 1) {
			$mail_msg->set_template('inserir_usuario.htm');
		} else {
			$mail_msg->set_template('editar_usuario.htm');
		}

		$mail_msg->AddAddress($usuario->email);
		$mail_msg->Subject = 'RS Press - Dados de acesso';

		$vetor[] = array('#email#', $usuario->email);
		$vetor[] = array('#senha#', Authenticate::pwdec($usuario->senha));
		$mail_msg->set_vetor_replace($vetor);

		$sucesso_email = $mail_msg->Send();
		//_________________________*/
	}

	public function cria_thumb($arquivo = null)
	{
		$arquivo = $arquivo ? $arquivo : $this->arquivo;
		//die (DIR_ROOT . self::DESTINO_ARQUIVO . $arquivo . '<br />'); 
		Imagem::redimensiona_prop(DIR_ROOT . self::DESTINO_ARQUIVO . $arquivo, self::LARGURA_FOTO, self::ALTURA_FOTO);
		Imagem::redimensiona_prop(DIR_ROOT . self::DESTINO_ARQUIVO . $arquivo, self::LARGURA_T1, self::ALTURA_T1, DIR_ROOT . self::DESTINO_ARQUIVO . 't1_' . $arquivo);
	}

	/**
	 * Exclui os assets direcionados a este usu�rio
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function exclui_arquivos($id = null)
	{
		$usuario = $id ? new self($id) : $this;
		$usuario->exclui_foto();
	}

	/**
	 * Exclui a foto deste usu�rio
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function exclui_foto($id = null)
	{
		$usuario = $id ? new self($id) : $this;
		@unlink(DIR_ROOT . self::DESTINO_ARQUIVO . $usuario->arquivo);
		@unlink(DIR_ROOT . self::DESTINO_ARQUIVO . 't1_' . $usuario->arquivo);
		$usuario->arquivo = '';
	}

	/**
	 * Exclui as rela��es do usu�rio no sistema
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function exclui_relacoes($id = null)
	{
		$usuario = $id ? new self($id) : $this;

		// abdica da autoria dos coment�rios
		$sql = 'UPDATE ' . Comentario::TABLENAME . ' SET id_autor=0 WHERE id_autor=' . $usuario->id;
		$conn = TConnection::open();
		$conn->exec($sql);
	}

	/**
	 * Verifica se o usu�rio pode ser exclu�do
	 * @param int $id ID do registro no banco. Se fornecido, instancia o objeto.
	 */
	public function pode_deletar($id = null)
	{
		$usuario = $id ? new self($id) : $this;
		$bool_pode = true;


		// verifica alguma condi��o de exclus�o
		if ($bool_pode) {
			// n�o permite que o pr�prio usu�rio se exclua
			if ($usuario->id && $usuario->id == $con_usuario->id) {
				$bool_pode = false;
			}
		}


		// verifica outra condi��o de exclus�o
		if ($bool_pode) {
			// c�digo da veririca��o
		}

		return $bool_pode;
	}

}
