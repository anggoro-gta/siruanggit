<?php

if (! function_exists('tanggal_indo')) {
    function tanggal_indo(?string $tanggal): string
    {
        if (empty($tanggal)) {
            return '-';
        }

        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $timestamp = strtotime($tanggal);

        return date('d', $timestamp) . ' '
            . $bulan[(int) date('m', $timestamp)] . ' '
            . date('Y', $timestamp);
    }
}