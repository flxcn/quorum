<?php

session_start();

if(isset($_SESSION["moderator_signed_in"]) && $_SESSION["moderator_signed_in"] === true){
    header("location: dashboard.php");
    exit;
}

require_once "../classes/Moderator.php";

$first_name = "";
$last_name = "";
$username = "";
$password = "";
$confirm_password = "";

$error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = new Moderator();
    
    // Set username
    $username = trim($_POST["username"]);
    $error .= $obj->setUsername($username);

    // Set password
    $password = trim($_POST["password"]);
    $error .= $obj->setPassword($password);

    // Set confirm_password
    $confirm_password = trim($_POST["confirm_password"]);
    $error .= $obj->setConfirmPassword($confirm_password);

    if(empty($error))
    {
        if($obj->addModerator()) {
        header("location: sign-in.php");
        }
        else {
            echo "Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Moderator Registration</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    
    <link rel="icon" href="../assets/images/icon.png">
    
    <!-- Custom styles for this template -->
    <link href="../assets/css/register.css" rel="stylesheet">
</head>

<body class="bg-light">
    
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="../assets/images/icon.png" alt="" width="72" height="72">
            <h2>Moderator Registration</h2>
            <p class="lead">Fill out this form to create your <i><b>Quorum</b></i> account.</p>
        </div>

        <p class="text-danger text-center"><?php echo $error; ?></p>

        <div class="row">
            <div class="col-md-12 d-flex justify-content-center order-md-1">
                <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate="" oninput='confirm_password.setCustomValidity(confirm_password.value != password.value ? "Passwords do not match." : "")'>
                
                <h4 class="mb-3">Moderator details</h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                            Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                            Valid last name is required.
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <h4 class="mb-3">Sign-in details</h4>

                    <div class="mb-3">
                        <label for="username">Email (Username)</label>
                        <input type="email" class="form-control" id="username" name="username" placeholder="you@example.com" required="">
                        <div class="invalid-feedback">
                            Please enter a valid email address for your username.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
                        <div class="invalid-feedback">
                            Please enter a password for your email username.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password">Confirm password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required="">
                        <div class="invalid-feedback">
                            Passwords do not match.
                        </div>
                    </div>

                    <hr class="mb-4">

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Register!</button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2021 Felix Chen</p>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom js for this page -->
    <script src="../assets/js/register.js"></script>
</body>
</html>