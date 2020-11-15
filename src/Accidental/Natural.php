<?php

namespace Theorem\Accidental;

class Natural extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::NATURAL);
	}
}