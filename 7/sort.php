<?php

class CommonElementsFinder
{
    private array $array1;
    private array $array2;

    public function __construct(array $array1, array $array2)
    {
        $this->array1 = $array1;
        $this->array2 = $array2;
    }

    /**
     * Returns an array of common elements between two sorted arrays (no duplicates).
     */
    public function find(): array
    {
        $i = $j = 0;
        $result = [];

        while ($i < count($this->array1) && $j < count($this->array2)) {
            $a = $this->array1[$i];
            $b = $this->array2[$j];

            if ($a === $b) {
                // Avoid duplicates in the result
                if (empty($result) || end($result) !== $a) {
                    $result[] = $a;
                }
                $i++;
                $j++;
            } elseif ($a < $b) {
                $i++;
            } else {
                $j++;
            }
        }

        return $result;
    }
}

// ------------------ Example ------------------

$array1 = [1, 2, 2, 3, 4, 5, 6];
$array2 = [2, 2, 4, 4, 6, 7];

$finder = new CommonElementsFinder($array1, $array2);
$common = $finder->find();

echo "Common elements: [" . implode(", ", $common) . "]\n";
