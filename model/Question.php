<?php

namespace model;

class Question
{
	private $id;
	private $questionText;
	private $category;
	private $answerAlternatives;
	private $correctAnswerAlternative;

	public $erro;

	public function setId($id)
	{
		if (!empty($id) && is_numeric($id)) {
			$this->id = $id;
		} else {
			$this->erro = true;
		}
	}

	public function setQuestionText($questionText)
	{
		if (!empty($questionText)) {
			$this->questionText = $questionText;
		} else {
			$this->erro = true;
		}
	}

	public function setCategory($category)
	{
		if (!empty($category)) {
			$this->category = strtoupper($category);
		} else {
			$this->erro = true;
		}
	}

	public function setAnswerAlternatives($answerAlternatives)
	{
		if (!empty($answerAlternatives)) {
			$this->answerAlternatives = $answerAlternatives;
		} else {
			$this->erro = true;
		}
	}

	public function setCorrectAnswerAlternative($correctAnswerAlternative)
	{
		if (!empty($correctAnswerAlternative)) {
			$this->correctAnswerAlternative = $correctAnswerAlternative;
		} else {
			$this->erro = true;
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function getQuestionText()
	{
		return $this->questionText;
	}

	public function getCategory()
	{
		return $this->category;
	}

	public function getAnswerAlternativeA()
	{
		return $this->answerAlternativeA;
	}

	public function getAnswerAlternatives()
	{
		return $this->answerAlternatives;
	}

	public function getCorrectAnswerAlternative()
	{
		return $this->correctAnswerAlternative;
	}
}
