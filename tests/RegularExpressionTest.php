<?php

use PHPUnit\Framework\TestCase;
use Theorem\Accidental;
use Theorem\Accidental\AccidentalFactory;
use Theorem\RegularExpression;

class RegularExpressionTest extends TestCase
{
	public function testParseScientificNoteNotation()
	{
		// Ascending letters, ascending octaves, mixed accidentals.
		$regex = RegularExpression::parseScientificNoteNotation('A-1', $output);
		$this->assertTrue($regex);
		$this->assertEquals('A', $output['letter']);
		$this->assertInstanceOf(Accidental\Natural::class, $output['accidental']);
		$this->assertEquals(-1, $output['octave']);

		$regex = RegularExpression::parseScientificNoteNotation('Bd0', $output);
		$this->assertTrue($regex);
		$this->assertEquals('B', $output['letter']);
		$this->assertInstanceOf(Accidental\HalfFlat::class, $output['accidental']);
		$this->assertEquals(0, $output['octave']);

		$regex = RegularExpression::parseScientificNoteNotation('C+b1', $output);
		$this->assertTrue($regex);
		$this->assertEquals('C', $output['letter']);
		$this->assertInstanceOf(Accidental\HalfFlat::class, $output['accidental']);
		$this->assertEquals(1, $output['octave']);

		$regex = RegularExpression::parseScientificNoteNotation('Dbb2', $output);
		$this->assertTrue($regex);
		$this->assertEquals('D', $output['letter']);
		$this->assertInstanceOf(Accidental\DoubleFlat::class, $output['accidental']);
		$this->assertEquals(2, $output['octave']);

		$regex = RegularExpression::parseScientificNoteNotation('Edbb3', $output);
		$this->assertTrue($regex);
		$this->assertEquals('E', $output['letter']);
		$this->assertInstanceOf(Accidental\FiveQuarterFlat::class, $output['accidental']);
		$this->assertEquals(3, $output['octave']);

		RegularExpression::parseScientificNoteNotation('F#4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('F', $output['letter']);
		$this->assertInstanceOf(Accidental\Sharp::class, $output['accidental']);
		$this->assertEquals(4, $output['octave']);

		$regex = RegularExpression::parseScientificNoteNotation('G+#x5', $output);
		$this->assertTrue($regex);
		$this->assertEquals('G', $output['letter']);
		$this->assertInstanceOf(Accidental\Special::class, $output['accidental']);
		$this->assertEquals(5, $output['octave']);

		// Invalid expressions.
		$regex = RegularExpression::parseScientificNoteNotation('A', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('b', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('Ab', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('b4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('Add4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A##4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A++4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('Ax#4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A#+4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A+x#4', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A-0', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A-', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A4-', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation('A4 ', $output);
		$this->assertFalse($regex);

		$regex = RegularExpression::parseScientificNoteNotation(4, $output);
		$this->assertFalse($regex);
	}

	public function testParseAccidental()
	{
		// Matching quarter tone part.
		$quarterTone = RegularExpression::parseQuarterTonePart('+');
		$this->assertEquals('+', $quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('+bb');
		$this->assertEquals('+', $quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('d');
		$this->assertEquals('d', $quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('d#xxxx');
		$this->assertEquals('d', $quarterTone);

		// No quarter tone part.
		$quarterTone = RegularExpression::parseQuarterTonePart('bb');
		$this->assertNull($quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('#');
		$this->assertNull($quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('x');
		$this->assertNull($quarterTone);

		// Invalid expressions.
		$quarterTone = RegularExpression::parseQuarterTonePart('d+');
		$this->assertFalse($quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('++b');
		$this->assertFalse($quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('dbd');
		$this->assertFalse($quarterTone);

		$quarterTone = RegularExpression::parseQuarterTonePart('x#');
		$this->assertFalse($quarterTone);
	}
}