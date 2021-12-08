<?php
require_once "DatabaseConnection.php";

class DelegateDashboard {
    protected $pdo = null;
    private $delegate_id = "";

    public function __construct($delegate_id) {
        $this->pdo = DatabaseConnection::instance();
        $this->delegate_id = $delegate_id;
	}

    // Return an array of votes which are currently open to delegates or caucuses
    public function getOngoingVotes() {
        $sql =
            "SELECT * 
            FROM    votes
            WHERE   is_open_for_delegates = true
            OR      is_open_for_caucuses = true
            ORDER BY created_on ASC";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute();
		if(!$status) {
			return null;
		}
		else {
			$votes = $stmt->fetchAll();
            return $votes;
		}
    }

    // Count the number of votes which are currently open to delegates or caucuses
    public function countOngoingVotes() {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                votes
            WHERE   is_open_for_delegates = true
            OR      is_open_for_caucuses = true";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    // Count the number of Delegates which are marked present
    private function countPresentDelegates() {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                delegates
            WHERE is_present = true";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    // Format the display of present delegates
    public function formatPresentDelegates() {
        $count = $this->countPresentDelegates();
        if($count == 1) {
            return "There is currently <b>1</b> delegate present.";
        }
        else
        {
            return "There are currently <b>" . $count . "</b> delegates present.";
        }
    }

    // Count how many yea votes a Delegate has left
    public function countRemainingYeaVotesForDelegate() {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                delegate_ballots
            WHERE decision = true
            AND delegate_id = :delegate_id";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['delegate_id' => $this->delegate_id]);
        $count = $stmt->fetchColumn();
        return MAX_YEA_DELEGATE_BALLOTS - $count;
    }

    // Count how many yea votes a Delegate's Caucus has left
    public function countRemainingYeaVotesForCaucus($caucus_id) {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                caucus_ballots
            WHERE decision = true
            AND caucus_id = :caucus_id";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['caucus_id' => $caucus_id]);
        $count = $stmt->fetchColumn();
        return MAX_YEA_CAUCUS_BALLOTS - $count;
    }
}