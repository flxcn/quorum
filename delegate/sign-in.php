<?php

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to dashboard
if(isset($_SESSION["delegate_signed_in"]) && $_SESSION["delegate_signed_in"] === true){
    header("location: dashboard.php");
    exit;
}

// Include config file
require_once "../classes/Delegate.php";

// Define variables and initialize with empty values
$username = "";
$username_error = "";
$error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Instatiate SponsorLogin object
    $delegateObj = new Delegate();
    
    // Set username
    $username = trim($_POST["username"]);
    $username_error = $delegateObj->setUsernameForSignIn($username);

    if(empty($username_error)) {
        if($delegateObj->signIn()) {
            // Start a new session
            if(session_status() !== PHP_SESSION_ACTIVE) session_start();

            // Set session variables
            $_SESSION["delegate_signed_in"] = true;
            $_SESSION["caucus_id"] = $delegateObj->getCaucusId();
            $_SESSION["caucus_title"] = $delegateObj->getCaucusTitle();
            $_SESSION["delegate_id"] = $delegateObj->getDelegateId();
            $_SESSION["first_name"] = $delegateObj->getFirstName();
            $_SESSION["last_name"] = $delegateObj->getLastName();
            $_SESSION["username"] = $delegateObj->getUsername();
            $_SESSION["is_present"] = $delegateObj->getIsPresent();

            // Redirect user to dashboard
            header("location: dashboard.php");
        }
    }
    else {
        $error = $username_error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Delegate Sign in</title>
    
    <link rel="icon" href="../assets/images/icon.png">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="../assets/css/sign-in.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
        <img class="mb-4" src="../assets/images/icons8-vote-64.png" alt="" width="72" height="72">
        
        <h1 class="h3 mb-3 font-weight-normal">Delegate Sign In</h1>

        <label for="username" class="sr-only">Username</label>
        <input type="email" id="username" name="username" class="form-control mb-2" value="" placeholder="College Email Address" required autofocus>
        <div class="text-danger invalid-feedback"><?php echo $password_error; ?></div>
        <button class="btn btn-lg btn-danger btn-block" type="submit">Sign in</button>
        <p class="mt-1">Don't have an account yet? <a href="register.php">Sign up.</a></p>
        <p class="mt-5 mb-3 text-muted">&copy; Felix Chen 2021</p>
    </form>
</body>
</html>