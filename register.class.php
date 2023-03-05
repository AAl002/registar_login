<?php 
class RegisterUser{
	private $login;
	private $raw_password;
	private $encrypted_password;
	private $confirm_password;
	public $email;
	public $name;
	public $error;
	public $success;
	private $storage = "data.json";
	private $stored_users;
	private $new_user; 


	public function __construct($login, $password,$confirm_password,$email,$name){

		$this->login = trim($this->login);
		$this->login = filter_var($login, FILTER_SANITIZE_STRING);

		$this->raw_password = filter_var(trim($password), FILTER_SANITIZE_STRING);
		$this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

		$this->stored_users = json_decode(file_get_contents($this->storage), true); 

		$this->email=$email;
		$this->name=$name;
		$this->confirm_password=$confirm_password;

		$this->new_user = [
			"login" => $this->login,
			"password" => $this->encrypted_password,
			"email" => $this->email,
			"name" => $this->name,
		];

		if($this->checkFieldValues()){
			$this->insertUser();
		}
	}


	private function checkFieldValues(){
		if(empty($this->login) || empty($this->raw_password) || empty($this->confirm_password) || empty($this->email) || empty($this->name)){
			$this->error = "Все поля должны быть заполнены";
			return false;
		}else{
			return true;
		}
	}
	private function checkValidationOfValues(){
		if(strlen($this->login)<6){
			$this->error = "Длина логина должна быть минимум 6 символов";
			return true;
		}elseif(strlen($this->raw_password)<6 || (!preg_match('/[A-zА-я]+/', $this->raw_password)) || (!preg_match('/[0-9]+/', $this->raw_password))){
			$this->error = "Длина пароля должна быть минимум 6 символов и состоять из цифр и букв";
			return true;
		}elseif(strlen($this->name)<2){
			$this->error = "Длина имени должна быть минимум 2 символов";
			return true;
		}else{
			return false;
		}
	}


	private function loginExists(){
		foreach($this->stored_users as $user){
			if($this->login == $user['login']){
				$this->error = "Существует пользователь с данным логином,выберите другой";
				return true;
			}
		}
		return false;
	}
	private function emailExists(){
		foreach($this->stored_users as $user){
			if($this->email == $user['email']){
				$this->error = "Существует пользователь с данной почтой,выберите другую";
				return true;
			}
		}
		return false;
	}
	private function samePassword(){
			if($this->raw_password != $this->confirm_password){
				$this->error = "Пароли не совпадают";
				return true;
			}
		
		return false;
	}




	private function insertUser(){
		if($this->checkValidationOfValues() == FALSE  && $this->loginExists() == FALSE && $this->emailExists() == FALSE && $this->samePassword() == FALSE){
			array_push($this->stored_users, $this->new_user);
			if(file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))){
				return $this->success = "Регистрация прошла успешно";
			}else{
				return $this->error = "Что-то пошло не так,попробуйте еще раз";
			}
		}
	}



} 