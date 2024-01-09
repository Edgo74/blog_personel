<?php

require_once("managers/MainManager.php");
require_once("controllers/Toolbox.php");


class PostManager extends Model
{
    public function addPost($title, $title_fr,  $description, $description_fr, $image, $date, $slug)
    {
        $sql = "INSERT INTO posts(title_en_GB, title_fr, description_en_GB, description_fr, image, created_at, slug) 
        VALUES (:title_en_GB, :title_fr,:description_en_GB, :description_fr, :image, :date, :slug)";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':title_en_GB', $title);
        $stmt->bindValue(':title_fr', $title_fr);
        $stmt->bindValue(':description_en_GB', $description);
        $stmt->bindValue(':description_fr', $description_fr);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':slug', $slug);
        $result = $stmt->execute();

        if ($result) {
            if (empty($_POST["customtag"]) && !empty($_POST['tags'])) {
                $tags = $_POST['tags'];
                $lastInsertedId = $this->getBdd()->lastInsertId();
                foreach ($tags as $tag) {
                    $sql = "INSERT INTO post_tags(post_id, tag_id) VALUES (:postId, :tagId)";
                    $stmt = $this->getBdd()->prepare($sql);
                    $stmt->bindValue(':postId', $lastInsertedId);
                    $stmt->bindValue(':tagId', $tag);
                    $result = $stmt->execute();
                }
            } else if (!empty($_POST["customtag"]) && empty($_POST['tags'])) {
                $customtag = $_POST['customtag'];
                $lastInsertedId = $this->getBdd()->lastInsertId();

                $sql = "INSERT INTO tags(tag) VALUES (:tag)";
                $stmt = $this->getBdd()->prepare($sql);
                $stmt->bindValue(':tag', $customtag);
                $stmt->execute();
                $newTagId = $this->getBdd()->lastInsertId();

                $sql = "INSERT INTO post_tags(post_id, tag_id) VALUES (:postId, :tagId)";
                $stmt = $this->getBdd()->prepare($sql);
                $stmt->bindValue(':postId', $lastInsertedId);
                $stmt->bindValue(':tagId', $newTagId);
                $result = $stmt->execute();
            } else {
                $customtag = $_POST['customtag'];
                $tags = $_POST['tags'];
                $lastInsertedId = $this->getBdd()->lastInsertId();

                $sql = "INSERT INTO tags(tag) VALUES (:tag)";
                $stmt = $this->getBdd()->prepare($sql);
                $stmt->bindValue(':tag', $customtag);
                $stmt->execute();
                $newTagId = $this->getBdd()->lastInsertId();

                $sql = "INSERT INTO post_tags(post_id, tag_id) VALUES (:postId, :tagId)";
                $stmt = $this->getBdd()->prepare($sql);
                $stmt->bindValue(':postId', $lastInsertedId);
                $stmt->bindValue(':tagId', $newTagId);
                $stmt->execute();

                foreach ($tags as $tag) {
                    $sql = "INSERT INTO post_tags(post_id, tag_id) VALUES (:postId, :tagId)";
                    $stmt = $this->getBdd()->prepare($sql);
                    $stmt->bindValue(':postId', $lastInsertedId);
                    $stmt->bindValue(':tagId', $tag);
                    $stmt->execute();
                }
            }
        }
        return $result;
    }

    // $allowedLocales = ['en_GB', 'fr']; // Liste des valeurs autorisées pour $locale

    // // Vérification pour éviter les injections SQL
    // if (!in_array($locale, $allowedLocales)) {
    //     $locale = 'en';
    // }


    public function getPost($locale)
    {
        // Recherche avec keyword
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            return $this->search($keyword, $locale);
        }

        // Recherche avec un Tag
        if (isset($_GET['tag'])) {
            $tag = $_GET['tag'];
            $sql = "SELECT title_$locale AS title, description_$locale AS description, 
                    image, created_at, slug
					FROM posts
					INNER JOIN post_tags ON posts.id = post_tags.post_id
					INNER JOIN tags ON tags.id = post_tags.tag_id
					WHERE tags.tag=:tag";

            $stmt = $this->getBdd()->prepare($sql);
            $stmt->bindValue(':tag', $tag);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $limit = 5;
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $start = ($page - 1) * $limit;

        $sql = "SELECT title_$locale AS title, description_$locale AS description, 
        image, created_at, slug FROM posts LIMIT :start, :limit";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($keyword, $locale)
    {
        $sql = "SELECT title_$locale AS title, description_$locale AS description, image, created_at, slug FROM posts
            WHERE title_$locale LIKE :keyword OR description_$locale LIKE :keyword";

        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSinglePost($slug, $locale)
    {



        $sql = "SELECT title_$locale AS title,
        description_$locale AS description, 
        image, created_at, slug FROM posts
        WHERE slug = :slug";


        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePost($title, $description, $slug, $locale)
    {
        $newImage = $_FILES['image']['name'];
        if (!empty($newImage)) {
            $image = Toolbox::uploadImage();
            $sql = "UPDATE posts SET title_$locale = :title, 
            description_$locale = :description, image = :image 
            WHERE slug = :slug";
        } else {
            $sql = "UPDATE posts SET title_$locale = :title, 
            description_$locale = :description WHERE slug = :slug";
        }

        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        if (!empty($newImage)) {
            $stmt->bindValue(':image', $image);
        }
        $stmt->bindValue(':slug', $slug);
        $result = $stmt->execute();

        return $result;
    }



    public function deletePostBySlug($slug)
    {
        $sql = "DELETE FROM posts WHERE slug = :slug";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $result = $stmt->execute();
        return $result;
    }


    public function getPopularPosts($locale)
    {
        $sql = "SELECT posts.title_$locale AS title, posts.description_$locale AS description, posts.image, posts.created_at, posts.slug, COUNT(comments.slug) AS comment_count 
                FROM posts 
                LEFT JOIN comments ON posts.slug = comments.slug 
                GROUP BY posts.slug 
                ORDER BY comment_count DESC 
                LIMIT 5";

        $stmt = $this->getBdd()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCheckedTag($slug)
    {
        $sql = "SELECT *
				FROM posts
				INNER JOIN post_tags ON posts.id = post_tags.post_id
				INNER JOIN tags ON tags.id = post_tags.tag_id
				WHERE tags.tag = :slug";

        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getPageLink()
    {
        $sql = "SELECT count(id) FROM posts";
        $stmt = $this->getBdd()->query($sql);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $totalRecords = $row[0];
        $totalPages = ceil($totalRecords / 5);
        return $totalPages;
    }

    public function GetAllByslug($slug, $locale)
    {
        $sql = "SELECT title_$locale AS title, description_$locale AS description, image, created_at, slug  FROM posts WHERE slug=:slug";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch results as an associative array
        $count = count($result); // Count the number of rows fetched from the result set
        return $count;
    }
}
