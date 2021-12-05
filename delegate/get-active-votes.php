<?php

session_start(); // TODO: may or may not be necessary, if I'm posting the data

if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/DelegateDashboard.php";

$obj = new DelegateDashboard($_SESSION["delegate_id"]);

if($_SERVER["REQUEST_METHOD"] == "POST") {

    // $delegate_id = $_POST["delegate_id"]; 
    // $obj = new DelegateDashboard();

    $result = $obj->getOngoingVotes();
    
    if($result) {
        
        $votes = array();
        foreach($result as $row) {
            $votes[] = array(
                "vote_id" => $row['vote_id'],
                "title" => $row['title'],
                "description" => $row['description'],
                "sponsor" => $row['sponsor'],
                "link" => $row['link'],
                "caucus" => $row['caucus'],
                // "is_open_for_delegates" => $is_open_for_delegates,
                // "is_open_for_caucuses" => $is_open_for_caucuses,
            );
        }
		
        // Send back data in JSON format
        header('Content-Type: application/json');
        echo json_encode($votes);
        exit;
    } 
    else {
        echo null;
    }

}
?>