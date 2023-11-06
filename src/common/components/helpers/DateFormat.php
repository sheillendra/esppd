<?php

namespace common\components\helpers;

class DateFormat {

    const MONTH_TEXT = [
        '',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    public static function id($date) {
        $strtotime = strtotime($date);
        return date('d ', $strtotime) . ' ' . self::MONTH_TEXT[(int)date('m', $strtotime)].' '.date('Y', $strtotime);
    }

}
