<?php

namespace Theorem\Accidental;

class Flat extends AbstractAccidental
{
	public function __construct()
	{
		$this->setOffset(AbstractAccidental::FLAT);
	}
}