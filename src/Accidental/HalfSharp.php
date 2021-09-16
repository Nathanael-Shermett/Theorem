<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class HalfSharp extends Accidental
{
	/**
	 * HalfSharp constructor.
	 */
	public function __construct()
	{
		$this->setOffset(Accidental::HALF_SHARP);
	}
}
