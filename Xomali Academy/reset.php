<?php

$resetPath = "http://localhost/reset.php";

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        header('Location: ' . $resetPath . '?message=Invalid Email');
        }else{
            
        $stmt = $connection->prepare('select email from user where email = ?');
        $stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_num_rows($result);
        if ($row=="0"){
            header('Location: ' . $resetPath . '?message=No user is registered with this email address!');
            } else {
                $expFormat = mktime(
                    date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
                    $expDate = date("Y-m-d H:i:s",$expFormat);
                    $key = md5(2418*2 . $email);
                    $addKey = substr(md5(uniqid(rand(),1)),3,10);
                    $key = $key . $addKey;
                    $sql = "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
                    VALUES (?,?,?);";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("sss",$email,$key,$expDate);
                    $stmt->execute();
                    $link= "http://localhost/reset-password.php?key=".$key."&email=".$email."&action=reset";
                    $message = $link;
                    
 
                    header('Location: ' . $resetPath . '?message=' . $link .$key."&email=".$email."&action=reset");
    
            
        
        }
} }
?>

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
    // $message = "";
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        // $link = $_GET['link'];
        $email  = $_GET['email'];
        $action  = $_GET['action'];
        $message    .= '&email='.$email.'&action=reset';
    }
    ?>


<body>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Reset Your Password</h2>
                </div>
                <form method="post" action="reset.php">
                    <div class="form-group"><label for="email">Email</label><input class="form-control item" type="text" id="email" name="email"></div>
                    <div class="form-group"><button name="reset" class="btn btn-primary btn-block" type="submit">Send Code</button></div>
                    <?php
                        if (!empty($message)) {
                            echo '<br><br><div  class="alert"> <a href="'.$message.'">Reset Link</a></p></div> <br>';
                            // echo($message);
                            
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