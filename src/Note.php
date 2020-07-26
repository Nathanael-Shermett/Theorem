<?php

namespace Theorem;

use Theorem\Accidental\AbstractAccidental;

/**
 * Class containing properties and methods pertaining to musical notes.
 */
class Note
{
	use RenderableTrait, TransposableTrait;

	/**
	 * The note's accidental.
	 *
	 * @var AbstractAccidental $accidental
	 */
	private AbstractAccidental $accidental;

	/**
	 * The note's letter name (A-G).
	 *
	 * @var string $letter
	 */
	private string $letter;

	/**
	 * The octave the note belongs to (based on scientific pitch notation).
	 *
	 * @var int $octave
	 */
	private int $octave;

	/**
	 * Creates a new note.
	 *
	 * @param float|string $value Accepts any of the following:
	 *                            * A note written in scientific pitch notation (SPN). Examples include `A4` and `C#4`.
	 *                            * A frequency. Examples include `440 Hz`, `440`, and `415.305`.
	 */
	public function __construct($value)
	{
		if (RegularExpression::ParseScientificNoteNotation($value, $output))
		{
			$this->setLetter($output['letter']);
			$this->setAccidental($output['accidental']);
			$this->setOctave($output['octave']);
		}
	}

	/**
	 * Returns the relative distance, in steps ({@see Theorem\Setting::getStep()}), from the current note to the
	 * specified note. If the specified note is lower, then the result will be negative.
	 *
	 * @param Note $note
	 * @return float
	 */
	public function distanceTo(Note $note): float
	{
		$that = $note;

		// $this (current note)
		$thisLetter = $this->getLetter();
		$thisAccidental = $this->getAccidental()->getOffset();
		$thisOctave = $this->getOctave();

		// $that (note we're comparing $this to)
		$thatLetter = $that->getLetter();
		$thatAccidental = $that->getAccidental()->getOffset();
		$thatOctave = $that->getOctave();

		// The distance between the two notes (so far).
		$difference = 0;

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///
		///  Calculate the distance between the two notes' letters.
		///
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
		if ($normalizedLetters[$thisLetter] < $normalizedLetters[$thatLetter])
		{
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
		}
		else
		{    // Each value represents the relative descending distance from $key[i] to $key[i+1]
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
		while (array_keys($letterSteps)[0] != $thisLetter)
		{
			// Shift off the first element of the array, then re-add it (with the same key).
			$letterSteps[array_key_first($letterSteps)] = array_shift($letterSteps);
		}

		// Walk over $letterSteps until we reach $thatLetter, increasing the difference sum with every step.
		foreach ($letterSteps as $letter => $distance)
		{
			if ($letter == $thatLetter)
			{
				break;
			}

			$difference += $distance;
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///
		///  Factor in the distance between the two notes' accidentals.
		///
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// Add the difference between the two accidentals to the result.
		$difference += $thatAccidental - $thisAccidental;

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///
		///  Factor in the distance between the two notes' octaves.
		///
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// Add the difference between the two octaves to the result.
		//
		// NOTE: Since distances up to this point have been based on percentages (1 or .5) of whole tones, we must
		// multiply the octave number by six because there are 6 whole tones (12 semitones, 24 quarter tones) in an
		// octave. Accordingly, the difference between C4 and C5 is 6 whole tones.
		$difference += ($thatOctave * 6) - ($thisOctave * 6);

		// We now have the distance calculated, but in whole tones (i.e. 6). The result should be returned based on
		// Setting::getStep().
		$difference *= (Setting::getStep() / 6);

		return $difference;
	}

	/**
	 * Gets the {@see AbstractAccidental} object corresponding with the note's accidental.
	 *
	 * @return AbstractAccidental
	 */
	public function getAccidental(): AbstractAccidental
	{
		return $this->accidental;
	}

	/**
	 * Gets the note's frequency using the specified tuning system {@see Setting::getTuningSystem()}.
	 *
	 * **NOTE:** This number is rounded based on {@see Setting::getFrequencyPrecision()}.
	 *
	 * @return float
	 */
	public function getFrequency(): float
	{
		// The tuning system class, expressed as a string.
		$tuningSystem = 'Theorem\TuningSystem\\' . Setting::getTuningSystem();

		return round($tuningSystem::calcFrequency($this), Setting::getFrequencyPrecision());
	}

	/**
	 * Returns the note's value in scientific pitch notation (SPN).
	 *
	 * **NOTE #1:** In SPN, octave numbers increment at C, not A.
	 *
	 * **NOTE #2:** In SPN, accidental adjustments apply *after* determining the note's octave. Therefore, because
	 * octave numbers increment at C and accidentals apply afterwards, B4 and Cb5 are exactly one octave apart.
	 *
	 * @return string
	 */
	public function getSpn(): string
	{
		return $this->getLetter()
			   . $this->getAccidental()->toString(Setting::OUTPUT_STANDARD, Setting::RENDER_NOSYMBOL)
			   . $this->getOctave();
	}

	/**
	 * Sets the note's accidental to a different accidental object.
	 *
	 * @param AbstractAccidental $accidental
	 */
	public function setAccidental(AbstractAccidental $accidental): void
	{
		$this->accidental = $accidental;
	}

	/**
	 * Gets the note's letter name (A-G).
	 *
	 * @return string
	 */
	public function getLetter(): string
	{
		return $this->letter;
	}

	/**
	 * Sets the note's letter name (A-G).
	 *
	 * @param string $letter
	 */
	public function setLetter(string $letter): void
	{
		$this->letter = $letter;
	}

	/**
	 * Gets the octave the note belongs to (based on scientific pitch notation).
	 *
	 * @return int
	 */
	public function getOctave(): int
	{
		return $this->octave;
	}

	/**
	 * Sets the octave the note belongs to (based on scientific pitch notation).
	 *
	 * @param int $octave
	 */
	public function setOctave(int $octave): void
	{
		$this->octave = $octave;
	}

	public function toString($outputMode = NULL, $renderMode = NULL): string
	{
		return $this->letter . $this->accidental->toString($outputMode, $renderMode);
	}
}