<?php

declare(strict_types=1);

namespace Theorem;

use Theorem\Accidental\AbstractAccidental;
use Theorem\Factory\AccidentalFactory;
use Theorem\Factory\NoteFactory;
use Theorem\Note\Note;
use Theorem\Renderer\Ascii;
use Theorem\Renderer\RendererInterface;
use Theorem\TuningSystem\EqualTemperament;
use Theorem\TuningSystem\TuningSystemInterface;

/**
 *  Base class. Contains various configuration properties (and corresponding getters and setters).
 */
final class Theorem
{
	/**
	 * Constant representing the number of whole steps in an octave. Useful for calculating note frequencies within a
	 * given tuning system.
	 */
	public const WHOLE_TONE_STEPS = 6;

	/**
	 * Constant representing the number of half steps in an octave. Useful for calculating note frequencies within a
	 * given tuning system.
	 */
	public const SEMITONE_STEPS = 12;

	/**
	 * Constant representing the number of quarter steps in an octave. Useful for calculating note frequencies within a
	 * given tuning system.
	 */
	public const QUARTER_TONE_STEPS = 24;

	/**
	 * Setting representing the number of decimal places that frequencies should be rounded to.
	 *
	 * NOTE: Internal frequency calculations are not changed by this setting. Only public frequency results (e.g.
	 * {@see Note::getFrequency()}) are affected.
	 *
	 * @see setFrequencyPrecision()
	 * @see getFrequencyPrecision()
	 */
	private int $frequencyPrecision = 0;

	/**
	 * Global setting property representing the key. Can be set on a per-object basis, or globally with
	 * `Theorem\Setting::setKey()`.
	 *
	 * @see setKey()
	 * @see getKey()
	 */
	private string $key = 'C major';

	/**
	 * Setting representing the renderer. Can be set on a per-object basis, or globally with
	 * `Setting::setRenderer()`.
	 *
	 * @see setRenderer()
	 * @see getRenderer()
	 */
	private RendererInterface $renderer;

	/**
	 * Global setting property representing the number of steps in an octave. Useful when working in microtonal
	 * systems. Used by tuning systems that implement `ITuningSystem`.
	 *
	 * @see SEMITONE_STEPS
	 * @see QUARTER_TONE_STEPS
	 * @see getStep()
	 * @see setStep()
	 * @see WHOLE_TONE_STEPS
	 */
	private int $step = self::SEMITONE_STEPS;

	/**
	 * Global setting property representing the reference pitch. Used by tuning systems that implement `ITuningSystem`.
	 *
	 * @see setTuningReferencePitch()
	 * @see getTuningReferencePitch()
	 */
	private float $tuningReferencePitch = 440;

	/**
	 * Global setting property representing the reference note. Used by tuning systems that implement `ITuningSystem`.
	 *
	 * **NOTE:** Very few tuning systems use reference notes other than A4. Only change this if you know exactly what
	 * you are doing.
	 *
	 * @see setTuningReferenceNote()
	 * @see getTuningReferenceNote()
	 */
	private string $tuningReferenceNote = 'A4';

	/**
	 * Global setting property representing the tuning system used to calculate notes and their relative frequencies.
	 *
	 * @see setTuningSystem()
	 * @see getTuningSystem()
	 */
	private TuningSystemInterface $tuningSystem;

	public function __construct()
	{
		$this->tuningSystem = new EqualTemperament($this);
		$this->renderer     = new Ascii($this);
	}

	/**
	 * Creates an accidental object from either a specified offset or a string.
	 */
	public function accidental(float|string $offsetOrString): AbstractAccidental
	{
		$accidentalFactory = new AccidentalFactory($this);

		return $accidentalFactory->create($offsetOrString);
	}

	/**
	 * Creates a Note object from the specified SPN (e.g. A4, B#7).
	 */
	public function note(string $spn): Note
	{
		$noteFactory = new NoteFactory($this);

		return $noteFactory->create($spn);
	}

	/**
	 * Gets the number of decimal places frequencies should be rounded to.
	 */
	public function getFrequencyPrecision(): int
	{
		return $this->frequencyPrecision;
	}

	/**
	 * Sets the number of decimal places frequencies should be rounded to.
	 */
	public function setFrequencyPrecision(int $frequencyPrecision): void
	{
		$this->frequencyPrecision = $frequencyPrecision;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function setKey(string $key): void
	{
		$this->key = $key;
	}

	/**
	 * Gets the renderer.
	 */
	public function getRenderer(): RendererInterface
	{
		return $this->renderer;
	}

	/**
	 * Sets the rendering ssytem. Can be set on a per-object basis, or globally with`Setting::setRenderer()`
	 * unless overridden.
	 */
	public function setRenderer(RendererInterface $renderer): void
	{
		$this->renderer = $renderer;
	}

	/**
	 * Gets the current setting's value for the number of steps in an octave. In most western music (which uses
	 * semitones) this will be 12.
	 *
	 * @see Theorem::SEMITONE_STEPS
	 * @see Theorem::QUARTER_TONE_STEPS
	 * @see Theorem::WHOLE_TONE_STEPS
	 */
	public function getStep(): int
	{
		return $this->step;
	}

	/**
	 * Sets the number of steps in an octave. In most western music (which uses semitones) this will be 12.
	 *
	 * @see Theorem::SEMITONE_STEPS
	 * @see Theorem::QUARTER_TONE_STEPS
	 * @see Theorem::WHOLE_TONE_STEPS
	 */
	public function setStep(int $step): void
	{
		$this->step = $step;
	}

	/**
	 * Gets the reference pitch setting (usually 440 Hz). This is used by tuning systems that implement the
	 * `ITuningSystem` interface.
	 */
	public function getTuningReferencePitch(): float
	{
		return $this->tuningReferencePitch;
	}

	/**
	 * Sets the reference pitch (usually 440 Hz). This is used by tuning systems that implement the `ITuningSystem`
	 * interface.
	 */
	public function setTuningReferencePitch(int $tuningReferencePitch): void
	{
		$this->tuningReferencePitch = $tuningReferencePitch;
	}

	/**
	 * Returns the note, as a string, that the reference pitch is calibrated to (usually A4). This is used by tuning
	 * systems that implement the `ITuningSystem` interface.
	 */
	public function getTuningReferenceNote(): string
	{
		return $this->tuningReferenceNote;
	}

	/**
	 * Sets the note that the reference pitch is calibrated to (usually A4). This is used by tuning systems that
	 * implement the `ITuningSystem` interface.
	 */
	public function setTuningReferenceNote(string $tuningReferenceNote): void
	{
		$this->tuningReferenceNote = $tuningReferenceNote;
	}

	/**
	 * Returns an object that implements `TuningSystemInterface`.
	 */
	public function getTuningSystem(): TuningSystemInterface
	{
		return $this->tuningSystem;
	}

	/**
	 * Expects a fully-qualified class name representing a tuning system.
	 */
	public function setTuningSystem(string $tuningSystem): void
	{
		$this->tuningSystem = new $tuningSystem($this);
	}
}
