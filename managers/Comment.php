<?php
require_once("managers/MainManager.php");

class CommentManager extends Model
{

	public function comment($name, $email, $subject, $description, $slug, $created)
	{
		$sql = "INSERT INTO comments(name, email, subject, description, slug, created_at) VALUES (:name, :email, :subject, :description, :slug, :created)";

		$stmt = $this->getBdd()->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':subject', $subject);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':slug', $slug);
		$stmt->bindParam(':created', $created);

		return $stmt->execute();
	}

	public function getCommentsBySlug($slug)
	{
		$sql = "SELECT * FROM comments WHERE slug = :slug AND status = 1";

		$stmt = $this->getBdd()->prepare($sql);
		$stmt->bindParam(':slug', $slug);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function countComments($slug)
	{
		$sql = "SELECT * FROM comments WHERE slug = :slug AND status = 1";

		$stmt = $this->getBdd()->prepare($sql);
		$stmt->bindParam(':slug', $slug);
		$stmt->execute();

		return $stmt->rowCount();
	}

	public function getPendingComments()
	{
		$sql = "SELECT * FROM comments WHERE status = 0";

		$stmt = $this->getBdd()->query($sql);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function update($id)
	{
		$sql = "UPDATE comments SET status = 1 WHERE id = :id";

		$stmt = $this->getBdd()->prepare($sql);
		$stmt->bindParam(':id', $id);

		return $stmt->execute();
	}

	public function delete($id)
	{
		$sql = "DELETE FROM comments WHERE id = :id";

		$stmt = $this->getBdd()->prepare($sql);
		$stmt->bindParam(':id', $id);

		return $stmt->execute();
	}
}
