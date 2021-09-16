<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class Natural extends Accidental
{
	/**
	 * Natural constructor.
	 */
	public function __construct()
	{
		$this->setOffset(Accidental::NATURAL);
	}
}
