<?php
class team
{
	public $name = "";
	public $coach;
	public $player=array();
	public $bot=array();
	public $stats = array();

	function __construct($name)
	{
		$this->name = $name;
		$this->stats["seasonWins"] = 0;
	}

	function debug()
	{
		print "Team: $this->name, " . $this->stats["seasonWins"] . " wins\n";
		print $this->coach->debug();
		$counter=1;
		foreach($this->player as $thisPlayer)
		{
			print $counter++ . ". ";
			$thisPlayer->debug();
		}
	}
}
