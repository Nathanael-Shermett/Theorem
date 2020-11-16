<?php

namespace Theorem\Accidental;

class HalfSharp extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::HALF_SHARP);
	}
}