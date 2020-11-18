<?php

namespace Theorem;

/**
 * Provides functionality for allowing entities to be transposed.
 *
 * @see Note
 */
trait TransposableTrait
{
	/**
	 * Transposes the note one step down, given `Setting::$STEP`.
	 *
	 * @return $this
	 * @see Setting::getStep()
	 * @see Setting::setStep()
	 */
	final public function stepDown(): self
	{
		return $this->transpose(1, 'down');
	}

	/**
	 * Transposes the note one step up, given `Setting::$STEP`.
	 *
	 * @return $this
	 * @see Setting::getStep()
	 * @see Setting::setStep()
	 */
	final public function stepUp(): self
	{
		return $this->transpose(1, 'up');
	}

	/**
	 * Transposes the note `$amount` steps in the specified direction, given `Setting::$STEP`.
	 *
	 * @param int    $amount    The number of steps to transpose the note.
	 * @param string $direction The transposition direction. Accepts either `down` or `up`.
	 * @return $this
	 * @see Setting::getStep()
	 * @see Setting::setStep()
	 */
	public function transpose($amount, $direction): self
	{
		return $this;
	}

	/**
	 * Transposes the note `$amount` steps down, given `Setting::$STEP`.
	 *
	 * @param int $amount The number of steps to transpose the note.
	 * @return $this
	 * @see Setting::getStep()
	 * @see Setting::setStep()
	 */
	final public function transposeDown($amount): self
	{
		return $this->transpose($amount, 'down');
	}

	/**
	 * Transposes the note `$amount` steps up, given `Setting::$STEP`.
	 *
	 * @param int $amount The number of steps to transpose the note.
	 * @return $this
	 * @see Setting::getStep()
	 * @see Setting::setStep()
	 */
	final public function transposeUp($amount): self
	{
		return $this->transpose($amount, 'up');
	}
}