<?php

namespace Theorem\Accidental;

use Theorem\RegularExpression;

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
	 * Whether or not the accidental's quarter tone part, if applicable, is moving moving "upwards" or "downwards".
	 *
	 * @var int
	 * @see AccidentalFactory::getQuarterToneDirection()
	 * @see AccidentalFactory::setQuarterToneDirection()
	 */
	private int   $quarterToneDirection = AbstractAccidental::QUARTER_TONE_DIRECTION_NEUTRAL;

	/**
	 * AccidentalFactory constructor.
	 *
	 * @param float $offset
	 * @param int   $quarterToneDirection
	 */
	public function __construct(float $offset = 0, int $quarterToneDirection = AbstractAccidental::QUARTER_TONE_DIRECTION_NEUTRAL)
	{
		$this->offset = $offset;
		$this->quarterToneDirection = $quarterToneDirection;
	}

	/**
	 * Builds and returns a specific accidental object based on the specified offset.
	 *
	 * @return AbstractAccidental
	 */
	public function build(): AbstractAccidental
	{
		switch ($this->getOffset())
		{
			case AbstractAccidental::TRIPLE_FLAT:
				$accidental = new TripleFlat();
				break;
			case AbstractAccidental::FIVE_QUARTER_FLAT:
				$accidental = new FiveQuarterFlat();
				break;
			case AbstractAccidental::DOUBLE_FLAT:
				$accidental = new DoubleFlat();
				break;
			case AbstractAccidental::THREE_QUARTER_FLAT:
				$accidental = new ThreeQuarterFlat();
				break;
			case AbstractAccidental::FLAT:
				$accidental = new Flat();
				break;
			case AbstractAccidental::HALF_FLAT:
				$accidental = new HalfFlat();
				break;
			case AbstractAccidental::NATURAL:
				$accidental = new Natural();
				break;
			case AbstractAccidental::HALF_SHARP:
				$accidental = new HalfSharp();
				break;
			case AbstractAccidental::SHARP:
				$accidental = new Sharp();
				break;
			case AbstractAccidental::THREE_QUARTER_SHARP:
				$accidental = new ThreeQuarterSharp();
				break;
			case AbstractAccidental::DOUBLE_SHARP:
				$accidental = new DoubleSharp();
				break;
			case AbstractAccidental::FIVE_QUARTER_SHARP:
				$accidental = new FiveQuarterSharp();
				break;
			case AbstractAccidental::TRIPLE_SHARP:
				$accidental = new TripleSharp();
				break;
			default:
				$accidental = new Special($this->getOffset());
		}

		// Set the accidental's quarter tone directionality.
		$accidental->setQuarterToneDirection($this->quarterToneDirection);

		return $accidental;
	}

	/**
	 * Calculates and sets the accidental's offset and quarter tone directionality from its ASCII string representation.
	 *
	 * @param string $string
	 * @return AccidentalFactory
	 */
	public function createFromString($string): AccidentalFactory
	{
		// Get the quarter tone part of the accidental, if any.
		$quarterTone = RegularExpression::parseQuarterTonePart($string);

		// Set the quarter tone directionality, if applicable.
		if ($quarterTone == 'd')
		{
			$this->setQuarterToneDirection(AbstractAccidental::QUARTER_TONE_DIRECTION_DOWN);
		}
		elseif ($quarterTone == '+')
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
		$this->setOffset(array_sum($characters));

		return $this;
	}

	/**
	 * Returns the accidental's offset.
	 *
	 * @return float
	 * @see AccidentalFactory::setOffset()
	 */
	public function getOffset(): float
	{
		return $this->offset;
	}

	/**
	 * Sets the accidental's offset.
	 *
	 * @param float $offset
	 * @return AccidentalFactory
	 */
	public function setOffset($offset): AccidentalFactory
	{
		$this->offset = $offset;

		return $this;
	}

	/**
	 * Returns the accidental's quarter tone part's directionality, if any.
	 *
	 * @return int
	 */
	public function getQuarterToneDirection(): int
	{
		return $this->quarterToneDirection;
	}

	/**
	 * Sets the accidental's quarter tone part's directionality.
	 *
	 * @param int $quarterToneDirection
	 * @return AccidentalFactory
	 */
	public function setQuarterToneDirection(int $quarterToneDirection): AccidentalFactory
	{
		$this->quarterToneDirection = $quarterToneDirection;

		return $this;
	}
}