<?php

use PHPUnit\Framework\TestCase;
use Theorem\Note;
use Theorem\Setting;

class NoteTest extends TestCase
{
	public function testDistanceTo()
	{
		Setting::setStep(SETTING::QUARTER_TONE);
		$this->assertEquals(7.0, (new Note('Adbbb4'))->distanceTo(new Note('A4')));
		$this->assertEquals(6.0, (new Note('Abbb4'))->distanceTo(new Note('A4')));
		$this->assertEquals(5.0, (new Note('Adbb4'))->distanceTo(new Note('A4')));
		$this->assertEquals(4.0, (new Note('Abb4'))->distanceTo(new Note('A4')));
		$this->assertEquals(3.0, (new Note('Adb4'))->distanceTo(new Note('A4')));
		$this->assertEquals(2.0, (new Note('Ab4'))->distanceTo(new Note('A4')));
		$this->assertEquals(1.0, (new Note('Ad4'))->distanceTo(new Note('A4')));
		$this->assertEquals(0.0, (new Note('A4'))->distanceTo(new Note('A4')));
		$this->assertEquals(-1.0, (new Note('A+4'))->distanceTo(new Note('A4')));
		$this->assertEquals(-2.0, (new Note('A#4'))->distanceTo(new Note('A4')));
		$this->assertEquals(-3.0, (new Note('A+#4'))->distanceTo(new Note('A4')));
		$this->assertEquals(-4.0, (new Note('Ax4'))->distanceTo(new Note('A4')));
		$this->assertEquals(-5.0, (new Note('A+x4'))->distanceTo(new Note('A4')));
		$this->assertEquals(-6.0, (new Note('A#x4'))->distanceTo(new Note('A4')));
		$this->assertEquals(-7.0, (new Note('A+#x4'))->distanceTo(new Note('A4')));

		Setting::setStep(SETTING::SEMITONE);
		$this->assertEquals(3.5, (new Note('Bdbbb4'))->distanceTo(new Note('B4')));
		$this->assertEquals(3.0, (new Note('Bbbb4'))->distanceTo(new Note('B4')));
		$this->assertEquals(2.5, (new Note('Bdbb4'))->distanceTo(new Note('B4')));
		$this->assertEquals(2.0, (new Note('Bbb4'))->distanceTo(new Note('B4')));
		$this->assertEquals(1.5, (new Note('Bdb4'))->distanceTo(new Note('B4')));
		$this->assertEquals(1.0, (new Note('Bb4'))->distanceTo(new Note('B4')));
		$this->assertEquals(0.5, (new Note('Bd4'))->distanceTo(new Note('B4')));
		$this->assertEquals(0.0, (new Note('B4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-0.5, (new Note('B+4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-1.0, (new Note('B#4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-1.5, (new Note('B+#4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-2.0, (new Note('Bx4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-2.5, (new Note('B+x4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-3.0, (new Note('B#x4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-3.5, (new Note('B+#x4'))->distanceTo(new Note('B4')));

		Setting::setStep(SETTING::WHOLE_TONE);
		$this->assertEquals(1.75, (new Note('Cdbbb4'))->distanceTo(new Note('C4')));
		$this->assertEquals(1.5, (new Note('Cbbb4'))->distanceTo(new Note('C4')));
		$this->assertEquals(1.25, (new Note('Cdbb4'))->distanceTo(new Note('C4')));
		$this->assertEquals(1.0, (new Note('Cbb4'))->distanceTo(new Note('C4')));
		$this->assertEquals(0.75, (new Note('Cdb4'))->distanceTo(new Note('C4')));
		$this->assertEquals(0.5, (new Note('Cb4'))->distanceTo(new Note('C4')));
		$this->assertEquals(0.25, (new Note('Cd4'))->distanceTo(new Note('C4')));
		$this->assertEquals(0.0, (new Note('C4'))->distanceTo(new Note('C4')));
		$this->assertEquals(-0.25, (new Note('C+4'))->distanceTo(new Note('C4')));
		$this->assertEquals(-0.5, (new Note('C#4'))->distanceTo(new Note('C4')));
		$this->assertEquals(-0.75, (new Note('C+#4'))->distanceTo(new Note('C4')));
		$this->assertEquals(-1.0, (new Note('Cx4'))->distanceTo(new Note('C4')));
		$this->assertEquals(-1.25, (new Note('C+x4'))->distanceTo(new Note('C4')));
		$this->assertEquals(-1.5, (new Note('C#x4'))->distanceTo(new Note('C4')));
		$this->assertEquals(-1.75, (new Note('C+#x4'))->distanceTo(new Note('C4')));
	}
}
