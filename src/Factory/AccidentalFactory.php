<?php

namespace Theorem\Factory;

use Theorem\Accidental\AbstractAccidental;
use Theorem\Accidental\TripleFlat;
use Theorem\Accidental\FiveQuarterFlat;
use Theorem\Accidental\DoubleFlat;
use Theorem\Accidental\ThreeQuarterFlat;
use Theorem\Accidental\Flat;
use Theorem\Accidental\HalfFlat;
use Theorem\Accidental\Natural;
use Theorem\Accidental\HalfSharp;
use Theorem\Accidental\Sharp;
use Theorem\Accidental\ThreeQuarterSharp;
use Theorem\Accidental\DoubleSharp;
use Theorem\Accidental\FiveQuarterSharp;
use Theorem\Accidental\TripleSharp;
use Theorem\Accidental\Special;

use Theorem\RegularExpression;
use Theorem\Theorem;

/**
 * Factory class to generate accidentals. Mostly just useful to keep accidental objects tidy after transpositions and to
 * prevent all accidentals from being Special types. Also useful for setting quarter tone directionality.
 *
 * @see Special
 */
class AccidentalFactory
{
	/**
	 * The offset of the accidental that is being built.
	 *
	 * @var float
	 * @see AccidentalFactory::getOffset()
	 * @see AccidentalFactory::setOffset()
	 */
	private float $offset = 0;

	/**
	 * Whether the accidental's quarter tone part, if applicable, is moving "upwards" or "downwards".
	 *
	 * @var int
	 * @see AccidentalFactory::getQuarterToneDirection()
	 * @see AccidentalFactory::setQuarterToneDirection()
	 */
	private int $quarterToneDirection = AbstractAccidental::QUARTER_TONE_DIRECTION_NEUTRAL;

	/**
	 * @var RegularExpression $regularExpression
	 */
	private RegularExpression $regularExpression;

	/**
	 * AccidentalFactory constructor.
	 */
	public function __construct(private Theorem $theorem)
	{
		$this->regularExpression = new RegularExpression($theorem);
	}

	/**
	 * @param float|string $offsetOrString
	 * @return AbstractAccidental
	 */
	public function create(float|string $offsetOrString): AbstractAccidental
	{
		if (is_string($offsetOrString))
		{
			return $this->createFromString($offsetOrString);
		}

		return $this->createFromOffset($offsetOrString);
	}

	/**
	 * Builds and returns a specific accidental object based on the specified offset.
	 *
	 * @param float $offset
	 * @return AbstractAccidental
	 */
	public function createFromOffset(float $offset): AbstractAccidental
	{
		return match ($offset)
		{
			AbstractAccidental::TRIPLE_FLAT => new TripleFlat(),
			AbstractAccidental::FIVE_QUARTER_FLAT => new FiveQuarterFlat(),
			AbstractAccidental::DOUBLE_FLAT => new DoubleFlat(),
			AbstractAccidental::THREE_QUARTER_FLAT => new ThreeQuarterFlat(),
			AbstractAccidental::FLAT => new Flat(),
			AbstractAccidental::HALF_FLAT => new HalfFlat(),
			AbstractAccidental::NATURAL => new Natural(),
			AbstractAccidental::HALF_SHARP => new HalfSharp(),
			AbstractAccidental::SHARP => new Sharp(),
			AbstractAccidental::THREE_QUARTER_SHARP => new ThreeQuarterSharp(),
			AbstractAccidental::DOUBLE_SHARP => new DoubleSharp(),
			AbstractAccidental::FIVE_QUARTER_SHARP => new FiveQuarterSharp(),
			AbstractAccidental::TRIPLE_SHARP => new TripleSharp(),
			default => new Special($offset),
		};
	}

	/**
	 * Builds and returns a specific accidental object based on the specified string.
	 *
	 * @param string $string
	 * @return AbstractAccidental
	 */
	public function createFromString(string $string): AbstractAccidental
	{
		// Get the quarter tone part of the accidental, if any.
		$quarterTone = $this->regularExpression->parseQuarterTonePart($string);

		// Set the quarter tone directionality, if applicable.
		if ($quarterTone === 'd')
		{
			$this->setQuarterToneDirection(AbstractAccidental::QUARTER_TONE_DIRECTION_DOWN);
		}
		elseif ($quarterTone === '+')
		{
			$this->setQuarterToneDirection(AbstractAccidental::QUARTER_TONE_DIRECTION_UP);
		}

		// Map of the accidental characters and their corresponding offsets.
		$offsets = [
			'd' => -.25,
			'b' => -.5,
			'+' => .25,
			'#' => .5,
			'x' => 1,
		];

		// Split the string into an array of single characters, and replace them with their corresponding offsets.
		$characters = str_split($string);
		$characters = str_replace(array_keys($offsets), array_values($offsets), $characters);

		// Sum the result and set the offset accordingly.
		$offset = array_sum($characters);

		return $this->create($offset);
	}

	/**
	 * @return int
	 * @see AbstractAccidental::setQuarterToneDirection()
	 */
	private function getQuarterToneDirection(): int
	{
		return $this->quarterToneDirection;
	}

	/**
	 * Sets the accidental's quarter tone direction.
	 *
	 * @param int $quarterToneDirection
	 * @return AccidentalFactory
	 * @see AbstractAccidental::getQuarterToneDirection()
	 */
	private function setQuarterToneDirection(int $quarterToneDirection): AccidentalFactory
	{
		$this->quarterToneDirection = $quarterToneDirection;

		return $this;
	}
}