<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class HalfSharp extends AbstractAccidental
{
	/**
	 * HalfSharp constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::HALF_SHARP);
	}
}
