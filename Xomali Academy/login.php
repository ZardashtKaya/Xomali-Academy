<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Xomali Academy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
</head>


<?php
    $message = "";
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }
    ?>


<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="#">Xomali Academy</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="courses.php">Courses</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="login.php">Login</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="registration.php">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Log In</h2>
                </div>
                <form method="post" action="verification.php">
                    <div class="form-group"><label for="username">Username or Email</label><input class="form-control item" type="text" id="email" name="user"></div>
                    <div class="form-group"><label for="password">Password</label><input class="form-control" type="password" id="password" name="pass"></div>
                    <div class="form-group">
                    <div class="form-group"><button name="login" class="btn btn-primary btn-block" type="submit">Login</button></div>
                    <?php
                        if (!empty($message)) {
                            echo '<br><br><div  class="alert alert-danger">'.$message.'</div> <br>';
                        }
                        ?>
                    <a class="label rtl" href="/reset.php">Forgot Your Password?</a>
            </div>
        </section>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>