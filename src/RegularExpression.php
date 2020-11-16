<?php

namespace Theorem;

use Theorem\Accidental\AccidentalFactory;

abstract class RegularExpression
{
	private static string $letterPattern     = '(?<letter>[ABCDEFG]){1}';
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
	private static string $octavePattern     = '(?<octave>-*[1-9]+[0-9]*|0)';

	/**
	 * Parses the string representation of a note (in scientific pitch notation) into an array consisting of a letter,
	 * an accidental, and an octave.
	 *
	 * @param string $input A note written in scientific pitch notation (e.g. A4, A#4, etc.)
	 * @param array  $output
	 * @return bool|array Returns an associative array containing a letter (string), an accidental
	 *                      ({@see AbstractAccidental} sub-type), and an octave (int).
	 */
	public static function parseScientificNoteNotation(string $input, &$output)
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

			$result['accidental'] = $accidentalFactory->build();
			$output = $result;

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function parseAccidental(string $input, &$output)
	{
		// Match a note expressed in scientific pitch notation.
		$regex = '/^' . self::$accidentalPattern . '$/x';

		// If there was a match.
		if (preg_match($regex, $input, $result) === 1)
		{
			$output = $result;

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}