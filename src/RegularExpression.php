<?php

namespace Theorem;

use Theorem\Accidental\AbstractAccidental;
use Theorem\Accidental\AccidentalFactory;

abstract class RegularExpression
{
	/**
	 * Regular expression subpattern for matching note letter names.
	 *
	 * @var string $letterPattern
	 */
	private static string $letterPattern = '(?<letter>[ABCDEFG]){1}';

	/**
	 * Regular expression subpattern for matching accidentals. Also matches the accidental's quarter tone part, if
	 * applicable.
	 *
	 * @var string $accidentalPattern
	 */
	private static string $accidentalPattern = '
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
	 *
	 * @var string $octavePattern
	 */
	private static string $octavePattern = '(?<octave>-*[1-9]+[0-9]*|0)';

	/**
	 * Parses the string representation of a note (i.e. scientific pitch notation) into an array consisting of a letter
	 * (`string`), an accidental (`AbstractAccidental`), and an octave (`int`).
	 *
	 * @param string $input A note written in scientific pitch notation (e.g. A4, A#4, etc.)
	 * @param array  $output
	 * @return bool|array Returns an associative array containing a letter (string), an accidental
	 *                      (AbstractAccidental), and an octave (int).
	 * @see AbstractAccidental
	 */
	public static function parseScientificPitchNotation(string $input, &$output)
	{
		// Match a note expressed in scientific pitch notation.
		$regex = '/
			^
			' . self::$letterPattern . '
			' . self::$accidentalPattern . '
			' . self::$octavePattern . '
			$/x';

		// If there was a match.
		if (preg_match($regex, $input, $result) === 1)
		{
			// Convert the matched accidental to an accidental object.
			$accidentalFactory = new AccidentalFactory();
			$accidentalFactory->createFromString($result['accidental']);

			// Convert the matched letter into an integer.
			$result['octave'] = (int)$result['octave'];

			$result['accidental'] = $accidentalFactory->build();
			$output = $result;

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Parses the string representation of an accidental and returns the quarter tone part, if applicable. For example,
	 * `db` would return `d`, but `#` would return `NULL`.
	 *
	 * @param string $input An accidental, as a string.
	 * @return bool|null|string Returns the quarter tone part of the accidental if it exists, otherwise `NULL`.
	 */
	public static function parseQuarterTonePart(string $input)
	{
		// Match a note expressed in scientific pitch notation.
		$regex = '/^' . self::$accidentalPattern . '$/x';

		// If a valid accidental (as a string) was provided.
		if (preg_match($regex, $input, $result) === 1)
		{
			// Return the quarter tone part of the accidental as a string, otherwise NULL.
			return $result['quarterTone'] ?: NULL;
		}
		else
		{
			return FALSE;
		}
	}
}