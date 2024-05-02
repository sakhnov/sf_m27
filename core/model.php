<?php
class Model
{
	protected $db;

	function __construct()
	{
		$this->db = new PDO('mysql:host=' . DB_HOST_NAME . ';dbname=' . DB_NAME . ';user=' . DB_USR_NAME . ';password=' . DB_PASSWORD);
	}

	//Проверка пользователя
	public function checkUser()
	{
		if (isset($_COOKIE['id'])) {
			$sql = "select * from users where id= '" . intval($_COOKIE['id']) . "' LIMIT 1";
			$createResult = $this->db->prepare($sql);
			$createResult->execute();
			$userdata = $createResult->FETCH(PDO::FETCH_ASSOC);
			if ($userdata) {
				if (($userdata['token'] !== $_COOKIE['hash']) or strcasecmp($userdata['token'], $_COOKIE['hash']) !== 0) {
					setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
					setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/", null, null, true);
					print "Что-то пошло не так...";
					return null;
				} else {
					return $userdata['login'];
				}
			} else {
				return null;
			}
		} else {
			print "Кука отсутствует" . '</br>';
			return null;
		}
	}

	//Роль пользователя
	public function getUserRole()
	{
		if (isset($_COOKIE['id'])) {
			/*
			$sql = "select role_name from roles r
			join roles_map r2 on r.role_id = r2.role_id 
			where r2.user_id = 
			(
			select id from users where id = '" . $_COOKIE['id'] . "'
			)";
			*/
			$sql = "select role_id from roles_map
			where user_id = ".$_COOKIE['id'];
			$stmt = $this->db->query($sql);
			$result = $stmt->FETCH(PDO::FETCH_ASSOC);
			return $result;
		} else return array();
	}
}
