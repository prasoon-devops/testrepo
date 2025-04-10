<?php

class EvenFibonacciGenerator
{
    private string $prevEven;
    private string $currEven;

    public function __construct()
    {
        $this->prevEven = "0";
        $this->currEven = "2";
    }

    public function next(): string
    {
        $next = $this->currEven;
        $newEven = bcadd(bcmul("4", $this->currEven), $this->prevEven);

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

    public function calculate(): string
    {
        $sum = "0";
        for ($i = 0; $i < $this->count; $i++) {
            $sum = bcadd($sum, $this->generator->next());
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