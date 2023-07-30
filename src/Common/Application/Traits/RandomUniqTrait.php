<?php

namespace Common\Application\Traits;

trait RandomUniqTrait
{
    public static function cryptoRandSecure($min, $max): int
    {
        $range = $max - $min;

        if ($range < 0) {
            return $min;
        }
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd &= $filter; // discard irrelevant bits
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    public function generateRandomUniq(int $length = 6): string
    {
        $token = '';
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= '0123456789';
        for ($i = 0; $i < $length; ++$i) {
            $token .= $codeAlphabet[self::cryptoRandSecure(0, strlen($codeAlphabet))];
        }

        return $token;
    }

    public function generateRandomUniqWithPrefix(string $prefix, int $length = 6): string
    {
        return sprintf('%s-%s', $prefix, $this->generateRandomUniq($length));
    }

    public static function getNumericUniq(int $length = 6): string
    {
        $token = '';
        $codeAlphabet = '123456789';
        for ($i = 0; $i < $length; ++$i) {
            $token .= $codeAlphabet[self::cryptoRandSecure(0, strlen($codeAlphabet))];
        }

        return $token;
    }
}
