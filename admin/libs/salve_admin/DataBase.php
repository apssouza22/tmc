<?php
/**
 * Cuida das interações com o banco
 *
 * @author Alexsandro Souza
 */
class DataBase
{
	private $conn;

	public function __construct($pdo)
	{
		$this->conn = $pdo;
	}
	
	public function query($sql)
	{
		try{
			$result = $this->conn->query($sql);
			return $result->fetchAll();
		}  catch (Exception $e){
			echo $sql ."<br>";
			echo $e->getMessage();
		}		
	}
	
	public function execute($query){
		$stmte = $this->conn->prepare($query);
		$stmte->execute();
		return $stmte;
	}
	
	public function fetchAllObject($query, $class) {
		$stmte = $this->conn->prepare($query);
		$stmte->execute();
		
		if ($stmte) {
			$stmte->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
			return $stmte->fetchAll();
		} else {
			return false;
		}
	}
	
	public function lastInsertId(){
		return $this->conn->lastInsertId();
	}


	public function __destruct()
	{
		$this->conn = null;
	}
	
	
}

