<?php

declare(strict_types=1);

namespace Theorem\Tests;

use PHPUnit\Framework\TestCase;
use Theorem\Accidental\Accidental;
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
	/**
	 * @return array[]
	 */
	public function parseScientificPitchNotationProvider(): array
	{
		$theorem = new Theorem();

		return [
			['A-1', 'A', $theorem->accidental(''), -1],
			['Bd0', 'B', $theorem->accidental('d'), 0],
			['C+b1', 'C', $theorem->accidental('+b'), 1],
			['Dbb2', 'D', $theorem->accidental('bb'), 2],
			['Edbb3', 'E', $theorem->accidental('dbb'), 3],
			['F#4', 'F', $theorem->accidental('#'), 4],
			['G+#x5', 'G', $theorem->accidental('+#x'), 5],
		];
	}

	/**
	 * @dataProvider parseScientificPitchNotationProvider
	 */
	public function testParseScientificPitchNotation(string $spn, string $letter, Accidental $accidental, int $octave): void
	{
		$theorem           = new Theorem();
		$regularExpression = new RegularExpression($theorem);

		$output = [];

		// Ascending letters, ascending octaves, mixed accidentals.
		$match = $regularExpression->parseScientificPitchNotation($spn, $output);
		self::assertTrue($match);
		self::assertEquals($letter, $output['letter']);
		self::assertEquals($accidental, $output['accidental']);
		self::assertEquals($octave, $output['octave']);
	}

	/**
	 * @return array<int, array<string>>
	 */
	public function parseScientificPitchNotationInvalidProvider(): array
	{
		return [
			['A'],
			['4'],
			['b'],
			['Ab'],
			['b4'],
			['Add4'],
			['A##4'],
			['A++4'],
			['Ax#4'],
			['A#+4'],
			['A+x#4'],
			['A-0'],
			['A-'],
			['A4-'],
			['A4 '],
			['4'],
		];
	}

	/**
	 * @dataProvider parseScientificPitchNotationInvalidProvider
	 */
	public function testParseScientificPitchNotationInvalid(string $spn): void
	{
		$theorem           = new Theorem();
		$regularExpression = new RegularExpression($theorem);

		$output = [];

		$match = $regularExpression->parseScientificPitchNotation($spn, $output);
		self::assertFalse($match);
	}

	/**
	 * @return string[][]
	 */
	public function parseAccidentalQuarterTonePartProvider(): array
	{
		return [
			['+', '+'],
			['+bb', '+'],
			['d', 'd'],
			['d#xxxx', 'd'],
		];
	}

	/**
	 * @dataProvider parseAccidentalQuarterTonePartProvider
	 */
	public function testParseAccidentalQuarterTonePart(string $accidentalWithQuarterTone, string $quarterTonePart): void
	{
		$theorem           = new Theorem();
		$regularExpression = new RegularExpression($theorem);

		$match = $regularExpression->parseQuarterTonePart($accidentalWithQuarterTone);
		self::assertEquals($quarterTonePart, $match);
	}

	/**
	 * @return array<int, array<string>>
	 */
	public function parseAccidentalNoQuarterTonePartProvider(): array
	{
		return [
			['bb'],
			['#'],
			['x'],
		];
	}

	/**
	 * @dataProvider parseAccidentalNoQuarterTonePartProvider
	 */
	public function testParseAccidentalNoQuarterTonePartProvider(string $accidental): void
	{
		$theorem           = new Theorem();
		$regularExpression = new RegularExpression($theorem);

		$match = $regularExpression->parseQuarterTonePart($accidental);
		self::assertNull($match);
	}

	/**
	 * @return array<int, array<string>>
	 */
	public function parseAccidentalsInvalidProvider(): array
	{
		return [
			['d+'],
			['++b'],
			['dbd'],
			['x#'],
		];
	}

	/**
	 * @dataProvider parseAccidentalsInvalidProvider
	 */
	public function testParseAccidentalsInvalid(string $quarterTone): void
	{
		$theorem           = new Theorem();
		$regularExpression = new RegularExpression($theorem);

		$match = $regularExpression->parseQuarterTonePart($quarterTone);
		self::assertFalse($match);
	}
}
