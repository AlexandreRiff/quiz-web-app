<?php

namespace controller;

use model\Question;
use dao\QuestionDao;
use http\Request;
use utils\View;

session_name('auth');
session_start();

class AdminPanel
{
	private $question;
	private $questionDao;

	public function __construct()
	{
		if (!isset($_SESSION['login']) || !$_SESSION['login']) {
			http_response_code(403);
			header('Location: /quiz/login');
			exit;
		} else {
			$this->question = new Question();
			$this->questionDao = new QuestionDao();
		}
	}

	public function index()
	{
		View::render('admin-panel');
	}

	public function saveQuestion()
	{
		$id = Request::post('id', FILTER_SANITIZE_NUMBER_INT);
		$questionText = Request::post('inAddEditQuestionText');
		$category = Request::post('inAddEditQuestionCategory');
		$answerAlternativeA = Request::post('inAddEditAnswerAlternativeA');
		$answerAlternativeB = Request::post('inAddEditAnswerAlternativeB');
		$answerAlternativeC = Request::post('inAddEditAnswerAlternativeC');
		$answerAlternativeD = Request::post('inAddEditAnswerAlternativeD');
		$correctAnswerAlternative = Request::post('inAddEditCorrectAnswerAlternative');

		$answer_alternatives = array(
			'A' => $answerAlternativeA,
			'B' => $answerAlternativeB,
			'C' => $answerAlternativeC,
			'D' => $answerAlternativeD,
		);

		$this->question->setId($id);
		$this->question->setQuestionText($questionText);
		$this->question->setCategory($category);
		$this->question->setAnswerAlternatives($answer_alternatives);
		$this->question->setCorrectAnswerAlternative($correctAnswerAlternative);

		if ($this->question->getId() == 0) {
			$this->questionDao->saveQuestion($this->question) ? http_response_code(201) : http_response_code(200);
		} else {
			$this->questionDao->updateQuestion($this->question) ? http_response_code(201) : http_response_code(200);
		}
	}

	public function listAllQuestions()
	{
		$data = $this->questionDao->listAllQuestions();
		echo json_encode($data);
	}

	public function searchQuestions()
	{
		$id = Request::get('id', FILTER_SANITIZE_NUMBER_INT);
		$questionText = Request::get('questionText');
		$category = Request::get('category');
		$this->question->setId($id);
		$this->question->setQuestionText($questionText);
		$this->question->setCategory($category);
		$data = $this->questionDao->searchQuestions($this->question);
		echo json_encode($data);
	}

	public function searchQuestionById()
	{
		$id = Request::get('id', FILTER_SANITIZE_NUMBER_INT);
		$this->question->setId($id);
		$data = $this->questionDao->searchQuestionById($this->question);
		echo json_encode($data);
	}

	public function deleteQuestion()
	{
		$id = Request::get('id', FILTER_SANITIZE_NUMBER_INT);
		$this->question->setId($id);
		$this->questionDao->deleteQuestion($this->question) ? http_response_code(201) : http_response_code(200);
	}
}
