<?php

namespace Theorem\TuningSystem;

use Theorem\Factory\NoteFactory;
use Theorem\Note\Note;
use Theorem\Theorem;

/**
 * Equal temperament tuning system. Equal temperament is the most commonly used tuning system today and works by
 * splitting an octave into `n` equal steps, with pitch doubling upwards (or halving downwards) between octaves.
 *
 * @see Theorem::getTuningReferenceNote()
 * @see Theorem::setTuningReferenceNote()
 * @see Theorem::getTuningReferencePitch()
 * @see Theorem::getTuningReferencePitch()
 * @see Theorem::getStep()
 * @see Theorem::setStep()
 */
class EqualTemperament implements TuningSystemInterface
{
	public function __construct(private Theorem $theorem)
	{
	}

	/**
	 * Calculates and returns the frequency of the specified note.
	 *
	 * @param $note
	 * @return float
	 * @see Theorem::getTuningReferenceNote()
	 * @see Theorem::setTuningReferenceNote()
	 * @see Theorem::getTuningReferencePitch()
	 * @see Theorem::getTuningReferencePitch()
	 */
	public function calcFrequency(Note $note): float
	{
		// If this note is the reference note, return the reference frequency.
		if ($note->getSpn() === $this->theorem->getTuningReferenceNote())
		{
			return $this->theorem->getTuningReferencePitch();
		}

		// Reference note (probably A4).
		$noteFactory = new NoteFactory($this->theorem);
		$referenceNote = $noteFactory->create($this->theorem->getTuningReferenceNote());

		// To calculate a note frequency using equal temperament:
		//   [this frequency] =
		//   [reference frequency] *
		//   [2^(1/ [number of steps in an octave] )] ^ [number of steps from reference note to this note]
		$referenceFrequency = $referenceNote->getFrequency();
		$magicNumber = 2 ** (1 / $this->theorem->getStep());
		$distanceFromReferenceNote = $referenceNote->distanceTo($note);

		return $referenceFrequency * ($magicNumber ** $distanceFromReferenceNote);
	}
}