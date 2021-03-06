<?php
require_once "DatabaseConnection.php";

class ModeratorDashboard {
    protected $pdo = null;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
    }

    // Get an array of all Delegates
    public function getDelegates() {
        $sql =
            "SELECT * FROM delegates
            INNER JOIN caucuses 
            ON delegates.caucus_id = caucuses.caucus_id
            ORDER BY first_name ASC";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if(!$status) {
            return null;
        }
        else {
            $delegates = $stmt->fetchAll();
            return $delegates;
        }
    }

    // Get an array of all Caucuses
    public function getCaucuses() {
        $sql = "SELECT * FROM caucuses";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute();
        if(!$status) {
            return null;
        }
        else {
            $caucuses = $stmt->fetchAll();
            return $caucuses;
        }
    }

    // Get an array of all Caucuses
    public function getVotes() {
        $sql = "SELECT * FROM votes";
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
}
?>