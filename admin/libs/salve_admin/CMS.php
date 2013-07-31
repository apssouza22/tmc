<?php

/**
 * Description of CMS
 *
 * @author User
 */
class CMS
{

	protected $db;

	public function __construct(PDO $pdo = null)
	{
		if ($pdo) {
			$db = new DataBase($pdo);
			$this->db = $db;
		} else {
			$this->db = new DataBase(ContainerDi::getDb());
		}
	}

	public function getAll($where = "")
	{
		$query = "SELECT * FROM " . constant(get_class($this) . "::TABLENAME") . " " . $where;
		return $this->db->fetchAllObject($query, get_class($this));
	}

	public function find($id)
	{
		$result = $this->getAll("WHERE id = $id");
		return is_array($result) ? $result[0] : false;
	}

	public function delete($where)
	{
		if(is_numeric($where)){
			$where = " WHERE id=".$where;
		}
		return $this->db->execute("DELETE FROM " . constant(get_class($this) . "::TABLENAME") .' '. $where);
	}

	public function insert($data)
	{
		$sql = "INSERT INTO " . constant(get_class($this) . "::TABLENAME") . " (";
		$sql .= implode(', ', array_keys($data)) . ' )';
		foreach ($data as $column => $value) {
				$insert[] = "'{$value}'";
			}
		$sql .= " VALUES (" . implode(', ', $insert) . ")";

		$this->db->execute($sql);
		return $this->db->lastInsertId();
	}

	public function update($data, $where)
	{
		if (is_array($data)) {
			foreach ($data as $column => $value) {
				$set[] = "{$column} = '{$value}'";
			}
		}
		if(is_numeric($where)){
			$where = " WHERE id=".$where;
		}

		$sql = "UPDATE " . constant(get_class($this) . "::TABLENAME");
		$sql .= ' SET ' . implode(', ', $set);
		$sql .= ' '.$where;
		
		$stmte = $this->db->execute($sql);
		return $stmte->rowCount();
	}
	
	public function store($data){
		if(isset($data['id'])){
			return $this->update($data, $data['id']);
		}else{
			return $this->insert($data);
		}
	}

}

?>
