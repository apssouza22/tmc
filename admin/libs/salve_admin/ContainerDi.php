<?php

class ContainerDi {

    public static function getDb() {
		$db_porta = CMS_DB_PORTA ? CMS_DB_PORTA : '3306';
		$conn = new PDO("mysql:host=".CMS_DB_HOST."; dbname=".CMS_DB_NOME."; port={$db_porta}", CMS_DB_USUARIO, CMS_DB_SENHA);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
    }

    public static function getObject($name, $data = "") {
        if ($data)
            $objct = new $name(self::getDb(), $data);
        else
            $objct= new $name(self::getDb());
        return $objct;
    }
}