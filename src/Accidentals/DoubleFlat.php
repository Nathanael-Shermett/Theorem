<?php

namespace Theorem\Accidental;

use Theorem\Accidental;

class DoubleFlat extends Accidental
{
	public function __construct()
	{
		$this->setOffset(Accidental::DOUBLE_FLAT);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return 'bb';
	}
}