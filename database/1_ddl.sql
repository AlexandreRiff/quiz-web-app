CREATE DATABASE IF NOT EXISTS quiz;

use quiz;

CREATE TABLE
	IF NOT EXISTS quiz_question (
		id INT UNSIGNED NOT NULL AUTO_INCREMENT,
		question_text VARCHAR(255) NOT NULL,
		category VARCHAR(255) NOT NULL,
		correct_answer_alternative ENUM ('A', 'B', 'C', 'D') NOT NULL,
		created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated TIMESTAMP NULL,
		PRIMARY KEY (id)
	);

CREATE TABLE
	IF NOT EXISTS quiz_answer_alternatives (
		id INT UNSIGNED NOT NULL AUTO_INCREMENT,
		question_id INT UNSIGNED NOT NULL,
		alternative ENUM ('A', 'B', 'C', 'D') NOT NULL,
		answer VARCHAR(255) NOT NULL,
		created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated TIMESTAMP NULL,
		PRIMARY KEY (id),
		CONSTRAINT fk_quiz_question__quiz_answer_alternatives FOREIGN KEY (question_id) REFERENCES quiz_question (id) ON DELETE CASCADE ON UPDATE CASCADE
	);

CREATE TABLE
	IF NOT EXISTS quiz_user (
		id INT UNSIGNED NOT NULL AUTO_INCREMENT,
		email VARCHAR(255) NOT NULL,
		password VARCHAR(255) NOT NULL,
		PRIMARY KEY (id),
		CONSTRAINT uk_quiz_user_email UNIQUE KEY (email)
	);
