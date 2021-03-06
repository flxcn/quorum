<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Dashboard</title>

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
                    <li class="nav-item active">
                    <a class="nav-link" href="#">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="votes.php">Votes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="delegates.php">Delegates</a>
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
        <div class="pt-4 text-center">
            <h2>Constitutional Convention</h2>
            <p class="lead">Chair's Dashboard</p>
        </div>

        <hr>

        <div class="row">
            <a href="delegates.php" class="btn btn-primary col mx-1">Delegate Overview</a>
            <a href="caucuses.php" class="btn btn-primary col mx-1">Caucus Overview</a>
            <a href="votes.php" class="btn btn-primary col mx-1">Vote Overview</a>
            <a href="vote-create.php" class="btn btn-success col mx-1">Create a Vote!</a>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">?? 2021 Felix Chen</p>
        </footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom JS for this page -->
    <!-- Define JS variables to hold PHP session variables -->
    <script type="text/javascript">
        var moderator_id = <?php echo $_SESSION['moderator_id']; ?>;
        var committee_id = <?php echo $_SESSION['committee_id'];?>;
    </script>

    <!-- Script for JQuery Functions -->
    <script src="../assets/js/moderator-dashboard.js"></script>
</body>
</html>