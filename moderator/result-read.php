<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["moderator_signed_in"]) || $_SESSION["moderator_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/Vote.php";

$title = "";
$sponsor = "";
$caucus = "";
$link = "";
$description = "";
$error = "";
$vote_id = "";
$is_open_for_caucuses = "";
$is_open_for_delegates = "";

$vote_id = "";

// Check existence of id parameter before processing further
if(isset($_GET["vote_id"]) && !empty(trim($_GET["vote_id"]))){

    $obj = new Vote();

    $vote_id =  trim($_GET["vote_id"]);
    $obj->setVoteId($vote_id);

    if($obj->getVote()) {
        $vote_id = $obj->getVoteId();
        $title = $obj->getTitle();
        $sponsor = $obj->getSponsor();
        $caucus = $obj->getCaucus();
        $link = $obj->getLink();
        $description = $obj->getDescription();
        $is_open_for_delegates = $obj->getIsOpenForDelegates();
        $is_open_for_caucuses = $obj->getIsOpenForCaucuses();
    }
    else {
        echo "Existing vote details unavailable.";
        exit();
    }        
}
else {
    header("location: error.php");
    exit();
}

$delegate_yea_count = $obj->countDelegateYeaVotes();
$delegate_nay_count = $obj->countDelegateNayVotes();
$delegate_abstain_count = $obj->countDelegateAbstainVotes();
$delegate_present_count = $obj->countDelegatesPresent();
$delegate_nonvoting_count = $delegate_present_count - $delegate_abstain_count - $delegate_nay_count - $delegate_yea_count;

$caucus_yea_count = $obj->countCaucusYeaVotes();
$caucus_nay_count = $obj->countCaucusNayVotes();
$caucus_present_count = $obj->countCaucusesPresent();
$caucus_nonvoting_count = $caucus_present_count - $caucus_yea_count - $caucus_nay_count;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Felix Chen">
    <link rel="icon" type="image/png" href="icon.png">
    <title>H-SPAN | Vote Tally</title>
    <link href="../assets/css/hspan.css" rel="stylesheet">
</head>
<body>
    <div class="bgimg">
        <div class="middle">
            <p id="title"><?php echo $obj->getSponsor(); ?><br>of <?php echo $obj->getCaucus(); ?> CAUCUS<br>ON <?php echo $obj->getTitle(); ?></p>

            <table style="margin-top: 1.5em;">   
                <tr style="margin-bottom: 0.75em;">
                    <td>AMEND.</td>
                    <td id="voteId">&nbsp;&nbsp;&nbsp;<?php echo "#" . $obj->getVoteId(); ?></td>
                </tr>

                <tr>
                    <td></td>
                    <th>YEA</td>
                    <td>NAY</td>
                    <td>ABST</td>
                    <td>NV</td>
                </tr>
            
                <tr>
                    <th>DELEGATES&nbsp;&nbsp;</th>
                    <td id="delegateYeaCount"><?php echo $delegate_yea_count; ?></td>
                    <td id="delegateNayCount"><?php echo $delegate_nay_count; ?></td>     
                    <td><?php echo $delegate_abstain_count; ?></td>
                    <td><?php echo $delegate_nonvoting_count; ?></td>
                </tr>

                <tr>
                    <th>CAUCUSES</th>
                    <td id="caucusYeaCount"><?php echo $caucus_yea_count; ?></td>
                    <td id="caucusNayCount"><?php echo $caucus_nay_count; ?></td>
                    <td></td>
                    <td id="caucusNonvotingCount"><?php echo $caucus_nonvoting_count; ?></td>
                </tr>
            </table>

            <p id="time">  
                TIME REMAINING&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </p>

            <p id="outcome"></p>
        </div>
        
        <a href="votes.php" class="logo">
            H<span style="font-size: 80%;">&#9642;</span>SPAN
        </a>
    </div>

    <script>
        var duration = 5;

        var countDownDate = new Date(new Date().getTime() + duration * 1000);
        
        var countDownFunction = setInterval(function() {
        
            var now = new Date().getTime();
        
            var difference = countDownDate - now;
        
            var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((difference % (1000 * 60)) / 1000);
        
            document.getElementById("time").innerHTML = "TIME REMAINING&nbsp;&nbsp;" + 
            minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
        
            if (difference < 0) {
                clearInterval(countDownFunction);
                document.getElementById("time").innerHTML = "TIME REMAINING&nbsp;&nbsp;0:00";
                calculateOutcome();
            }
        }, 1000);

        function calculateOutcome() {
            var delegateYeaCount = parseInt(document.getElementById("delegateYeaCount").innerHTML);
            var delegateNayCount = parseInt(document.getElementById("delegateNayCount").innerHTML);

            var caucusYeaCount = parseInt(document.getElementById("caucusYeaCount").innerHTML);
            var caucusNayCount = parseInt(document.getElementById("caucusNayCount").innerHTML);
            var caucusNonvotingCount = parseInt(document.getElementById("caucusNonvotingCount").innerHTML);

            if (delegateYeaCount / (delegateYeaCount + delegateNayCount) >= 0.75 && caucusYeaCount / (caucusYeaCount + caucusNayCount + caucusNonvotingCount) >= 0.667) {
                document.getElementById("outcome").innerHTML = "PASSAGE SECURED";
                document.getElementById("outcome").style.backgroundColor = "green";
            }
            else if (delegateYeaCount / (delegateYeaCount + delegateNayCount) < 0.75 || caucusYeaCount / (caucusYeaCount + caucusNayCount + caucusNonvotingCount) < 0.667)
            {
                document.getElementById("outcome").innerHTML = "PASSAGE FAILED";
                document.getElementById("outcome").style.backgroundColor = "red";
            }
            else {
                document.getElementById("outcome").innerHTML = "ERROR";
                document.getElementById("outcome").style.backgroundColor = "white";
                document.getElementById("outcome").style.color = "black";
            }

        }
    </script>

</body>
</html>