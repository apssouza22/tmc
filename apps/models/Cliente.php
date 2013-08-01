<?php


/**
 * Cuida das ações do cliente
 *
 * @author apssouza
 */
class Cliente extends Model
{
	const TB_NAME = 'cliente';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'detalhes.php';
	const PG_EDITAR = 'form.php';
	
	
	public function getMatriz(){
		$filter = new Filter;
		$filter->where('ismatriz = 1 AND cliente_id ='.$this->id);
		$oUnidade = new ClienteUnidade();
		$filial = $oUnidade->getAll($filter);
		if(count($filial)){
			return $filial[0];
		}
		
		$filter->where(' cliente_id = '.$this->id)
				->orderBy('id ASC');
		$filial = $oUnidade->getAll($filter);
		
		return $filial[0];
	}
	
	
	public function getFiliais(){
		$matriz = $this->getMatriz();
		if(!$matriz){
			return false;
		}
		$oUnidade = new ClienteUnidade();
		$filter = new Filter;
		$filter->where("id != {$matriz->id} AND cliente_id =".$this->id);
		return $oUnidade->getAll($filter);
	}
}

?>
