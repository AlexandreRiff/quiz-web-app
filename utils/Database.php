<?php

namespace utils;

use PDO;
use PDOException;

class Database
{

	private static function connect()
	{
		try {
			$connection = new PDO(DB_SGBD . ':host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $connection;
		} catch (PDOException $error) {
			die('error: não foi possível conectar-se com o banco de dados. ' . $error->getMessage());
		}
	}

	public static function instance()
	{
		return self::connect();
	}
}