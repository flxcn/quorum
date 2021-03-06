<?php
require_once "DatabaseConnection.php";

class DelegateHistory {
    protected $pdo = null;
    private $delegate_id = "";

    public function __construct($delegate_id) {
        $this->pdo = DatabaseConnection::instance();
        $this->delegate_id = $delegate_id;
	}

    // Get an array of details about past Ballots cast by a Delegate
    public function getPastDelegateVotes() {
        $sql =
            "SELECT votes.vote_id, title, sponsor, caucus, link, description, decision
            FROM delegate_ballots
            INNER JOIN votes ON votes.vote_id = delegate_ballots.vote_id
            WHERE delegate_ballots.delegate_id = :delegate_id 
            ORDER BY delegate_ballots.created_on ASC";
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['delegate_id' => $this->delegate_id]);
		if(!$status) {
			return null;
		}
		else {
			$votes = $stmt->fetchAll();
            return $votes;
		}
    }

    // Get an array of details about past Ballots cast by a Caucus
    public function getPastCaucusVotes($caucus_id) {
        $sql =
            "SELECT votes.vote_id, title, sponsor, caucus, caucus_id, link, description, decision
            FROM caucus_ballots
            INNER JOIN votes ON votes.vote_id = caucus_ballots.vote_id
            WHERE caucus_ballots.caucus_id = :caucus_id 
            ORDER BY caucus_ballots.created_on ASC";
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['caucus_id' => $caucus_id]);
		if(!$status) {
			return null;
		}
		else {
			$votes = $stmt->fetchAll();
            return $votes;
		}
    }
}