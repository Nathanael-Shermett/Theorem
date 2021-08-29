<?php

declare(strict_types=1);

namespace Theorem\Renderer;

use Theorem\Accidental\AbstractAccidental;
use Theorem\Note\Note;

class Ascii implements RendererInterface
{
	// Accidentals glyphs and their corresponding offsets.
	protected array $accidentals = [
		'flats' => [
			'b' => AbstractAccidental::FLAT,
			'd' => AbstractAccidental::HALF_FLAT,
		],
		'sharps' => [
			'x' => AbstractAccidental::DOUBLE_SHARP,
			'#' => AbstractAccidental::SHARP,
			'+' => AbstractAccidental::HALF_SHARP,
		],
	];

	/**
	 * Returns the rendered accidental.
	 */
	public function renderAccidental(AbstractAccidental $accidental): string
	{
		$result = '';

		// Are we using flats or sharps?
		// If flats, get the absolute value of the offset so that we don't have to work with negative values.
		$accidentals = ($accidental->getOffset() < 0) ? array_map('abs', $this->accidentals['flats']) : $this->accidentals['sharps'];

		// Sort the accidentals by their relative offset in descending order (so that higher offsets receive precedence).
		arsort($accidentals);

		$runningOffset = abs($accidental->getOffset());
		foreach ($accidentals as $glyph => $accidentalOffset) {
			while ($runningOffset >= $accidentalOffset) {
				$result         = $glyph . $result;
				$runningOffset -= $accidentalOffset;
			}
		}

		return $result;
	}

	/**
	 * Returns the rendered note+accidental.
	 */
	public function renderNote(Note $note): string
	{
		return $note->getLetter() . $this->renderAccidental($note->getAccidental());
	}

	/**
	 * Returns the rendered note+accidental+octave.
	 */
	public function renderSpn(Note $note): string
	{
		return $this->renderNote($note) . $note->getOctave();
	}
}
