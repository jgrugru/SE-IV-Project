<?php

///////////////////////////////////////////////////////////////////////
//Currently hard coded the map area, move to a loop once the database calls
//are figured out.
///////////////////////////////////////////////////////////////////////


//Create an array of all instersetions which will be viewed as nodes
//and the intersections that they are connected with. For this program all
//lengths are 1 since every intersection is a block apart.
$_downtownMap = array();
//A streets
$_downtownMap[A1][A2] = 1;
$_downtownMap[A2][A3] = 1;
$_downtownMap[A2][B2] = 1;
$_downtownMap[A3][A4] = 1;
$_downtownMap[A4][A5] = 1;
$_downtownMap[A4][B4] = 1;
$_downtownMap[A5][A6] = 1;
$_downtownMap[A6][A7] = 1;
$_downtownMap[A6][B6] = 1;
$_downtownMap[A7][B7] = 1;

//B streets
$_downtownMap[B1][A1] = 1;
$_downtownMap[B2][B1] = 1;
$_downtownMap[B2][A2] = 1;
$_downtownMap[B2][C2] = 1;
$_downtownMap[B3][B2] = 1;
$_downtownMap[B3][A3] = 1;
$_downtownMap[B4][B3] = 1;
$_downtownMap[B4][C4] = 1;
$_downtownMap[B5][B4] = 1;
$_downtownMap[B5][A5] = 1;
$_downtownMap[B6][B5] = 1;
$_downtownMap[B6][A6] = 1;
$_downtownMap[B6][C6] = 1;
$_downtownMap[B7][B6] = 1;
$_downtownMap[B7][C7] = 1;

//C streets
$_downtownMap[C1][B1] = 1;
$_downtownMap[C1][C2] = 1;
$_downtownMap[C2][C3] = 1;
$_downtownMap[C2][B2] = 1;
$_downtownMap[C2][D2] = 1;
$_downtownMap[C3][C4] = 1;
$_downtownMap[C3][B3] = 1;
$_downtownMap[C4][C5] = 1;
$_downtownMap[C4][D4] = 1;
$_downtownMap[C5][C6] = 1;
$_downtownMap[C5][B5] = 1;
$_downtownMap[C6][C7] = 1;
$_downtownMap[C6][B6] = 1;
$_downtownMap[C6][D6] = 1;
$_downtownMap[C7][D7] = 1;

//D streets
$_downtownMap[D1][C1] = 1;
$_downtownMap[D1][D2] = 1;
$_downtownMap[D2][C2] = 1;
$_downtownMap[D2][E2] = 1;
$_downtownMap[D2][D1] = 1;
$_downtownMap[D2][D3] = 1;
$_downtownMap[D3][D2] = 1;
$_downtownMap[D3][D4] = 1;
$_downtownMap[D3][C3] = 1;
$_downtownMap[D4][D3] = 1;
$_downtownMap[D4][D5] = 1;
$_downtownMap[D4][E4] = 1;
$_downtownMap[D5][D4] = 1;
$_downtownMap[D5][D6] = 1;
$_downtownMap[D5][C5] = 1;
$_downtownMap[D6][D5] = 1;
$_downtownMap[D6][D7] = 1;
$_downtownMap[D6][C6] = 1;
$_downtownMap[D6][E6] = 1;
$_downtownMap[D7][D6] = 1;
$_downtownMap[D7][E7] = 1;

//E streets
$_downtownMap[E1][D1] = 1;
$_downtownMap[E1][E2] = 1;
$_downtownMap[E2][E3] = 1;
$_downtownMap[E2][D2] = 1;
$_downtownMap[E2][F2] = 1;
$_downtownMap[E3][E4] = 1;
$_downtownMap[E3][D3] = 1;
$_downtownMap[E4][E5] = 1;
$_downtownMap[E4][F4] = 1;
$_downtownMap[E5][E6] = 1;
$_downtownMap[E5][D5] = 1;
$_downtownMap[E6][E7] = 1;
$_downtownMap[E6][D6] = 1;
$_downtownMap[E6][F6] = 1;
$_downtownMap[E7][F7] = 1;

//F streets
$_downtownMap[F1][E1] = 1;
$_downtownMap[F2][F1] = 1;
$_downtownMap[F2][E2] = 1;
$_downtownMap[F2][G2] = 1;
$_downtownMap[F3][F2] = 1;
$_downtownMap[F3][E2] = 1;
$_downtownMap[F4][F3] = 1;
$_downtownMap[F4][G4] = 1;
$_downtownMap[F5][F4] = 1;
$_downtownMap[F5][E5] = 1;
$_downtownMap[F6][F5] = 1;
$_downtownMap[F6][E6] = 1;
$_downtownMap[F6][G7] = 1;
$_downtownMap[F7][F6] = 1;
$_downtownMap[F7][G7] = 1;

//F streets
$_downtownMap[G1][F1] = 1;
$_downtownMap[G1][G2] = 1;
$_downtownMap[G2][F2] = 1;
$_downtownMap[G2][G3] = 1;
$_downtownMap[G2][G1] = 1;
$_downtownMap[G3][F3] = 1;
$_downtownMap[G3][G2] = 1;
$_downtownMap[G3][G4] = 1;
$_downtownMap[G4][G3] = 1;
$_downtownMap[G4][G5] = 1;
$_downtownMap[G5][F5] = 1;
$_downtownMap[G5][G4] = 1;
$_downtownMap[G5][G6] = 1;
$_downtownMap[G6][G5] = 1;
$_downtownMap[G6][G7] = 1;
$_downtownMap[G6][F6] = 1;
$_downtownMap[G7][G6] = 1;


//Start and ending points
$start = A1;
$end = D5;


//The current shortest path with its parent(s) and weight
$shortestPath = array();
//All other paths
$failPaths = array();

//Sets the weight to "infinity" since currently the shortest path is 0
//This allows the first path that is calculated be the shortest
//Else it would stay at 0 and no path would be shorter
foreach(array_keys($_downtownMap) as $value) $failPaths[$value] = 999;
$failPaths[$start] = 0;


//start calculations
while(!empty($failPaths))
{
  //the current minimum weight
  $minimum = array_search(min($failPaths), $failPaths);

  //If the minimum is at the ending intersection break
  if($minimum == $end) break;

  //
  foreach($_downtownMap[$minimum] as $key=>$value) if(!empty($failPaths[$key]) && $failPaths[$minimum] + $value < $failPaths[$key])
  {
    $failPaths[$key] = $failPaths[$minimum] + $value;
    $shortestPath[$key] = array($minimum, $failPaths[$key]);
  }
  unset($failPaths[$minimum]);
}

//list the shortest path
$directions = array();
//Current position in array
$position = $end;

//Retrack from the ending intersection
while($position != $start)
{
  $directions[] = $position;
  $position = $shortestPath[$position][0];
}

//Reverse array so it's in order from start to ending intersection
$directions[] = $start;
$directions = array_reverse($directions);

//print result
echo "<br />To get from $start to $end";
echo "<br />The distance is ".$shortestPath[$end][1] , " blocks.";
echo "<br />The directions are ".implode(' to ', $directions);
