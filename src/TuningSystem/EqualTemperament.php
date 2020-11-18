<?php

namespace Theorem\TuningSystem;

use Theorem;
use Theorem\Note;
use Theorem\Setting;

/**
 * Equal temperament tuning system. Equal temperament is the most commonly used tuning system today and works by
 * splitting an octave into `n` equal steps, with pitch doubling upwards (or halving downwards) between octaves.
 *
 * @see Setting::getStep()
 * @see Setting::setStep()
 */
class EqualTemperament implements TuningSystemInterface
{
	/**
	 * Calculates the frequency of the specified note.
	 *
	 * @param Note $note
	 * @return float
	 * @see Setting::getTuningReferenceNote()
	 * @see Setting::getTuningReferencePitch()
	 */
	public function calcFrequency(Note $note): float
	{
		// If this note is the reference note, return the reference frequency.
		if ($note->getSpn() == Setting::getTuningReferenceNote())
		{
			return Theorem\Setting::getTuningReferencePitch();
		}

		// Reference note (probably A4).
		$referenceNote = new Theorem\Note(Setting::getTuningReferenceNote());

		// To calculate a note frequency using equal temperament:
		//   [this frequency] =
		//   [reference frequency] *
		//   [2^(1/ [number of steps in an octave] )] ^ [number of steps from reference note to this note]
		$referenceFrequency = $referenceNote->getFrequency();
		$magicNumber = 2 ** (1 / Setting::getStep());
		$distanceFromReferenceNote = $referenceNote->distanceTo($note);

		return $referenceFrequency * ($magicNumber ** $distanceFromReferenceNote);
	}
}