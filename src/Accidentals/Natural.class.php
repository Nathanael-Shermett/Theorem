<?php

namespace Theorem\Accidental;

use Theorem\Accidental;

class Natural extends Accidental
{
	public function __construct()
	{
		$this->setOffset(Accidental::NATURAL);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return '';
	}
}