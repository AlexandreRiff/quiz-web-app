<?php

namespace dao;

use model\User;
use utils\Database;
use PDO;
use PDOException;

class UserDao
{

	private $db;

	public function __construct()
	{
		$this->db = Database::instance();
	}

	public function searchUserByEmail(User $user)
	{
		$sql = 'SELECT password FROM quiz_user WHERE email = :email';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
		try {
			$stmt->execute();
		} catch (PDOException $error) {
			die("error: {$error->getMessage()}");
		}
		if ($stmt->rowCount() == 1) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return false;
	}
}