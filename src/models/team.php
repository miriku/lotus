<?php
class team
{
	public $name = "";
	public $coach;
	public $player=array();
	public $bot=array();

	function __construct($name)
	{
		$this->name = $name;
	}

	function debug()
	{
		print "Team: $this->name.\n";
		print $this->coach->debug();
		$counter=1;
		foreach($this->player as $thisPlayer)
		{
			print $counter++ . ". ";
			$thisPlayer->debug();
		}
	}
}
