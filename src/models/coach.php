<?php
class coach
{
	public $name = "";
	public $team;

	// combat stats
	public $favorRange = 0;
	public $favorHp = 0;
	public $favorAttack = 0;
	public $favorSpeed = 0;

	function __construct($team)
	{
		$this->team = $team;
		$this->name = makeName();
		$this->favorRange = rand(1, 100);
		$this->favorHp = rand(1, 100);
		$this->favorAttack = rand(1, 100);
		$this->favorSpeed = rand(1, 100);
	}

	function scorePlayer($person)
	{
		return ((1000-$person->hpRank) * $this->favorHp +
						(1000-$person->rangeRank) * $this->favorRange +
						(1000-$person->attackRank) * $this->favorAttack +
						(1000-$person->speedRank) * $this->favorSpeed);
	}

	function debug()
	{
		print "$this->name coaching " . $this->team->name . " prefers (range $this->favorRange, hp $this->favorHp, attack $this->favorAttack, speed $this->favorSpeed)\n";
	}
}
