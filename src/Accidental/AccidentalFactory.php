<?php

namespace Theorem\Accidental;

/**
 * Static class. Really just used to keep accidental objects tidy after transpositions and to prevent all accidentals
 * from being {@see Special} types.
 */
class AccidentalFactory
{
	/**
	 * Creates an accidental based on the specified offset.
	 *
	 * @param float $offset
	 * @return AbstractAccidental
	 */
	public static function create(float $offset)
	{
		switch ($offset)
		{
			case AbstractAccidental::TRIPLE_FLAT:
				return new TripleFlat();

			case AbstractAccidental::FIVE_QUARTER_FLAT:
				return new FiveQuarterFlat();

			case AbstractAccidental::DOUBLE_FLAT:
				return new DoubleFlat();

			case AbstractAccidental::THREE_QUARTER_FLAT:
				return new ThreeQuarterFlat();

			case AbstractAccidental::FLAT:
				return new Flat();

			case AbstractAccidental::HALF_FLAT:
				return new HalfFlat();

			case AbstractAccidental::NATURAL:
				return new Natural();

			case AbstractAccidental::HALF_SHARP:
				return new HalfSharp();

			case AbstractAccidental::SHARP:
				return new Sharp();

			case AbstractAccidental::THREE_QUARTER_SHARP:
				return new ThreeQuarterSharp();

			case AbstractAccidental::DOUBLE_SHARP:
				return new DoubleSharp();

			case AbstractAccidental::FIVE_QUARTER_SHARP:
				return new FiveQuarterSharp();

			case AbstractAccidental::TRIPLE_SHARP:
				return new TripleSharp();

			default:
				return new Special($offset);
		}
	}
}