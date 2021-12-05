<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/DelegateDashboard.php";
$obj = new DelegateDashboard($_SESSION["delegate_id"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <!-- <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="icon" href="../assets/images/icon.png">

    
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">

    <style>
    .delegate {
        border:none;
        background-color:transparent;
        outline:none;
        padding: 0px;
    }
    </style>
</head>

<body class="bg-light">
    <header>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <!-- <a class="navbar-brand" href="#"><img src="../assets/images/icons8-vote-64.png" alt="" width="32" height="32"></a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarsExample02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">My Record</a>
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
        <div class="pt-4 text-center">
            <!-- <img class="d-block mx-auto mb-4" src="../assets/images/icons8-vote-64.png" alt="" width="72" height="72"> -->
            <h2 class="mt-4">Constitutional Convention</h2>
            <p class="lead">Welcome, <?php echo $_SESSION["first_name"]; ?>!</p>
        </div>

        <div class="row">

            <div class="col-md-4 order-md-2 mb-4">
                <div class="card text-center" style="border-color: grey;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?></h5>
                        <small class="card-text text-muted"><?php echo $_SESSION["username"]; ?></small>
                        <hr>
                        <p class="card-text">Member of the <b><?php echo $_SESSION["caucus"]; ?> Caucus</b></p>
                        <p class="card-text">You have <b><?php echo $obj->countRemainingYeaVotes(); ?></b> individual yea votes remaining</p>
                        <hr>
                        <p><?php echo $obj->formatPresentDelegates(); ?></p>
                        <?php if ($_SESSION["is_present"] == 0): ?>
                            <div class="btn-group text-center mb-2 mb-md-0">
                                <a href="delegate-update.php" class="btn btn-sm btn-outline-success">Mark as present</a>  
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8 order-md-1">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom print">
                    <h4 class="mb-2">Ongoing Votes (<span id="ongoingVotesCount"></span>)</h4>
                    <!-- <h4 class="mb-2">Ongoing Voting <span id="ongoingVotesCount" class="badge badge-pill badge-secondary">(0)</span></h4> -->
                    
                    <button class="btn btn-sm btn-outline-secondary" onclick="getOngoingVotes();">Refresh</button>
                </div>

                <div id="ongoingVotes">
                    <p>There are no ongoing votes at this time.</p>
                </div>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021 Felix Chen</p>
        </footer>
    </div>

    <!-- 
    <script src="../assets/js/jquery-3.3.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.6/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="./Checkout example · Bootstrap v4.6_files/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom JS for this page -->
    <!-- Define JS variables to hold PHP session variables -->
    <script type="text/javascript">
        var delegate_id  = <?php echo $_SESSION['delegate_id']; ?>;
    </script>

    <!-- Script for JQuery Functions -->
    <script src="../assets/js/dashboard.js"></script>

</body>
</html>