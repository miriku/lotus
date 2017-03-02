<?php
require("loader.php");

$person = array();
$coach = array();
$team = array();

// create people
for($i=0; $i<1000; $i++)
{
  $person[] = new player();
}

// set up rankings for all players
for($i=0; $i<1000; $i++)
{
	$person[$i]->hpRank = $person[$i]->attackRank =
		$person[$i]->speedRank = $person[$i]->rangeRank = 1;

	for($j=0; $j<1000; $j++)
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
    for($j=0; $j<1000; $j++)
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

// print the teams
for($i=0; $i<16; $i++)
{
	$team[$i]->debug();
	print "\n";
}
