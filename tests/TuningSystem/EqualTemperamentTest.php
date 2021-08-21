<?php

namespace TuningSystem;

use PHPUnit\Framework\TestCase;

use Theorem\Note\Note;
use Theorem\Theorem;
use Theorem\TuningSystem\EqualTemperament;

class EqualTemperamentTest extends TestCase
{
	/**
	 * @return array[]
	 */
	public function calcFrequencyProvider()
	{
		$theorem = new Theorem();
		$theorem->setTuningSystem(EqualTemperament::class);
		$theorem->setFrequencyPrecision(3);
		$theorem->setTuningReferenceNote('A4');
		$theorem->setTuningReferencePitch(440);

		return [
			// Natural notes / negative octaves.
			[4.088, $theorem->note('C-2')],
			[9.177, $theorem->note('D-1')],
			[20.602, $theorem->note('E0')],
			[43.654, $theorem->note('F1')],
			[97.999, $theorem->note('G2')],
			[220.000, $theorem->note('A3')],
			[493.883, $theorem->note('B4')],

			// Accidentals.
			[369.994, $theorem->note('Abbb4')],
			[380.836, $theorem->note('Adbb4')],
			[391.995, $theorem->note('Abb4')],
			[403.482, $theorem->note('Adb4')],
			[415.305, $theorem->note('Ab4')],
			[427.474, $theorem->note('Ad4')],
			[440.000, $theorem->note('A4')],
			[452.893, $theorem->note('A+4')],
			[466.164, $theorem->note('A#4')],
			[479.823, $theorem->note('A+#4')],
			[493.883, $theorem->note('Ax4')],
			[508.355, $theorem->note('A+x4')],
			[523.251, $theorem->note('A#x4')],
			[538.584, $theorem->note('A+#x4')],
		];
	}

	/**
	 * @dataProvider calcFrequencyProvider
	 *
	 * @param float $frequency
	 * @param Note  $note
	 */
	public function testCalcFrequency(float $frequency, Note $note): void
	{
		self::assertEquals($frequency, $note->getFrequency());
	}

	/**
	 * @return array[]
	 */
	public function calcFrequencyWithTuningProvider(): array
	{
		// Reference pitch = 435 Hz
		$theorem = new Theorem();
		$theorem->setTuningSystem(EqualTemperament::class);
		$theorem->setFrequencyPrecision(3);
		$theorem->setTuningReferenceNote('A4');
		$theorem->setTuningReferencePitch(435);

		return [
			[258.653, $theorem->note('C4')],
			[290.328, $theorem->note('D4')],
			[325.882, $theorem->note('E4')],
			[345.26, $theorem->note('F4')],
			[387.541, $theorem->note('G4')],
			[435.000, $theorem->note('A4')],
			[488.271, $theorem->note('B4')],
		];
	}

	/**
	 * @dataProvider calcFrequencyWithTuningProvider
	 *
	 * @param float $frequency
	 * @param Note  $note
	 */
	public function testCalcFrequencyWithTuning(float $frequency, Note $note): void
	{
		self::assertEquals($frequency, $note->getFrequency());
	}
}