<?php
require_once "DatabaseConnection.php";

class Vote {
    protected $pdo = null;
    
    private $vote_id = "";
    private $title = "";
    private $sponsor = "";
    private $caucus = "";
    private $description = "";
    private $link = "";
    private $is_open_for_delegates = "";
    private $is_open_for_caucuses = "";

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
        $this->is_open_for_delegates = false;
        $this->is_open_for_caucuses = false;
	}

    // getters and setters

    public function setVoteId($vote_id) {
        $this->vote_id = $vote_id;
    }

    public function getVoteId() {
        return $this->vote_id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setSponsor($sponsor) {
        $this->sponsor = $sponsor;
    }
    
    public function getSponsor() {
        return $this->sponsor;
    }

    public function setCaucus($caucus) {
        $this->caucus = $caucus;
    }
    
    public function getCaucus() {
        return $this->caucus;
    }

    public function setLink($link) {
        $this->link = $link;
    }
    
    public function getLink() {
        return $this->link;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setIsOpenForDelegates($is_open_for_delegates) {
        $this->is_open_for_delegates = $is_open_for_delegates;
    }
    
    public function getIsOpenForDelegates() {
        return $this->is_open_for_delegates;
    }

    public function setIsOpenForCaucuses($is_open_for_caucuses) {
        $this->is_open_for_caucuses = $is_open_for_caucuses;
    }
    
    public function getIsOpenForCaucuses() {
        return $this->is_open_for_caucuses;
    }


    public function addVote() {
        $sql = "INSERT INTO votes (title, sponsor, caucus, description, link)
			VALUES (:title, :sponsor, :caucus, :description, :link)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'title' => $this->title,
				'sponsor' => $this->sponsor,
                'caucus' => $this->caucus,
                'description' => $this->description,
                'link' => $this->link
			]);

		return $status;
    }

    public function getVote() {
        $sql = "SELECT * FROM votes WHERE vote_id = :vote_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['vote_id' => $this->vote_id]);
        $vote = $stmt->fetch();

		if($vote) {
            $this->title = $vote["title"];
            $this->sponsor = $vote["sponsor"];
            $this->caucus = $vote["caucus"];
            $this->description = $vote["description"];
            $this->link = $vote["link"];
            $this->is_open_for_delegates = $vote["is_open_for_delegates"];
            $this->is_open_for_caucuses = $vote["is_open_for_caucuses"];
            return true;
        }
		else {
			return false;
		}
    }

    public function updateVote() {
        $sql = 
            "UPDATE votes 
            SET title = :title,
            sponsor = :sponsor,
            caucus = :caucus,
            description = :description,
            link = :link,
            is_open_for_delegates = :is_open_for_delegates,
            is_open_for_caucuses = :is_open_for_caucuses
            WHERE vote_id = :vote_id";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute([
            'title' => $this->title,
            'sponsor' => $this->sponsor,
            'caucus' => $this->caucus,
            'description' => $this->description,
            'link' => $this->link,
            'is_open_for_delegates' => $this->is_open_for_delegates,
            'is_open_for_caucuses' => $this->is_open_for_caucuses,
            'vote_id' => $this->vote_id
        ]);

		return $status;
    }
}
?>