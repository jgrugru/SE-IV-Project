<?php
 session_start();
 if (!isset($_SESSION['acme_user_id'])){
   echo "<script>document.location = 'login.php'</script>";
 }
 
    require('utilities/database.php');
    require('utilities/map.php');


    $db = new DATABASE();
    $intersections = $db->getIntersections();

    if(isset($_POST['submitAddTicket'])){
        $sender_id = $_POST['fromCustomer'];
        $recipient_id = $_POST['toCustomer'];
        $creator_id = 1;
        $courier_id = $_POST['courier'];
        $date = date("Y/m/d");
        $bill_to_id = $_POST['billTo'];
        $pickup_time = $_POST['pickUpTime'];
        $status = "Awaiting Pickup";
        $note = $_POST['note'];

        //create class
        $map = new DOWNTOWNMAP();
        $map->populate($intersections);

        //Location of the 3 businesses
        $acme_location = $db->getCompany()->getIntersection()->getId();
        $sender_location = $db->getCustomerById($sender_id)->getIntersection()->getId();
        $recipient_location = $db->getCustomerById($recipient_id)->getIntersection()->getId();

        //$totalBlocks used for courier directionsArray
        //$acmeToRecBlocks used for estimating the cost is th blocks from acme->sender->recipient
        //$sendToRecBlocks used for estimating delivery time is just sender to recipient
        $totalBlocks;
        $acmeToRecBlocks;
        $sendToRecBlocks;

        //$acmeToSender is directions array from acme to sender
        //$senderToRec is directions array sender to recipient
        //$recToAcme is directions array recipient to acme

         //Directions and length from acme to sender
         $start= $acme_location;
         $end = $sender_location;
         $map->dijkstra($start,$end);
         $totalBlocks = $map->getLength();
         $acmeToSender = $map->getDirections();
         array_pop($acmeToSender);

         //Directions and length from sender to recipient
         $start= $sender_location;
         $end = $recipient_location;
         $map->dijkstra($start,$end);
         $sendToRecBlocks = $map->getLength();
         $totalBlocks = $totalBlocks + $map->getLength();
         $acmeToRecBlocks = $totalBlocks;
         $senderToRec = $map->getDirections();
         array_pop($senderToRec);

         //Directions and length from recipient back to acme
         $start= $recipient_location;
         $end = $acme_location;
         $map->dijkstra($start,$end);
         $totalBlocks = $totalBlocks + $map->getLength();
         $recToAcme = $map->getDirections();
         $fullDirections = array_merge($acmeToSender, $senderToRec, $recToAcme);




         //calculate cost
         $base_cost = $db->getCompany()->getDeliveryBaseCost();
         $perblock_cost = $db->getCompany()->getDeliveryPerBlockCost();
         $estimated_cost = $base_cost + ($perblock_cost * $acmeToRecBlocks);
         $cost = $estimated_cost;

        //calculate delivery time
        $timeToDeliver = ($sendToRecBlocks * 2);
        $tempTime = strtotime($pickup_time);
        $assigned_delivery_time = date('h:i:s',strtotime("+".$timeToDeliver." minutes", $tempTime));



        $ticket = new TICKET(0,$sender_id, $recipient_id, $creator_id, $courier_id, $date, $bill_to_id, $assigned_delivery_time, $pickup_time, $delivery_time, $estimated_cost, $cost, $status, $note);
        $db->addTicket($ticket);


      }

  ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>ACME: Add Ticket</title>
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
        <li><a href="mapmaintenance.php"><span class="glyphicon glyphicon-map-marker"></span> Map</a></li>
        <li><a href="employee.php"><span class="glyphicon glyphicon-user"></span> Employees</a></li>
        <li><a href="customer.php"><span class="glyphicon glyphicon-list-alt"></span> Customers</a></li>
        <li><a href="reports.html"><span class="glyphicon glyphicon-file"></span> Reports</a></li>
        <li><a href="#" onclick=""><span class="glyphicon glyphicon-new-window"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- Form -->


  <div class="container col-sm-12">

    <h3 >Add Ticket</h3>
    <form id="ticketForm" action="instructionsPDF.php"  method="post">





      <div class = "col-sm-1"></div>
      <div class= "col-sm-6">


        <div class="form-group">
          <label for="estimatedCost">Estimated Cost:</label>
          <input type="text" class="form-control" id="estimatedCost" name="estimatedCost" value="<?php echo $ticket->getEstimatedCost(); ?>" readonly>
        </div>
        <br>

        <div class="form-group">
          <label for="cost">Cost:</label>
          <input type="text" class="form-control" name="cost" value="<?php echo $ticket->getEstimatedCost(); ?>">
        </div>
        <br>

        <div class="form-group">
          <label for="estimatedTime">Estimated Delivery:</label>

          <input type="text" class="form-control" id="estimatedTime" name="estimatedTime" value="<?php echo $ticket->getAssignedDeliveryTime(); ?>"  readonly>
        </div>
        <br>

      </div>
  </div>

<br>

    <div class ="container col-sm-12">
      <div class="col-sm-5"></div>
      <div class = "col-sm-6">
        <button type="submit" class="btn btn-primary" name="submitAddTicket">Submit</button>



      </div>
    </div>
  </form>



</body>
</html>
