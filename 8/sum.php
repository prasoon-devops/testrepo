<?php

class PatternSumCalculator
{
    private int $digit;

    public function __construct($digit)
    {
        $this->validateInput($digit);
        $this->digit = (int) $digit;
    }

    /**
     * Validates that the input is a single digit between 0 and 9.
     */
    private function validateInput($digit): void
    {
        if (!is_numeric($digit) || (int)$digit != $digit) {
            throw new InvalidArgumentException("Input must be an integer.");
        }

        $digit = (int) $digit;

        if ($digit < 0 || $digit > 9) {
            throw new InvalidArgumentException("Input must be a single digit between 0 and 9.");
        }
    }

    /**
     * Calculates the value of X + XX + XXX + XXXX.
     */
    public function calculate(): int
    {
        $pattern = "";
        $sum = 0;

        for ($i = 0; $i < 4; $i++) {
            $pattern = (int) str_repeat($this->digit, $i+1);
            $sum += (int) $pattern;
        }

        return $sum;
    }
}

// ---------------- Example usage ----------------

try {
    $x = 3; // Change this to test with other digits
    $calculator = new PatternSumCalculator($x);
    $result = $calculator->calculate();
    echo "Result of $x + $x$x + $x$x$x + $x$x$x$x = $result\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
