<?php

namespace Theorem\Accidental;

class DoubleFlat extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::DOUBLE_FLAT);
	}
}