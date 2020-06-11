<?php
include 'dbconnect.php';


$loginPath = "http://localhost/login.php";
$indexPath = "http://localhost/index.php";
$cookie_name="PHPSESSID";
$cookie_value="";

if (isset($_POST['user'])) {

    $input = $_POST['user'];
    if(strstr($input, '@')){
        $email_input = $_POST['user'];
    } else {
        $user = $_POST['user'];
    } 
    
}
if (empty($_POST['user'])) {
    header('Location: ' . $loginPath . '?message=Please Enter Your Username');
    exit();
}

if (isset($_POST['pass'])) {
    $pass = $_POST['pass'];
    // $encPass = md5($pass);
}

if (empty($_POST['pass'])) {
    header('Location: ' . $loginPath . '?message=Please Enter a password');
    exit();
}



if (!empty($user)) {
    $stmt = $connection->prepare('select password from user where username = ?');
    $stmt->bind_param('s', $user); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Do something with $row
        $hashed_pass = $row;
        
        foreach($hashed_pass as $hashed_pass){
            $hashed_pass = $hashed_pass;
        }
        
        
    }
    if (password_verify($pass, $hashed_pass)) {
        $stmt = $connection->prepare("SELECT SessionID FROM xomali_db.user where username = ?;");
        $stmt->bind_param('s', $user); // 's' specifies the variable type => 'string'
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Do something with $row
            $cookie_value = $row;
            
            foreach($cookie_value as $cookie_value){
                $cookie_value = $cookie_value;
            }
            
        }
         setcookie($cookie_name,$cookie_value, time() + (86400 * 30), "*");
          header('Location: '.$indexPath);
          exit();
    } else {
          header('Location: '.$loginPath.'?message=User Name Or password is incorrect');
          exit();
    }
    
    
} elseif (!empty($email_input))  {
    $stmt = $connection->prepare('select password from user where email = ?');
    $stmt->bind_param('s', $email_input); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Do something with $row
        $hashed_pass = $row;
        
        foreach($hashed_pass as $hashed_pass){
            $hashed_pass = $hashed_pass;
        }
        
        
    }
    if (password_verify($pass, $hashed_pass)) {
        $stmt = $connection->prepare("SELECT SessionID FROM xomali_db.user where email = ?;");
        $stmt->bind_param('s', $email_input); // 's' specifies the variable type => 'string'
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Do something with $row
            $cookie_value = $row;
            
            foreach($cookie_value as $cookie_value){
                $cookie_value = $cookie_value;
            }
            
        }
         setcookie($cookie_name,$cookie_value, time() + (86400 * 30), "*");
          header('Location: '.$indexPath);
          exit();
    } else {
          header('Location: '.$loginPath.'?message=User Name Or password is incorrect');
          exit();
    }
    
    
}





mysqli_close($connection);


/*
  if($user == $actualUser && $pass == $actualPass){
  header('Location: '.$calculatorPath);
  exit();
  }else{
  header('Location: '.$loginPath.'?message=User Name Or password is incorrect');
  exit();
  }


 */
?>