const he = require("he");

// ** components **
const body = document.querySelector("body");
const questionText = document.querySelector(".question-text");
const answerAlternative = document.querySelectorAll(".answer-alternative");
const btnNextQuestion = document.querySelector(".btn-next-question");
const btnTryAgain = document.getElementById("btn-try-again");
const quizResult = document.getElementById("quiz-result");
// ** end components **

const categoryUri = window.location.pathname.split("/")[4];

let data = {};
let index = 0;
let answered = false;
let score = 0;

// * clears the previously selected answer
const clearAnswer = () => {
	answerAlternative.forEach((element) => {
		element.className = "answer-alternative";
		element.firstElementChild.className = "answer-alternative-letter";
		element.firstElementChild.innerText = element.dataset.letter;
	});
};

// * checks if the selected answer is correct
const checkAnswer = (element) => {
	if (!answered) {
		if (element.dataset.letter === data[index].correct_answer_alternative) {
			element.className += " correct";
			element.firstElementChild.className += " correct-letter";
			element.firstElementChild.innerHTML =
				'<i class="bi bi-check-circle-fill"></i>';
			score += 1;
		} else {
			element.className += " wrong";
			element.firstElementChild.className += " wrong-letter";
			element.firstElementChild.innerHTML =
				'<i class="bi bi-x-circle-fill"></i>';
		}
	}
	if (index >= data.length - 1) {
		btnNextQuestion.innerHTML = 'Finalizar Quiz <i class="bi bi-check-lg"></i>';
		btnNextQuestion.dataset.bsToggle = "modal";
		btnNextQuestion.dataset.bsTarget = "#staticBackdrop";
		quizResult.innerText = `Você acertou: ${score} de ${data.length} questões.`;
	}
	btnNextQuestion.style.visibility = "visible";
	answered = true;
};

// * add the question and its answer alternatives to the screen
const addQuestion = (i) => {
	clearAnswer();
	answered = false;
	btnNextQuestion.style.visibility = "hidden";
	questionText.innerText = he.decode(data[i].question_text);
	answerAlternative.forEach((element) => {
		switch (element.dataset.letter) {
			case "A":
				element.children[1].innerText = he.decode(data[i].alternatives.A);
				break;
			case "B":
				element.children[1].innerText = he.decode(data[i].alternatives.B);
				break;
			case "C":
				element.children[1].innerText = he.decode(data[i].alternatives.C);
				break;
			case "D":
				element.children[1].innerText = he.decode(data[i].alternatives.D);
				break;
			default:
				break;
		}
		element.addEventListener("click", () => checkAnswer(element));
	});
};

// * list all questions by category
const listAllQuestionsByCategory = (category) => {
	const url = `/quiz/quiz/listAllQuestionsByCategory/${category}`;
	fetch(url, {
		method: "GET",
	})
		.then((response) => response.json())
		.then((json) => {
			data = json;
			addQuestion(index);
		})
		.catch((error) => console.log(error.message));
};

// * add the next question to the screen
btnNextQuestion.addEventListener("click", () => {
	if (index < data.length - 1) {
		index += 1;
		addQuestion(index);
	}
});

// * reset everything and restart the quiz
const tryAgain = () => {
	score = 0;
	index = 0;
	btnNextQuestion.innerHTML =
		'Próxima Questão <i class="bi bi-arrow-right"></i>';
	btnNextQuestion.dataset.bsToggle = "";
	btnNextQuestion.dataset.bsTarget = "";
	addQuestion(index);
};

// * fetch the quiz question data on page load and launch the quiz
body.addEventListener("onload", listAllQuestionsByCategory(categoryUri));
btnTryAgain.addEventListener("click", tryAgain);
