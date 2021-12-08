<?php
require_once "DatabaseConnection.php";

class Caucus {
    protected $pdo = null;
    private $caucus_id;
    private $title;
    private $description;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
	}

    // getters and setters

    public function setCaucusId($caucus_id) {
        $this->caucus_id = $caucus_id;
    }

    public function getCaucusId() {
        return $this->caucus_id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    public function getDescription() {
        return $this->description;
    }

    // Insert new Caucus into Caucuses table
    public function addCaucus() {
        $sql = "INSERT INTO caucuses (title, description)
			VALUES (:title, :description)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'title' => $this->title,
                'description' => $this->description,
			]);

		return $status;
    }

    // Edit existing Caucus in Caucuses table
    public function updateCaucus() {
        $sql = 
            "UPDATE delegates 
            SET name = :name,
                email = :email,
            WHERE delegate_id = :delegate_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(
            [
                'name' => $this->name,
                'email' => $this->email,
                'delegate_id' => $this->delegate_id
            ]);

        return $status;
    }
}
?>