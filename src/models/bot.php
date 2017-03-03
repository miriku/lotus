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

	function __construct($player, $class)
	{
		$this->speed = $player->speed * $player->fatigue;
		$this->range = $player->range * $player->fatigue;
		$this->hp = $player->hp * $player->fatigue;
		$this->attack = $player->attack * $player->fatigue;

		if($class == "sniper") { $this->range*=2; }
		if($class == "tank") { $this->hp*=2; }
		if($class == "attack") { $this->attack*=2; }

		$this->class = $class;
		$this->player = $player;
	}

	function displayStats()
	{
		return "" . $this->player->name . " ($this->class) [$this->hp, $this->attack, $this->range, $this->speed]";
	}
	function debug()
	{
		print "Bot: " . $this->player->name . "($this->class)";
	}
}
