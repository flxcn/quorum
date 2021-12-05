<?php
require_once "DatabaseConnection.php";

class DelegateHistory {
    protected $pdo = null;
    private $delegate_id = "";

    public function __construct($delegate_id) {
        $this->pdo = DatabaseConnection::instance();
        $this->delegate_id = $delegate_id;
	}

    public function getPastVotes() {
        $sql =
            "SELECT * FROM ballots
            INNER JOIN votes ON votes.vote_id = ballots.vote_id
            WHERE ballots.delegate_id = :delegate_id 
            ORDER BY ballots.created_on ASC";
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

    public function countRemainingYeaVotes() {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                ballots
            WHERE decision = true
            AND delegate_id = :delegate_id";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['delegate_id' => $this->delegate_id]);
        $count = $stmt->fetchColumn();
        return MAX_YEA_DELEGATE_BALLOTS - $count;
    }
}