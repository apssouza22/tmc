<?php


/**
 * Cuida dos cadastros de tecnicos
 *
 * @author apssouza
 */
class Repetidora extends Model
{
	const TB_NAME = 'repetidora';
	const PG_LISTAR = 'listar.php';
	const PG_DETALHE = 'detalhes.php';
	const PG_EDITAR = 'form.php';
	const PG_PASTA = 'repetidora';
	
	public function getSentinela(){
		return new Equipamento($this->equipamento_id);
		//var_dump($equip)
	}
}

?>
