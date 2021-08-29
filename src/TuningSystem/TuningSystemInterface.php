<?php

namespace Theorem\TuningSystem;

use Theorem\Note\Note;
use Theorem\Theorem;

/**
 * Tuning system interface. Declares methods that all tuning systems must implement.
 *
 * @see Note
 */
interface TuningSystemInterface
{
	/**
	 * Tuning system constructor.
	 */
	public function __construct(Theorem $theroem);

	/**
	 * Calculates the frequency of the specified note.
	 */
	public function calcFrequency(Note $note): float;
}
