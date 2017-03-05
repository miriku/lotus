<?php

function playMatch($hometeam, $awayteam, $matchSize)
{
  $rounds = 0;
  $hometeam->coach->assignIntoBots();
  $awayteam->coach->assignIntoBots();

  $fighters = array( $hometeam->bot[0], $hometeam->bot[1], $hometeam->bot[2],
    $hometeam->bot[3], $awayteam->bot[0], $awayteam->bot[1], $awayteam->bot[2],
    $awayteam->bot[3]);

	printHeader($hometeam, $awayteam);
  placeInitially($hometeam, $awayteam, $matchSize);

  printState($hometeam, $awayteam);

  while(checkIfSomeoneWon($hometeam, $awayteam) == "none")
  {
    goOneRound($hometeam, $awayteam, $fighters, $matchSize);
    printState($hometeam, $awayteam);
    $rounds++;
  }

  if(checkIfSomeoneWon($hometeam, $awayteam)=="home") { print "\nHome in $rounds\n"; }
  elseif(checkIfSomeoneWon($hometeam, $awayteam)=="away") { print "\nAway in $rounds\n"; }
}

function cmp($a, $b)
{
  return $b->speed > $a->speed;
}

function goOneRound($hometeam, $awayteam, &$fighters, $matchSize)
{
  usort($fighters, "cmp");

  foreach($fighters as $key => $fighter)
  {
    // what's nearest enemy? there has to be one
    $closestBot;
    $closestDistance=$matchSize;

    foreach($fighters as $target)
    {
      if($target->player->team==$fighter->player->team)
      {
        continue;
      }
      $distance = abs($fighter->location - $target->location);
      if($distance<$closestDistance)
      {
        $closestDistance = $distance;
        $closestBot=$target;
      }
    }

    // should i move closer to them or move further away
    $distance = abs($fighter->location - $closestBot->location);

    $cantMove = 0;
    // case 1, too far, let's step up
    if($distance > $fighter->range)
    {
      // is to front or back?
      if($fighter->location>$closestBot->location)
        $sign = -1;
      else
        $sign = 1;

      // walk until done walking or until in range
      for($i=0; $i<$fighter->speed && $distance>$fighter->range; $i++)
      {
        // is the step ahead clear?
        foreach($fighters as $blocker)
        {
          if($blocker->location==$fighter->location+$sign &&
             $blocker->player->team != $fighter->player->team)
          {
            break 2;
          }
        }

        // are they against the edge?
        if($fighter->location+$sign == 0 || $fighter->location+$sign==$matchSize)
        {
          break;
        }

        // step is clear, take it
        $fighter->location=$fighter->location+$sign;

        $distance = abs($fighter->location - $closestBot->location);
      }
    }
    // case 2, too close, let's back up
    elseif($distance < $fighter->range)
    {
      // is to front or back?
      if($fighter->location<$closestBot->location)
        $sign = -1;
      else
        $sign = 1;

      // walk until done walking or until at edge of range
      for($i=0; $i<$fighter->speed && $distance<$fighter->range; $i++)
      {
        // is the step ahead clear?
        foreach($fighters as $blocker)
        {
          if($blocker->location==$fighter->location+$sign &&
             $blocker->player->team != $fighter->player->team)
            break 2;
        }

        // are they against the edge?
        if($fighter->location+$sign == 0 || $fighter->location+$sign==$matchSize)
          break;

        // step is clear, take it
        $fighter->location+=$sign;

        $distance = abs($fighter->location - $closestBot->location);
      }
    }
    // can i shoot anyone?
    if($distance <= $fighter->range)
    {
      // take a shot
      // roll two dice, add them, then multiply attack by it
      $die1=rand(0,5)/10;
      $die2=rand(0,5)/10;
      $attack = ceil($fighter->attack * $die1 * $die2);

      // remove it from their hp
      $closestBot->currentHp -= $attack;

      if($closestBot->currentHp < 1)
      {
        $key = array_search($closestBot, $fighters);
        unset($fighters[$key]);
      }
    }
  }
}

function checkIfSomeoneWon($hometeam, $awayteam)
{
  if($awayteam->bot[0]->currentHp<1 &&
     $awayteam->bot[1]->currentHp<1 &&
     $awayteam->bot[2]->currentHp<1 &&
     $awayteam->bot[3]->currentHp<1)
    return "home";
  elseif($hometeam->bot[0]->currentHp<1 &&
     $hometeam->bot[1]->currentHp<1 &&
     $hometeam->bot[2]->currentHp<1 &&
     $hometeam->bot[3]->currentHp<1)
    return "away";
  return "none";
}

function placeInitially($hometeam, $awayteam, $matchSize)
{
  $hometeam->bot[0]->location=4;
  $hometeam->bot[1]->location=3;
  $hometeam->bot[2]->location=2;
  $hometeam->bot[3]->location=1;

  $awayteam->bot[0]->location=$matchSize-4;
  $awayteam->bot[1]->location=$matchSize-3;
  $awayteam->bot[2]->location=$matchSize-2;
  $awayteam->bot[3]->location=$matchSize-1;

  $hometeam->bot[0]->currentHp = $hometeam->bot[0]->hp;
  $hometeam->bot[1]->currentHp = $hometeam->bot[1]->hp;
  $hometeam->bot[2]->currentHp = $hometeam->bot[2]->hp;
  $hometeam->bot[3]->currentHp = $hometeam->bot[3]->hp;
  $awayteam->bot[0]->currentHp = $awayteam->bot[0]->hp;
  $awayteam->bot[1]->currentHp = $awayteam->bot[1]->hp;
  $awayteam->bot[2]->currentHp = $awayteam->bot[2]->hp;
  $awayteam->bot[3]->currentHp = $awayteam->bot[3]->hp;
}

function printHeader($hometeam, $awayteam)
{
  print "MATCH DAY\n";
  print "$hometeam->name\n";
  print "1. " . $hometeam->bot[0]->displayStats() . "\n";
  print "2. " . $hometeam->bot[1]->displayStats() . "\n";
  print "3. " . $hometeam->bot[2]->displayStats() . "\n";
  print "4. " . $hometeam->bot[3]->displayStats() . "\n";
  print "\t\t[hp, attack, range, speed]\n";
  print "VS\n";
  print "$awayteam->name\n";
  print "A. " . $awayteam->bot[0]->displayStats() . "\n";
  print "B. " . $awayteam->bot[1]->displayStats() . "\n";
  print "C. " . $awayteam->bot[2]->displayStats() . "\n";
  print "D. " . $awayteam->bot[3]->displayStats() . "\n";
  print "\t\t[hp, attack, range, speed]\n";
}

function printState($hometeam, $awayteam)
{
  print "$hometeam->name\n";
  print "1. " . $hometeam->bot[0]->displayUpdate() . "\n";
  print "2. " . $hometeam->bot[1]->displayUpdate() . "\n";
  print "3. " . $hometeam->bot[2]->displayUpdate() . "\n";
  print "4. " . $hometeam->bot[3]->displayUpdate() . "\n";
  print "\t\t[hp, attack, range, speed]\n";
  print "VS\n";
  print "$awayteam->name\n";
  print "A. " . $awayteam->bot[0]->displayUpdate() . "\n";
  print "B. " . $awayteam->bot[1]->displayUpdate() . "\n";
  print "C. " . $awayteam->bot[2]->displayUpdate() . "\n";
  print "D. " . $awayteam->bot[3]->displayUpdate() . "\n";
  print "\t\t[hp, attack, range, speed]\n";
}
