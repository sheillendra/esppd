<?php

namespace common\components\helpers;

class Number {

    public static function indonesianWords($number) {
        $textAngka = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        if ($number < 12) {
            return ' ' . $textAngka[$number];
        } elseif ($number < 20) {
            return self::indonesianWords($number - 10) . ' belas';
        } elseif ($number < 100) {
            return self::indonesianWords($number / 10) . ' puluh' . self::indonesianWords($number % 10);
        } elseif ($number < 200) {
            return 'seratus' . self::indonesianWords($number - 100);
        } elseif ($number < 1000) {
            return self::indonesianWords($number / 100) . ' ratus' . self::indonesianWords($number % 100);
        } elseif ($number < 2000) {
            return 'seribu' . self::indonesianWords($number - 1000);
        } elseif ($number < 1000000) {
            return self::indonesianWords($number / 1000) . ' ribu' . self::indonesianWords($number % 1000);
        } elseif ($number < 1000000000) {
            return self::indonesianWords($number / 1000000) . ' juta' . self::indonesianWords($number % 1000000);
        }
    }
    
}
