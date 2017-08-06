<?php
  // one of the 3 zines
  // responsible for stats
  class gn extends zine
  {
  	// globalizing the rankings array so that the sort functions
  	// have it in scope without needing an argument
  	public $rank = array();
    
    // running counter of team stats
    static function printSeasonState($team)
    {
  		$rank['damageDone'] = array();
  		$rank['damageTaken'] = array();
  		$rank['kills'] = array();
  		$rank['deaths'] = array();
      
      for($i=0; $i<16; $i++)
      {
        print "" . $i+1 . ". " . $team[$i]->name . " " . $team[$i]->stats['seasonWins'] . " " . $team[$i]->stats['seasonLosses'] . "\n";
      }
    }

    static function printTopWorldPlayers($players)
    {
			$playersTotal = sizeof($players);    
    
      // do stats analysis of teams in current state to find
      // - top 5 damage dealers
      // - top 5 blockers
      // - top 5 kills
      // - top 5 deaths
      
      for($i=0; $i<$playersTotal; $i++)
      {
      	// initial set
      	$rank["damageDone"][$i] = 
      		$rank["damageTaken"][$i] =
      		$rank["deaths"][$i] = 
      		$rank["kills"][$i] = 0;
      	// rank by total kills, deaths, damage done, and damage taken
      	// for each player
      	for($j=0; $j<$playersTotal; $j++)
      	{
      		// compared to every other player (including themselves, it's ok)
      		if($players[$i]->stats['careerDamageCaused'] < $players[$j]->stats['careerDamageCaused'])
      			$rank["damageDone"][$i]++;
      		if($players[$i]->stats['careerDamageTaken'] < $players[$j]->stats['careerDamageTaken']) 
      			$rank["damageTaken"][$i]++;
      		if($players[$i]->stats['careerKills'] < $players[$j]->stats['careerKills']) 
      			$rank["kills"][$i]++;
      		if($players[$i]->stats['careerDeaths'] < $players[$j]->stats['careerDeaths']) 
      			$rank["deaths"][$i]++;
      	}
      }
      
      // display
      gn::printTopFive($rank, "damageDone", $players, "careerDamageCaused", "Top Damage Dealers", " damage");
      gn::printTopFive($rank, "damageTaken", $players, "careerDamageTaken", "Top Damage Taken", " damage");
      gn::printTopFive($rank, "kills", $players, "careerKills", "Top Last Hitters", " kills");
      gn::printTopFive($rank, "deaths", $players, "careerDeaths", "Most Deaths", " deaths");
    }
 
	  static function printTopFive($rank, $rankString, $players, $stat, $header, $unit)
  	{
  		print $header . "\n";
			for($i=0; $i<5; $i++)
			{
				$printingI = $i+1;
				$thisOne;
				
				foreach($rank[$rankString] as $key => $val)
				{
					if($i == $val)
					{
						$thisOne = $key;
						break;
					}
				}
				
				print "$printingI. " .
					$players[$thisOne]->name . " (" . 
					$players[$thisOne]->team->name . ") " . 
					$players[$thisOne]->stats[$stat]. " $unit\n"; 
				$players[$thisOne]->debug();
			}
			print "\n";
		}
  }
