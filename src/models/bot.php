<?php
class bot
{
	// options "sniper", "melee", "tank"
	public $class = "";

	public $player;

	public $range = 0;
	public $hp = 0;
	public $attack = 0;
	public $speed = 0;

	// used during matches
	public $currentHp;
	public $location;
	public $dead;

	// per match stats
	public $stats;

	function __construct($player, $class)
	{
		$this->speed = ceil($player->speed * $player->fatigue);
		$this->range = ceil($player->range * $player->fatigue);
		$this->hp = ceil($player->hp * $player->fatigue);
		$this->attack = ceil($player->attack * $player->fatigue);
		$this->dead = 0;

		if($class == "sniper") { $this->range*=3; }
		if($class == "tank") { $this->hp*=3; }
		if($class == "attack") { $this->attack*=3; }

		$this->class = $class;
		$this->player = $player;

		$this->stats["damageCaused"] = 0;
		$this->stats["kills"] = 0;
		$this->stats["deaths"] = 0;
		$this->stats["damageTaken"] = 0;
	}

	function displayUpdate()
	{
		$string = "";
		if($this->currentHp<1)
			$string .= "DEAD";
		return "$string " . $this->player->name . " ($this->class) [$this->currentHp ($this->hp), $this->attack, $this->range, $this->speed] @ $this->location";
	}

	function displayStats()
	{
		$string = "";
		if($this->currentHp<1)
			$string .= "DEAD";
		return "" . $this->player->name . " ($this->class) [$this->hp, $this->attack, $this->range, $this->speed] at " . $this->player->fatigue. " fatigue $string" .
					"\nKills: ". $this->stats["kills"] . " (" . $this->player->stats["seasonKills"] . ")" .
					" Damage Caused: ". $this->stats["damageCaused"] . " (" . $this->player->stats["seasonDamageCaused"] . ")" .
					" Damage Taken: ". $this->stats["damageTaken"] . " (" . $this->player->stats["seasonDamageTaken"] . ")";
	}

	function debug()
	{
		print "Bot: " . $this->player->name . "($this->class)";
	}
}
