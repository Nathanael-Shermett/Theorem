<?php

namespace Theorem;

/**
 * Static class. Contains various global configuration options (static). Also contains a few inheritable configuration
 * options ({@see setOutputMode()} and {@see setRenderMode()}).
 */
final class Setting
{
	/**
	 * Constant representing the number of whole steps in an octave. Useful for calculating note frequencies within a
	 * given tuning system.
	 */
	public const WHOLE_TONE = 6;

	/**
	 * Constant representing the number of half steps in an octave. Useful for calculating note frequencies within a
	 * given tuning system.
	 */
	public const SEMITONE = 12;

	/**
	 * Constant representing the number of quarter steps in an octave. Useful for calculating note frequencies within a
	 * given tuning system.
	 */
	public const QUARTER_TONE = 24;

	/**
	 * Constant representing full-text output of a note, chord, interval, et cetera. Output is fully expanded.
	 *
	 * **Examples:**
	 * - A-flat major
	 * - C half-diminished seventh with an added ninth
	 * - E-flat diminished fifth
	 * - G half-sharp minor
	 */
	public const OUTPUT_FULLTEXT = 'OUTPUT_FULLTEXT';

	/**
	 * Constant representing standard output of a note, chord, interval, et cetera. Output is compressed, but varies
	 * based on the render mode.
	 *
	 * **Examples:**
	 * - Ab
	 * - Cø7add9
	 * - Eb d5
	 * - Gv#m
	 */
	public const OUTPUT_STANDARD = 'OUTPUT_STANDARD';

	/** Constant representing the HTML rendering mode. Uses HTML to nicely format output. */
	public const RENDER_HTML = 'RENDER_HTML';

	/** Constant representing the plaintext rendering mode. Output will consist of only numbers, letters, and spaces. */
	public const RENDER_NOSYMBOL = 'RENDER_NOSYMBOL';

	/**
	 * Constant representing the SMuFL (Standard Music Font Layout) rendering mode. Symbols will be encoded according
	 * to the SMuFL font specification. Uses HTML to nicely format output.
	 *
	 * **NOTE #1:** You must use a <a href="https://github.com/steinbergmedia/bravura" target="SMuFL">SMuFL-compliant
	 * font</a> to render symbols correctly.
	 *
	 * **NOTE #2:** For easy CSS styling, output is wrapped in `&lt;span class="SMuFL"&gt;&lt;/span&gt;` tags.
	 */
	public const RENDER_SMUFL = 'RENDER_SMUFL';

	/**
	 * Constant representing the Unicode rendering mode. Output will consist of plaintext characters, but will use
	 * Unicode symbols wherever possible.
	 */
	public const RENDER_UNICODE = 'RENDER_UNICODE';

	/**
	 * Setting representing the number of decimal places that frequencies should be rounded to.
	 *
	 * NOTE: Internal frequency calculations are not changed by this setting. Only public frequency results (e.g.
	 * {@see Note::getFrequency()}) are affected.
	 *
	 * @see getFrequencyPrecision()
	 * @see setFrequencyPrecision()
	 * @var int
	 */
	private static int $FREQUENCY_PRECISION = 0;

	/**
	 * Global setting property representing the key. Can be set on a per-object basis, or globally with
	 * `Theorem\Setting::setKey()`.
	 *
	 * @see getKey()
	 * @see setKey()
	 * @var string
	 */
	private static string $KEY = 'C major';

	/**
	 * Setting representing the output mode. Can be set on a per-object basis, or globally with
	 * `Setting::setOutputMode()`.
	 *
	 * @see getOutputMode()
	 * @see setOutputMode()
	 * @var string
	 */
	private static string $OUTPUT_MODE = self::OUTPUT_STANDARD;

	/**
	 * Setting representing the rendering mode. Can be set on a per-object basis, or globally with
	 * `Setting::setRenderMode()`.
	 *
	 * @see getRenderMode()
	 * @see setRenderMode()
	 * @var string
	 */
	private static string $RENDER_MODE = self::RENDER_UNICODE;

	/**
	 * Global setting property representing the number of steps in an octave. Useful when working in microtonal
	 * systems. Used by tuning systems that implement `ITuningSystem`.
	 *
	 * @see WHOLE_TONE
	 * @see SEMITONE
	 * @see QUARTER_TONE
	 * @see getStep()
	 * @see setStep()
	 * @var int
	 */
	private static int $STEP = self::SEMITONE;

	/**
	 * Global setting property representing the reference pitch. Used by tuning systems that implement `ITuningSystem`.
	 *
	 * @see getTuningReferencePitch()
	 * @see setTuningReferencePitch()
	 * @var float
	 */
	private static float $TUNING_REFERENCE_PITCH = 440;

	/**
	 * Global setting property representing the reference note. Used by tuning systems that implement `ITuningSystem`.
	 *
	 * **NOTE:** Very few tuning systems use reference notes other than A4. Only change this if you know exactly what
	 * you are doing.
	 *
	 * @see getTuningReferenceNote()
	 * @see setTuningReferenceNote()
	 * @var string
	 */
	private static string $TUNING_REFERENCE_NOTE = 'A4';

	/**
	 * Global setting property representing the tuning system used to calculate notes and their relative frequencies.
	 *
	 * @see getTuningSystem()
	 * @see setTuningSystem()
	 * @var string
	 */
	private static string $TUNING_SYSTEM = 'EqualTemperament';

	/**
	 * Gets the number of decimal places frequencies should be rounded to.
	 *
	 * @return int
	 */
	final public static function getFrequencyPrecision(): int
	{
		return self::$FREQUENCY_PRECISION;
	}

	/**
	 * Sets the number of decimal places frequencies should be rounded to.
	 *
	 * @param int $frequencyPrecision
	 * @return void
	 */
	final public static function setFrequencyPrecision(int $frequencyPrecision): void
	{
		self::$FREQUENCY_PRECISION = $frequencyPrecision;
	}

	/**
	 * @return string
	 */
	final public static function getKey(): string
	{
		return self::$KEY;
	}

	/**
	 * @param string $key
	 */
	final public static function setKey(string $key): void
	{
		self::$KEY = $key;
	}

	/**
	 * Gets the output mode.
	 *
	 * @return string
	 */
	final public static function getOutputMode(): string
	{
		return self::$OUTPUT_MODE;
	}

	/**
	 * Sets the output mode. Can be set on a per-object basis, or globally with `Setting::setOutputMode()` unless
	 * overridden.
	 *
	 * @param string $outputMode
	 * @return void
	 */
	final public static function setOutputMode(string $outputMode): void
	{
		self::$OUTPUT_MODE = $outputMode;
	}

	/**
	 * Gets the rendering mode.
	 *
	 * @return string
	 */
	final public static function getRenderMode(): string
	{
		return self::$RENDER_MODE;
	}

	/**
	 * Sets the rendering mode. Can be set on a per-object basis, or globally with`Setting::setRenderMode()` unless
	 * overridden.
	 *
	 * @param string $renderMode
	 * @return void
	 */
	final public static function setRenderMode(string $renderMode): void
	{
		self::$RENDER_MODE = $renderMode;
	}

	/**
	 * Gets the current setting's value for the number of steps in an octave. In most western music (which uses
	 * semitones) this will be 12.
	 *
	 * @return int
	 * @see Setting::SEMITONE
	 * @see Setting::QUARTER_TONE
	 * @see Setting::WHOLE_TONE
	 */
	final public static function getStep(): int
	{
		return self::$STEP;
	}

	/**
	 * Sets the number of steps in an octave. In most western music (which uses semitones) this will be 12.
	 *
	 * @param int $step
	 * @return void
	 * @see Setting::SEMITONE
	 * @see Setting::QUARTER_TONE
	 * @see Setting::WHOLE_TONE
	 */
	final public static function setStep(int $step): void
	{
		self::$STEP = $step;
	}

	/**
	 * Gets the reference pitch setting (usually 440 Hz). This is used by tuning systems that implement the
	 * `ITuningSystem` interface.
	 *
	 * @return float
	 */
	final public static function getTuningReferencePitch(): float
	{
		return self::$TUNING_REFERENCE_PITCH;
	}

	/**
	 * Sets the reference pitch (usually 440 Hz). This is used by tuning systems that implement the `ITuningSystem`
	 * interface.
	 *
	 * @param int $tuningReferencePitch
	 * @return void
	 */
	final public static function setTuningReferencePitch(int $tuningReferencePitch): void
	{
		self::$TUNING_REFERENCE_PITCH = $tuningReferencePitch;
	}

	/**
	 * Returns the note, as a string, that the reference pitch is calibrated to (usually A4). This is used by tuning
	 * systems that implement the `ITuningSystem` interface.
	 *
	 * @return string
	 */
	final public static function getTuningReferenceNote(): string
	{
		return self::$TUNING_REFERENCE_NOTE;
	}

	/**
	 * Sets the note that the reference pitch is calibrated to (usually A4). This is used by tuning systems that
	 * implement the `ITuningSystem` interface.
	 *
	 * @param int $tuningReferenceNote
	 * @return void
	 */
	final public static function setTuningReferenceNote(int $tuningReferenceNote): void
	{
		self::$TUNING_REFERENCE_NOTE = $tuningReferenceNote;
	}

	/**
	 * @return string
	 */
	final public static function getTuningSystem(): string
	{
		return self::$TUNING_SYSTEM;
	}

	/**
	 * @param string $tuningSystem
	 * @return void
	 */
	final public static function setTuningSystem(string $tuningSystem): void
	{
		self::$TUNING_SYSTEM = $tuningSystem;
	}
}