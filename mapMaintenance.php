<?php
    require('utilities/database.php');

    $db = new DATABASE();
    $customers = $db->getCustomers();
    $intersections = $db->getIntersections();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACME</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="style.css">

  <!-- Okta -->
  <script src="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/js/okta-sign-in.min.js" type="text/javascript"></script>
  <link href="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/css/okta-sign-in.min.css" type="text/css" rel="stylesheet"/>
  <link href="https://ok1static.oktacdn.com/assets/js/sdk/okta-signin-widget/2.6.0/css/okta-theme.css" type="text/css" rel="stylesheet"/>

  <!-- Bootstrap -->
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
        <li><a href="maintenance.php"><span class="glyphicon glyphicon-wrench"></span> Maintenance</a></li>
        <li><a href="map.php"><span class="glyphicon glyphicon-map-marker"></span> Map</a></li>
        <li><a href="employee.php"><span class="glyphicon glyphicon-user"></span> Employees</a></li>
        <li><a href="customer.php"><span class="glyphicon glyphicon-list-alt"></span> Customers</a></li>
        <li><a href="reports.html"><span class="glyphicon glyphicon-file"></span> Reports</a></li>
        <li><a href="#" onclick=""><span class="glyphicon glyphicon-new-window"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

    <div class = "container" div style="width:800px;">
        <h2 align ="center">Map Maintenance</h2>
          <div style="width:300px; float:left;">
            <img src="DownTownMap.jpg" alt="Map of Downtown" style="width:400px;height:400px;">
            </div>


          <div style="height: 150px; width: 40%;  overflow-y: auto; float:right;">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Closed Intersection</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                asort($intersections);
                $intersections = array_values($intersections);
                    $length = count($intersections);
                    $closedCount = 0;
                    for($x = 0; $x < $length; $x++){
                      if($intersections[$x]->isClosed())
                      {
                        $closedCount++;
                        echo "<tr class='table-row'>";
                        echo "<td>".($closedCount)."</td>";
                        echo "<td>".$intersections[$x]->getStreetX()->getName(). " , " .$intersections[$x]->getStreetY()->getName()."</td>";
                        echo "</tr>";
                    }
                  }
                ?>
                </tbody>
            </table>

          </div>

<form id="mapMaintenanceForm" action="post.php" method="post">

          <div style="height: 100px; width: 40%; margin-top:8px; margin-bottom:10px; float:right;">

            <div class="form-group">

              <label for="openInter">Select A Closed Intersection To Open:</label>
              <select class="form-control" id="openInter" name="openInter"align:"center">
                <option></option>
                <?php
                asort($intersections);
                $intersections = array_values($intersections);
                $length = count($intersections);
                for($x = 0; $x < $length; $x++){
                  if($intersections[$x]->isClosed())
                  {
                    echo "<option value=".$intersections[$x]->getId().">".$intersections[$x]->getStreetX()->getName(). " , " .$intersections[$x]->getStreetY()->getName()."</option>";
                  }
                    }
            ?>
              </select>
              <button type="submit"  class="btn btn-primary" name="submitOpenInter" style="margin-top:10px; margin-left: 28%;">Open Intersection</button>
            </div>

          </div>

<div style="height: 100px; width: 40%; margin-top:8px; margin-bottom:10px; float:right;">
  <div class="form-group">

    <label for="closeInter">Or Select an Open Intersection to Close:</label>
    <select class="form-control" id="closeInter" name="closeInter"align:"center">
      <option></option>
      <?php
      asort($intersections);
      $intersections = array_values($intersections);
      $length = count($intersections);
      for($x = 0; $x < $length; $x++){
        if(!$intersections[$x]->isClosed())
        {
          echo "<option value=".$intersections[$x]->getId().">".$intersections[$x]->getStreetX()->getName(). " , " .$intersections[$x]->getStreetY()->getName()."</option>";
        }
          }
  ?>
    </select>
    <button type="submit"  class="btn btn-primary" name="submitCloseInter" style="margin-top:10px; margin-left: 28%;">Close Intersection</button>
  </div>


          </div>

</form>
    </div>
</body>
<script>
$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
});

}


</script>
</html>
