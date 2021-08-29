<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class ThreeQuarterFlat extends AbstractAccidental
{
	/**
	 * ThreeQuarterFlat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::THREE_QUARTER_FLAT);
	}
}
