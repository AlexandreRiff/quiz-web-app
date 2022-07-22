<?php

namespace controller;

use dao\QuizDao;
use utils\View;

class Home
{
	private $quizDao;

	public function __construct()
	{
		$this->quizDao = new QuizDao();
	}

	public function index()
	{
		View::render('home');
	}

	public function listAllQuizzes()
	{
		$data = $this->quizDao->listAllQuizzes();
		echo json_encode($data);
	}
}