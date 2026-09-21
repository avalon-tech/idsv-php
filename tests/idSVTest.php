<?php

namespace avalontechsv\idSV\Tests;

use PHPUnit\Framework\TestCase;
use avalontechsv\idSV\idSV;
use avalontechsv\idSV\Exceptions\InvalidDUIException;
use avalontechsv\idSV\Exceptions\InvalidNITException;

class idSVTest extends TestCase {
        public function testInstantiationOfidSV() {
                $validator = new idSV();
                $this->assertInstanceOf(idSV::class, $validator);
        }

        public function testValidatorReturnsTrueForValidDUIWithDash() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidDUI('12345678-4'));
        }

        public function testValidatorReturnsTrueForValidDUIWithoutDash() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidDUI('123456784'));
        }

        public function testValidatorReturnsFalseForInvalidDUIWithDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('12345678-9'));
        }

        public function testValidatorReturnsFalseForInvalidDUIWithoutDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('123456789'));
        }

        public function testValidatorReturnsFalseForEmptyDUI() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI(''));
        }

        public function testValidatorReturnsTrueForValidDUIWithSpaces() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidDUI(' 12345678-4 '));
        }

        public function testValidatorReturnsFalseForInvalidDUIWithSpaces() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI(' 12345678-9 '));
        }

        public function testValidatorReturnsFalseForDUIWithLetters() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('12345678-A'));
        }

        public function testValidatorReturnsFalseForDUIInNumericNotation() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('1e5'));
                $this->assertFalse($validator->isValidDUI('1.5'));
                $this->assertFalse($validator->isValidDUI('+12'));
                $this->assertFalse($validator->isValidDUI('12 34'));
        }

        public function testValidatorReturnsFalseForDUIWithMoreThan10Characters() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('1234567844'));
        }

        public function testValidatorReturnsTrueForTrimmedValidDUI() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidDUI('18'));
        }

        public function testValidatorReturnsFalseForTrimmedInvalidDUI() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('01'));
        }

        public function testValidatorReturnsTrueForValidNITWithDash() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNIT('1234-567890-123-0'));
        }

        public function testValidatorReturnsTrueForValidNITWithoutDash() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNIT('12345678901230'));
        }

        public function testValidatorReturnsFalseForInvalidNITWithDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('1234-567890-123-1'));
        }

        public function testValidatorReturnsFalseForInvalidNITWithoutDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('12345678901231'));
        }

        public function testValidatorReturnsFalseForEmptyNIT() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT(''));
        }

        public function testValidatorReturnsTrueForValidNITWithSpaces() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNIT(' 1234-567890-123-0 '));
        }

        public function testValidatorReturnsFalseForInvalidNITWithSpaces() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT(' 1234-567890-123-1 '));
        }

        public function testValidatorReturnsFalseForNITWithLetters() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('1234-567890-123-A'));
        }

        public function testValidatorReturnsFalseForNITInNumericNotation() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('1e5'));
                $this->assertFalse($validator->isValidNIT('1.5'));
                $this->assertFalse($validator->isValidNIT('+12'));
                $this->assertFalse($validator->isValidNIT('12 34'));
        }

        public function testValidatorReturnsTrueForValidNITinDUIFormat() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNIT('123456784'));
        }

        public function testValidatorReturnsFalseForInvalidNITinDUIFormat() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('123456789'));
        }

        public function testValidatorReturnsFalseForNITWithMoreThan17Characters() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('12345678901230000'));
        }

        public function testValidatorReturnsTrueForDUIinNITValidation() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNit('12345678-4'));
        }

        public function testValidatorReturnsFalseForDUIinNITValidationIfDUIsAreNotAllowed() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNit('12345678-4', true));
        }

        public function testValidatorReturnsFalseForNullDUI() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI(null));
        }

        public function testValidatorReturnsFalseForNullNIT() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT(null));
        }

        public function testFormatterReturnsFormattedDUI() {
                $validator = new idSV();
                $this->assertEquals('12345678-4', $validator->formatDUI('123456784'));
        }

        public function testFormatterReturnsFormattedNIT() {
                $validator = new idSV();
                $this->assertEquals('1234-567890-123-0', $validator->formatNIT('12345678901230'));
        }

        public function testFormatterReturnsFormattedNITinDUIFormat() {
                $validator = new idSV();
                $this->assertEquals('12345678-4', $validator->formatNIT('123456784'));
        }

        public function testFormatterReturnsFormattedNITinNITFormatWhenAsked() {
                $validator = new idSV();
                $this->assertEquals('0000-000000-011-5', $validator->formatNIT('000000115', false));
        }

        public function testFormatterCleansDashedNITWhenDUIsAreNotAllowed() {
                $validator = new idSV();
                $this->assertEquals('1234-567890-123-0', $validator->formatNIT('1234-567890-123-0', false));
        }

        public function testFormatterTrimsNITWhenDUIsAreNotAllowed() {
                $validator = new idSV();
                $this->assertEquals('1234-567890-123-0', $validator->formatNIT(' 12345678901230 ', false));
        }

        public function testFormatterThrowsExceptionForInvalidDUI() {
                $validator = new idSV();
                $this->expectException(InvalidDUIException::class);
                $validator->formatDUI('123456789');
        }

        public function testFormatterThrowsExceptionForInvalidNIT() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT('12345678901231');
        }

        public function testFormatterThrowsExceptionForInvalidNITinDUIFormat() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT('123456789');
        }

        public function testFormatterThrowsExceptionForNullDUI() {
                $validator = new idSV();
                $this->expectException(InvalidDUIException::class);
                $validator->formatDUI(null);
        }

        public function testFormatterThrowsExceptionForEmptyDUI() {
                $validator = new idSV();
                $this->expectException(InvalidDUIException::class);
                $validator->formatDUI('');
        }

        public function testFormatterThrowsExceptionForNullNIT() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT(null);
        }

        public function testFormatterThrowsExceptionForNullNITIfDUIsAreNotAllowed() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT(null, false);
        }

        public function testFormatterThrowsExceptionForEmptyNIT() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT('');
        }

        public function testFormatterThrowsExceptionForEmptyNITIfDUIsAreNotAllowed() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT('', false);
        }

        public function testFormatterReturnsFormattedDUIIfShorterStringProvided(){
                $validator = new idSV();
                $this->assertEquals('00000001-8', $validator->formatDUI('18'));
        }

        public function testFormatterReturnsFormattedNITIfShorterStringProvided(){
                $validator = new idSV();
                $this->assertEquals('0000-000000-011-5', $validator->formatNIT('115', false));
        }

        public function testValidatorReturnsFalseForDUIWithOnlyZeros() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('00000000-0'));
                $this->assertFalse($validator->isValidDUI('000000000'));
                $this->assertFalse($validator->isValidDUI('00'));
        }

        public function testValidatorReturnsFalseForNITWithOnlyZeros() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('0000-000000-000-0'));
                $this->assertFalse($validator->isValidNIT('00000000000000'));
                $this->assertFalse($validator->isValidNIT('00'));
                $this->assertFalse($validator->isValidNIT('00000000000000', false));
        }

        public function testFormatterThrowsExceptionForDUIWithOnlyZeros() {
                $validator = new idSV();
                $this->expectException(InvalidDUIException::class);
                $validator->formatDUI('000000000');
        }

        public function testFormatterThrowsExceptionForNITWithOnlyZeros() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT('00000000000000');
        }
}