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

	function assignIntoBots()
	{
		$botType;
		if($this->favorRange > $this->favorHp && $this->favorRange > $this->favorAttack)
			$botType = array("sniper", "attack", "tank", "sniper");
		elseif($this->favorHp > $this->favorRange && $this->favorHp > $this->favorAttack)
			$botType = array("tank", "attack", "sniper", "tank");
		else
			$botType = array("attack", "sniper", "tank", "attack");

		foreach($this->team->player as $player)
		{
			$myScore = $this->scorePlayer($player);
			$myRank = 1;
			foreach($this->team->player as $otherPlayer)
			{
				if($this->scorePlayer($otherPlayer) > $myScore) { $myRank++; }
			}

			if($myRank==1)
			{
				$player->inMatch = 1;
				$player->stats["seasonGames"]++;
				$player->stats["careerGames"]++;
				$this->team->bot[0] = new bot($player, $botType[0]);
			}
			elseif($myRank==2)
			{
				$player->inMatch = 1;
				$player->stats["seasonGames"]++;
				$player->stats["careerGames"]++;
				$this->team->bot[1] = new bot($player, $botType[1]);
			}
			elseif($myRank==3)
			{
				$player->inMatch = 1;
				$player->stats["seasonGames"]++;
				$player->stats["careerGames"]++;
				$this->team->bot[2] = new bot($player, $botType[2]);
			}
			elseif($myRank==4)
			{
				$player->inMatch = 1;
				$player->stats["seasonGames"]++;
				$player->stats["careerGames"]++;
				$this->team->bot[3] = new bot($player, $botType[3]);
			}
			else
			{
				$player->inMatch = 0;
			}
		}
	}

	function scorePlayer($person)
	{
		return ((1000-$person->hpRank) * $this->favorHp +
						(1000-$person->rangeRank) * $this->favorRange +
						(1000-$person->attackRank) * $this->favorAttack +
						(1000-$person->speedRank) * $this->favorSpeed) * $person->fatigue;
	}

	function debug()
	{
		print "$this->name coaching " . $this->team->name . " prefers (range $this->favorRange, hp $this->favorHp, attack $this->favorAttack, speed $this->favorSpeed)\n";
	}
}
