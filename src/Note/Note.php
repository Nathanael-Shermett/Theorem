<?php

declare(strict_types=1);

namespace Theorem\Note;

use Theorem\Accidental\Accidental;
use Theorem\RegularExpression;
use Theorem\Renderer\RenderableTrait;
use Theorem\Renderer\RendererInterface;
use Theorem\Theorem;
use Theorem\TransposableTrait;

/**
 * Class containing properties and methods pertaining to musical notes.
 */
class Note
{
	use RenderableTrait;
	use TransposableTrait;

	/**
	 * The note's accidental.
	 */
	private Accidental $accidental;

	/**
	 * The note's letter name (`A`-`G`).
	 */
	private string $letter;

	/**
	 * The octave the note belongs to (based on scientific pitch notation).
	 */
	private int $octave;

	/**
	 * Note constructor.
	 */
	public function __construct(private Theorem $theorem)
	{
	}

	/**
	 * Returns the relative distance, in steps from the current note to the specified note. If the specified note is
	 * lower, then the result will be negative.
	 *
	 * @see Theorem::getStep()
	 * @see Theorem::setStep()
	 */
	public function distanceTo(Note $note): float
	{
		$that = $note;

		// $this (current note)
		$thisLetter     = $this->getLetter();
		$thisAccidental = $this->getAccidental()->getOffset();
		$thisOctave     = $this->getOctave();

		// $that (note we're comparing $this to)
		$thatLetter     = $that->getLetter();
		$thatAccidental = $that->getAccidental()->getOffset();
		$thatOctave     = $that->getOctave();

		// The distance between the two notes (so far).
		$difference = 0;

		// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//
		// Calculate the distance between the two notes' letters.
		//
		// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//
		// Scientific pitch notation (SPN) describes notes by their letter and octave number, but increments at C.
		// Therefore, B4 > D4 > C4. This is rather silly, and since Note::getOctave() returns the octave the note
		// belongs to based on SPN, we must normalize relative letter values based on SPN.
		$normalizedLetters = [
			'C' => 0,
			'D' => 1,
			'E' => 2,
			'F' => 3,
			'G' => 4,
			'A' => 5,
			'B' => 6,
		];

		// First, determine if $thisLetter or $thatLetter is higher (based on normalized SPN letter values). This tells
		// us which direction we need to walk.
		if ($normalizedLetters[$thisLetter] < $normalizedLetters[$thatLetter]) {
			// Each value represents the relative ascending distance from $key[i] to $key[i+1].
			$letterSteps = [
				'C' => 1,
				'D' => 1,
				'E' => .5,
				'F' => 1,
				'G' => 1,
				'A' => 1,
				'B' => .5,
			];
		} else {
			// Each value represents the relative descending distance from $key[i] to $key[i+1]
			$letterSteps = [
				'C' => -.5,
				'B' => -1,
				'A' => -1,
				'G' => -1,
				'F' => -.5,
				'E' => -1,
				'D' => -1,
			];
		}

		// Rotate $letterSteps until the first letter corresponds with $thisLetter. This allows us to avoid walking off
		// the end of the array while looking for $thatLetter.
		while (array_keys($letterSteps)[0] !== $thisLetter) {
			// Shift off the first element of the array, then re-add it (with the same key).
			$letterSteps[array_key_first($letterSteps)] = array_shift($letterSteps);
		}

		// Walk over $letterSteps until we reach $thatLetter, increasing the difference sum with every step.
		foreach ($letterSteps as $letter => $distance) {
			if ($letter === $thatLetter) {
				break;
			}

			$difference += $distance;
		}

		// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//
		// Factor in the distance between the two notes' accidentals.
		//
		// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//
		// Add the difference between the two accidentals to the result.
		$difference += $thatAccidental - $thisAccidental;

		// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//
		// Factor in the distance between the two notes' octaves.
		//
		// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//
		// Add the difference between the two octaves to the result.
		//
		// NOTE: Since distances up to this point have been based on percentages (1 or .5) of whole tones, we must
		// multiply the octave number by six because there are 6 whole tones (12 semitones, 24 quarter tones) in an
		// octave. Accordingly, the difference between C4 and C5 is 6 whole tones.
		$difference += ($thatOctave * 6) - ($thisOctave * 6);

		// We now have the distance calculated, but in whole tones (i.e. 6). The result should be returned based on
		// Setting::getStep().
		$difference *= ($this->theorem->getStep() / 6);

		return $difference;
	}

	/**
	 * Gets the `Accidental` object corresponding with the note's accidental.
	 *
	 * @see Accidental
	 */
	public function getAccidental(): Accidental
	{
		return $this->accidental;
	}

	/**
	 * Sets the note's accidental to a different accidental object.
	 */
	public function setAccidental(Accidental $accidental): static
	{
		$this->accidental = $accidental;

		return $this;
	}

	/**
	 * Gets the note's frequency using the specified tuning system {@see Theorem::getTuningSystem()}.
	 *
	 * @see Theorem::getFrequencyPrecision()
	 * @see Theorem::setFrequencyPrecision()
	 */
	public function getFrequency(): float
	{
		$tuningSystem = $this->theorem->getTuningSystem();

		return round($tuningSystem->calcFrequency($this), $this->theorem->getFrequencyPrecision());
	}

	/**
	 * Returns the note's value in scientific pitch notation (SPN).
	 *
	 * **NOTE #1:** In SPN, octave numbers increment at C, not A.
	 *
	 * **NOTE #2:** In SPN, accidental adjustments apply *after* determining the note's octave. Therefore, because
	 * octave numbers increment at C and accidentals apply afterwards, B4 and Cb5 are exactly one octave apart.
	 */
	public function getSpn(): string
	{
		// The renderer class.
		$renderer = $this->getRenderer() ?? $this->theorem->getRenderer();
		$renderer = new $renderer();

		return $renderer->renderSpn($this);
	}

	/**
	 * Gets the note's letter name (A-G).
	 */
	public function getLetter(): string
	{
		return $this->letter;
	}

	/**
	 * Sets the note's letter name (A-G).
	 */
	public function setLetter(string $letter): static
	{
		$this->letter = $letter;

		return $this;
	}

	/**
	 * Gets the octave the note belongs to (based on scientific pitch notation).
	 */
	public function getOctave(): int
	{
		return $this->octave;
	}

	/**
	 * Sets the octave the note belongs to (based on scientific pitch notation).
	 */
	public function setOctave(int $octave): static
	{
		$this->octave = $octave;

		return $this;
	}

	public function toString(RendererInterface $renderer = null): string
	{
		$renderer ??= $this->getRenderer();

		return $renderer->renderNote($this);
	}
}
