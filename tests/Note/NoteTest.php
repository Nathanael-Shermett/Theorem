<?php

namespace Note;

use PHPUnit\Framework\TestCase;
use Theorem\Theorem;

class NoteTest extends TestCase
{
	public function testDistanceTo(): void
	{
		$theorem = new Theorem();
		$theorem->setStep(Theorem::QUARTER_TONE_STEPS);

		self::assertEquals(7.0, $theorem->note('Adbbb4')->distanceTo($theorem->note('A4')));
		self::assertEquals(6.0, $theorem->note('Abbb4')->distanceTo($theorem->note('A4')));
		self::assertEquals(5.0, $theorem->note('Adbb4')->distanceTo($theorem->note('A4')));
		self::assertEquals(4.0, $theorem->note('Abb4')->distanceTo($theorem->note('A4')));
		self::assertEquals(3.0, $theorem->note('Adb4')->distanceTo($theorem->note('A4')));
		self::assertEquals(2.0, $theorem->note('Ab4')->distanceTo($theorem->note('A4')));
		self::assertEquals(1.0, $theorem->note('Ad4')->distanceTo($theorem->note('A4')));
		self::assertEquals(0.0, $theorem->note('A4')->distanceTo($theorem->note('A4')));
		self::assertEquals(-1.0, $theorem->note('A+4')->distanceTo($theorem->note('A4')));
		self::assertEquals(-2.0, $theorem->note('A#4')->distanceTo($theorem->note('A4')));
		self::assertEquals(-3.0, $theorem->note('A+#4')->distanceTo($theorem->note('A4')));
		self::assertEquals(-4.0, $theorem->note('Ax4')->distanceTo($theorem->note('A4')));
		self::assertEquals(-5.0, $theorem->note('A+x4')->distanceTo($theorem->note('A4')));
		self::assertEquals(-6.0, $theorem->note('A#x4')->distanceTo($theorem->note('A4')));
		self::assertEquals(-7.0, $theorem->note('A+#x4')->distanceTo($theorem->note('A4')));

		$theorem->setStep(Theorem::SEMITONE_STEPS);

		self::assertEquals(3.5, $theorem->note('Bdbbb4')->distanceTo($theorem->note('B4')));
		self::assertEquals(3.0, $theorem->note('Bbbb4')->distanceTo($theorem->note('B4')));
		self::assertEquals(2.5, $theorem->note('Bdbb4')->distanceTo($theorem->note('B4')));
		self::assertEquals(2.0, $theorem->note('Bbb4')->distanceTo($theorem->note('B4')));
		self::assertEquals(1.5, $theorem->note('Bdb4')->distanceTo($theorem->note('B4')));
		self::assertEquals(1.0, $theorem->note('Bb4')->distanceTo($theorem->note('B4')));
		self::assertEquals(0.5, $theorem->note('Bd4')->distanceTo($theorem->note('B4')));
		self::assertEquals(0.0, $theorem->note('B4')->distanceTo($theorem->note('B4')));
		self::assertEquals(-0.5, $theorem->note('B+4')->distanceTo($theorem->note('B4')));
		self::assertEquals(-1.0, $theorem->note('B#4')->distanceTo($theorem->note('B4')));
		self::assertEquals(-1.5, $theorem->note('B+#4')->distanceTo($theorem->note('B4')));
		self::assertEquals(-2.0, $theorem->note('Bx4')->distanceTo($theorem->note('B4')));
		self::assertEquals(-2.5, $theorem->note('B+x4')->distanceTo($theorem->note('B4')));
		self::assertEquals(-3.0, $theorem->note('B#x4')->distanceTo($theorem->note('B4')));
		self::assertEquals(-3.5, $theorem->note('B+#x4')->distanceTo($theorem->note('B4')));

		$theorem->setStep(Theorem::WHOLE_TONE_STEPS);

		self::assertEquals(1.75, $theorem->note('Cdbbb4')->distanceTo($theorem->note('C4')));
		self::assertEquals(1.5, $theorem->note('Cbbb4')->distanceTo($theorem->note('C4')));
		self::assertEquals(1.25, $theorem->note('Cdbb4')->distanceTo($theorem->note('C4')));
		self::assertEquals(1.0, $theorem->note('Cbb4')->distanceTo($theorem->note('C4')));
		self::assertEquals(0.75, $theorem->note('Cdb4')->distanceTo($theorem->note('C4')));
		self::assertEquals(0.5, $theorem->note('Cb4')->distanceTo($theorem->note('C4')));
		self::assertEquals(0.25, $theorem->note('Cd4')->distanceTo($theorem->note('C4')));
		self::assertEquals(0.0, $theorem->note('C4')->distanceTo($theorem->note('C4')));
		self::assertEquals(-0.25, $theorem->note('C+4')->distanceTo($theorem->note('C4')));
		self::assertEquals(-0.5, $theorem->note('C#4')->distanceTo($theorem->note('C4')));
		self::assertEquals(-0.75, $theorem->note('C+#4')->distanceTo($theorem->note('C4')));
		self::assertEquals(-1.0, $theorem->note('Cx4')->distanceTo($theorem->note('C4')));
		self::assertEquals(-1.25, $theorem->note('C+x4')->distanceTo($theorem->note('C4')));
		self::assertEquals(-1.5, $theorem->note('C#x4')->distanceTo($theorem->note('C4')));
		self::assertEquals(-1.75, $theorem->note('C+#x4')->distanceTo($theorem->note('C4')));
	}
}
