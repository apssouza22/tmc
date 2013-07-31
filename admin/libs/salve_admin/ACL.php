<?php
/**
 * Cuida dos acessos nas diversas áreas do site
 *
 * @author Alexsandro Souza
 * 
 * NÃO ESTOU USANDO ESSA CLASSE, É UM PROJETO PARA O FUTURO
 * 
 */
class Acl
{
	private $profiles = array();
	private $area = array();
	
	/**
	 * Adiciona as permissões pertinentes ao perfil/usuário
	 * @param string $perfil string com o perfil do usuário ex. visitante
	 * @param string $allow string com a  permissão concedida ao perfil ex. editar
	 */
	public function addAllow($profile,$allow){
		$this->profiles[$profile][] = $allow;
	}
	
	/**
	 * Remove a permissão dada anteriormente pelo método addAllow
	 * @param string $perfil string com o perfil do usuário ex. visitante
	 * @param string $allow string com a  permissão concedida ao perfil ex. editar
	 * @return Boolean com o resultado da operação
	 */
	public function deny($profile,$allow){
		if (in_array($allow, $this->profiles[$profile])) {
			$pos = array_search($allow, $this->profiles[$profile]);
			array_slice($this->profiles[$profile], $pos, 1);
			return $this->profiles[$profile];
		}
		return false;
	}
	
	/**
	 * Adiciona um perfil e as ações liberadas a esse perfil
	 * @param string $area nome do modulo 
	 * @param string $perfil nome do perfil
	 * @param array $actions lista com as ações perfmitidas para o pefil
	 */
	public function allowArea($area, $perfil, $actions )
	{
		
	}
	
	
	
	
}

?>
