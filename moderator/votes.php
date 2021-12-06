<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["moderator_signed_in"]) || $_SESSION["moderator_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/ModeratorDashboard.php";
$obj = new ModeratorDashboard();
$votes = $obj->getVotes(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Votes</title>

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
            <h1 class="h2">Votes</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a href="vote-create.php" class="btn btn-sm btn-outline-success">Create New</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <?php if($votes):?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Art. #</th>
                            <th scope="col">Title</th>
                            <th scope="col">Proposed by</th>
                            <th scope="col">Delegate Access</th>
                            <th scope="col">Caucus Access</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($votes as $vote):?>
                            <tr>
                                <th scope="row"><?php echo $vote["vote_id"]; ?></th>
                                <td><?php echo $vote["title"]; ?></td>
                                <td><?php echo $vote["caucus"]; ?></td>
                                <?php if($vote["is_open_for_delegates"] === 1): echo "<td class='text-success'>Active</td>"; ?>
                                <?php else: echo "<td class='text-danger'>Closed</td>"; ?>
                                <?php endif; ?>
                                <?php if($vote["is_open_for_caucuses"] === 1): echo "<td class='text-success'>Active</td>"; ?>
                                <?php else: echo "<td class='text-danger'>Closed</td>"; ?>
                                <?php endif; ?>
                                <td>
                                    <a href="vote-update.php?vote_id=<?php echo $vote['vote_id']; ?>">Edit&nbsp;Vote</a> |
                                    <a href="result-read.php?vote_id=<?php echo $vote['vote_id']; ?>">View&nbsp;Results</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center"><i>No votes added yet.</i></p>
                <?php endif;?>
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