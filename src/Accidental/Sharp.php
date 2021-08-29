<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class Sharp extends AbstractAccidental
{
	/**
	 * Sharp constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::SHARP);
	}
}
