<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class Sharp extends Accidental
{
	/**
	 * Sharp constructor.
	 */
	public function __construct()
	{
		$this->setOffset(Accidental::SHARP);
	}
}
