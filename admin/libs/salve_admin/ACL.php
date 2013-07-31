<?php
/**
 * Cuida dos acessos nas diversas �reas do site
 *
 * @author Alexsandro Souza
 * 
 * N�O ESTOU USANDO ESSA CLASSE, � UM PROJETO PARA O FUTURO
 * 
 */
class Acl
{
	private $profiles = array();
	private $area = array();
	
	/**
	 * Adiciona as permiss�es pertinentes ao perfil/usu�rio
	 * @param string $perfil string com o perfil do usu�rio ex. visitante
	 * @param string $allow string com a  permiss�o concedida ao perfil ex. editar
	 */
	public function addAllow($profile,$allow){
		$this->profiles[$profile][] = $allow;
	}
	
	/**
	 * Remove a permiss�o dada anteriormente pelo m�todo addAllow
	 * @param string $perfil string com o perfil do usu�rio ex. visitante
	 * @param string $allow string com a  permiss�o concedida ao perfil ex. editar
	 * @return Boolean com o resultado da opera��o
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
	 * Adiciona um perfil e as a��es liberadas a esse perfil
	 * @param string $area nome do modulo 
	 * @param string $perfil nome do perfil
	 * @param array $actions lista com as a��es perfmitidas para o pefil
	 */
	public function allowArea($area, $perfil, $actions )
	{
		
	}
	
	
	
	
}

?>
