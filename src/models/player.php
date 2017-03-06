<?php
class player
{
	public $name = "";
	public $team;

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

		$this->stats["seasonDamageCaused"] = 0;
		$this->stats["seasonDamageTaken"] = 0;
		$this->stats["seasonKills"] = 0;
		$this->stats["seasonDeaths"] = 0;
		$this->stats["seasonGames"] = 0;
	}

	function debug()
	{
		print "Player: $this->name (range $this->range, hp $this->hp, attack $this->attack, speed $this->speed) \n\t\t(#$this->rangeRank, #$this->hpRank, #$this->attackRank, #$this->speedRank) @ fatigue " . $this->fatigue . "\n";
		print "        Season: " . $this->stats["seasonGames"] . " games, " . $this->stats["seasonKills"] . " kills, " . $this->stats["seasonDeaths"] . " deaths, " . $this->stats["seasonDamageCaused"] . " attack, " . $this->stats["seasonDamageTaken"] . " tanked\n";
	}
}
