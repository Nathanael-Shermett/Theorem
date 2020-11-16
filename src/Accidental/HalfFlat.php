<?php

namespace Theorem\Accidental;

class HalfFlat extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::HALF_FLAT);
	}
}