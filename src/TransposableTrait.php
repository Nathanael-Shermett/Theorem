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
	 * Transposes the note one step down, given `Theorem::step`.
	 *
	 * @return $this
	 * @see Theorem::getStep()
	 * @see Theorem::setStep()
	 */
	final public function stepDown(): self
	{
		return $this->transpose(1, 'down');
	}

	/**
	 * Transposes the note one step up, given `Theorem::step`.
	 *
	 * @return $this
	 * @see Theorem::getStep()
	 * @see Theorem::setStep()
	 */
	final public function stepUp(): self
	{
		return $this->transpose(1, 'up');
	}

	/**
	 * Transposes the note `$amount` steps in the specified direction, given `Theorem::step`.
	 *
	 * @param int    $amount    The number of steps to transpose the note.
	 * @param string $direction The transposition direction. Accepts either `down` or `up`.
	 * @return $this
	 * @see Theorem::getStep()
	 * @see Theorem::setStep()
	 */
	public function transpose(int $amount, string $direction): self
	{
		return $this;
	}

	/**
	 * Transposes the note `$amount` steps down, given `Theorem::step`.
	 *
	 * @param int $amount The number of steps to transpose the note.
	 * @return $this
	 * @see Theorem::getStep()
	 * @see Theorem::setStep()
	 */
	final public function transposeDown(int $amount): self
	{
		return $this->transpose($amount, 'down');
	}

	/**
	 * Transposes the note `$amount` steps up, given `Theorem::step`.
	 *
	 * @param int $amount The number of steps to transpose the note.
	 * @return $this
	 * @see Theorem::getStep()
	 * @see Theorem::setStep()
	 */
	final public function transposeUp(int $amount): self
	{
		return $this->transpose($amount, 'up');
	}
}