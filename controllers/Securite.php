<?php

class Securite
{


    public static function SecureHTML($chaine)
    {
        return htmlentities($chaine);
    }

    public const COOKIE_NAME = "timers";


    public static function genererCookieConnexion()
    {
        $ticket = session_id() . microtime() . rand(0, 999999);
        $ticket = hash("sha512", $ticket);
        setcookie(self::COOKIE_NAME, $ticket, time() + (60 * 10), "/");
        $_SESSION[self::COOKIE_NAME] = $ticket;
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
