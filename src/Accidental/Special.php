<?php

namespace Theorem\Accidental;

class Special extends AbstractAccidental
{
	public function __construct(float $offset)
	{
		$this->setOffset($offset);
	}
}