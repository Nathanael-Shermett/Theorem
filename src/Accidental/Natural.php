<?php

namespace Theorem\Accidental;

class Natural extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::NATURAL);
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return '';
	}
}