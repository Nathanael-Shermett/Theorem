<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class Flat extends Accidental
{
	/**
	 * Flat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(Accidental::FLAT);
	}
}
