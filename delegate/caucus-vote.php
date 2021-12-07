<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

// Include Caucus Ballot Class
require_once '../classes/CaucusBallot.php';
$obj = new CaucusBallot();

if(isset($_GET["vote_id"]) && !empty(trim($_GET["vote_id"]))){

    if($obj->checkBallotExists(trim($_GET["vote_id"]), $_SESSION["caucus_id"])) {
        header("location: history.php");
    }

    $error = "";
    $vote_id = trim($_GET["vote_id"]);
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check input errors before inserting in database
    if(isset($_SESSION["caucus_id"]) && isset($_POST["decision"]) && isset($_POST["vote_id"]))
    {

        $obj->setCaucusId($_SESSION["caucus_id"]);
        $obj->setVoteId($_POST["vote_id"]);

        if(strcmp($_POST["decision"],"yea") == 0) {
            $obj->setDecision(1);
        }
        elseif(strcmp($_POST["decision"],"nay") == 0) {
            $obj->setDecision(0);
        }
        elseif(strcmp($_POST["decision"],"abstain") == 0) {
            $obj->setDecision(null);
        }
        else {
            $error = "Please select an option.";
        }

        if(empty($error)) {
            if($obj->addBallot()) {
                // Success
                $_SESSION["ballot_success"] = true;
                header("location: dashboard.php");
                exit();
            }
            else {
                // Failure
                header("location: error.php");
                exit();
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Felix Chen">
    
    <title>Vote as a Caucus!</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <main class="ms-sm-auto px-md-4">
                <div class="col-12 col-md-6 card mt-3 mx-auto border-primary">
                    <h5 class="card-header">Vote as a Caucus!</h5>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="vote_id" value="<?php echo $vote_id; ?>"/>
                            <select name="decision">
                                <option value="">Select option</option>
                                <option value="yea">Yea</option>
                                <option value="nay">Nay</option>
                            </select>
                            <p class="text-danger"><?php echo $error; ?></p>
                            <input type="submit" value="Vote!" class="btn btn-success"> 
                            <a href="dashboard.php" class="btn btn-outline-secondary">Go back</a>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


