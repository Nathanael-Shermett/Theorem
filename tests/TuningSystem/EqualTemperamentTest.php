<?php

namespace TuningSystem;

use PHPUnit\Framework\TestCase;

use Theorem\Theorem;
use Theorem\TuningSystem\EqualTemperament;

class EqualTemperamentTest extends TestCase
{
	public function testCalcFrequency()
	{
		$theorem = new Theorem();
		$theorem->setTuningSystem(EqualTemperament::class);
		$theorem->setFrequencyPrecision(3);
		$theorem->setTuningReferenceNote('A4');
		$theorem->setTuningReferencePitch(440);

		// Natural notes / negative octaves.
		self::assertEquals(4.088, $theorem->note('C-2')->getFrequency());
		self::assertEquals(9.177, $theorem->note('D-1')->getFrequency());
		self::assertEquals(20.602, $theorem->note('E0')->getFrequency());
		self::assertEquals(43.654, $theorem->note('F1')->getFrequency());
		self::assertEquals(97.999, $theorem->note('G2')->getFrequency());
		self::assertEquals(220.000, $theorem->note('A3')->getFrequency());
		self::assertEquals(493.883, $theorem->note('B4')->getFrequency());

		// Accidentals.
		self::assertEquals(369.994, $theorem->note('Abbb4')->getFrequency());
		self::assertEquals(380.836, $theorem->note('Adbb4')->getFrequency());
		self::assertEquals(391.995, $theorem->note('Abb4')->getFrequency());
		self::assertEquals(403.482, $theorem->note('Adb4')->getFrequency());
		self::assertEquals(415.305, $theorem->note('Ab4')->getFrequency());
		self::assertEquals(427.474, $theorem->note('Ad4')->getFrequency());
		self::assertEquals(440.000, $theorem->note('A4')->getFrequency());
		self::assertEquals(452.893, $theorem->note('A+4')->getFrequency());
		self::assertEquals(466.164, $theorem->note('A#4')->getFrequency());
		self::assertEquals(479.823, $theorem->note('A+#4')->getFrequency());
		self::assertEquals(493.883, $theorem->note('Ax4')->getFrequency());
		self::assertEquals(508.355, $theorem->note('A+x4')->getFrequency());
		self::assertEquals(523.251, $theorem->note('A#x4')->getFrequency());
		self::assertEquals(538.584, $theorem->note('A+#x4')->getFrequency());

		// Reference pitch = 435 Hz
		$theorem->setTuningReferencePitch(435);
		self::assertEquals(258.653, $theorem->note('C4')->getFrequency());
		self::assertEquals(290.328, $theorem->note('D4')->getFrequency());
		self::assertEquals(325.882, $theorem->note('E4')->getFrequency());
		self::assertEquals(345.26, $theorem->note('F4')->getFrequency());
		self::assertEquals(387.541, $theorem->note('G4')->getFrequency());
		self::assertEquals(435.000, $theorem->note('A4')->getFrequency());
		self::assertEquals(488.271, $theorem->note('B4')->getFrequency());
	}
}