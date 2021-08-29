<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class DoubleFlat extends AbstractAccidental
{
	/**
	 * DoubleFlat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::DOUBLE_FLAT);
	}
}
