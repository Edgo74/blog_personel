<?php
require_once("managers/MainManager.php");

class AccountManager extends Model
{

	public function getPasswordUser($username)
	{
		$req = "SELECT password FROM users WHERE username=:username";
		$stmt = $this->getBdd()->prepare($req);
		$stmt->bindValue(":username", $username, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $result["password"];
	}


	public function isCombinaisonValide($username, $password)
	{
		$passwordBD =  $this->getPasswordUser($username);
		return password_verify($password, $passwordBD);
	}
}
