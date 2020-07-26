<?php

namespace TuningSystem;

use PHPUnit\Framework\TestCase;
use Theorem\Note;
use Theorem\Setting;
use Theorem\TuningSystem\EqualTemperament;

class EqualTemperamentTest extends TestCase
{
	public function testCalcFrequency()
	{
		Setting::setFrequencyPrecision(2);
		Setting::setTuningReferenceNote('A4');
		Setting::setTuningReferencePitch(440);

		$note = new Note('A-1');
		$this->assertEquals(13.75, $note->getFrequency());

		$note = new Note('A0');
		$this->assertEquals(27.5, $note->getFrequency());

		$note = new Note('A4');
		$this->assertEquals(440, $note->getFrequency());

		$note = new Note('B4');
		$this->assertEquals(493.88, $note->getFrequency());

		$note = new Note('B#4');
		$this->assertEquals(523.25, $note->getFrequency());

		$note = new Note('Cb5');
		$this->assertEquals(493.88, $note->getFrequency());

		$note = new Note('C5');
		$this->assertEquals(523.25, $note->getFrequency());
	}
}