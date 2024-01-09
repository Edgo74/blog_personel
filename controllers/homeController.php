<?php

require_once("controllers/Maincontroller.php");
require_once("managers/PostManager.php");
require_once("managers/TagManager.php");
require_once("managers/Comment.php");
require_once("controllers/Toolbox.php");


class HomeController extends MainController
{

    private  $tagManager;
    private  $postManager;
    private  $commentsManager;

    public function __construct()
    {
        $this->tagManager = new TagManager;
        $this->postManager = new PostManager;
        $this->commentsManager = new CommentManager;
    }


    public function home($locale)
    {
        $posts = $this->postManager->getPost($locale);
        $popularposts = $this->postManager->getPopularPosts($locale);
        $tags = $this->tagManager->getAllTags();
        $totalPages = $this->postManager->getPageLink();

        $data_page = [
            "page_description" => "Home",
            "page_title" => "Home",
            "tags" => $tags,
            "posts" => $posts,
            "popularposts" => $popularposts,
            "totalPages" => $totalPages,
            "view" => "views/home.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function getPageBySlug($slug, $locale)
    {
        $date = date('Y-m-d');
        $posts = $this->postManager->getSinglePost($slug, $locale);
        $comments = $this->commentsManager->getCommentsBySlug($slug);
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['description'])) {
            $this->commentsManager->comment(strip_tags($_POST['name']), strip_tags($_POST['email']), strip_tags($_POST['subject']), strip_tags($_POST['description']), $_GET['slug'], $date);
        } else {
        }

        $data_page = [
            "page_description" => "Article",
            "page_title" => "Article",
            "comments" => $comments,
            "posts" => $posts,
            "view" => "views/view.php",
            "template" => "views/template.php"
        ];
        $this->genererPage($data_page);
    }
}
