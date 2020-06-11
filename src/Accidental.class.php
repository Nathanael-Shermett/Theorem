<?php

namespace Theorem;

/**
 * Static class. Serves primarily as an enumerator for accidentals. Contains various public constants with values
 * representing the effect the accidental has on a letter note. Values are signed, relative, and scaled to whole tones.
 */
abstract class Accidental
{
	use RenderableTrait;

	/**
	 * Triple-flat accidental. Lowers a letter note by three semitones.
	 */
	public const TRIPLE_FLAT = -1.5;

	/** Five-quarter-tones-flat accidental. Lowers a letter note by five quarter tones. */
	public const FIVE_QUARTER_FLAT = -1.25;

	/** Double-flat accidental. Lowers a letter note by two semitones (i.e. one whole tone). */
	public const DOUBLE_FLAT = -1;

	/** Three-quarter-tones-flat accidental. Lowers a letter note by three quarter tones. */
	public const THREE_QUARTER_FLAT = -.75;

	/** Flat accidental. Lowers a letter note by a single semitone. */
	public const FLAT = -.5;

	/** Half-flat accidental. Lowers a letter note by a single quarter tone. */
	public const HALF_FLAT = -.25;

	/** Natural accidental. */
	public const NATURAL = 0;

	/** Half-sharp accidental. Raises a letter note by a single quarter tone. */
	public const HALF_SHARP = .25;

	/** Sharp accidental. Raises a letter note by a single semitone. */
	public const SHARP = .5;

	/** Three-quarter-tones-sharp accidental. Raises a letter note by three quarter tones. */
	public const THREE_QUARTER_SHARP = .75;

	/** Double-sharp accidental. Raises a letter note by two semitones (i.e. one whole tone). */
	public const DOUBLE_SHARP = 1;

	/** Five-quarter-tones-sharp accidental. Raises a letter note by five quarter tones. */
	public const FIVE_QUARTER_SHARP = 1.25;

	/** Triple-sharp accidental. Raises a letter note by three semitones. */
	public const TRIPLE_SHARP = 1.5;

	/**
	 * The accidental's offset value. Values are signed, relative, and scaled to whole tones.
	 *
	 * @var float $offset
	 */
	private float $offset;

	/**
	 * Gets the accidental's offset.
	 *
	 * @return float
	 */
	public function getOffset(): float
	{
		return $this->offset;
	}

	/**
	 * Sets the accidental's offset.
	 *
	 * @param float $offset
	 */
	protected function setOffset(float $offset): void
	{
		$this->offset = $offset;
	}
}