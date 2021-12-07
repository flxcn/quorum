<?php
require_once "DatabaseConnection.php";

class DelegateDashboard {
    protected $pdo = null;
    private $delegate_id = "";

    public function __construct($delegate_id) {
        $this->pdo = DatabaseConnection::instance();
        $this->delegate_id = $delegate_id;
	}

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

    public function countOngoingVotes() {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                votes
            WHERE is_active = true";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function countPresentDelegates() {
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

    public function countRemainingYeaVotes() {
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
}