<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class TripleFlat extends AbstractAccidental
{
	/**
	 * TripleFlat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::TRIPLE_FLAT);
	}
}
