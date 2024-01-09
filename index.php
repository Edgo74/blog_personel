<?php
session_start();

require 'App/I18n.php';
require_once("controllers/Maincontroller.php");
require_once("controllers/homeController.php");
require_once("controllers/UserController.php");

$mainController = new MainController();
$homeController = new HomeController();
$userController = new  UserController();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
	"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

define("page", (isset($_GET['mapage']) ? $_GET['mapage'] : 'home'));




list($subdomain, $domain) = explode('.', $_SERVER['HTTP_HOST'], 2);

$i18n = new App\I18n(['en_GB', 'fr']);

$locale = $i18n->getBestMatch($subdomain);


if ($locale === null) {

	$locale = $i18n->getLocaleForRedirect();

	$subdomain = substr($locale, 0, 2);

	header("Location: http://" . $subdomain . ".localhost/blogv2/home");
	exit;
}


define("locale", $locale);


$link_data = $i18n->getLinkData(['en' => 'English', 'fr' => 'Français']);

define("link_data", $link_data);

try {
	if (empty($_GET["mapage"])) {
		$page = "home";
	} else {
		$url = explode("/", filter_var($_GET["mapage"], FILTER_SANITIZE_URL));
		$page = $url[0];
	}

	switch ($page) {
		case "home":
			$homeController->home($locale);
			break;
		case "view":
			if (
				isset($_GET["slug"]) && !empty($_GET["slug"])
			) {
				$homeController->getPageBySlug($_GET["slug"], $locale);
			} else {
				header("location:" . URL . "error403");
				exit();
			}
			break;
		case "login":
			$userController->login();
			break;

		case "validation_login":
			if (
				isset($_POST["username"]) && isset($_POST["username"]) &&
				!empty($_POST["username"]) && !empty($_POST["password"])
			) {
				$email = Securite::SecureHTML($_POST["username"]);
				$password = Securite::SecureHTML($_POST["password"]);
				$userController->validation_login($email, $password);
			} else {
				header("location:" . URL . "login");
				exit();
			}
			break;

		case "dashboard":
			if (Toolbox::estConnecte()) {
				Securite::genererCookieConnexion();
				$userController->dashboard($locale);
			} else {
				header("location:" . URL . "login");
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				exit();
			}
			break;

		case "AddPost":
			if (Toolbox::estConnecte()) {
				Securite::genererCookieConnexion();
				$userController->AddPost();
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
			break;

		case "ConfirmAddPost":
			if (Toolbox::estConnecte()) {
				$userController->ConfirmAddPost($locale);
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
			break;

		case "Comments":
			if (Toolbox::estConnecte()) {
				Securite::genererCookieConnexion();
				$userController->ViewComments();
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
			break;
		case "SendComment":
			$userController->SendComment($slug);


			break;
		case "ApproveComments":
			if (Toolbox::estConnecte()) {
				$userController->ApproveComments();
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
			break;
		case "DeleteComments":
			if (Toolbox::estConnecte()) {
				$userController->DeleteComments();
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
			break;
		case "edit":
			if (Toolbox::estConnecte()) {
				$userController->EditPosts($_GET["slug"], $locale);
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
		case "updatepost":
			if (Toolbox::estConnecte()) {
				$userController->UpdatePosts($locale);
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
			break;
		case "deletepost":
			if (Toolbox::estConnecte()) {
				$userController->DeletePost();
			} else {
				Toolbox::ajouterMessageAlerte("Veuillez d'abord vous connectez", Toolbox::COULEUR_ROUGE);
				header("location:" . URL . "login");
				exit();
			}
			break;
		case "logout":
			$userController->logout();
			header("location:" . URL . "login");
			exit();

			break;

		case "error403":
			throw new Exception("La page n'esxiste pas error 403");
			break;
		case "error404":
			throw new Exception("La page n'esxiste pas error 404");
			break;
		case "error500":
			throw new Exception("La page n'esxiste pas error 500");
			break;

		default:
			throw new Exception("La page n'existe pas ! ");
	}
} catch (Exception $e) {
	$mainController->getErreur($e->getMessage());
}
