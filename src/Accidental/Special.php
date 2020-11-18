<?php

namespace Theorem\Accidental;

class Special extends AbstractAccidental
{
	/**
	 * Special constructor.
	 *
	 * @param float $offset
	 */
	public function __construct(float $offset)
	{
		$this->setOffset($offset);
	}
}