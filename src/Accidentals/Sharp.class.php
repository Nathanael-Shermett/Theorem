<?php

namespace Theorem\Accidental;

use Theorem\Accidental;

class Sharp extends Accidental
{
	public function __construct()
	{
		$this->setOffset(Accidental::SHARP);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return '#';
	}
}