<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class Special extends Accidental
{
	/**
	 * Special constructor.
	 */
	public function __construct(float $offset)
	{
		$this->setOffset($offset);
	}
}
