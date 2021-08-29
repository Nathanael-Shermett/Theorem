<?php

namespace Theorem\Accidental;

class Natural extends AbstractAccidental
{
	/**
	 * Natural constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::NATURAL);
	}
}
