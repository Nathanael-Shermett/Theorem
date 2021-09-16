<?php

declare(strict_types=1);

namespace Theorem\Factory;

use Theorem\Accidental\Accidental;
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
	private int $quarterToneDirection = Accidental::QUARTER_TONE_DIRECTION_NEUTRAL;

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
	public function create(float|string $offsetOrString = null, ?int $quarterToneDirection = null): Accidental
	{
		if (is_string($offsetOrString)) {
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
	public function createFromOffset(?float $offset = null, ?int $quarterToneDirection = null): Accidental
	{
		$created = new Accidental($this->theorem, $offset ?? $this->offset);
		$created->setQuarterToneDirection($quarterToneDirection ?? $this->quarterToneDirection);

		return $created;
	}

	/**
	 * Builds and returns a specific accidental object based on the specified string.
	 */
	public function createFromString(string $string): Accidental
	{
		// Get the quarter tone part of the accidental, if any.
		$quarterTone = $this->regularExpression->parseQuarterTonePart($string);

		// Set the quarter tone directionality, if applicable.
		if ($quarterTone === 'd') {
			$quarterToneDirection = Accidental::QUARTER_TONE_DIRECTION_DOWN;
		} elseif ($quarterTone === '+') {
			$quarterToneDirection = Accidental::QUARTER_TONE_DIRECTION_UP;
		} else {
			$quarterToneDirection = null;
		}

		// Map of the accidental characters and their corresponding offsets.
		$offsets = [
			'd' => -.25,
			'b' => -.5,
			'+' => .25,
			'#' => .5,
			'x' => 1.0,
		];

		// Split the string into an array of single characters and replace them with their corresponding offsets.
		$characters = str_split($string);
		$characters = str_replace(array_keys($offsets), array_values($offsets), $characters);

		// Sum the result and set the offset accordingly.
		$offset = array_sum($characters);

		return $this->create($offset, $quarterToneDirection ?? null);
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
	 * @see Accidental::setQuarterToneDirection()
	 */
	public function getQuarterToneDirection(): int
	{
		return $this->quarterToneDirection;
	}

	/**
	 * Sets the accidental's quarter tone direction.
	 *
	 * @see Accidental::getQuarterToneDirection()
	 */
	public function setQuarterToneDirection(int $quarterToneDirection): static
	{
		$this->quarterToneDirection = $quarterToneDirection;

		return $this;
	}
}
