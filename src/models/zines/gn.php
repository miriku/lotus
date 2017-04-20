<?php
  // one of the 3 zines
  // responsible for stats
  class gn extends zine
  {
    // running counter of team stats
    static function printSeasonState($team)
    {
      for($i=0; $i<16; $i++)
      {
        print "" . $i+1 . ". " . $team[$i]->name . " " . $team[$i]->stats['seasonWins'] . " " . $team[$i]->stats['seasonLosses'] . "\n";
      }
    }

    static function printTopPlayers($team)
    {
      // do stats analysis of teams in current state to find
      // - top 5 damage dealers
      // - top 5 blockers
    }
  }
