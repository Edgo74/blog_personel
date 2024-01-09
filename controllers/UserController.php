<?php

require_once("controllers/Maincontroller.php");
require_once("managers/PostManager.php");
require_once("managers/Account.php");
require_once("controllers/Toolbox.php");
require_once("controllers/Securite.php");
require_once("managers/TagManager.php");
require_once("managers/Comment.php");




class UserController extends MainController
{
    private  $postManager;
    private  $tagManager;
    private  $commentManager;
    private  $accountManager;

    public function __construct()
    {
        $this->postManager = new PostManager;
        $this->tagManager = new TagManager;
        $this->commentManager = new CommentManager;
        $this->accountManager = new AccountManager;
    }

    public function login()
    {

        $data_page = [
            "page_description" => "login",
            "page_title" => "login",
            "view" => "views/login.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function dashboard($locale)
    {
        $posts = $this->postManager->getPost($locale);
        $totalPages = $this->postManager->getPageLink();
        $data_page = [
            "page_description" => "dashboard",
            "page_title" => "dashboard",
            "posts" => $posts,
            "totalPages" => $totalPages,
            "view" => "views/result.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function AddPost()
    {
        $tags = $this->tagManager->getAllTags();
        $data_page = [
            "page_description" => "dashboard",
            "page_title" => "dashboard",
            "tags" => $tags,
            "view" => "views/add.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function ConfirmAddPost($locale)
    {
        if (isset($_POST['btnSubmit'])) {
            $data = date('Y-m-d');

            if (
                !empty($_POST['title_en_GB']) && !empty($_POST['description_en_GB']) &&
                !empty($_POST['title_fr']) && !empty($_POST['description_fr'])
            ) {
                $title = strip_tags($_POST['title_en_GB']);
                $description = $_POST['description_en_GB'];
                $title_fr = strip_tags($_POST['title_fr']);
                $description_fr = $_POST['description_fr'];
                $slug = Toolbox::createSlug($title);
                $result =  $this->postManager->GetAllByslug($slug, $locale);

                if ($result > 0) {
                    $newSlug = $slug . uniqid();
                    $record = $this->postManager->addPost($title, $title_fr, $description, $description_fr, Toolbox::uploadImage(), $data, $newSlug);
                } else {
                    $record = $this->postManager->addPost($title, $title_fr, $description, $description_fr, Toolbox::uploadImage(), $data, $slug);
                }

                if ($record == true) {
                    header("location: dashboard");
                    Toolbox::ajouterMessageAlerte("Le post a bien été ajouté", Toolbox::COULEUR_VERTE);
                    exit();
                }
            } else {
                Toolbox::ajouterMessageAlerte("Veuillez remplir tous les champs", Toolbox::COULEUR_ROUGE);
                header("location:" . URL . "AddPost");
                exit();
            }
        }
    }


    public function ViewComments()
    {

        $comments = $this->commentManager->getPendingComments();
        $data_page = [
            "page_description" => "Commentaires",
            "page_title" => "Commentaires",
            "comments" => $comments,
            "view" => "views/view-comment.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function ApproveComments()
    {
        if (isset($_POST['approveComment'])) {
            $result = $this->commentManager->update($_POST['approveID']);
            if ($result == true) {
                header("location: dashboard");
                Toolbox::ajouterMessageAlerte("Le commentaire a bien été approuvé", Toolbox::COULEUR_VERTE);
                exit();
            } else {
                Toolbox::ajouterMessageAlerte("Veuillez réessayer plus tard",  Toolbox::COULEUR_ROUGE);
                header("location: dashboard");
                exit();
            }
        }
    }
    public function DeleteComments()
    {

        if (isset($_POST['deleteID'])) {
            $result = $this->commentManager->delete($_POST['deleteID']);
            if ($result == true) {
                header("location: dashboard");
                Toolbox::ajouterMessageAlerte("Le commentaire a bien été supprimé", Toolbox::COULEUR_VERTE);
                exit();
            } else {
                Toolbox::ajouterMessageAlerte("Veuillez réessayer plus tard",  Toolbox::COULEUR_ROUGE);
                header("location: dashboard");
                exit();
            }
        }
    }
    public function SendComment($slug)
    {
        $date = date('Y-m-d');
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['description'])) {
            $this->commentManager->comment(strip_tags($_POST['name']), strip_tags($_POST['email']), strip_tags($_POST['subject']), strip_tags($_POST['description']), $slug, $date);
            Toolbox::ajouterMessageAlerte("Commentaire ajouté avec succes", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("Les champs nom, email, description sont obligatoire", Toolbox::COULEUR_ROUGE);
        }
    }

    public function logout()
    {
        Toolbox::ajouterMessageAlerte("La deconnexion est effectuée", Toolbox::COULEUR_VERTE);
        unset($_SESSION['username']);
        setcookie(Securite::COOKIE_NAME, "", time() - 3600, "/");
        header("location:" . URL . "home");
    }

    public function validation_login($username, $password)
    {
        if (
            $this->accountManager->isCombinaisonValide($username, $password)
        ) {
            $_SESSION['username'] = $_POST['username'];
            Toolbox::ajouterMessageAlerte("Bon retour sur le site !", Toolbox::COULEUR_VERTE);
            Securite::genererCookieConnexion();
            header("location:" . URL . "dashboard");
            exit();
        } else {
            header("location:" . URL . "home");
            Toolbox::ajouterMessageAlerte("Combinaison Login/Mot de passe invalide", Toolbox::COULEUR_ROUGE);
            exit();
        }
    }




    public function EditPosts($slug, $locale)
    {
        $posts = $this->postManager->getSinglePost($slug,  $locale);
        $data_page = [
            "page_description" => "Commentaires",
            "page_title" => "Commentaires",
            "posts" => $posts,
            "view" => "views/edit.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function UpdatePosts($locale)
    {
        if (isset($_POST['btnUpdate'])) {
            $result = $this->postManager->updatePost($_POST['title_' . locale], $_POST['description' . locale], $_POST['slug'], $locale);
            if ($result) {
                Toolbox::ajouterMessageAlerte("Post mis a jour avec Succés !",  Toolbox::COULEUR_VERTE);
                header("location: dashboard");
                exit();
            } else {
                Toolbox::ajouterMessageAlerte("Veuillez réessayer plus tard",  Toolbox::COULEUR_ROUGE);
                header("location: dashboard");
                exit();
            }
        }
    }

    public function DeletePost()
    {
        $result = $this->postManager->deletePostBySlug($_POST['slug']);
        if ($result) {
            Toolbox::ajouterMessageAlerte("Post Supprimé",  Toolbox::COULEUR_VERTE);
            header("location: dashboard");
            exit();
        } else {
            Toolbox::ajouterMessageAlerte("Veuillez réessayer plus tard",  Toolbox::COULEUR_ROUGE);
            header("location: dashboard");
            exit();
        }
    }
}
