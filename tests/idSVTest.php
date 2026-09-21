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
                $this->assertTrue($validator->isValidDUI('00000000-0'));
        }

        public function testValidatorReturnsTrueForValidDUIWithoutDash() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidDUI('000000000'));
        }

        public function testValidatorReturnsFalseForInvalidDUIWithDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('00000000-1'));
        }

        public function testValidatorReturnsFalseForInvalidDUIWithoutDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('000000001'));
        }

        public function testValidatorReturnsFalseForEmptyDUI() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI(''));
        }

        public function testValidatorReturnsTrueForValidDUIWithSpaces() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidDUI(' 00000000-0 '));
        }

        public function testValidatorReturnsFalseForInvalidDUIWithSpaces() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI(' 00000000-1 '));
        }

        public function testValidatorReturnsFalseForDUIWithLetters() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('00000000-A'));
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
                $this->assertFalse($validator->isValidDUI('0000000000'));
        }

        public function testValidatorReturnsTrueForTrimmedValidDUI() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidDUI('00'));
        }

        public function testValidatorReturnsFalseForTrimmedInvalidDUI() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidDUI('01'));
        }

        public function testValidatorReturnsTrueForValidNITWithDash() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNIT('0000-000000-000-0'));
        }

        public function testValidatorReturnsTrueForValidNITWithoutDash() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNIT('00000000000000'));
        }

        public function testValidatorReturnsFalseForInvalidNITWithDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('0000-000000-000-1'));
        }

        public function testValidatorReturnsFalseForInvalidNITWithoutDash() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('00000000000001'));
        }

        public function testValidatorReturnsFalseForEmptyNIT() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT(''));
        }

        public function testValidatorReturnsTrueForValidNITWithSpaces() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNIT(' 0000-000000-000-0 '));
        }

        public function testValidatorReturnsFalseForInvalidNITWithSpaces() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT(' 0000-000000-000-1 '));
        }

        public function testValidatorReturnsFalseForNITWithLetters() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('0000-000000-000-A'));
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
                $this->assertTrue($validator->isValidNIT('000000000'));
        }

        public function testValidatorReturnsFalseForInvalidNITinDUIFormat() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('000000001'));
        }

        public function testValidatorReturnsFalseForNITWithMoreThan17Characters() {
                $validator = new idSV();
                $this->assertFalse($validator->isValidNIT('00000000000000000'));
        }

        public function testValidatorReturnsTrueForDUIinNITValidation() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNit('00000000-0'));
        }

        public function testValidatorReturnsFalseForDUIinNITValidationIfDUIsAreNotAllowed() {
                $validator = new idSV();
                $this->assertTrue($validator->isValidNit('00000000-0', true));
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
                $this->assertEquals('00000000-0', $validator->formatDUI('000000000'));
        }

        public function testFormatterReturnsFormattedNIT() {
                $validator = new idSV();
                $this->assertEquals('0000-000000-000-0', $validator->formatNIT('00000000000000'));
        }

        public function testFormatterReturnsFormattedNITinDUIFormat() {
                $validator = new idSV();
                $this->assertEquals('00000000-0', $validator->formatNIT('000000000'));
        }

        public function testFormatterReturnsFormattedNITinNITFormatWhenAsked() {
                $validator = new idSV();
                $this->assertEquals('0000-000000-000-0', $validator->formatNIT('000000000', false));
        }

        public function testFormatterThrowsExceptionForInvalidDUI() {
                $validator = new idSV();
                $this->expectException(InvalidDUIException::class);
                $validator->formatDUI('000000001');
        }

        public function testFormatterThrowsExceptionForInvalidNIT() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT('00000000000001');
        }

        public function testFormatterThrowsExceptionForInvalidNITinDUIFormat() {
                $validator = new idSV();
                $this->expectException(InvalidNITException::class);
                $validator->formatNIT('000000001');
        }

        public function testFormatterReturnsFormattedDUIIfShorterStringProvided(){
                $validator = new idSV();
                $this->assertEquals('00000000-0', $validator->formatDUI('00'));
        }

        public function testFormatterReturnsFormattedNITIfShorterStringProvided(){
                $validator = new idSV();
                $this->assertEquals('0000-000000-000-0', $validator->formatNIT('00', false));
        }
}