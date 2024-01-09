<?php

require_once("managers/MainManager.php");

class TagManager extends Model

{

    public function getAllTags()
    {
        $sql = "SELECT * FROM tags";
        $stmt = $this->getBdd()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTags($slug)
    {
        $data = [];
        $sql = "SELECT tags.tag 
                FROM posts 
                INNER JOIN post_tags ON post_tags.post_id = posts.id
                INNER JOIN tags ON tags.id = post_tags.tag_id
                WHERE tags.tag = :slug";

        $stmt = $this->getBdd()->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row['tag'];
        }

        return $data;
    }

    // public function filterPostsByTags($locale)
    // {
    //     $sql = "SELECT title_$locale AS title, description_$locale AS description, image, created_at, slug  FROM posts
    //             INNER JOIN post_tags ON post_tags.post_id = posts.id
    //             INNER JOIN tags ON tags.id = post_tags.tag_id
    //             WHERE posts.id = ";

    //     $stmt = $this->getBdd()->query($sql);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function tags()
    {
        $sql = "SELECT * FROM tags";
        $stmt = $this->getBdd()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
