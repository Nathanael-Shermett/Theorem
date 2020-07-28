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

		$this->assertEquals(13.75, (new Note('A-1'))->getFrequency());
		$this->assertEquals(27.5, (new Note('A0'))->getFrequency());
		$this->assertEquals(440, (new Note('A4'))->getFrequency());
		$this->assertEquals(493.88, (new Note('B4'))->getFrequency());
		$this->assertEquals(523.25, (new Note('B#4'))->getFrequency());
		$this->assertEquals(493.88, (new Note('Cb5'))->getFrequency());
		$this->assertEquals(523.25, (new Note('C5'))->getFrequency());
	}
}