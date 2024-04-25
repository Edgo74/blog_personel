<?php

class Securite
{


    public static function SecureHTML($chaine)
    {
        return htmlspecialchars($chaine);
    }

    public const COOKIE_NAME = "cookie";


    public static function genererCookieConnexion()
    {
        $ticket = session_id() . microtime() . rand(0, 999999);
        $ticket = hash("sha512", $ticket);
        setcookie(self::COOKIE_NAME, $ticket, time() + (60 * 60), "/");
        $_SESSION[self::COOKIE_NAME] = $ticket;
    }

    public static function estConnecte()
    {
        return isset($_SESSION["profil"]) && !empty($_SESSION["profil"]);
    }



    public static function checkCookieConnexion()
    {
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            return $_COOKIE[self::COOKIE_NAME] === $_SESSION[self::COOKIE_NAME];
        } else {
            return false;
        }
    }
}
