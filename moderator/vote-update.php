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
$is_open_for_caucuses = 0;
$is_open_for_delegates = 0;

$vote_id = "";

$obj = new Vote();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get hidden input value
    $vote_id = $_POST["vote_id"];
    $obj->setVoteId($vote_id);

    // Set title
    $title = trim($_POST["title"]);
    $error .= $obj->setTitle($title);

    // Set sponsor
    $sponsor = trim($_POST["sponsor"]);
    $error .= $obj->setSponsor($sponsor);

    // Set caucus
    $caucus = trim($_POST["caucus"]);
    $error .= $obj->setCaucus($caucus);

    // Set link
    $link = trim($_POST["link"]);
    $error .= $obj->setLink($link);

    // Set description
    $description = trim($_POST["description"]);
    $error .= $obj->setDescription($description);

    // Set is_open_for_delegates
    $is_open_for_delegates = trim($_POST["is_open_for_delegates"]);
    $error .= $obj->setIsOpenForDelegates($is_open_for_delegates);

    // Set is_open_for_caucuses
    $is_open_for_caucuses = trim($_POST["is_open_for_caucuses"]);
    $error .= $obj->setIsOpenForCaucuses($is_open_for_caucuses);

    if(empty($error))
    {
        if($obj->updateVote()) {
            header("location: votes.php");
        }
        else {
            echo "Something went wrong. Please try again later.";
        }
    }
} 
else {
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
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Update a Vote</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="icon" href="../assets/images/icon.png">
    
    <!-- Custom styles for this template -->
    <link href="../assets/css/register.css" rel="stylesheet">
</head>

<body class="bg-light">
    
    <div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-4" src="../assets/images/icon.png" alt="" width="72" height="72">
            <h2>Update a Vote</h2>
            <p class="lead">Fill out this form to update an existing vote.</p>
        </div>

        <p class="text-danger text-center"><?php echo $error; ?></p>

        <div class="row">
            <div class="col-md-12 d-flex justify-content-center order-md-1">
                <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate="" oninput='confirm_password.setCustomValidity(confirm_password.value != password.value ? "Passwords do not match." : "")'>
                

                <div class="row mx-4">
                    <div class="mb-3 col-md-12">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $title; ?>" required="">
                        <div class="invalid-feedback">
                            Please enter a valid title.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sponsor">Sponsor</label>
                        <input type="text" class="form-control" id="sponsor" name="sponsor" placeholder="Sponsor" value="<?php echo $sponsor; ?>" required="">
                        <div class="invalid-feedback">
                            Please enter a valid sponsor.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="caucus">Caucus</label>
                        <input type="text" class="form-control" id="caucus" name="caucus" placeholder="Caucus" value="<?php echo $caucus; ?>" required="">
                        <div class="invalid-feedback">
                            Please enter a valid caucus.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="link">URL Link</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="http://" value="<?php echo $link; ?>" required="">
                        <div class="invalid-feedback">
                            Please enter a valid link.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description">Description</label>
                        <textarea type="text" class="form-control" id="description" name="description" placeholder="Description" required=""><?php echo $description; ?></textarea>
                        <div class="invalid-feedback">
                            Please enter a valid description.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type='hidden' value='0' name='is_open_for_delegates'>
                            <input class="form-check-input" type="checkbox" value="1" name="is_open_for_delegates" id="is_open_for_delegates" <?php if($is_open_for_delegates===1){echo "checked";}?>>
                            <label class="form-check-label" for="is_open_for_delegates">
                                Open to delegates
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input type='hidden' value='0' name='is_open_for_caucuses'>
                            <input class="form-check-input" type="checkbox" value="1" name="is_open_for_caucuses" id="is_open_for_caucuses" <?php if($is_open_for_caucuses===1){echo "checked";}?>>
                            <label class="form-check-label" for="is_open_for_caucuses">
                                Open to caucuses
                            </label>
                        </div>
                        <span class="help-block text-danger"><?php echo $error;?></span>
                    </div>

                    <input type="hidden" name="vote_id" value="<?php echo $vote_id; ?>"/>

                    <hr class="mb-4">

                    <button class="btn btn-danger btn-lg btn-block w-100" type="submit">Update!</button>
                    <br>
                    <a href="votes.php" class="btn w-100 btn-link">Go back</a>
                    </div>

                </form>
            </div>
        </div>

        <footer class="my-5 pt-3 text-muted text-center text-small">
            <p class="mb-1">&copy; 2021 Felix Chen</p>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom js for this page -->
    <script src="../assets/js/register.js"></script>
</body>
</html>