<?php

namespace Theorem\Accidental;

class DoubleSharp extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::DOUBLE_SHARP);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return 'x';
	}
}