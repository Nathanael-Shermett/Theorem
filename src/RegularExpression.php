<?php

declare(strict_types=1);

namespace Theorem;

use Theorem\Accidental\Accidental;
use Theorem\Factory\AccidentalFactory;

class RegularExpression
{
	public function __construct(private Theorem $theorem)
	{
	}

	/**
	 * Regular expression subpattern for matching note letter names.
	 */
	private const LETTER_PATTERN = '(?<letter>[ABCDEFG]){1}';

	/**
	 * Regular expression subpattern for matching accidentals. Also matches the accidental's quarter tone part, if
	 * applicable.
	 */
	private const ACCIDENTAL_PATTERN = '
		(?<accidental>
			(?<quarterTone>[d+]{0,1})
			(?:
				(?:
					(?:
						b*
					)
				)|
				(?:
					\#{0,1}
					x*
				)
			)
		)
	';

	/**
	 * Regular expression subpattern for matching note octave numbers. More specifically, this matches any negative or
	 * non-negative number, including zero (which cannot be negative). Only zero can start with zero.
	 */
	private const OCTAVE_PATTERN = '(?<octave>-*[1-9]+[0-9]*|0)';

	/**
	 * Parses the string representation of a note (i.e. scientific pitch notation) into an array consisting of a letter
	 * (`string`), an accidental (`Accidental`), and an octave (`int`).
	 *
	 * @param string $input A note written in scientific pitch notation (e.g. A4, A#4, etc.)
	 * @return bool Returns an associative array containing a letter (string), an accidental
	 *                      (Accidental), and an octave (int).
	 * @see Accidental
	 */
	public function parseScientificPitchNotation(string $input, array &$output): bool
	{
		// Match a note expressed in scientific pitch notation.
		$regex = '/
			^
			' . self::LETTER_PATTERN . '
			' . self::ACCIDENTAL_PATTERN . '
			' . self::OCTAVE_PATTERN . '
			$/x';

		// If there was a match.
		if (preg_match($regex, $input, $result) === 1) {
			// Convert the matched accidental to an accidental object.
			$accidentalFactory = new AccidentalFactory($this->theorem);
			$accidentalFactory->createFromString($result['accidental']);

			// Convert the matched letter into an integer.
			$result['octave'] = (int)$result['octave'];

			$result['accidental'] = $accidentalFactory->createFromString($result['accidental']);
			$output               = $result;

			return true;
		}

		return false;
	}

	/**
	 * Parses the string representation of an accidental and returns the quarter tone part, if applicable. For example,
	 * `db` would return `d`, but `#` would return `NULL`.
	 *
	 * @param string $input An accidental, as a string.
	 * @return bool|null|string Returns the quarter tone part of the accidental if it exists, otherwise `NULL`.
	 */
	public function parseQuarterTonePart(string $input)
	{
		// Match a note expressed in scientific pitch notation.
		$regex = '/^' . self::ACCIDENTAL_PATTERN . '$/x';

		// If a valid accidental (as a string) was provided.
		if (preg_match($regex, $input, $result) === 1) {
			// Return the quarter tone part of the accidental as a string, otherwise NULL.
			return (string)$result['quarterTone'] ?: null;
		}

		return false;
	}
}
