<?php
class Controller_Register extends Controller
{
	public $model_register;
	function __construct()
	{
		$this->model_register = new Model_Register();
		$this->view = new View();
	}

	function createPage(string $viewName)
	{
		$this->view->generate($viewName, 'default.php', $this->authorised);
	}

	function submitted()
	{
		$err = [];
		// проверяем логин
		if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['login'])) {
			$err[] = "Логин может состоять только из букв английского алфавита и цифр";
		}
		if (strlen($_POST['login']) < 3 || strlen($_POST['login']) > 30) {
			$err[] = "Логин должен быть не менее 3-х и не более 30 символов";
		}
		if (!count($err) > 0) {
			$userChecked = $this->model_register->checkUserExistance($_POST['login']);
			if ($userChecked) {
				$createUser = $this->model_register->createUser($_POST['login'], $_POST['password']);
				header("Location: /index.php?page=1");
			}
		} else {
			print "<b>Пользователь с таким логином уже существует</b><br>";
		}
	}
}
