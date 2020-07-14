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
  $customers = $db->getCustomers();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACME: Billing Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>

<body>
   
  <!-- Navbar -->
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

  <!-- Form -->
  <div class="container col-sm-12">

    <h3 >Billing report</h3>
    <br>
    <br>

    <div class="col-sm-1">&nbsp</div>

    <form action ="billingView.php" method="post" target="_blank">
      <div class ="col-sm-4">
        <div class="form-group">
          <label for="startDate">Start Date:</label>
          <input type="date" name="startDate" value="mm-dd-yyyy" min="2000-01-01" max="2040-12-31">
        </div>

        <div class="form-group">
          <label for="endDate">End Date:</label>
          <input type="date" name="endDate" value="mm-dd-yyyy" min="2000-01-01" max="2040-12-31">
        </div>
      </div>
      <br>

      <div class= "col-sm-2">
        <div class="form-group">
          <label for="customer">Customer:</label>
          <select class="form-control" name="customer">
          <?php
                $length = count($customers);
                for($x = 0; $x < $length; $x++){
                  echo "<option value=".$customers[$x]->getId().">".$customers[$x]->getName()."</option>";
                }
          ?>
          </select>
        </div>
      </div>
  </div>
  <br>

    <div class ="container col-sm-12">
      <div class="col-sm-4"></div>
      <div class = "col-sm-1">
      <br>
        <button type="submit" class="btn btn-primary" name="submitBillingreport">Generate Report</button>
      </div>
      
    </div>
  </form>

</body>
</html>

