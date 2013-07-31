<?php

/**
 * @author Cícero Lourenço da Silva
 *
 */
class ModuloCMS extends CMS
{

	const TABLENAME = 'cms_modulo';
	const DIRETORIO_IMAGEM = 'imagens/modulos/';
	const PREFIXO_IMAGEM = 'modulo_';
	const EXTENSAO_IMAGEM = '.png';

	/**
	 * Verifica se o diretório pesquisado é protegido e, em caso afirmativo, 
	 * verifica se o usuário fornecido tem permissão para acessar o módulo
	 * @param PDO $db resource da conecção com o banco
	 * @param string $pasta nome do diretório pesquisado
	 * @param int $id_usuario ID do usuário no banco
	 * @return bool $retorno booleano (TRUE para permissão concedida)
	 */
	public static function autentica($db, $pasta)
	{
		$retorno = true;
		$usuario = unserialize($_SESSION['con_usuario']);

		if (!$usuario->id) {
			$retorno = false;
		} else {
			// verifica se há necessidade de permissão ao diretório atual
			$sql= "SELECT * FROM cms_modulo WHERE diretorio = '$pasta' limit 1";
			$lista = $db->query($sql);
			if ($lista) {
				// diretório está protegido, então verifica a permissão do usuário ao módulo
				$modulo = $lista[0];
				
				$sql= "SELECT count(*) total FROM cms_usuario_modulo WHERE id_usuario = '{$usuario->id}' AND id_modulo= '{$modulo['id']}'";
				$lista = $db->query($sql);

				if ($lista[0]['total'] == 0) {
					$retorno = false;
				}
			}
		}

		return $retorno;
	}

	/**
	 * Retorna o endereço absoluto HTML da imagem que representa o módulo ou da imagem padrão, se não existir
	 * @param int $id ID do objeto no banco. Se informado, instancia um objeto
	 */
	public function get_imagem($id = null)
	{
		$modulo = $id ? $this->find($id) : $this;
		$caminho_php = DIR_CMS_ROOT . self::DIRETORIO_IMAGEM;
		$caminho_html = DIR_CMS_HTM_ROOT . self::DIRETORIO_IMAGEM;
		$imagem = self::PREFIXO_IMAGEM . $modulo->diretorio . self::EXTENSAO_IMAGEM;

		if (!file_exists($caminho_php . $imagem)) {
			$imagem = 'padrao.png';
		}

		return $caminho_html . $imagem;
	}

	/**
	 * Auxilia na montagem do menu superior (classe do item ativo e imagem respectiva)
	 * @param string $diretorio Diretório da página atual
	 * @param string $dir_modulo Diretório do módulo pesquisado
	 */
	public static function getVetor($diretorio, $dir_modulo)
	{
		$db = new DataBase(ContainerDi::getDb());
		$vetor['auth'] = self::autentica($db, $dir_modulo);
		$vetor['current'] = $diretorio == $dir_modulo ? true : false;

		return $vetor;
	}

}
