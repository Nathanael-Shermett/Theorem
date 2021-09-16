<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class HalfFlat extends Accidental
{
	/**
	 * HalfFlat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(Accidental::HALF_FLAT);
	}
}
