<?php

namespace dao;

use model\Question;
use utils\Database;
use PDO;
use PDOException;

class QuestionDao
{

	private $db;

	public function __construct()
	{
		$this->db = Database::instance();
	}

	public function saveQuestion(Question $question)
	{
		$sql = 'INSERT INTO quiz_question (question_text, category, correct_answer_alternative) VALUES (:question_text, :category, :correct_answer_alternative)';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':question_text', $question->getQuestionText(), PDO::PARAM_STR);
		$stmt->bindValue(':category', $question->getCategory(), PDO::PARAM_STR);
		$stmt->bindValue(':correct_answer_alternative', $question->getCorrectAnswerAlternative(), PDO::PARAM_STR);
		try {
			$stmt->execute();
		} catch (PDOException $error) {
			die("error: {$error->getMessage()}");
		}
		if ($stmt->rowCount() > 0) {
			$question_id = $this->db->lastInsertId();
			$sql = 'INSERT INTO quiz_answer_alternatives (question_id, alternative, answer) VALUES (:question_id, :alternative, :answer)';
			$stmt = $this->db->prepare($sql);
			foreach ($question->getAnswerAlternatives() as $key => $value) {
				$stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
				$stmt->bindParam(':alternative', $key, PDO::PARAM_STR);
				$stmt->bindParam(':answer', $value, PDO::PARAM_STR);
				try {
					$stmt->execute();
				} catch (PDOException $error) {
					die("error: {$error->getMessage()}");
				}
			}
			return true;
		}
		return false;
	}

	public function updateQuestion(Question $question)
	{
		$ok = false;
		$sql = 'UPDATE quiz_question SET question_text = :question_text, category = :category, correct_answer_alternative = :correct_answer_alternative, updated = CURRENT_TIMESTAMP WHERE id = :id';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $question->getId(), PDO::PARAM_INT);
		$stmt->bindValue(':question_text', $question->getQuestionText(), PDO::PARAM_STR);
		$stmt->bindValue(':category', $question->getCategory(), PDO::PARAM_STR);
		$stmt->bindValue(':correct_answer_alternative', $question->getCorrectAnswerAlternative(), PDO::PARAM_STR);
		try {
			$stmt->execute();
		} catch (PDOException $error) {
			die("error: {$error->getMessage()}");
		}

		if ($stmt->rowCount() > 0) {
			$ok = true;
		}

		$sql = 'UPDATE quiz_answer_alternatives SET answer = :answer, updated = CURRENT_TIMESTAMP WHERE question_id = :question_id AND alternative = :alternative';
		$stmt = $this->db->prepare($sql);
		foreach ($question->getAnswerAlternatives() as $key => $value) {
			$stmt->bindValue(':question_id', $question->getId(), PDO::PARAM_INT);
			$stmt->bindParam(':alternative', $key, PDO::PARAM_STR);
			$stmt->bindParam(':answer', $value, PDO::PARAM_STR);
			try {
				$stmt->execute();
			} catch (PDOException $error) {
				die("error: {$error->getMessage()}");
			}
		}

		if ($stmt->rowCount() > 0) {
			$ok = true;
		}

		return $ok;
	}

	public function listAllQuestions()
	{
		$sql = 'SELECT *, DATE_FORMAT(created, \'%d/%m/%y %H:%i:%s\') AS created, DATE_FORMAT(updated, \'%d/%m/%y %H:%i:%s\') AS updated FROM quiz_question ORDER BY id DESC';
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

	public function searchQuestions(Question $question)
	{
		$sql = 'SELECT *, DATE_FORMAT(created, \'%d/%m/%y %H:%i:%s\') AS created, DATE_FORMAT(updated, \'%d/%m/%y %H:%i:%s\') AS updated FROM quiz_question WHERE id LIKE :id AND question_text LIKE :question_text AND category LIKE :category ORDER BY id DESC';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', '%' . ($question->getId() ?: '') . '%', PDO::PARAM_STR);
		$stmt->bindValue(':question_text', '%' . ($question->getQuestionText() ?: '') . '%', PDO::PARAM_STR);
		$stmt->bindValue(':category', '%' . ($question->getCategory() ?: '') . '%', PDO::PARAM_STR);
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

	public function searchQuestionByid(Question $question)
	{
		$sql = 'SELECT qq.*, qaa.* FROM quiz_question qq INNER JOIN quiz_answer_alternatives qaa ON qq.id = qaa.question_id WHERE qq.id = :id ';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $question->getId(), PDO::PARAM_INT);
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

	public function deleteQuestion(Question $question)
	{
		$sql = 'DELETE FROM quiz_question WHERE id = :id';
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $question->getId(), PDO::PARAM_INT);
		try {
			$stmt->execute();
		} catch (PDOException $error) {
			die("error: {$error->getMessage()}");
		}
		if ($stmt->rowCount() > 0) {
			return true;
		}
		return false;
	}

	public function listAllQuestionsByCategory(Question $question)
	{
		$sql = <<<SQL
			SELECT qq.id, qq.question_text, qq.correct_answer_alternative, qaa.question_id, qaa.alternative, qaa.answer
				FROM quiz_question qq
				INNER JOIN quiz_answer_alternatives qaa ON qq.id = qaa.question_id
				WHERE qq.category = :category
			ORDER BY qq.id DESC
SQL;

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':category', $question->getCategory(), PDO::PARAM_STR);
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