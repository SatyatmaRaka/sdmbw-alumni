<?php

namespace App\Helpers;

class FormatHelper
{
    /**
     * Format phone number with dashes
     * Example: 081234567890 -> 0812-3456-7890
     */
    public static function phone($number)
    {
        if (empty($number)) return '-';

        // Remove all non-numeric characters
        $clean = preg_replace('/[^0-9]/', '', $number);

        // Format based on length
        if (strlen($clean) >= 10) {
            // Format: 0812-3456-7890
            if (strlen($clean) == 10) {
                return preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $clean);
            } else if (strlen($clean) == 11) {
                return preg_replace('/(\d{4})(\d{3})(\d{4})/', '$1-$2-$3', $clean);
            } else {
                return preg_replace('/(\d{4})(\d{4})(\d+)/', '$1-$2-$3', $clean);
            }
        }

        return $number;
    }

    /**
     * Format date
     */
    public static function date($date, $format = 'd M Y')
    {
        if (empty($date)) return '-';
        return \Carbon\Carbon::parse($date)->format($format);
    }

    /**
     * Format datetime
     */
    public static function datetime($datetime, $format = 'd M Y H:i')
    {
        if (empty($datetime)) return '-';
        return \Carbon\Carbon::parse($datetime)->format($format);
    }
}
