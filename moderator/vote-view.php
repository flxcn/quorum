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

$obj = new Vote();

// Check existence of id parameter before processing further
if(isset($_GET["vote_id"]) && !empty(trim($_GET["vote_id"]))){

    $vote_id =  trim($_GET["vote_id"]);
    $obj->setVoteId($vote_id);

    if($obj->getVote()) {
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

$delegate_yea_ballots = $obj->getDelegateYeaVotes(); 
$delegates_yea_count = count($delegate_yea_ballots);
$delegate_nay_ballots = $obj->getDelegateNayVotes(); 
$delegates_nay_count = count($delegate_nay_ballots);
$delegate_abstain_ballots = $obj->getDelegateAbstainVotes();
$delegates_abstain_count = count($delegate_abstain_ballots);
$delegates_present_count = $obj->countDelegatesPresent();

$caucus_yea_ballots = $obj->getCaucusYeaVotes(); 
$caucus_yea_count = count($caucus_yea_ballots); 

$caucus_nay_ballots = $obj->getCaucusNayVotes();
$caucus_nay_count = count($caucus_nay_ballots); 

$caucus_present_count = $obj->countCaucusesPresent();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>View a Vote</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">

    <link rel="icon" href="../assets/images/icon.png">
</head>

<body class="bg-light">
    <header>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#"><img src="../assets/images/icon.png" alt="" width="32" height="32"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item active">
                    <a class="nav-link" href="votes.php">Votes <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="delegates.php">Delegates </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="caucuses.php">Caucuses</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="sign-out.php">Sign out</a>
                    </li>
                </ul>
        </div>
        </nav>
    </header>
    
    <div class="container">

        <div class="pt-4 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">View Vote Details</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a href="votes.php" class="btn btn-sm btn-outline-secondary">Back</a>
                    <a href="vote-update.php?vote_id=<?php echo $obj->getVoteId(); ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $obj->getTitle(); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $obj->getCaucus(); ?></h6>
                    <p class="card-text"><?php echo $obj->getDescription(); ?></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col mt-3">
                <div class="card-body">
                    <h5 class="card-title">Delegate Vote Totals</h5>
                    <h6 class="card-subtitle mb-4"><?php echo $delegates_yea_count + $delegates_nay_count + $delegates_abstain_count; ?> out of <?php echo $delegates_present_count; ?> delegates have voted</h6>

                    <div class="row text-center">
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Yea Votes (<?php echo $delegates_yea_count; ?>)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($delegate_yea_ballots):?>
                                    <?php foreach($delegate_yea_ballots as $ballot):?>
                                    <tr>
                                        <td>
                                            <?php echo $ballot["first_name"] ." ". $ballot["last_name"]; ?>
                                            <a class="text-danger" href="delegate-ballot-delete.php?vote_id=<?php echo $ballot['ballot_id']; ?>">(x)</a>
                                        </th>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr><td class="text-center"><i>No yea votes yet.</i></td></tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nay Votes (<?php echo $delegates_nay_count; ?>)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($delegate_nay_ballots):?>
                                    <?php foreach($delegate_nay_ballots as $ballot):?>
                                    <tr>
                                        <td>
                                            <?php echo $ballot["first_name"] ." ". $ballot["last_name"]; ?>
                                            <a class="text-danger" href="delegate-ballot-delete.php?vote_id=<?php echo $ballot['ballot_id']; ?>">(x)</a>
                                        </th>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr><td class="text-center"><i>No nay votes yet.</i></td></tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Abstain Votes (<?php echo $delegates_abstain_count; ?>)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($delegate_abstain_ballots):?>
                                    <?php foreach($delegate_abstain_ballots as $ballot):?>
                                    <tr>
                                        <td>
                                            <?php echo $ballot["first_name"] ." ". $ballot["last_name"]; ?>
                                            <a class="text-danger" href="delegate-ballot-delete.php?vote_id=<?php echo $ballot['ballot_id']; ?>">(x)</a>
                                        </th>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr><td class="text-center"><i>No abstentions yet.</i></td></tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col mt-3">
                <div class="card-body">
                    <h5 class="card-title">Caucus Vote Totals</h5>
                    <h6 class="card-subtitle mb-4"><?php echo $caucus_yea_count + $caucus_nay_count; ?> out of <?php echo $caucus_present_count; ?> caucuses have voted</h6>

                    <div class="row text-center">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Yea Votes (<?php echo $caucus_yea_count; ?>)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($caucus_yea_ballots):?>
                                    <?php foreach($caucus_yea_ballots as $ballot):?>
                                    <tr>
                                        <td>
                                            <?php echo $ballot["title"]; ?>
                                            <a class="text-danger" href="caucus-ballot-delete.php?vote_id=<?php echo $ballot['ballot_id']; ?>">(x)</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr><td class="text-center"><i>No yea votes yet.</i></td></tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nay Votes (<?php echo $caucus_nay_count; ?>)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($caucus_nay_ballots):?>
                                    <?php foreach($caucus_nay_ballots as $ballot):?>
                                    <tr>
                                        <td>
                                            <?php echo $ballot["title"]; ?>
                                            <a class="text-danger" href="caucus-ballot-delete.php?vote_id=<?php echo $ballot['ballot_id']; ?>">(x)</a>
                                        </th>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr><td class="text-center"><i>No nay votes yet.</i></td></tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021 Felix Chen</p>
        </footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom JS for this page -->
    <!-- Define JS variables to hold PHP session variables -->

    <!-- Script for JQuery Functions -->
    <script src="../assets/js/moderator-dashboard.js"></script>
</body>
</html>