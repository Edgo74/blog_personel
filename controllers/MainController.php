
<?php
//		username:john password:john123
require_once("managers/MainManager.php");
class MainController
{

    protected function genererPage($data)
    {
        extract($data);
        ob_start();
        require_once($view);
        $page_content = ob_get_clean();
        require_once($template);
    }

    public function getErreur($msg)
    {

        $data_page = [
            "page_description" => "Description de la page d'erreur  ",
            "page_title" => "Page d'erreur",
            "msg" => $msg,
            "view" => "views/erreur.view.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }
}
