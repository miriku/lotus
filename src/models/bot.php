<?php
class bot
{
	// options "sniper", "melee", "tank"
	public $class = "";
	public $team;

	public $range = 0;
	public $hp = 0;
	public $attack = 0;

	function debug()
	{
		print "Player: $this->name";
	}
}
