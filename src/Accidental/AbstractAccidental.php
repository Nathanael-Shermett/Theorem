<?php

namespace Theorem\Accidental;

use Theorem\RenderableTrait;
use Theorem\Renderer\RendererInterface;

/**
 * Abstract class inherited by all accidentals. Contains constants representing each accidental's relative pitch offset
 * (minimum unit: quarter tones). Also includes a few universal methods, including {@see toString()}.
 */
abstract class AbstractAccidental
{
	use RenderableTrait;

	/** Triple-flat accidental. Lowers a letter note by three semitones. */
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
	 * Constant representing "downward" quarter tone accidentals. Useful for nuanced renderers (e.g. Gould-style).
	 */
	public const QUARTER_TONE_DIRECTION_DOWN = -1;

	/**
	 * Constant representing "neutral" quarter tone accidentals. Accidentals that have not been directionally
	 * transposed are neutral.
	 */
	public const QUARTER_TONE_DIRECTION_NEUTRAL = 0;

	/**
	 * Constant representing "upward" quarter tone accidentals. Useful for nuanced renderers (e.g. Gould-style).
	 */
	public const QUARTER_TONE_DIRECTION_UP = 1;

	/**
	 * The accidental's offset value. Values are signed, relative, and scaled to whole tones.
	 *
	 * @var float $offset
	 */
	private float $offset;

	/**
	 * Indicates whether the accidentals should favor "up" or "down". Mostly useful for rendering Gould quarter tone
	 * sub-accidentals (e.g. for cases where we should favor vx instead of ^#), though there may be other uses.
	 *
	 * @var int $quarterToneDirection
	 */
	protected int $quarterToneDirection = self::QUARTER_TONE_DIRECTION_NEUTRAL;

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
	 * @param RendererInterface $renderer
	 * @return string
	 * @TODO
	 */
	public function toString(RendererInterface $renderer): string
	{
		return $renderer->renderAccidental($this);
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

	/**
	 * @return int
	 */
	public function getQuarterToneDirection(): int
	{
		return $this->quarterToneDirection;
	}

	/**
	 * Sets the accidental's quarter tone direction.
	 *
	 * @param int $quarterToneDirection
	 * @see
	 */
	public function setQuarterToneDirection(int $quarterToneDirection): void
	{
		$this->quarterToneDirection = $quarterToneDirection;
	}
}