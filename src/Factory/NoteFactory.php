<?php

namespace Theorem\Factory;

use Theorem\Note\Note;
use Theorem\RegularExpression;
use Theorem\Theorem;

/**
 * Factory class to generate accidentals. Mostly just useful to keep accidental objects tidy after transpositions and to
 * prevent all accidentals from being Special types. Also useful for setting quarter tone directionality.
 *
 * @see Special
 */
class NoteFactory
{
	private RegularExpression $regularExpression;

	/**
	 * NoteFactory constructor.
	 */
	public function __construct(private Theorem $theorem)
	{
		$this->regularExpression = new RegularExpression($theorem);
	}

	/**
	 * Builds and returns a specific accidental object based on the specified offset.
	 */
	public function create(string $spn): Note
	{
		$note = new Note($this->theorem);

		$output = [];
		if ($this->regularExpression->parseScientificPitchNotation($spn, $output)) {
			$note->setLetter($output['letter']);
			$note->setAccidental($output['accidental']);
			$note->setOctave($output['octave']);
		}

		return $note;
	}
}
