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
	 * @see AccidentalFactory::getOffset()
	 * @see AccidentalFactory::setOffset()
	 */
	private float $offset = 0;

	/**
	 * Whether the accidental's quarter tone part, if applicable, is moving "upwards" or "downwards".
	 *
	 * @see AccidentalFactory::getQuarterToneDirection()
	 * @see AccidentalFactory::setQuarterToneDirection()
	 */
	private int $quarterToneDirection = AbstractAccidental::QUARTER_TONE_DIRECTION_NEUTRAL;

	private RegularExpression $regularExpression;

	/**
	 * AccidentalFactory constructor.
	 */
	public function __construct(private Theorem $theorem)
	{
		$this->regularExpression = new RegularExpression($this->theorem);
	}

	/**
	 * @param float|string|null $offsetOrString
	 */
	public function create(float|string $offsetOrString = NULL, ?int $quarterToneDirection = NULL): AbstractAccidental
	{
		if (is_string($offsetOrString))
		{
			return $this->createFromString($offsetOrString);
		}

		return $this->createFromOffset($offsetOrString, $quarterToneDirection);
	}

	/**
	 * Builds and returns a specific accidental object based on the specified offset.
	 *
	 * @param float|null $offset               If not specified, `AbstractAccidental::offset` is used instead.
	 * @param int|null   $quarterToneDirection If not specified, `AbstractAccidental::quarterToneDirection` is used
	 *                                         instead.
	 */
	public function createFromOffset(?float $offset = NULL, ?int $quarterToneDirection = NULL): \Theorem\Accidental\DoubleFlat|\Theorem\Accidental\DoubleSharp|\Theorem\Accidental\FiveQuarterFlat|\Theorem\Accidental\FiveQuarterSharp|\Theorem\Accidental\Flat|\Theorem\Accidental\HalfFlat|\Theorem\Accidental\HalfSharp|\Theorem\Accidental\Natural|\Theorem\Accidental\Sharp|\Theorem\Accidental\Special|\Theorem\Accidental\ThreeQuarterFlat|\Theorem\Accidental\ThreeQuarterSharp|\Theorem\Accidental\TripleFlat|\Theorem\Accidental\TripleSharp
	{
		$created = match ($offset ?? $this->offset)
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

		$created->setQuarterToneDirection($quarterToneDirection ?? $this->quarterToneDirection);

		return $created;
	}

	/**
	 * Builds and returns a specific accidental object based on the specified string.
	 */
	public function createFromString(string $string): AbstractAccidental
	{
		// Get the quarter tone part of the accidental, if any.
		$quarterTone = $this->regularExpression->parseQuarterTonePart($string);

		// Set the quarter tone directionality, if applicable.
		if ($quarterTone === 'd')
		{
			$quarterToneDirection = AbstractAccidental::QUARTER_TONE_DIRECTION_DOWN;
		}
		elseif ($quarterTone === '+')
		{
			$quarterToneDirection = AbstractAccidental::QUARTER_TONE_DIRECTION_UP;
		}
		else
		{
			$quarterToneDirection = NULL;
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

		return $this->create($offset, $quarterToneDirection ?? NULL);
	}

	/**
	 * Gets the accidental's offset.
	 */
	public function getOffset(): float
	{
		return $this->offset;
	}

	/**
	 * Sets the accidental's offset.
	 */
	protected function setOffset(float $offset): static
	{
		$this->offset = $offset;

		return $this;
	}

	/**
	 * @see AbstractAccidental::setQuarterToneDirection()
	 */
	public function getQuarterToneDirection(): int
	{
		return $this->quarterToneDirection;
	}

	/**
	 * Sets the accidental's quarter tone direction.
	 *
	 * @see AbstractAccidental::getQuarterToneDirection()
	 */
	public function setQuarterToneDirection(int $quarterToneDirection): static
	{
		$this->quarterToneDirection = $quarterToneDirection;

		return $this;
	}
}