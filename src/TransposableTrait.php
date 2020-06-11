<?php

namespace Theorem;

/**
 * Provides functionality for allowing {@see Note} entities to be transposed.
 *
 * **NOTE:** `TransposableTrait` only provides functionality for transposing individual notes. If you need to transpose
 * *collections* of notes (such as {@see Chord} and {@see Sequence}), use {@see TransposableColletionTrait}.
 */
trait TransposableTrait
{
	/**
	 * Transposes the note one step down, given {@see Setting::STEP}.
	 *
	 * @return $this
	 */
	final public function stepDown(): self
	{
		return $this;
	}

	/**
	 * Transposes the note one step up, given {@see Setting::STEP}.
	 *
	 * @return $this
	 */
	final public function stepUp(): self
	{
		return $this;
	}

	/**
	 * Transposes the note `$amount` steps in the specified direction, given {@see Setting::STEP}.
	 *
	 * @param int    $amount    The number of steps to transpose the note.
	 * @param string $direction The transposition direction. Accepts either `down` or `up`.
	 * @return $this
	 */
	final public function transpose($amount, $direction): self
	{
		return $this;
	}

	/**
	 * Transposes the note `$amount` steps down, given {@see Setting::STEP}.
	 *
	 * @param int $amount The number of steps to transpose the note.
	 * @return $this
	 */
	final public function transposeDown($amount): self
	{
		return $this->transpose($amount, 'down');
	}

	/**
	 * Transposes the note `$amount` steps up, given {@see Setting::STEP}.
	 *
	 * @param int $amount The number of steps to transpose the note.
	 * @return $this
	 */
	final public function transposeUp($amount): self
	{
		return $this->transpose($amount, 'up');
	}
}