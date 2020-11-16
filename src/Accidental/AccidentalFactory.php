<?php

namespace Theorem\Accidental;

use Theorem\RegularExpression;

/**
 * Factory class to generate accidentals. Really just used to keep accidental objects tidy after transpositions and to
 * prevent all accidentals from being Special types. Also useful for setting quarter tone directionality.
 *
 * @see Special
 */
class AccidentalFactory
{
	private float $offset               = 0;
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
	 * Builds and returns an accidental based on the specified offset.
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
	 * @return float
	 */
	public function getOffset(): float
	{
		return $this->offset;
	}

	/**
	 * @param float $offset
	 * @return AccidentalFactory
	 */
	public function setOffset($offset): AccidentalFactory
	{
		$this->offset = $offset;

		return $this;
	}

	/**
	 * Calculates and sets the accidental's offset and quarter tone directionality from its ASCII string
	 * representation..
	 *
	 * @param string $string
	 * @return AccidentalFactory
	 */
	public function createFromString($string): AccidentalFactory
	{
		// Parse the accidental into an associative array, like so:
		// ['accidental' => 'db', 'quarterTone' => 'd']
		RegularExpression::parseAccidental($string, $accidental);

		// Set the quarter tone directionality, if applicable.
		if ($accidental['quarterTone'] == 'd')
		{
			$this->setQuarterToneDirection(AbstractAccidental::QUARTER_TONE_DIRECTION_DOWN);
		}
		elseif ($accidental['quarterTone'] == '+')
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

		return $this;
	}

	/**
	 * @return int
	 */
	public function getQuarterToneDirection(): int
	{
		return $this->quarterToneDirection;
	}

	/**
	 * @param int $quarterToneDirection
	 * @return AccidentalFactory
	 */
	public function setQuarterToneDirection(int $quarterToneDirection): AccidentalFactory
	{
		$this->quarterToneDirection = $quarterToneDirection;

		return $this;
	}
}