<?php

/**
 * Cuida da geração do relatório
 *
 * @author apssouza
 */
class Relatorio extends Model
{
	/**
	 * Retorna uma lista de chamados com informações do cliente e equipamento 
	 */
	public function getRelatorioIndisponibilidade(Filter $filter, $cliente = null)
	{
		$cliente = $cliente ? ' AND cl.id ='.$cliente : '';
		$oSelect = new Select('cl.empresa, eq.cliente_id, eq.descricao, eq.ip,uc.nome , ch.*', __CLASS__);
		return $oSelect->from(Chamado::TB_NAME.' ch')
						->innerJoin(Queda::TB_NAME . " q ON ch.id = q.chamado_id ")
						->innerJoin(Equipamento::TB_NAME . " eq ON eq.id = q.equip_id  ")
						->innerJoin(Cliente::TB_NAME . " cl ON cl.id = ch.cliente_id ".$cliente )
						->innerJoin(ClienteUnidade::TB_NAME . " uc ON uc.id = ch.unidade_id ".$cliente )
						->setFilter($filter)
						->fetchAllObject();
	}
	
	

}

?>
