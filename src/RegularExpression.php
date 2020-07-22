<?php

namespace Theorem;

abstract class RegularExpression
{
	/**
	 * Parses the string representation of a note (in scientific pitch notation) into an array consisting of a letter,
	 * an accidental, and an octave.
	 *
	 * @param string $input A note written in scientific pitch notation (e.g. A4, A#4, etc.)
	 * @param array  $output
	 * @return bool|array Returns an associative array containing a letter (string), an accidental
	 *                      ({@see AbstractAccidental} sub-type), and an octave (int).
	 */
	public static function ParseScientificNoteNotation(string $input, &$output)
	{
		// Match a note expressed in scientific pitch notation.
		$regex = '/^
			(?<letter>[ABCDEFG]){1}
			(?<accidental>bb|[b#x]){0,1}
			(?<octave>-*[1-9]+[0-9]*|0)
		$/x';

		// If there was a match.
		if (preg_match($regex, $input, $result) === 1)
		{
			// Convert the matched accidental to an accidental object.
			switch ($result['accidental'])
			{
				case 'bb':
					$result['accidental'] = new Accidental\DoubleFlat();
					break;
				case 'b':
					$result['accidental'] = new Accidental\Flat();
					break;
				case '#':
					$result['accidental'] = new Accidental\Sharp();
					break;
				case 'x':
					$result['accidental'] = new Accidental\DoubleSharp();
					break;
				default:
					$result['accidental'] = new Accidental\Natural();
					break;
			}

			$output = $result;

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}