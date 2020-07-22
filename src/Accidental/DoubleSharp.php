<?php

namespace Theorem\Accidental;

class DoubleSharp extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AccidentalEnum::DOUBLE_SHARP);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return 'x';
	}
}