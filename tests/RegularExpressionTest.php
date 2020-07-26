<?php

use Theorem\Accidental;
use Theorem\RegularExpression;
use PHPUnit\Framework\TestCase;

class RegularExpressionTest extends TestCase
{
	public function testParseScientificNoteNotation()
	{
		$regex = RegularExpression::ParseScientificNoteNotation('A4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('A', $output['letter']);
		$this->assertInstanceOf(Accidental\Natural::class, $output['accidental']);
		$this->assertEquals(4, $output['octave']);
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('Ab4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('A', $output['letter']);
		$this->assertInstanceOf(Accidental\Flat::class, $output['accidental']);
		$this->assertEquals(4, $output['octave']);
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('Abb4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('A', $output['letter']);
		$this->assertInstanceOf(Accidental\DoubleFlat::class, $output['accidental']);
		$this->assertEquals(4, $output['octave']);
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('A-4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('A', $output['letter']);
		$this->assertInstanceOf(Accidental\Natural::class, $output['accidental']);
		$this->assertEquals(-4, $output['octave']);
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('C4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('C', $output['letter']);
		$this->assertInstanceOf(Accidental\Natural::class, $output['accidental']);
		$this->assertEquals(4, $output['octave']);
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('A0', $output);
		$this->assertTrue($regex);
		$this->assertEquals('A', $output['letter']);
		$this->assertInstanceOf(Accidental\Natural::class, $output['accidental']);
		$this->assertEquals(0, $output['octave']);
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('A', $output);
		$this->assertFalse($regex);
		$this->assertFalse(isset($output));
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('4', $output);
		$this->assertFalse($regex);
		$this->assertFalse(isset($output));
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('Abbb4', $output);
		$this->assertFalse($regex);
		$this->assertFalse(isset($output));
		unset($output);

		$regex = RegularExpression::ParseScientificNoteNotation('A##4', $output);
		$this->assertFalse($regex);
		$this->assertFalse(isset($output));
		unset($output);
	}
}
