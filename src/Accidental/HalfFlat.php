<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class HalfFlat extends AbstractAccidental
{
	/**
	 * HalfFlat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::HALF_FLAT);
	}
}
