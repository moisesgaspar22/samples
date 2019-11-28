<?php

namespace someApp\math;

/**
 * 🧮
 * Some generic math exercises
 * 1rst - get a binary representation for a given decimal number using the inverted
 * method
 *
 * 2cnd - get the fibo number for a given Nth position
 */
class MathCalculator
{
    /**
     * Placeholder
     *
     * @var array
     */
    public $memoization = [];

    /**
     * returns a binary representation for a decimal number
     *
     * @param string $decimal
     * @return string
     */
    public function convertDecimalToBin($decimal)
    {
        return $this->decimalToBin($decimal);
    }

    /**
     * converts a decimal number into its binary representation
     *
     * @param string $decimal
     * @return string
     */
    protected function decimalToBin($decimal)
    {
        $bin = '';
        do {
            $bin .= ($decimal % 2 == 0) ? '0' : '1';
            $decimal = floor($decimal / 2);
        } while ($decimal >=1);
         
         return  strrev($bin);
    }

    /**
     * get the fibo number for the given Nth position
     *
     * @param integer $position
     * @return void
     */
    public function getNFiboNumber($n)
    {
        if ($n <= 1) {
            return $n;
        }

        if (array_key_exists($n, $this->memoization)) {
            return $this->memoization[$n];
        }

        $this->memoization[$n] = $this->getNFiboNumber($n - 1) + $this->getNFiboNumber($n - 2);
        return $this->memoization[$n];
    }
}
