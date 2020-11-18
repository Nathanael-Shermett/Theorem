<?php

namespace Theorem\TuningSystem;

use Theorem\Note;

/**
 * Tuning system interface. Declares methods that all tuning systems must implement.
 *
 * @see Theorem::Note
 */
interface TuningSystemInterface
{
	/**
	 * Calculates the frequency of the specified note.
	 *
	 * @param Note $note
	 * @return float
	 */
	public function calcFrequency(Note $note): float;
}