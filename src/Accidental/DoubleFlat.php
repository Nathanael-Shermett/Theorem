<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class DoubleFlat extends Accidental
{
	/**
	 * DoubleFlat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(Accidental::DOUBLE_FLAT);
	}
}
