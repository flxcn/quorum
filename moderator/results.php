<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Delegates</title>

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
                    <li class="nav-item">
                    <a class="nav-link" href="history.php">History</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="delegates.php">Delegates<span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="sign-out.php">Sign out</a>
                    </li>
                    <!-- <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                    </li> -->
                </ul>
        </div>
        </nav>
    </header>
    
    <div class="container">
        <div class="pt-4 text-center">
            <h2>Constitutional Convention</h2>
            <p class="lead">Completed Amendments</p>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <!-- <h4 class="mb-2">Roster</h4> -->
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Amendment Name</th>
                        <th scope="col">Proposed By</th>
                        <th scope="col">Caucus</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Wealth Amendment</td>
                        <td>Adam W. of Washington</td>
                        <td>Voting</td>
                        <td><a href="result-read.php">View Result</a></td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Congress Voting</td>
                        <td>Jerry Y. of Arkansas</td>
                        <td>Banking</td>
                        <td><a href="result-read.php">View Result</a></td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Funding</td>
                        <td>Larry the Bird</td>
                        <td>Sesame</td>
                        <td><a href="result-read.php">View Result</a></td>
                      </tr>
                    </tbody>
                </table>
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
    <script type="text/javascript">
        var moderator_id = <?php echo $_SESSION['moderator_id']; ?>;
        var committee_id = <?php echo $_SESSION['committee_id'];?>;
    </script>

    <!-- Script for JQuery Functions -->
    <script src="../assets/js/moderator-dashboard.js"></script>
</body>
</html>