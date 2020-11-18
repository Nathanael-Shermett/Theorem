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
		Setting::setTuningSystem(EqualTemperament::class);
		Setting::setFrequencyPrecision(3);
		Setting::setTuningReferenceNote('A4');
		Setting::setTuningReferencePitch(440);

		// Natural notes / negative octaves.
		$this->assertEquals(4.088, (new Note('C-2'))->getFrequency());
		$this->assertEquals(9.177, (new Note('D-1'))->getFrequency());
		$this->assertEquals(20.602, (new Note('E0'))->getFrequency());
		$this->assertEquals(43.654, (new Note('F1'))->getFrequency());
		$this->assertEquals(97.999, (new Note('G2'))->getFrequency());
		$this->assertEquals(220.000, (new Note('A3'))->getFrequency());
		$this->assertEquals(493.883, (new Note('B4'))->getFrequency());

		// Accidentals.
		$this->assertEquals(369.994, (new Note('Abbb4'))->getFrequency());
		$this->assertEquals(380.836, (new Note('Adbb4'))->getFrequency());
		$this->assertEquals(391.995, (new Note('Abb4'))->getFrequency());
		$this->assertEquals(403.482, (new Note('Adb4'))->getFrequency());
		$this->assertEquals(415.305, (new Note('Ab4'))->getFrequency());
		$this->assertEquals(427.474, (new Note('Ad4'))->getFrequency());
		$this->assertEquals(440.000, (new Note('A4'))->getFrequency());
		$this->assertEquals(452.893, (new Note('A+4'))->getFrequency());
		$this->assertEquals(466.164, (new Note('A#4'))->getFrequency());
		$this->assertEquals(479.823, (new Note('A+#4'))->getFrequency());
		$this->assertEquals(493.883, (new Note('Ax4'))->getFrequency());
		$this->assertEquals(508.355, (new Note('A+x4'))->getFrequency());
		$this->assertEquals(523.251, (new Note('A#x4'))->getFrequency());
		$this->assertEquals(538.584, (new Note('A+#x4'))->getFrequency());

		// Reference pitch = 435 Hz
		Setting::setTuningReferencePitch(435);
		$this->assertEquals(258.653, (new Note('C4'))->getFrequency());
		$this->assertEquals(290.328, (new Note('D4'))->getFrequency());
		$this->assertEquals(325.882, (new Note('E4'))->getFrequency());
		$this->assertEquals(345.26, (new Note('F4'))->getFrequency());
		$this->assertEquals(387.541, (new Note('G4'))->getFrequency());
		$this->assertEquals(435.000, (new Note('A4'))->getFrequency());
		$this->assertEquals(488.271, (new Note('B4'))->getFrequency());
	}
}