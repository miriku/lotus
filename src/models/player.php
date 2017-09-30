<?php
class player
{
	public $name = "";

	// pointer
	public $team;

	// cross season stat
	public $retirementChance = 0;
	public $annaulStatMultiplier = 1;
	public $yearsAtThisMultiplier = 0;

	// combat stats
	public $range = 0;
	public $hp = 0;
	public $attack = 0;
	public $speed = 0;
	public $fatigue = 1;

	// how good he is compared to others
	public $rangeRank;
	public $hpRank;
	public $attackRank;
	public $speedRank;

	public $stats;

	public $inMatch = 0;

	function __construct()
	{
		$this->buildInitialStats();
	}

	function buildinitialStats()
	{
		$this->name = makeName();
		$this->range = rand(10, 300);
		$this->hp = rand(100, 1000);
		$this->attack = rand(10, 1000);
		$this->speed = rand(100, 200);

		$this->stats["careerDamageCaused"] = 0;
		$this->stats["careerDamageTaken"] = 0;
		$this->stats["careerKills"] = 0;
		$this->stats["careerDeaths"] = 0;
		$this->stats["careerGames"] = 0;
		$this->stats["careerBotAttack"] = 0;
		$this->stats["careerBotSniper"] = 0;
		$this->stats["careerBotTank"] = 0;

		$this->stats["seasonDamageCaused"] = 0;
		$this->stats["seasonDamageTaken"] = 0;
		$this->stats["seasonKills"] = 0;
		$this->stats["seasonDeaths"] = 0;
		$this->stats["seasonGames"] = 0;
		$this->stats["seasonBotAttack"] = 0;
		$this->stats["seasonBotSniper"] = 0;
		$this->stats["seasonBotTank"] = 0;

		// season end stats
		$this->retirementChance = 1.5;
		$this->annualStatMultiplier = rand(80, 110)/100;
	}

	function applySeasonEnd()
	{
		// each stat changes by stat multiplier * (+-0.2)
		$this->range *= ceil($this->annualStatMultiplier * (rand(80, 120)/100));
		$this->hp *= ceil($this->annualStatMultiplier * (rand(80, 120)/100));
		$this->attack *= ceil($this->annualStatMultiplier * (rand(80, 120)/100));
		$this->speed *= ceil($this->annualStatMultiplier * (rand(80, 120)/100));

		// are they old and getting worse?
		if($this->retirementChance*10 > rand(1,100)) $this->annualStatMultiplier*=0.98;

		// did they retire?
		if($this->retirementChance > rand(1,100))
			// they did. reroll this playerd
		{
			$this->buildInitialStats();
		}
		else
		{
			$this->stats["seasonDamageCaused"] = 0;
			$this->stats["seasonDamageTaken"] = 0;
			$this->stats["seasonKills"] = 0;
			$this->stats["seasonDeaths"] = 0;
			$this->stats["seasonGames"] = 0;
			$this->stats["seasonBotAttack"] = 0;
			$this->stats["seasonBotSniper"] = 0;
			$this->stats["seasonBotTank"] = 0;

			$this->retirementChance += 1.5;
		}
	}

	function recordBot($bot)
	{
		$this->stats["careerGames"]++;
		$this->stats["seasonGames"]++;
		if("attack"==$bot)
		{
			$this->stats["careerBotAttack"]++;
			$this->stats["seasonBotAttack"]++;
		}
		if("tank"==$bot)
		{
			$this->stats["careerBotTank"]++;
			$this->stats["seasonBotTank"]++;
		}
		if("sniper"==$bot)
		{
			$this->stats["careerBotSniper"]++;
			$this->stats["seasonBotSniper"]++;
		}
	}

	function debug()
	{
		print "Player: $this->name (range $this->range, hp $this->hp, attack $this->attack, speed $this->speed) \n\t\t($this->rangeRank%, $this->hpRank%, $this->attackRank%, $this->speedRank%) @ fatigue " . $this->fatigue . "\n";
		if($this->stats["seasonGames"]>0)
		{
			if($this->stats["seasonDeaths"]>0)
				print "        Season: " . $this->stats["seasonGames"] . " games, " . $this->stats["seasonKills"] . " kills, " . $this->stats["seasonDeaths"] . " deaths, " . round($this->stats["seasonKills"]/$this->stats["seasonDeaths"], 2) . " k/d, ". $this->stats["seasonDamageCaused"] . " attack, " . $this->stats["seasonDamageTaken"] . " tanked\n";
			else {
				print "        Season: " . $this->stats["seasonGames"] . " games, " . $this->stats["seasonKills"] . " kills, " . $this->stats["seasonDeaths"] . " deaths, n/a k/d, ". $this->stats["seasonDamageCaused"] . " attack, " . $this->stats["seasonDamageTaken"] . " tanked\n";
			}
		}
		else print "        Season: 0 games\n";
		if($this->stats["seasonGames"]>0) print "        Per match: " . round($this->stats["seasonKills"]/$this->stats["seasonGames"], 2) . " kills, " . round($this->stats["seasonDeaths"]/$this->stats["seasonGames"], 2) . " deaths, " . round($this->stats["seasonDamageCaused"]/$this->stats["seasonGames"],2) .
					" attack, " . round($this->stats["seasonDamageTaken"]/$this->stats["seasonGames"],2) . " tanked\n";
		if($this->stats["seasonGames"]>0) print "        Bots driven: " . $this->stats["seasonBotAttack"] . " attack, " . $this->stats["seasonBotTank"] . " tank, " . $this->stats["seasonBotSniper"] . " sniper.\n";
	}
}
