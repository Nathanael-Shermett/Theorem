<?php

namespace Theorem\Accidental;

class Flat extends AbstractAccidental
{
	/**
	 * Flat constructor.
	 */
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::FLAT);
	}
}