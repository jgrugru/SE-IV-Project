<?php
require('utilities/database.php');
    $db = new DATABASE();
    $x = 3.4234234324;


    $x = number_format($x, 3);
    var_dump($x);
