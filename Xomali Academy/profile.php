<?php
if(isset($_GET['logout'])) {
    unset($_COOKIE['PHPSESSID']);
    setcookie('PHPSESSID', null, -1, '*');
    header('Location: /');
    session_destroy();
    exit;

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
                            echo '<li class="nav-item" role="presentation"><a class="nav-link active" href="profile.php">'.$username.'</a></li>';
                            if ($role=='1'){echo '<li class="nav-item" role="presentation"><a class="nav-link" href="users.php">Users</a></li>';}
                            echo '<li class="nav-item" role="presentation"><a class="nav-link " href="?logout">Logout</a></li>';
                        } else {
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="login.php">Login</a></li>';
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="login.php">Login</a></li>';
                            
                        }?>            

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
if(isset($_COOKIE['PHPSESSID'])) {
    $session_id = $_COOKIE['PHPSESSID'];
    $stmt = $connection->prepare('SELECT username FROM xomali_db.user where SessionID = ?;');
    $stmt->bind_param('s', $session_id); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Do something with $row
        $username = $row['username'];
        
    }

    $sql  = "SELECT * FROM xomali_db.courses WHERE author = '".$username."'";
    $result = mysqli_query($connection,$sql);
    
    if (mysqli_fetch_assoc($result)!==NULL){
        $result = mysqli_query($connection,$sql);
        while($row = mysqli_fetch_assoc($result))
            {
        
                echo '<div class="clean-blog-post">';
                echo '<div class="row">';
                echo '<div class="col-lg-5"><img class="rounded img-fluid" src="'.$row['img'].'"></div>';
                echo '<div class="col-lg-7">';
                echo '<h3>'.$row['title'].'</h3>';
                echo '<div class="info"><span class="text-muted">'.$row['author'].'</span></div>';
                echo '<p>'.$row['description'].'</p><a class="btn btn-outline-primary btn-sm" "type="button" href="'.$row['video_url'].'">Watch Course</a></div>';
                echo '</div>';
                echo '<div class="info text-right"><span class="text-muted">'.date("F d, Y", strtotime($row['time'])).'</span></div>';
                echo '</div>';
        
        
            }
    } else {
    
                echo "<div class='alert alert-danger'><strong>Error!</strong> You don't have any courses</div>";
    
    }
        

}

// $sql  = "SELECT * FROM xomali_db.courses WHERE author = ?";
// $result = mysqli_query($connection,$sql);

// if (mysqli_fetch_assoc($result)!==NULL){
//     $result = mysqli_query($connection,$sql);
//     while($row = mysqli_fetch_assoc($result))
//         {
    
           
    
        // }
// } else {


// }


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