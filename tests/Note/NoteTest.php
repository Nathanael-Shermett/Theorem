<?php

namespace Note;

use PHPUnit\Framework\TestCase;
use Theorem\Note\Note;
use Theorem\Theorem;

class NoteTest extends TestCase
{
	/**
	 * @return array[]
	 */
	public function distanceToQuarterToneProvider(): array
	{
		$theorem = new Theorem();
		$theorem->setStep(Theorem::QUARTER_TONE_STEPS);

		return [
			[7.0, $theorem->note('Adbbb4'), $theorem->note('A4')],
			[6.0, $theorem->note('Abbb4'), $theorem->note('A4')],
			[5.0, $theorem->note('Adbb4'), $theorem->note('A4')],
			[4.0, $theorem->note('Abb4'), $theorem->note('A4')],
			[3.0, $theorem->note('Adb4'), $theorem->note('A4')],
			[2.0, $theorem->note('Ab4'), $theorem->note('A4')],
			[1.0, $theorem->note('Ad4'), $theorem->note('A4')],
			[0.0, $theorem->note('A4'), $theorem->note('A4')],
			[-1.0, $theorem->note('A+4'), $theorem->note('A4')],
			[-2.0, $theorem->note('A#4'), $theorem->note('A4')],
			[-3.0, $theorem->note('A+#4'), $theorem->note('A4')],
			[-4.0, $theorem->note('Ax4'), $theorem->note('A4')],
			[-5.0, $theorem->note('A+x4'), $theorem->note('A4')],
			[-6.0, $theorem->note('A#x4'), $theorem->note('A4')],
			[-7.0, $theorem->note('A+#x4'), $theorem->note('A4')],
		];
	}

	/**
	 * @dataProvider distanceToQuarterToneProvider
	 *
	 * @param float $distance
	 * @param Note  $a
	 * @param Note  $b
	 */
	public function testDistanceToQuarterTone(float $distance, Note $a, Note $b): void
	{
		self::assertEquals($distance, $a->distanceTo($b));
	}

	/**
	 * @return array[]
	 */
	public function distanceToSemitoneProvider(): array
	{
		$theorem = new Theorem();
		$theorem->setStep(Theorem::SEMITONE_STEPS);

		return [
			[3.5, $theorem->note('Bdbbb4'), $theorem->note('B4')],
			[3.0, $theorem->note('Bbbb4'), $theorem->note('B4')],
			[2.5, $theorem->note('Bdbb4'), $theorem->note('B4')],
			[2.0, $theorem->note('Bbb4'), $theorem->note('B4')],
			[1.5, $theorem->note('Bdb4'), $theorem->note('B4')],
			[1.0, $theorem->note('Bb4'), $theorem->note('B4')],
			[0.5, $theorem->note('Bd4'), $theorem->note('B4')],
			[0.0, $theorem->note('B4'), $theorem->note('B4')],
			[-0.5, $theorem->note('B+4'), $theorem->note('B4')],
			[-1.0, $theorem->note('B#4'), $theorem->note('B4')],
			[-1.5, $theorem->note('B+#4'), $theorem->note('B4')],
			[-2.0, $theorem->note('Bx4'), $theorem->note('B4')],
			[-2.5, $theorem->note('B+x4'), $theorem->note('B4')],
			[-3.0, $theorem->note('B#x4'), $theorem->note('B4')],
			[-3.5, $theorem->note('B+#x4'), $theorem->note('B4')],
		];
	}

	/**
	 * @dataProvider distanceToSemitoneProvider
	 *
	 * @param float $distance
	 * @param Note  $a
	 * @param Note  $b
	 */
	public function testDistanceToSemitone(float $distance, Note $a, Note $b): void
	{
		self::assertEquals($distance, $a->distanceTo($b));
	}

	/**
	 * @return array[]
	 */
	public function distanceToWholeToneProvider(): array
	{
		$theorem = new Theorem();
		$theorem->setStep(Theorem::WHOLE_TONE_STEPS);

		return [
			[1.75, $theorem->note('Cdbbb4'), $theorem->note('C4')],
			[1.5, $theorem->note('Cbbb4'), $theorem->note('C4')],
			[1.25, $theorem->note('Cdbb4'), $theorem->note('C4')],
			[1.0, $theorem->note('Cbb4'), $theorem->note('C4')],
			[0.75, $theorem->note('Cdb4'), $theorem->note('C4')],
			[0.5, $theorem->note('Cb4'), $theorem->note('C4')],
			[0.25, $theorem->note('Cd4'), $theorem->note('C4')],
			[0.0, $theorem->note('C4'), $theorem->note('C4')],
			[-0.25, $theorem->note('C+4'), $theorem->note('C4')],
			[-0.5, $theorem->note('C#4'), $theorem->note('C4')],
			[-0.75, $theorem->note('C+#4'), $theorem->note('C4')],
			[-1.0, $theorem->note('Cx4'), $theorem->note('C4')],
			[-1.25, $theorem->note('C+x4'), $theorem->note('C4')],
			[-1.5, $theorem->note('C#x4'), $theorem->note('C4')],
			[-1.75, $theorem->note('C+#x4'), $theorem->note('C4')],
		];
	}

	/**
	 * @dataProvider distanceToWholeToneProvider
	 *
	 * @param float $distance
	 * @param Note  $a
	 * @param Note  $b
	 */
	public function testDistanceToWholeTone(float $distance, Note $a, Note $b): void
	{
		self::assertEquals($distance, $a->distanceTo($b));
	}
}
