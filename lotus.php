<?php

require("loader.php");

$person = array();
$coach = array();
$team = array();

// create people
for($i=0; $i<$playersTotal; $i++)
{
  $person[] = new player();
}

// set up rankings for all players
for($i=0; $i<$playersTotal; $i++)
{
	$person[$i]->hpRank = $person[$i]->attackRank =
		$person[$i]->speedRank = $person[$i]->rangeRank = 1;

	for($j=0; $j<$playersTotal; $j++)
	{
		if($person[$j]->hp > $person[$i]->hp)
			{ $person[$i]->hpRank++; }
		if($person[$j]->attack > $person[$i]->attack)
			{ $person[$i]->attackRank++; }
		if($person[$j]->range > $person[$i]->range)
			{ $person[$i]->rangeRank++; }
		if($person[$j]->speed > $person[$i]->speed)
			{ $person[$i]->speedRank++; }
	}
}

// create teams
for($i=0; $i<16; $i++)
{
  $team[] = new team($teamName[$i]);
}

// create 16 coaches
for($i=0; $i<16; $i++)
{
  $coach[] = new coach($team[$i]);
	$team[$i]->coach = $coach[$i];
}

// do the draft
// - for each member they need to draft
for($h=0; $h<7; $h++)
{
  // - for each coach
  for($i=0; $i<16; $i++)
  {
    // - rank each player for this coach
    $topPlayer = 0;
    $topScore = 0;
    for($j=0; $j<$playersTotal; $j++)
    {
      $score = $coach[$i]->scorePlayer($person[$j]);

      if($score>$topScore && !isset($person[$j]->team))
      {
        $topScore = $score;
        $topPlayer = $j;
      }
    }
    // - draft
    $person[$topPlayer]->team = $coach[$i]->team;
		$person[$topPlayer]->team->player[] = $person[$topPlayer];
  }
}

// play 1 season
// 30 games (each team plays another twice)
for($i=1; $i<16; $i++)
{
  for($j=0; $j<15; $j++)
  {
    $opponent = ($j+$i)%16;
    playMatch($team[$j], $team[$opponent], $matchSize);
  }
}

$sortedByWins = $team;
usort($sortedByWins, "cmp_wins");
foreach($sortedByWins as $thisTeam)
{
  print "\n";
  print $thisTeam->debug();
}



function cmp_wins($a, $b)
{
  return $a->stats["seasonWins"] < $b->stats["seasonWins"];
}
