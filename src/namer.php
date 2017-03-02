<?php

function makeName()
{
	$consonants = array( "b", "c", "ch", "d", "f", "g", "h", "k", "l", "m", "n", "p", "qu", "r", "s", "sh", "t", "v", "z" );
	$vowels = array( "a", "e", "i", "o", "u" );

	$name = "";
	$start = rand(0,1);
	$len = rand(3, 7);
	$toggle = 0;

	if($start)
	{
		$name .= $consonants[rand(0, 18)];
		$toggle = 1;
	}

	for( $total=$start; $total<$len; $total++)
	{
		if($toggle) { $name .= $vowels[rand(0,4)]; $toggle=0; }
		else { $name .= $consonants[rand(0, 18)]; $toggle=1; }
	}
	$name = ucfirst($name);

	return($name);
}
