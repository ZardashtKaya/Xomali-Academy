<?php
include 'dbconnect.php';

$registerPath = "http://localhost/registration.php";
$loginPath = "http://localhost/login.php";

session_start();
if (isset($_POST['user'])) {
    $user = $_POST['user'];
}
if (empty($_POST['user'])) {
    header('Location: ' . $registerPath . '?message=Username is empty');
    exit();
}
if (isset($_POST['email'])) {
  
    $email = $_POST['email'];

}
if (empty($_POST['email'])) {
    header('Location: ' . $registerPath . '?message=Email is empty');
    exit();
}

if (isset($_POST['pass'])) {
    $pass = $_POST['pass'];
    // $encPass = md5($pass);
    $hash = password_hash($pass, PASSWORD_DEFAULT);

}

if (empty($_POST['pass'])) {
    header('Location: ' . $registerPath . '?message=Password is empty');
    exit();
}



$session_id = session_id();
$sql = "INSERT INTO `xomali_db`.`user` (`username`,`email` ,`password`,`SessionID`) VALUES (?, ?, ?, ?);";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ssss",$user,$email,$hash,$session_id);

$stmt->execute();

if ($stmt->errno==1062){
    header('Location: '.$registerPath.'?message=This Username exists, Please Choose a different username.');

} else {
    $stmt->close();
    mysqli_close($connection);
    header('Location: '.$loginPath);    
}

