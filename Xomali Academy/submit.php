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
    <title>Contact Us - Xomali Academy</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">

    <?php
    include 'dbconnect.php';
    $error_message = "";$success_message = "";
    $session_id = $_COOKIE['PHPSESSID'];
    $stmt = $connection->prepare('SELECT username FROM xomali_db.user where SessionID = ?;');
    $stmt->bind_param('s', $session_id); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Do something with $row
        $username = $row;
        
        foreach($username as $username){
            $username = $username;
        }
        
    }
        if(isset($_POST['send'])){
            $title          = trim($_POST['title']);
            $author         = $username;
            $video_url      = trim($_POST['video_url']);
            $description    = trim($_POST['description']);     
            $time           = date ("Y-m-d H:i:s");
            $target_dir = "assets/img/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $img            = $target_file;
            $isValid=false;

            if($title == '' || $video_url == '' || $description == '') {
                $error_message = "Please fill in all the fields.";
                $isValid=false;
            } else {
                $isValid=true;
            }
            
            if($_FILES["file"]["name"] and $isValid==true){

                $sql= "INSERT INTO `xomali_db`.`courses` (`title`, `author`, `img`, `description`, `video_url`, `time`) VALUES (?, ?, ?, ?, ?, NOW());";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("sssss",$title,$author,$img,$description,$video_url);
                $stmt->execute();
                $error_message = $stmt->error;
                $stmt->close();
                $success_message = "Video has been submitted successfully.";
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }

            } else{
                $error_message  = "Sorry, please fill in your form completely.";
            }
        
        }


    ?>




</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="#">Xomali Academy</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="courses.php">Courses</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="submit.php">Submit</a></li>
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
                            echo '<li class="nav-item" role="presentation"><a class="nav-link" href="profile.php">'.$username.'</a></li>';
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
    <main class="page contact-us-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Submit a Tutorial</h2>
                    <p>Here you can submit your tutorials to be shown on the homepage</p>
                </div>
                <?php 
            // Display Error message
            if(!empty($error_message)){
            ?>
            <div class="alert alert-danger">
              <strong>Error!</strong> <?= $error_message ?>
            </div>

            <?php
            }
            ?>

            <?php 
            // Display Success message
            if(!empty($success_message)){
            ?>
            <div class="alert alert-success">
              <strong>Success!</strong> <?= $success_message ?>
            </div>

            <?php
            }
            ?>
                <form name="submit-form" action="" method="post" id="submit-form" enctype="multipart/form-data">
                    <div class="form-group"><label>Tutorial Name</label><input name="title" class="form-control" type="text"></div>
                    <div class="form-group"><label>Thumbnail</label><input name="file" class="form-control" type="file"></div>
                    <div class="form-group"><label>Author</label><input name="author" class="form-control" type="text" placeholder="<?php echo $username;?>"disabled></div>
                    <div class="form-group"><label>Video</label><input name="video_url" class="form-control" type="text"></div>
                    <div class="form-group"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
                    <div class="form-group"><button name="send" class="btn btn-primary btn-block" type="submit">Send</button></div>
                </form>
            </div>
        </section>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>