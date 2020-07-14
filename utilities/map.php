<?php

class DOWNTOWNMAP {
        private $lengthOfShortestPath;
        private $mapArray;
        private $directionsArray;

        //Construct an array of open intersections
        public function populate($intersections){

          asort($intersections);
          $intersections = array_values($intersections);
          $lengthOfArray = count($intersections);

          for($i = 0; $i < $lengthOfArray; $i++)
          {
          //Works for only dealing with open intersections, no need for closed intersections
          //in the alogirthm array
            if(!$intersections[$i]->isClosed())
            {

                //Works for cheching if x street is both directions
                if($intersections[$i]->getStreetX()->isbothDirections())
                {
                  if($intersections[$i + 1] != null)
                  {
                    //Works for compaing the current street with one node over to see if they are on the same x street
                    if(($intersections[$i]->getStreetX()->getName() == $intersections[$i + 1]->getStreetX()->getName()) && !($intersections[$i + 1]->isClosed()))
                    {
                      $this->mapArray[$intersections[$i]->getID()] [$intersections[$i + 1]->getID()] = 1;
                    }
                  }
                  if($intersections[$i - 1] != null)
                  {
                    //Works for compaing the current street with one node over to see if they are on the same x street
                    if(($intersections[$i]->getStreetX()->getName() == $intersections[$i -1 ]->getStreetX()->getName()) && !($intersections[$i -1 ]->isClosed()))
                    {
                      $this->mapArray[$intersections[$i]->getID()] [$intersections[$i - 1]->getID()] = 1;
                    }
                  }
                }

                //If not both directions getting which direction it goes
                else if($intersections[$i]->getStreetX()->getDirection() == 'W')
                {
                  if($intersections[$i + 1] != null)
                    {
                      if(($intersections[$i]->getStreetX()->getName() == $intersections[$i + 1]->getStreetX()->getName()) && !($intersections[$i + 1]->isClosed()))
                      {
                        $this->mapArray[$intersections[$i]->getID()] [$intersections[$i + 1]->getID()] = 1;
                      }
                    }
                }


                //If it isn't both directions or west the Xstreet has to be east
                else if($intersections[$i]->getStreetX()->getDirection() == 'E')
                {
                  if($intersections[$i - 1] != null)
                    {
                      if(($intersections[$i]->getStreetX()->getName() == $intersections[$i -1 ]->getStreetX()->getName()) && !($intersections[$i -1 ]->isClosed()))
                      {
                        $this->mapArray[$intersections[$i]->getID()] [$intersections[$i - 1]->getID()] = 1;
                      }
                    }
                }

                //Do the same as above but for each intersections y directions
                //Works for cheching if Y street is both directions
                if($intersections[$i]->getStreetY()->isbothDirections())
                {
                  //Works for compaing the current street with seven nodes after to see if there is a street below it
                  //South
                  if($intersections[$i + 7] != null)
                  {
                    if(($intersections[$i]->getStreetY()->getName() == $intersections[$i + 7]->getStreetY()->getName())&& !($intersections[$i + 7]->isClosed()))
                    {
                      $this->mapArray[$intersections[$i]->getID()] [$intersections[$i + 7]->getID()] = 1;
                    }
                  }
                  //Works for compaing the current street with seven nodes before to see if there is a street above it
                  //North
                  if($intersections[$i - 7] != null)
                  {
                    if( ($intersections[$i]->getStreetY()->getName() == $intersections[$i - 7 ]->getStreetY()->getName()) && !($intersections[$i - 7]->isClosed()))
                    {
                      $this->mapArray[$intersections[$i]->getID()] [$intersections[$i - 7]->getID()] = 1;
                    }
                  }
                }
                //If not both directions getting which direction it goes
                else if($intersections[$i]->getStreetY()->getDirection() == 'N')
                {
                  if($intersections[$i - 7] != null)
                  {
                    if(($intersections[$i]->getStreetY()->getName() == $intersections[$i - 7]->getStreetY()->getName())&& !($intersections[$i - 7]->isClosed()))
                    {
                      $this->mapArray[$intersections[$i]->getID()] [$intersections[$i - 7]->getID()] = 1;
                    }
                  }
                }
                //If it isn't both directions or North the Ystreet has to be South
                else if($intersections[$i]->getStreetY()->getDirection() == 'S')
                {
                  if($intersections[$i + 7] != null)
                  {
                    if(($intersections[$i]->getStreetY()->getName() == $intersections[$i + 7 ]->getStreetY()->getName()) && !($intersections[$i + 7 ]->isClosed()))
                    {
                      $this->mapArray[$intersections[$i]->getID()] [$intersections[$i + 7]->getID()] = 1;
                    }
                  }
                }
              }
          }

        }

        //Calculate the shortest path
        //Working correctly
        public function dijkstra($start,$end){


          //The current shortest path with its parent(s) and weight
          $shortestPath = array();

          //All other paths
          $failPaths = array();

          //Sets the weight to "infinity" since currently the shortest path is 0
          //This allows the first path that is calculated be the shortest
          //Else it would stay at 0 and no path would be shorter
          foreach(array_keys($this->mapArray) as $value) $failPaths[$value] = 999;
          $failPaths[$start] = 0;


          //start calculations
          while(!empty($failPaths))
          {
            //the current minimum weight
            $minimum = array_search(min($failPaths), $failPaths);

            //If the minimum is at the ending intersection break
            if($minimum == $end) break;

            //
            foreach($this->mapArray[$minimum] as $key=>$value) if(!empty($failPaths[$key]) && $failPaths[$minimum] + $value < $failPaths[$key])
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
          //Currently not exiting this while loop
          while($position != $start)
          {
            $directions[] = $position;
            $position = $shortestPath[$position][0];
          }


          //Reverse array so it's in order from start to ending intersection
          $directions[] = $start;
          $directions = array_reverse($directions);

          //set class variable directions to final in order direction array
         $this->directionsArray = $directions;
         $this->lengthOfShortestPath = ($shortestPath[$end][1]);

        }


        //returns the length of the shortest path
        public function getLength(){
          return $this->lengthOfShortestPath;
        }

        public function getDirections(){
          return $this->directionsArray;
        }

        public function getMapArray(){
          return $this->mapArray;
        }


}







  ?>
