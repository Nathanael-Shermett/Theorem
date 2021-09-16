<?php

declare(strict_types=1);

namespace Theorem\Renderer;

use Theorem\Accidental\Accidental;
use Theorem\Note\Note;

/**
 * Renderer interface. Declares methods that all renderers must implement.
 *
 * @see Theorem::Note
 */
interface RendererInterface
{
	/**
	 * Returns the rendered accidental.
	 */
	public function renderAccidental(Accidental $accidental): string;

	/**
	 * Returns the rendered note+accidental.
	 */
	public function renderNote(Note $note): string;

	/**
	 * Returns the rendered note+accidental+octave.
	 */
	public function renderSpn(Note $note): string;
}
