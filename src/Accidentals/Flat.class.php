<?php

namespace Theorem\Accidental;

use Theorem\Accidental;

class Flat extends Accidental
{
	public function __construct()
	{
		$this->setOffset(Accidental::FLAT);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return 'b';
	}
}