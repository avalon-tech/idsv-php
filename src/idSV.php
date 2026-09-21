<?php

namespace avalontechsv\idSV;
use avalontechsv\idSV\Exceptions\InvalidDUIException;
use avalontechsv\idSV\Exceptions\InvalidNITException;

class idSV {
    /**
     * Clean a document string
     *
     * @param string $document
     * @return string
     */
    private function cleanDocument(string $document): string
    {
        // Trim to remove spaces at the beginning and end of the string
        $document = trim($document);

        // Remove dash from document
        $document = str_replace('-', '', $document);

        return $document;
    }

    /**
     * Check if a DUI is valid
     *
     * @param string $dui
     * @return bool
     */
    public function isValidDUI(?string $dui): bool
    {
        // DUI cannot be null
        if (is_null($dui)) {
            return false;
        }

        // DUI cannot be empty
        if (empty($dui)) {
            return false;
        }

        $dui = $this->cleanDocument($dui);

        // DUI must be made of digits only
        if (!ctype_digit($dui)) {
            return false;
        }

        // Pad DUI with zeros to the left, if it's less than 9 characters long
        $dui = str_pad($dui, 9, '0', STR_PAD_LEFT);

        // DUI must be 9 characters long
        if (strlen($dui) != 9) {
            return false;
        }

        // DUI must have a valid check digit
        $checkDigit = substr($dui, -1);

        $duiWithoutCheckDigit = substr($dui, 0, -1);

        $sum = 0;

        for ($i = 0; $i < strlen($duiWithoutCheckDigit); $i++) {
            $sum += $duiWithoutCheckDigit[$i] * (9 - $i);
        }

        $expectedCheckDigit = 10 - ($sum % 10);

        if ($expectedCheckDigit == 10) {
            $expectedCheckDigit = 0;
        }

        if ($checkDigit != $expectedCheckDigit) {
            return false;
        }

        return true;
    }

    /**
     * Check if a NIT is valid. You may disable the validation of DUIs in this function passing false as a second argument.
     *
     * @param string $nit
     * @param bool $allowDUI = true
     * @return bool
     */
    public function isValidNIT(?string $nit, bool $allowDUI = true): bool
    {
        // Since December 17th, 2021, DUIs are valid NITs, so isValidDUI() can be used
        // if $nit is a DUI. If you want to make a strict NIT validation without taking
        // DUIs as valid, pass false to $allowDUI.
        if ($this->isValidDUI($nit) && $allowDUI) {
            return true;
        }

        // NIT cannot be null
        if (is_null($nit)) {
            return false;
        }

        // NIT cannot be empty
        if (empty($nit)) {
            return false;
        }

        $nit = $this->cleanDocument($nit);

        // NIT must be made of digits only
        if (!ctype_digit($nit)) {
            return false;
        }

        // Pad NIT with zeros to the left, if it's less than 14 characters long
        $nit = str_pad($nit, 14, '0', STR_PAD_LEFT);

        // NIT must be 14 characters long
        if (strlen($nit) != 14) {
            return false;
        }

        // Initialize variables
        $sum = 0;
        $calculatedCheckDigit = 0;
        $calculatedFactor = 0;

        // Validate if it's an old (<= 100) or new (>= 100) NIT
        if (intval(substr($nit, 10, 3)) <= 100) { // Old routine
            for ($i = 1; $i <= 13; $i++) {
                $sum += intval(substr($nit, $i - 1, 1)) * (15 - $i);
            }
            $calculatedCheckDigit = $sum % 11;
            if ($calculatedCheckDigit == 10) {
                $calculatedCheckDigit = 0;
            }
        } else { // New routine
            for ($i = 1; $i <= 13; $i++) {
                $calculatedFactor = (3 + (6 * floor(abs(($i + 4) / 6)))) - $i;
                $sum += intval(substr($nit, $i - 1, 1)) * $calculatedFactor;
            }
            $calculatedCheckDigit = $sum % 11;
            if ($calculatedCheckDigit > 1) {
                $calculatedCheckDigit = 11 - $calculatedCheckDigit;
            } else {
                $calculatedCheckDigit = 0;
            }
        }

        return $calculatedCheckDigit == intval(substr($nit, 13, 1));
    }

    /**
     * Format a DUI
     *
     * @param string $unformatted
     * @return string
     * @throws InvalidDUIException
     */
    public function formatDUI(?string $unformatted)
    {
        $unformatted = $this->cleanDocument($unformatted);

        // Pad DUI with zeros to the left, if it's less than 9 characters long
        $unformatted = str_pad($unformatted, 9, '0', STR_PAD_LEFT);

        $validated = $this->isValidDUI($unformatted);

        if(!$validated){
            throw new InvalidDUIException();
        }

        $formatted = substr($unformatted, 0, 8) . '-' . substr($unformatted, 8, 1);

        return $formatted;
    }

    /**
     * Format a NIT. You may disable DUI formatting in this function passing false as a second argument.
     *
     * @param string $unformatted
     * @param bool $allowDUI = true
     * @return string
     * @throws InvalidNITException
     * @throws InvalidDUIException
     */
    public function formatNIT(?string $unformatted, bool $allowDUI = true)
    {
        if($allowDUI){
            $unformatted = $this->cleanDocument($unformatted);

            // If $unformatted is less than 8 characters long, it could be a DUI, pad it first
            $unformatted = str_pad($unformatted, 9, '0', STR_PAD_LEFT);

            $is_dui = $this->isValidDUI($unformatted);

            if($is_dui){
                return $this->formatDUI($unformatted);
            }
        }

        // Pad NIT with zeros to the left, if it's less than 14 characters long
        $unformatted = str_pad($unformatted, 14, '0', STR_PAD_LEFT);

        $validated = $this->isValidNIT($unformatted, false);

        if(!$validated){
            throw new InvalidNITException();
        }

        $formatted = substr($unformatted, 0, 4) . '-' . substr($unformatted, 4, 6) . '-' . substr($unformatted, 10, 3) . '-' . substr($unformatted, 13, 1);

        return $formatted;
    }
}