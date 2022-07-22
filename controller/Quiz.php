<?php

namespace controller;

use model\Question;
use dao\QuestionDao;
use utils\View;

class Quiz
{

	private $question;
	private $questionDao;

	public function __construct()
	{
		$this->question = new Question();
		$this->questionDao = new QuestionDao();
	}

	public function startQuiz()
	{
		View::render('quiz');
	}

	public function listAllQuestionsByCategory($category)
	{
		$this->question->setCategory($category);
		$data = $this->questionDao->listAllQuestionsByCategory($this->question);

		$new_data = array();

		for ($i = 0; $i < count($data); $i++) {
			$ok = false;
			if (!empty($new_data)) {
				for ($x = 0; $x < count($new_data); $x++) {
					if ($new_data[$x]['question_id'] == $data[$i]['question_id']) {
						$new_data[$x]['alternatives'][$data[$i]['alternative']] = $data[$i]['answer'];
						$ok = true;
						break;
					}
				}
			}

			if ($ok == true) {
				continue;
			}

			$new_data[] = array(
				'question_id' => $data[$i]['question_id'],
				'question_text' => $data[$i]['question_text'],
				'correct_answer_alternative' => $data[$i]['correct_answer_alternative'],
				'alternatives' => array(
					$data[$i]['alternative'] => $data[$i]['answer']
				),
			);
		}

		echo json_encode($new_data);
	}
}
