<?php

namespace dao;

use utils\Database;
use PDO;
use PDOException;

class QuizDao
{

	private $db;

	public function __construct()
	{
		$this->db = Database::instance();
	}

	public function listAllQuizzes()
	{
		$sql = 'SELECT category, COUNT(*) AS total FROM quiz_question GROUP BY category';
		$stmt = $this->db->prepare($sql);
		try {
			$stmt->execute();
		} catch (PDOException $error) {
			die("error: {$error->getMessage()}");
		}
		if ($stmt->rowCount() > 0) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return false;
	}
}