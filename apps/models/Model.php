<?php

/**
 * Classe com ações comuns do Negócio
 *
 * @author apssouza
 */
abstract class Model
{

	public function __construct($id = null)
	{
		if (isset($id) && !empty($id)) {
			$filter = new Filter();
			$filter->where("id=$id");
			$objs = $this->getAll($filter);
			if (is_array($objs) && count($objs)) {
				foreach (get_object_vars($objs[0]) as $key => $value) {
					$this->$key = $value;
				}
			}
		}
	}

	public function changeStatus()
	{
		$selfClass = get_class($this);
		$self = new $selfClass($_REQUEST['id_registro']);
		$status = $self->status ? 0 : 1;
		$this->update(array('status' => $status), $_REQUEST['id_registro']);
		return json_encode(array(
			0,
			'Alterado com sucesso'
		));
	}

	public function store($data){
		if(isset($data['id']) && $data['id'] != '' ){
			$this->update($data, $data['id']);
			return $data['id'];
		}
		return $this->insert($data);
	}
	
	public function insert($data)
	{
		return Query::create()
//->insert(static::TB_NAME)
						->insert(constant(get_class($this) . "::TB_NAME"))
						->data($data, true)
						->save();
	}

	public function update($data, $id)
	{
		return Query::create()
//->update(static::TB_NAME)
						->update(constant(get_class($this) . "::TB_NAME"))
						->data($data)
						->where('id = :id', array(
							'id' => $id
						))
						->save();
	}

	public function delete($id = null)
	{
		$id = $id ?: $this->id;
		return Query::create()
//->delete(static::TB_NAME)
						->delete(constant(get_class($this) . "::TB_NAME"))
						->where("id = :id", array('id' => $id))
						->exec();
	}

	public function getAll(Filter $filter = null, $obj = true)
	{
		$select = Query::create(get_class($this))
				->select()
//->from(static::TB_NAME);
				->from(constant(get_class($this) . "::TB_NAME"));

		if ($filter) {
			$select->setFilter($filter);
		}

		if ($obj) {
			return $select->fetchAllObject();
		} else {
			return $select->fetchAll();
		}
	}
	
	public function getAllVisible(){
		$filter = new Filter();
		$filter->where('status=1');
		return $this->getAll($filter);
	}

	public function count(Filter $filter = null)
	{
		$select = Query::create(get_class($this))
				->select('count(*) total')
				->from(constant(get_class($this) . "::TB_NAME"));

		if ($filter) {
			$select->setFilter($filter);
		}
//echo $select->getQuery();
		$result = $select->fetchOne();
		return $result['total'];
	}

}