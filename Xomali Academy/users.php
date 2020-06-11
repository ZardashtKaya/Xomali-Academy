<?php
include 'dbconnect.php';
if(isset($_GET['logout'])) {
    unset($_COOKIE['PHPSESSID']);
    setcookie('PHPSESSID', null, -1, '*');
    header('Location: /');
    session_destroy();
    exit;

}
$message = "";
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

if(isset($_GET['remove'])) {
    $user_to_remove = $_GET['remove'];
    header("Location: " . $path . "?message=You have removed: ".$user_to_remove);

    if ($user_to_remove == 'admin'){
        $path = "http://localhost/users.php";
        header("Location: " . $path . "?message=You can't remove the administrator");
        } else {
            $sql = "DELETE FROM `xomali_db`.`user` WHERE (`username` = ?);";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s",$user_to_remove);
            $stmt->execute();
            $sql = "DELETE FROM `xomali_db`.`courses` WHERE (`author` = ?);";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s",$user_to_remove);
            $stmt->execute();
        }
        
    } 
  


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Xomali Academy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="#">Xomali Academy</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php">Home</a></li>
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
                            echo '<li class="nav-item" role="presentation"><a class="nav-link active" href="users.php">Users</a></li>';
                            echo '<li class="nav-item" role="presentation"><a class="nav-link " href="?logout">Logout</a></li>';
                        } else {
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="login.php">Login</a></li>';
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="login.php">Login</a></li>';
                            
                        }
                        
                       
                    
                        ?>            

                </ul>
            </div>
        </div>
    </nav>
    <main class="page blog-post-list">
        <section class="clean-block clean-blog-list dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Courses</h2>
                </div>
                <div class="block-content">

<?php
include 'dbconnect.php';
if (!empty($message)) {
    echo '<br><br><div  class="alert alert-danger">'.$message.'</div> <br>';
}

$sql  = "SELECT username FROM xomali_db.user";
$result = mysqli_query($connection,$sql);

if (mysqli_fetch_assoc($result)!==NULL){
    $result = mysqli_query($connection,$sql);
    while($row = mysqli_fetch_assoc($result))
        {
    
            echo '<div class="clean-blog-post">';
            echo '<div class="row">';
            echo '<div class="col-lg-7">';
            echo '<h3>'.$row['username'].'</h3>';
            echo '<a class="btn btn-outline-primary btn-sm" "type="button" href="?remove='.$row['username'].'">Remove User</a></div>';
            
            echo '</div>';
            echo '</div>';
    
    
        }
} else {

            echo '<div class="alert alert-danger"><strong>Error!</strong> There are no courses available at this moment</div>';

}


?>

                </div>
            </div>
        </section>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>