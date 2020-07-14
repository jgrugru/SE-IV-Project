<?php
  session_start();
  if (!isset($_SESSION['acme_user_id'])){
    echo "<script>document.location = 'login.php'</script>";
  }
  require('utilities/database.php');
  $db = new DATABASE();
  $user = $db->getUserById($_SESSION['acme_user_id']);
  if ($user->getPermission() != 'Admin') {
    echo "<script>document.location = 'index.php'</script>";
  }
  $employees = $db->getEmployees();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACME: Add User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
      <a href="index.php"><img src="ACME.png"  style="width:135px;"/></a>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php"><span class="glyphicon glyphicon-tag"></span> Tickets</a></li>
        <li><a href="mapmaintenance.php"><span class="glyphicon glyphicon-map-marker"></span> Map</a></li>
        <li><a href="employee.php"><span class="glyphicon glyphicon-th-list"></span> Employees</a></li>
        <li><a href="customer.php"><span class="glyphicon glyphicon-list-alt"></span> Customers</a></li>
        <?php 
          $user = $db->getUserById($_SESSION['acme_user_id']);
          if ($user->getPermission() == 'Admin') {
            echo '<li><a href="user.php"><span class="glyphicon glyphicon-user"></span> Users</a></li>';
            echo '<li><a href="maintenance.php"><span class="glyphicon glyphicon-wrench"></span> Maintenance</a></li>';
            echo '<li><a href="reports.php"><span class="glyphicon glyphicon-file"></span> Reports</a></li>';
          }
        ?>
        <li><a href="logout.php"><span class="glyphicon glyphicon-new-window"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <h3 style>Add User</h3>
    <form action="post.php" method="post">
      <div class="form-group">
        <label for="employee">Employee</label>
        <select class="form-control" name="employee">
        <?php
          $length = count($employees);
          for($x = 0; $x < $length; $x++){
            if ($employees[$x]->getType() != 'Courier')
            echo "<option value=".$employees[$x]->getId().">".$employees[$x]->getFirstName()." ".$employees[$x]->getLastName()."</option>";
          }
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="permission">Role</label>
        <select class="form-control" name="permission">
          <option value="Employee">Employee</option>
          <option value="Admin">Admin</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary" name="submitAddUser">Add</button>
    </form>
  </div>
</body>
</html>