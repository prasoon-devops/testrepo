<?php

class EvenFibonacciGenerator
{
    private int $prevEven;
    private int $currEven;

    public function __construct()
    {
        // First two even Fibonacci numbers
        $this->prevEven = 0;
        $this->currEven = 2;
    }

    /**
     * Generate the next even Fibonacci number using the optimized formula.
     * E(n) = 4 * E(n-1) + E(n-2)
     */
    public function next(): int
    {
        $next = $this->currEven;
        $newEven = 4 * $this->currEven + $this->prevEven;

        $this->prevEven = $this->currEven;
        $this->currEven = $newEven;

        return $next;
    }
}

class EvenFibonacciSumCalculator
{
    private int $count;
    private EvenFibonacciGenerator $generator;

    public function __construct(int $count)
    {
        if ($count < 1) {
            throw new InvalidArgumentException("Count must be greater than zero.");
        }

        $this->count = $count;
        $this->generator = new EvenFibonacciGenerator();
    }

    public function calculate(): int
    {
        $sum = 0;
        for ($i = 0; $i < $this->count; $i++) {
            $sum += $this->generator->next();
        }
        return $sum;
    }
}

// ------------------ MAIN ------------------

try {
    $calculator = new EvenFibonacciSumCalculator(100);
    $result = $calculator->calculate();
    echo "Sum of the first 100 even Fibonacci numbers is: " . $result . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
