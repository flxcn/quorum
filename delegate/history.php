<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/DelegateHistory.php";
$obj = new DelegateHistory($_SESSION["delegate_id"]);
$delegate_votes = $obj->getPastDelegateVotes(); 
$caucus_votes = $obj->getPastCaucusVotes($_SESSION['caucus_id']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>My Record</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">

    <link rel="icon" href="../assets/images/icon.png">
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
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="history.php">My Record <span class="sr-only">(current)</span></a>
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
            <p class="lead">Voting Record</p>
        </div>

        <div class="pt-5 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4>Individual Votes</h1>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <?php if($delegate_votes):?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Amendment Name</th>
                                <th scope="col">Proposed By</th>
                                <th scope="col">Decision</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($delegate_votes as $vote):?>
                                <tr>
                                    <th scope="row"><?php echo $vote["vote_id"]; ?></th>
                                    <td><?php echo $vote["title"]; ?></td>
                                    <td><?php echo $vote["caucus"]; ?></td>
                                    <?php if($vote["decision"] === 1): echo "<td class='text-success'>Yea</td>"; ?>
                                    <?php elseif($vote["decision"] === 0): echo "<td class='text-danger'>Nay</td>"; ?>
                                    <?php else: echo "<td class='text-secondary'>Abstain</td>"; ?>
                                    <?php endif; ?>
                                    <td><a href="<?php echo $vote['link']; ?>">View Text</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>
                    <p class="text-center"><i>No individual votes yet.</i></p>
                <?php endif;?>
            </div>
        </div>

        <div class="pt-5 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4>Caucus Votes</h1>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-2">
                <?php if($caucus_votes):?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Amendment Name</th>
                                <th scope="col">Proposed By</th>
                                <th scope="col">Decision</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($caucus_votes as $vote):?>
                                <tr>
                                    <th scope="row"><?php echo $vote["vote_id"]; ?></th>
                                    <td><?php echo $vote["title"]; ?></td>
                                    <td><?php echo $vote["caucus"]; ?></td>
                                    <?php if($vote["decision"] === 1): echo "<td class='text-success'>Yea</td>"; ?>
                                    <?php elseif($vote["decision"] === 0): echo "<td class='text-danger'>Nay</td>"; ?>
                                    <?php else: echo "<td class='text-secondary'>Pending</td>"; ?>
                                    <?php endif; ?>
                                    <td><a href="<?php echo $vote['link']; ?>">View Text</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>
                    <p class="text-center"><i>No caucus votes yet.</i></p>
                <?php endif;?>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021 Felix Chen</p>
        </footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>