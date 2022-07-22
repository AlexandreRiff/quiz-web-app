/* eslint-disable no-console */
const content = document.querySelector(".content");

const addCard = (data) => {
	content.innerHTML = "";
	data.forEach((element) => {
		const html = `<div class="col-sm-6">
		<div class="card text-center">
			<div class="card-body">
				<h5 class="card-title">${element.category}</h5>
				<p class="card-text">${element.total} pergunta${
			element.total > 1 ? "s" : ""
		} sobre ${element.category}.</p>
				<a href="/quiz/quiz/startQuiz/${
					element.category
				}" class="btn btn-bd-primary">Iniciar quiz <i class="bi bi-play-fill"></i></a>
			</div>
		</div>
	</div>`;
		content.innerHTML += html;
	});
};

const listAllQuizzes = () => {
	const url = "/quiz/home/listAllQuizzes";
	fetch(url, {
		method: "GET",
	})
		.then((response) => response.json())
		.then((json) => addCard(json))
		.catch((error) => console.log(error.message));
};

document.addEventListener("DOMContentLoaded", listAllQuizzes);
