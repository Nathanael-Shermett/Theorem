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
	 *
	 * @param Theorem $theroem
	 */
	public function __construct(Theorem $theroem);

	/**
	 * Calculates the frequency of the specified note.
	 *
	 * @param Note $note
	 * @return float
	 */
	public function calcFrequency(Note $note): float;
}