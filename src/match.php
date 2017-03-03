<?php

function playMatch($hometeam, $awayteam)
{
  $hometeam->coach->assignIntoBots();
  $awayteam->coach->assignIntoBots();

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
