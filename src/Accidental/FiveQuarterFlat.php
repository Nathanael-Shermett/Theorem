<?php

declare(strict_types=1);

namespace Theorem\Accidental;

class FiveQuarterFlat extends AbstractAccidental
{
	/**
	 * FiveQuarterFlat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::FIVE_QUARTER_FLAT);
	}
}
