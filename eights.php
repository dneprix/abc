<?php

$matrix = new Matrix(10, 20, 5);
$matrix->build();
$matrix->print();

/**
 * Class Matrix
 *
 * Building and printing matrix data
 */
class Matrix
{
    const PRIMARY_VALUE = 8;
    const SECONDARY_VALUE = 1;
    const MAX_ATTEMPTS = 10;

    // Matrix data
    private $data;

    // Matrix rows number
    private $n;

    // Matrix columns number
    private $m;

    // Matrix elemenkts number
    private $k;

    // Matrix build attempts
    private $attempts;

    // Matrix build attempts limit
    private $attemptsLimit;

    /**
     * Matrix constructor
     *
     * @param $n - matrix rows number
     * @param $m - matrix columns number
     * @param $k - matrix primary values number
     */
    public function __construct(int $n, int $m, int $k)
    {
        // Set matrix settings
        $this->n = $n;
        $this->m = $m;
        $this->k = $k;

        // Set attempts settings
        $this->attempts = 0;
        $this->attemptsLimit = $this->k * self::MAX_ATTEMPTS;
    }

    /**
     * Build matrix data
     */
    public function build(): void
    {
        while ($this->k && $this->attempts < $this->attemptsLimit) {

            // Get random position
            $position = $this->getRandomPosition();

            // Validate position
            if (!$this->isValidPosition($position)) {
                $this->attempts++;
                continue;
            }

            // Set position
            $this->setPosition($position);
            $this->k--;
        }
    }

    /**
     * Print matrix data
     */
    public function print(): void
    {
        // Print matrix
        for ($i = 0; $i < $this->n; $i++) {
            for ($j = 0; $j < $this->m; $j++) {
                echo $this->getPositionValue([$i, $j]) . ' ';
            }
            echo "\n";
        }

        // Print notification
        if ($this->k){
          echo "No place for {$this->k} elements \n";
        }

        // Print attempts
        echo "Attempts: {$this->attempts} \n";
    }

    /***
     * Generate random position
     *
     * @return iterable
     * @throws Exception
     */
    private function getRandomPosition(): iterable
    {
        $x = random_int(0, $this->n - 1);
        $y = random_int(0, $this->m - 1);
        return [$x, $y];
    }

    /**
     * Validate position
     *
     * @param $position
     * @return bool
     */
    private function isValidPosition(iterable $position): bool
    {
        return !$this->getPositionValue($position) ? true : false;
    }

    /**
     * Get position value
     *
     * @param $position
     * @return int
     */
    private function getPositionValue(iterable $position): int
    {
        [$x, $y] = $position;
        return !empty($this->data[$x][$y]) ? $this->data[$x][$y] : 0;
    }

    /**
     * Set position primary and secondary values
     * @param $position
     */
    private function setPosition(iterable $position): void
    {
        [$x, $y] = $position;

        // Set primary value
        $this->data[$x][$y] = self::PRIMARY_VALUE;

        // Set secondary values
        $this->setSecondaryPosition([$x - 1, $y - 1]);
        $this->setSecondaryPosition([$x - 1, $y]);
        $this->setSecondaryPosition([$x - 1, $y + 1]);
        $this->setSecondaryPosition([$x, $y - 1]);
        $this->setSecondaryPosition([$x, $y + 1]);
        $this->setSecondaryPosition([$x + 1, $y - 1]);
        $this->setSecondaryPosition([$x + 1, $y]);
        $this->setSecondaryPosition([$x + 1, $y + 1]);
    }


    /**
     * Set secondary position value
     *
     * @param $position
     */
    private function setSecondaryPosition(iterable $position): void
    {
        [$x, $y] = $position;

        // Validate position coordinates
        if ($x < 0 || $y < 0) {
            return;
        }

        // Set secondary position and sum with existing value
        $this->data[$x][$y] = self::SECONDARY_VALUE + $this->getPositionValue($position);
    }

}