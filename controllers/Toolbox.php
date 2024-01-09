<?php

class Toolbox
{


	public static function estConnecte()
	{
		return isset($_SESSION["username"]) && !empty($_SESSION["username"]) && Securite::checkCookieConnexion();
	}

	public static function uploadImage()
	{
		$imagename = $_FILES['image']['name'];
		$imagetmp = $_FILES['image']['tmp_name'];

		$allowed = array('jpeg', 'png', 'jpg');

		$ext = pathinfo($imagename, PATHINFO_EXTENSION);

		if (in_array($ext, $allowed)) {
			move_uploaded_file($imagetmp, "images/" . $imagename);
		} else {
			echo "only png,jpg and jpeg image format are allowed";
		}
		return $imagename;
	}

	public static function createSlug($string)
	{
		$slug = preg_replace('/[^A-Za-z0-9]+/', '-', $string);
		return $slug;
	}



	public const COULEUR_ROUGE = "alert-danger";
	public const COULEUR_ORANGE = "alert-warning";
	public const COULEUR_VERTE = "alert-success";

	public static function ajouterMessageAlerte($message, $type)
	{
		$_SESSION['alert'][] = [
			"message" => $message,
			"type" => $type
		];
	}
}
