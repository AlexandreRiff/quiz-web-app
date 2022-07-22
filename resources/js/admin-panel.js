/* eslint-disable no-use-before-define */
/* eslint-disable no-unused-vars */
const bootstrap = require("bootstrap");
const Swal = require("sweetalert2");
const he = require("he");

// ** components **

// * forms
const formAddEditQuestion = document.getElementById("form-add-edit-question");
const formSearchQuestions = document.getElementById("form-search-questions");
// *

// * sections
const sidebar = document.querySelector(".sidebar");
const content = document.querySelector(".content");
// *

// * modal
const modal = new bootstrap.Modal(document.querySelector(".modal"), {});
const modalTitle = document.getElementById("staticBackdropLabel");
// *

// * inputs
// * inputs - question text (input text)
const inAddEditQuestionText = document.getElementById(
	"in-add-edit-question-text"
);

// * inputs - question category (input text)
const inAddEditQuestionCategory = document.getElementById(
	"in-add-edit-question-category"
);

// * inputs - answer alternatives (input text)
const inAddEditAnswerAlternativeA = document.getElementById(
	"in-add-edit-answer-alternative-a"
);
const inAddEditAnswerAlternativeB = document.getElementById(
	"in-add-edit-answer-alternative-b"
);
const inAddEditAnswerAlternativeC = document.getElementById(
	"in-add-edit-answer-alternative-c"
);
const inAddEditAnswerAlternativeD = document.getElementById(
	"in-add-edit-answer-alternative-d"
);

// * inputs - correct answer alternative (radio button)
const inAddEditCorrectAnswerAlternativeA = document.getElementById(
	"in-add-edit-correct-answer-alternative-a"
);
const inAddEditCorrectAnswerAlternativeB = document.getElementById(
	"in-add-edit-correct-answer-alternative-b"
);
const inAddEditCorrectAnswerAlternativeC = document.getElementById(
	"in-add-edit-correct-answer-alternative-c"
);
const inAddEditCorrectAnswerAlternativeD = document.getElementById(
	"in-add-edit-correct-answer-alternative-d"
);
// * end inputs

// * buttons
const btnAdd = document.getElementById("btn-add");
const btnShowSearch = document.getElementById("btn-show-search");
const btnSave = document.getElementById("btn-save");
const btnSearch = document.getElementById("btn-search");
// *

// ** end components **

// * add question content to the screen
const addCard = (data) => {
	content.innerHTML = "";
	data.forEach((element, index) => {
		const html = `<div class="card text-center">
      <div class="card-body">
				<h5 class="card-title">ID: ${element.id}</h5>
				<p class="card-text">
					${element.question_text}
				</p>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item">#${element.category}</li>
				<li class="list-group-item">Atualizado em: ${
					element.updated ?? element.created
				}</li>
			</ul>
			<div class="card-body">
				<button
					class="btn btn-bd-primary"
					data-bs-toggle="modal"
					data-bs-target="#staticBackdrop"
					data-edit-id="${element.id}"
					>Editar <i class="bi bi-pencil"></i></button>
				<button
					class="btn btn-bd-primary"
					data-delete-id="${element.id}"
					>Excluir <i class="bi bi-trash3"></i>
				</button>
			</div>
		</div>`;
		content.innerHTML += html;
	});
	const btnEdit = document.querySelectorAll("[data-edit-id]");
	const btnDelete = document.querySelectorAll("[data-delete-id]");
	Array.from(btnEdit).forEach((element) => {
		element.addEventListener("click", () =>
			searchQuestionById(element.dataset.editId)
		);
	});
	Array.from(btnDelete).forEach((element) => {
		element.addEventListener("click", () =>
			deleteQuestion(element.dataset.deleteId)
		);
	});
};

// * list all questions
const listAllQuestions = () => {
	const url = "/quiz/adminPanel/listAllQuestions";
	fetch(url, {
		method: "GET",
	})
		.then((response) => response.json())
		.then((json) => addCard(json))
		.catch((error) => console.log(error.message));
};

// * add or update a question
const saveQuestion = (id) => {
	if (formAddEditQuestion.checkValidity()) {
		const modalBackdrop = document.querySelector(".modal-backdrop");
		modal.hide();
		modalBackdrop.remove();
		const data = new FormData(formAddEditQuestion);
		data.append("id", id);
		const url = "/quiz/adminPanel/saveQuestion";
		fetch(url, {
			method: "POST",
			body: data,
		})
			.then((response) => {
				if (response.status === 201) {
					formAddEditQuestion.reset();
					Swal.fire({
						title: "Salvo com sucesso!",
						icon: "success",
					});
					listAllQuestions();
				}
			})
			.catch((error) => console.log(error));
		document.body.style = "";
	}
};

// * add the values of a question to the form
const setQuestionValues = (data) => {
	data.forEach((element) => {
		inAddEditQuestionText.value = he.decode(element.question_text);
		inAddEditQuestionCategory.value = element.category;

		switch (element.alternative) {
			case "A":
				inAddEditAnswerAlternativeA.value = he.decode(element.answer);
				break;
			case "B":
				inAddEditAnswerAlternativeB.value = he.decode(element.answer);
				break;
			case "C":
				inAddEditAnswerAlternativeC.value = he.decode(element.answer);
				break;
			case "D":
				inAddEditAnswerAlternativeD.value = he.decode(element.answer);
				break;
			default:
				break;
		}

		switch (element.correct_answer_alternative) {
			case "A":
				inAddEditCorrectAnswerAlternativeA.checked = true;
				break;
			case "B":
				inAddEditCorrectAnswerAlternativeB.checked = true;
				break;
			case "C":
				inAddEditCorrectAnswerAlternativeC.checked = true;
				break;
			case "D":
				inAddEditCorrectAnswerAlternativeD.checked = true;
				break;
			default:
				break;
		}
		btnSave.onclick = () => saveQuestion(element.question_id);
	});
};

// * search for a question by id
const searchQuestionById = (id) => {
	modalTitle.innerText = "Editar Pergunta";
	formAddEditQuestion.classList.remove("was-validated");
	const url = `/quiz/adminPanel/searchQuestionById?id=${id}`;
	fetch(url, {
		method: "GET",
	})
		.then((response) => response.json())
		.then((json) => setQuestionValues(json))
		.catch((error) => console.log(error.message));
};

// * delete a question by id
const deleteQuestion = (id) => {
	Swal.fire({
		title: "Tem certeza?",
		text: "Não será possível reverter esta ação!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sim, Excluir!",
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.isConfirmed) {
			const url = `/quiz/adminPanel/deleteQuestion?id=${id}`;
			fetch(url, {
				method: "DELETE",
			})
				.then((response) => {
					if (response.status === 201) {
						Swal.fire("Excluído!", "A pergunta foi excluída.", "success");
						listAllQuestions();
					}
				})
				.catch((error) => console.log(error));
		}
	});
};

// * search for one or more questions
const searchQuestions = () => {
	const data = new FormData(formSearchQuestions);
	const id = data.get("inSearchQuestionsId");
	const question = data.get("inSearchQuestionsText");
	const category = data.get("inSearchQuestionsCategory");
	const url = `/quiz/adminPanel/searchQuestions?id=${id}&questionText=${question}&category=${category}`;
	fetch(url, {
		method: "GET",
	})
		.then((response) => response.json())
		.then((json) => addCard(json))
		.catch((error) => console.log(error.message));
};

// * clears the question values in the form
const clearQuestionValues = () => {
	modalTitle.innerText = "Adicionar Pergunta";
	formAddEditQuestion.classList.remove("was-validated");
	inAddEditQuestionText.value = "";
	inAddEditQuestionCategory.value = "";
	inAddEditAnswerAlternativeA.value = "";
	inAddEditAnswerAlternativeB.value = "";
	inAddEditAnswerAlternativeC.value = "";
	inAddEditAnswerAlternativeD.value = "";
	inAddEditCorrectAnswerAlternativeA.checked = true;
	btnSave.onclick = () => saveQuestion(0);
};

formAddEditQuestion.onsubmit = (event) => {
	event.preventDefault();
	event.stopPropagation();
	formAddEditQuestion.classList.add("was-validated");
};

btnShowSearch.addEventListener("click", () => {
	if (sidebar.className.includes("hidden-sidebar")) {
		sidebar.classList.remove("hidden-sidebar");
		sidebar.classList.add("show-sidebar");
	} else {
		sidebar.classList.remove("show-sidebar");
		sidebar.classList.add("hidden-sidebar");
	}
});

btnAdd.addEventListener("click", clearQuestionValues);
btnSearch.addEventListener("click", searchQuestions);

document.addEventListener("DOMContentLoaded", listAllQuestions);
