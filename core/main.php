<?php
class Main
{
	static function showPage()
	{
		$pageNumber = '1';
		$pages = include 'config/pages.php';
		if (!empty($_GET['page'])) {
			$pageNumber = (int) $_GET['page'];
		}
		$page_name = $pages[$pageNumber];
		if (!strlen($page_name) > 0) {
			Main::ErrorPage404();
		} else {
			$page_name = strtolower($page_name);
			$controller_name = "Controller_" . $page_name;
			$controller_path = "controller/controller_" . $page_name . '.php';
			
			$model_name = 'model_'.$page_name;
			$model_path = "model/model_" . $page_name . '.php';

			if(file_exists($model_path))
			{
				include $model_path;
			}

			if (file_exists($controller_path)) {
				include $controller_path;
				$controller = new $controller_name;
				// если произошли авторизация или выход
				if (isset($_POST['submit']) & ($pageNumber == 1 || $pageNumber == 2)) {
					$controller->submitted();
				}

				if (isset($_GET['code']) & $pageNumber == 1) {
					$controller->vkAuth();
				}

				if (file_exists('views/' . $page_name . '.php')) {
					$controller->createPage('views/' . $page_name . '.php');
				}
			} else {
				Main::ErrorPage404();
			}
		}
	}

	static function ErrorPage404()
	{
		$page_name = "404";
		$page_name = strtolower($page_name);
		$controller_name = "Controller_" . $page_name;
		$controller_path = "controller/controller_" . $page_name . '.php';
		if (file_exists($controller_path)) {
			include $controller_path;
			$controller = new $controller_name;
			$controller->createPage('views/' . $page_name . '.php');
		}
	}
}
