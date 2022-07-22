<?php

namespace controller;

use model\User;
use dao\UserDao;
use http\Request;
use utils\View;

session_name('auth');
session_start();

class Login
{

	private $user;
	private $userDao;

	public function __construct()
	{
		$this->user = new User();
		$this->userDao = new UserDao();
	}

	public function index()
	{
		if (!isset($_SESSION['login']) || !$_SESSION['login']) {
			View::render('login');
		} else {
			header('Location: /quiz/adminPanel');
		}
	}

	public function authUser()
	{
		$email = Request::post('loginEmail', FILTER_SANITIZE_EMAIL);
		$password = Request::post('loginPassword');

		$this->user->setEmail($email);

		$data = $this->userDao->searchUserByEmail($this->user);

		if (password_verify($password, $data['password'])) {
			$_SESSION['login'] = true;
			header('Location: /quiz/adminPanel');
		}
		header('Location: /quiz/login');
	}
}