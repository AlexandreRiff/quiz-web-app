<?php

namespace model;

class User
{
	private $id;
	private $email;
	private $password;

	public $erro;

	public function setId($id)
	{
		if (!empty($id) && is_numeric($id)) {
			$this->id = $id;
		} else {
			$this->erro = true;
		}
	}

	public function setEmail($email)
	{
		if (!empty($email)) {
			$this->email = $email;
		} else {
			$this->erro = true;
		}
	}

	public function setPassword($password)
	{
		if (!empty($password)) {
			$this->password = password_hash($password, PASSWORD_BCRYPT);
		} else {
			$this->erro = true;
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getPassword()
	{
		return $this->password;
	}
}