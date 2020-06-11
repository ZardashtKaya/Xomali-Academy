<?php
if(isset($_GET['logout'])) {
    unset($_COOKIE['PHPSESSID']);
    setcookie('PHPSESSID', null, -1, '*');
    header('Location: /');
    session_destroy();
    exit;

}

// session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Xomali Academy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="#">Xomali Academy</a><button class="navbar-toggler"
                data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="courses.php">Courses</a></li>
                    <?php   
                        include 'dbconnect.php';
                        if(isset($_COOKIE['PHPSESSID'])) {
                            $session_id = $_COOKIE['PHPSESSID'];
                            $stmt = $connection->prepare('SELECT username,role FROM xomali_db.user where SessionID = ?;');
                            $stmt->bind_param('s', $session_id); // 's' specifies the variable type => 'string'
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                // Do something with $row
                                $username = $row['username'];
                                $role = $row['role'];
                                
                            }
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="submit.php">Submit</a></li>';
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="profile.php">'.$username.'</a></li>';
                            if ($role=='1'){echo '<li class="nav-item" role="presentation"><a class="nav-link" href="users.php">Users</a></li>';}
                            
                            echo '<li class="nav-item" role="presentation"><a class="nav-link " href="?logout">Logout</a></li>';
                        } else {
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="login.php">Login</a></li>';
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="registration.php">Register</a></li>';
                            
                        }?>            

                </ul>
            </div>
        </div>
    </nav>
    <main class="page landing-page">
        <section class="clean-block clean-hero"
            style="background-image:url(&quot;assets/img/tech/image4.jpg&quot;);color:rgba(9, 162, 255, 0.85);">
            <div class="text">
                <h2>Xomali Academy</h2>
                <p>The First Kurdish Language Tech Academy</p>


                <a class="btn btn-light btn-lg" type="button"
                    style="margin-right:10px;margin-bottom:0px;margin-left:10px;" href="courses.php">Courses</a>
                
                    <?php
                    if(!isset($_COOKIE['PHPSESSID'])) {
                        echo '<a class="btn btn-dark btn-lg" type="button" style="margin-right:0px;margin-bottom:0px;" href="registration.php">Register Today!</a>';

                    } else {
                    }
                    ?>
                    
            </div>
        </section>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>