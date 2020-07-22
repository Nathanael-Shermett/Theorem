<?php

namespace Theorem\Accidental;

class Sharp extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::SHARP);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return '#';
	}
}