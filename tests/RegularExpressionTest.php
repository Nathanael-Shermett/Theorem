<?php

use PHPUnit\Framework\TestCase;

use Theorem\Theorem;
use Theorem\RegularExpression;

use Theorem\Accidental\FiveQuarterFlat;
use Theorem\Accidental\DoubleFlat;
use Theorem\Accidental\HalfFlat;
use Theorem\Accidental\Natural;
use Theorem\Accidental\Sharp;
use Theorem\Accidental\Special;

class RegularExpressionTest extends TestCase
{
	public function testParseScientificNoteNotation(): void
	{
		$theorem = new Theorem();
		$regularExpression = new RegularExpression($theorem);

		$output = [];

		// Ascending letters, ascending octaves, mixed accidentals.
		$regex = $regularExpression->parseScientificPitchNotation('A-1', $output);
		self::assertTrue($regex);
		self::assertEquals('A', $output['letter']);
		self::assertInstanceOf(Natural::class, $output['accidental']);
		self::assertEquals(-1, $output['octave']);

		$regex = $regularExpression->parseScientificPitchNotation('Bd0', $output);
		self::assertTrue($regex);
		self::assertEquals('B', $output['letter']);
		self::assertInstanceOf(HalfFlat::class, $output['accidental']);
		self::assertEquals(0, $output['octave']);

		$regex = $regularExpression->parseScientificPitchNotation('C+b1', $output);
		self::assertTrue($regex);
		self::assertEquals('C', $output['letter']);
		self::assertInstanceOf(HalfFlat::class, $output['accidental']);
		self::assertEquals(1, $output['octave']);

		$regex = $regularExpression->parseScientificPitchNotation('Dbb2', $output);
		self::assertTrue($regex);
		self::assertEquals('D', $output['letter']);
		self::assertInstanceOf(DoubleFlat::class, $output['accidental']);
		self::assertEquals(2, $output['octave']);

		$regex = $regularExpression->parseScientificPitchNotation('Edbb3', $output);
		self::assertTrue($regex);
		self::assertEquals('E', $output['letter']);
		self::assertInstanceOf(FiveQuarterFlat::class, $output['accidental']);
		self::assertEquals(3, $output['octave']);

		$regularExpression->parseScientificPitchNotation('F#4', $output);
		self::assertTrue($regex);
		self::assertEquals('F', $output['letter']);
		self::assertInstanceOf(Sharp::class, $output['accidental']);
		self::assertEquals(4, $output['octave']);

		$regex = $regularExpression->parseScientificPitchNotation('G+#x5', $output);
		self::assertTrue($regex);
		self::assertEquals('G', $output['letter']);
		self::assertInstanceOf(Special::class, $output['accidental']);
		self::assertEquals(5, $output['octave']);

		// Invalid expressions.
		$regex = $regularExpression->parseScientificPitchNotation('A', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('b', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('Ab', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('b4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('Add4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A##4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A++4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('Ax#4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A#+4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A+x#4', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A-0', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A-', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A4-', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation('A4 ', $output);
		self::assertFalse($regex);

		$regex = $regularExpression->parseScientificPitchNotation(4, $output);
		self::assertFalse($regex);
	}

	public function testParseAccidental(): void
	{
		$theorem = new Theorem();
		$regularExpression = new RegularExpression($theorem);

		// Matching quarter tone part.
		$quarterTone = $regularExpression->parseQuarterTonePart('+');
		self::assertEquals('+', $quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('+bb');
		self::assertEquals('+', $quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('d');
		self::assertEquals('d', $quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('d#xxxx');
		self::assertEquals('d', $quarterTone);

		// No quarter tone part.
		$quarterTone = $regularExpression->parseQuarterTonePart('bb');
		self::assertNull($quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('#');
		self::assertNull($quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('x');
		self::assertNull($quarterTone);

		// Invalid expressions.
		$quarterTone = $regularExpression->parseQuarterTonePart('d+');
		self::assertFalse($quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('++b');
		self::assertFalse($quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('dbd');
		self::assertFalse($quarterTone);

		$quarterTone = $regularExpression->parseQuarterTonePart('x#');
		self::assertFalse($quarterTone);
	}
}