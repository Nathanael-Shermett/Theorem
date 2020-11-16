<?php

namespace Theorem\Renderer;

use Theorem\Accidental\AbstractAccidental;
use Theorem\Note;

/**
 * Renderer interface. Declares methods that all renderers must implement.
 *
 * @see Theorem::Note
 */
interface RendererInterface
{
	/**
	 * Returns the rendered accidental.
	 *
	 * @param AbstractAccidental $accidental
	 * @return string
	 */
	public function renderAccidental(AbstractAccidental $accidental): string;

	/**
	 * Returns the rendered note+accidental.
	 *
	 * @param Note $note
	 * @return string
	 */
	public function renderNote(Note $note): string;

	/**
	 * Returns the rendered note+accidental+octave.
	 *
	 * @param Note $note
	 * @return string
	 */
	public function renderSpn(Note $note): string;
}