<?php

use avalontechsv\idSV\idSV;

require_once 'vendor/autoload.php';

$validator = new idSV();

// DUI validation
// Validate DUI in the format 00000000-0
var_dump($validator->isValidDUI('12345678-4')); // true
var_dump($validator->isValidDUI('12345678-9')); // false

// Validate DUI in the format 000000000
var_dump($validator->isValidDUI('123456784')); // true
var_dump($validator->isValidDUI('123456789')); // false

// The library will automatically trim the input.
// This is useful when you are validating user input.
var_dump($validator->isValidDUI(' 123456784 ')); // true

// NIT validation
// Validate NIT in the format 0000-000000-000-0
var_dump($validator->isValidNIT('1234-567890-123-0')); // true
var_dump($validator->isValidNIT('1234-567890-123-1')); // false

// Validate NIT in the format 00000000000000
var_dump($validator->isValidNIT('12345678901230')); // true
var_dump($validator->isValidNIT('12345678901231')); // false

// Also, you can validate NITs for natural persons
// in the DUI format.
var_dump($validator->isValidNIT('12345678-4')); // true
var_dump($validator->isValidNIT('12345678-9')); // false

// The library will automatically trim the input.
// This is useful when you are validating user input.
var_dump($validator->isValidNIT(' 12345678901230 ')); // true

// DUI and NIT can also be null
var_dump($validator->isValidDUI(null)); // false
var_dump($validator->isValidNIT(null)); // false

// Documents made only of zeros do not exist, so they are never valid
var_dump($validator->isValidDUI('00000000-0')); // false
var_dump($validator->isValidNIT('0000-000000-000-0')); // false

// DUI and NIT formatting

// Format DUI in the format 000000000
var_dump($validator->formatDUI('123456784')); // 12345678-4

// Shorter strings will be padded with zeros
var_dump($validator->formatDUI('18')); // 00000001-8

// If a DUI was already formatted, it will be returned as is
var_dump($validator->formatDUI('12345678-4')); // 12345678-4

// Invalid DUIs generate an exception
try { $validator->formatDUI('123456789'); } catch (\Exception $e) { echo 'Exception: ' . $e->getMessage(); } // Exception: Invalid DUI

// Format NIT in the format 00000000000000
var_dump($validator->formatNIT('12345678901230')); // 1234-567890-123-0

// If a NIT was already formatted, it will be returned as is
var_dump($validator->formatNIT('1234-567890-123-0')); // 1234-567890-123-0

// Valid DUIs will be formatted as DUI in the NIT formatter by default
var_dump($validator->formatNIT('000000115')); // 00000011-5

// You can force the NIT formatter to disallow DUIs too
var_dump($validator->formatNIT('000000115', false)); // 0000-000000-011-5

// Padding is also applied to NITs
var_dump($validator->formatNIT('115', false)); // 0000-000000-011-5

// Invalid NITs generate an exception
try { $validator->formatNIT('12345678901231'); } catch (\Exception $e) { echo 'Exception: ' . $e->getMessage() . '\n';  } // Exception: Invalid NIT
