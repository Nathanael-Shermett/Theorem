<?php

use PHPUnit\Framework\TestCase;
use Theorem\Accidental;
use Theorem\Accidental\AccidentalFactory;
use Theorem\RegularExpression;

class RegularExpressionTest extends TestCase
{
	public function testParseScientificNoteNotation()
	{
		$accidentalFactory = new AccidentalFactory();

		$regex = RegularExpression::parseScientificNoteNotation('A4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('A', $output['letter']);
		$this->assertInstanceOf(Accidental\Natural::class, $accidentalFactory->createFromString($output['accidental'])
																			 ->build());
		$this->assertEquals(4, $output['octave']);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('Cdb-4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('C', $output['letter']);
		$this->assertInstanceOf(Accidental\ThreeQuarterFlat::class, $accidentalFactory->createFromString($output['accidental'])
																					  ->build());
		$this->assertEquals(-4, $output['octave']);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('Gbbb4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('G', $output['letter']);
		$this->assertInstanceOf(Accidental\TripleFlat::class, $accidentalFactory->createFromString($output['accidental'])
																				->build());
		$this->assertEquals(4, $output['octave']);
		unset($output);
		$regex = RegularExpression::parseScientificNoteNotation('Gbbbb4', $output);
		$this->assertTrue($regex);
		$this->assertEquals('G', $output['letter']);
		$this->assertInstanceOf(Accidental\Special::class, $accidentalFactory->createFromString($output['accidental'])
																			 ->build());
		$this->assertEquals(4, $output['octave']);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('F+x-8', $output);
		$this->assertTrue($regex);
		$this->assertEquals('F', $output['letter']);
		$this->assertInstanceOf(Accidental\FiveQuarterSharp::class, $accidentalFactory->createFromString($output['accidental'])
																					  ->build());
		$this->assertEquals(-8, $output['octave']);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('A', $output);
		$this->assertFalse($regex);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('b', $output);
		$this->assertFalse($regex);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('4', $output);
		$this->assertFalse($regex);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('A##4', $output);
		$this->assertFalse($regex);
		unset($output);

		$regex = RegularExpression::parseScientificNoteNotation('Abb4', $output);
		$this->assertTrue($regex);
		unset($output);
	}
}
