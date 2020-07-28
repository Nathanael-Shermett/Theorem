<?php

use PHPUnit\Framework\TestCase;
use Theorem\Note;
use Theorem\Setting;

class NoteTest extends TestCase
{

	public function testDistanceTo()
	{
		Setting::setStep(SETTING::QUARTER_TONE);
		$this->assertEquals(2, (new Note('A4'))->distanceTo(new Note('Bb4')));
		$this->assertEquals(4, (new Note('A4'))->distanceTo(new Note('B4')));
		$this->assertEquals(-18, (new Note('A4'))->distanceTo(new Note('C4')));

		Setting::setStep(SETTING::SEMITONE);
		$this->assertEquals(0, (new Note('B4'))->distanceTo(new Note('Cb5')));
		$this->assertEquals(0, (new Note('B#4'))->distanceTo(new Note('C5')));
		$this->assertEquals(1, (new Note('B4'))->distanceTo(new Note('C5')));

		Setting::setStep(SETTING::WHOLE_TONE);
		$this->assertEquals(0, (new Note('C4'))->distanceTo(new Note('C4')));
		$this->assertEquals(1.5, (new Note('C4'))->distanceTo(new Note('D#4')));
		$this->assertEquals(1, (new Note('D4'))->distanceTo(new Note('E4')));
		$this->assertEquals(1.5, (new Note('D4'))->distanceTo(new Note('E#4')));
		$this->assertEquals(1.5, (new Note('D4'))->distanceTo(new Note('F4')));
		$this->assertEquals(2.5, (new Note('D4'))->distanceTo(new Note('Fx4')));
	}
}
