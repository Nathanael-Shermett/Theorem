<?php

namespace Theorem\Accidental;

use Theorem\Accidental;

class DoubleSharp extends Accidental
{
	public function __construct()
	{
		$this->setOffset(Accidental::DOUBLE_SHARP);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return 'x';
	}
}