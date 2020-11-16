<?php

namespace Theorem;

use Theorem\Renderer\Ascii;
use Theorem\TuningSystem\EqualTemperament;

/**
 * Static class. Contains various global configuration options (static). Also contains a few inheritable configuration
 * options ({@see setOutputMode()} and {@see setRenderer()}).
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
	 * Setting representing the renderer. Can be set on a per-object basis, or globally with
	 * `Setting::setRenderer()`.
	 *
	 * @see getRenderer()
	 * @see setRenderer()
	 * @var string
	 */
	private static string $RENDERER = Ascii::class;

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
	private static string $TUNING_SYSTEM = EqualTemperament::class;

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
	 * Gets the renderer.
	 *
	 * @return string
	 */
	final public static function getRenderer(): string
	{
		return self::$RENDERER;
	}

	/**
	 * Sets the rendering ssytem. Can be set on a per-object basis, or globally with`Setting::setRenderer()`
	 * unless overridden.
	 *
	 * @param string $renderer
	 * @return void
	 */
	final public static function setRenderer(string $renderer): void
	{
		self::$RENDERER = $renderer;
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
	final public static function setTuningReferenceNote(string $tuningReferenceNote): void
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