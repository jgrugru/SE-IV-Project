<?php
session_start();
require('utilities/database.php');
$db = new DATABASE();

if(isset($_POST['login'])){  
  $email = $_POST['email'];
  $password = $_POST['password'];
  $user = $db->getUser($email);
  if($password === $user->getPassword()) {
    $_SESSION['acme_user_id'] = $user->getEmployeeId();
    echo "<script>document.location = 'index.php'</script>";
  } else {
    echo "<script>document.location = 'login.php'</script>";
  }
}
?>