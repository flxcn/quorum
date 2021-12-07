<?php
require_once "DatabaseConnection.php";

class CaucusBallot {
    protected $pdo = null;
    private $caucus_id;
    private $delegate_id;
    private $vote_id;
    private $decision;
    private $created_on;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
	}

    // getters and setters

    public function setDelegateId($delegate_id) {
        $this->delegate_id = $delegate_id;
    }

    public function getDelegateId() {
        return $this->delegate_id;
    }

    public function setCaucusId($caucus_id) {
        $this->caucus_id = $caucus_id;
    }

    public function getCaucusId() {
        return $this->caucus_id;
    }

    public function setVoteId($vote_id) {
        $this->vote_id = $vote_id;
    }

    public function getVoteId() {
        return $this->vote_id;
    }

    public function setDecision($decision) {
        $this->decision = $decision;
    }
    public function getDecision() {
        return $this->decision;
    }

    public function addBallot() {
        $sql = "INSERT INTO caucus_ballots (vote_id, caucus_id, decision)
			VALUES (:vote_id, :caucus_id, :decision)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'vote_id' => $this->vote_id,
                'caucus_id' => $this->caucus_id,
                'decision' => $this->decision
			]);

		return $status;
    }

    public function countRemainingYeaVotes() {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                caucus_ballots
            WHERE decision = true
            AND caucus_id = :caucus_id";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['delegate_id' => $this->delegate_id]);
        $count = $stmt->fetchColumn();
        return MAX_YEA_CAUCUS_BALLOTS - $count;
    }

    public function checkBallotExists($vote_id, $caucus_id): bool {
        $stmt = $this->pdo->prepare("SELECT 1 FROM caucus_ballots WHERE vote_id = :vote_id AND caucus_id = :caucus_id");
        $stmt->execute(['vote_id' => $vote_id, 'caucus_id' => $caucus_id]);
        return (bool)$stmt->fetch();
    }
}
?>