<?php

namespace Theorem\Accidental;

class Special extends AbstractAccidental
{
	/**
	 * Special constructor.
	 */
	public function __construct(float $offset)
	{
		$this->setOffset($offset);
	}
}