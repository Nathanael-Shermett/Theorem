<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class DoubleSharp extends AbstractAccidental
{
	/**
	 * DoubleSharp constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::DOUBLE_SHARP);
	}
}
