<?php

/**
 * @author C�cero Louren�o da Silva
 *
 */
class ModuloCMS extends CMS
{

	const TABLENAME = 'cms_modulo';
	const DIRETORIO_IMAGEM = 'imagens/modulos/';
	const PREFIXO_IMAGEM = 'modulo_';
	const EXTENSAO_IMAGEM = '.png';

	/**
	 * Verifica se o diret�rio pesquisado � protegido e, em caso afirmativo, 
	 * verifica se o usu�rio fornecido tem permiss�o para acessar o m�dulo
	 * @param PDO $db resource da conec��o com o banco
	 * @param string $pasta nome do diret�rio pesquisado
	 * @param int $id_usuario ID do usu�rio no banco
	 * @return bool $retorno booleano (TRUE para permiss�o concedida)
	 */
	public static function autentica($db, $pasta)
	{
		$retorno = true;
		$usuario = unserialize($_SESSION['con_usuario']);

		if (!$usuario->id) {
			$retorno = false;
		} else {
			// verifica se h� necessidade de permiss�o ao diret�rio atual
			$sql= "SELECT * FROM cms_modulo WHERE diretorio = '$pasta' limit 1";
			$lista = $db->query($sql);
			if ($lista) {
				// diret�rio est� protegido, ent�o verifica a permiss�o do usu�rio ao m�dulo
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
	 * Retorna o endere�o absoluto HTML da imagem que representa o m�dulo ou da imagem padr�o, se n�o existir
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
	 * @param string $diretorio Diret�rio da p�gina atual
	 * @param string $dir_modulo Diret�rio do m�dulo pesquisado
	 */
	public static function getVetor($diretorio, $dir_modulo)
	{
		$db = new DataBase(ContainerDi::getDb());
		$vetor['auth'] = self::autentica($db, $dir_modulo);
		$vetor['current'] = $diretorio == $dir_modulo ? true : false;

		return $vetor;
	}

}
