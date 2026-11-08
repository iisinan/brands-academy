<?php

namespace App\Services;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;

class BarcodeService
{
    /**
     * Code 128 Pattern Table (Widths of alternating bars and spaces)
     * Patterns 0-106 according to ISO/IEC 15417
     */
    private static array $code128Table = [
        0 => '212222', 1 => '222122', 2 => '222221', 3 => '121223', 4 => '121322',
        5 => '131222', 6 => '122213', 7 => '122312', 8 => '132212', 9 => '221213',
        10 => '221312', 11 => '231212', 12 => '112232', 13 => '122132', 14 => '122231',
        15 => '113222', 16 => '123122', 17 => '123221', 18 => '223211', 19 => '221132',
        20 => '221231', 21 => '213212', 22 => '223112', 23 => '312131', 24 => '311222',
        25 => '321122', 26 => '321221', 27 => '312212', 28 => '322112', 29 => '322211',
        30 => '212123', 31 => '212321', 32 => '232121', 33 => '111323', 34 => '131123',
        35 => '131321', 36 => '112313', 37 => '132113', 38 => '132311', 39 => '211313',
        40 => '231113', 41 => '231311', 42 => '112133', 43 => '112331', 44 => '132131',
        45 => '113123', 46 => '113321', 47 => '133121', 48 => '313121', 49 => '211331',
        50 => '231131', 51 => '213113', 52 => '213311', 53 => '213131', 54 => '311123',
        55 => '311321', 56 => '331121', 57 => '312113', 58 => '312311', 59 => '332111',
        60 => '314111', 61 => '221411', 62 => '431111', 63 => '111224', 64 => '111422',
        65 => '121124', 66 => '121421', 67 => '141122', 68 => '141221', 69 => '112214',
        70 => '112412', 71 => '122114', 72 => '122411', 73 => '142112', 74 => '142211',
        75 => '241211', 76 => '221114', 77 => '413111', 78 => '241112', 79 => '134111',
        80 => '111242', 81 => '121142', 82 => '121241', 83 => '114212', 84 => '124112',
        85 => '124211', 86 => '411212', 87 => '421112', 88 => '421211', 89 => '212141',
        90 => '214121', 91 => '412121', 92 => '111143', 93 => '111341', 94 => '131141',
        95 => '114113', 96 => '114311', 97 => '411113', 98 => '411311', 99 => '113141',
        100 => '114131', 101 => '311141', 102 => '411131',
        103 => '211412', // Start A
        104 => '211214', // Start B
        105 => '211232', // Start C
        106 => '2331112', // Stop
    ];

    /**
     * Generate a crisp, high-density 2D QR Code as a PNG data URI.
     */
    public static function generateQrCodePng(string $text, int $moduleSize = 6, int $quietZone = 4): string
    {
        $qr = Encoder::encode($text, ErrorCorrectionLevel::H(), 'UTF-8');
        $matrix = $qr->getMatrix();
        $width = $matrix->getWidth();
        $height = $matrix->getHeight();

        $imgWidth = ($width + 2 * $quietZone) * $moduleSize;
        $imgHeight = ($height + 2 * $quietZone) * $moduleSize;

        $im = imagecreatetruecolor($imgWidth, $imgHeight);
        $white = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 15, 23, 42); // Slate-900 for executive contrast

        imagefilledrectangle($im, 0, 0, $imgWidth, $imgHeight, $white);

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                if ($matrix->get($x, $y) === 1) {
                    $x1 = ($x + $quietZone) * $moduleSize;
                    $y1 = ($y + $quietZone) * $moduleSize;
                    $x2 = $x1 + $moduleSize - 1;
                    $y2 = $y1 + $moduleSize - 1;
                    imagefilledrectangle($im, $x1, $y1, $x2, $y2, $black);
                }
            }
        }

        ob_start();
        imagepng($im);
        $pngData = ob_get_clean();
        imagedestroy($im);

        return 'data:image/png;base64,'.base64_encode($pngData);
    }

    /**
     * Generate an authentic, standard Code-128 linear 1D barcode as a PNG data URI.
     * Fully scannable by physical barcode laser readers and smartphone scanners.
     */
    public static function generateCode128Png(string $text, int $barWidth = 2, int $barHeight = 48, bool $showText = true): string
    {
        $text = trim($text);

        // Use Code 128 Subset B (Standard ASCII 32..126)
        $values = [104]; // Start B
        $len = strlen($text);

        for ($i = 0; $i < $len; $i++) {
            $ascii = ord($text[$i]);
            if ($ascii >= 32 && $ascii <= 126) {
                $values[] = $ascii - 32;
            } else {
                $values[] = 0; // Space fallback
            }
        }

        // Calculate Modulo 103 Checksum
        $checksum = $values[0];
        for ($i = 1; $i < count($values); $i++) {
            $checksum += $i * $values[$i];
        }
        $values[] = $checksum % 103;
        $values[] = 106; // Stop code

        // Assemble bar sequence
        $pattern = '';
        foreach ($values as $val) {
            $pattern .= self::$code128Table[$val] ?? '';
        }

        // Compute total module units
        $totalModules = 0;
        $patternLen = strlen($pattern);
        for ($i = 0; $i < $patternLen; $i++) {
            $totalModules += (int) $pattern[$i];
        }

        $quietZoneModules = 12;
        $totalWidth = ($totalModules + 2 * $quietZoneModules) * $barWidth;
        $extraTextHeight = $showText ? 16 : 0;
        $totalHeight = $barHeight + $extraTextHeight + 6;

        $im = imagecreatetruecolor($totalWidth, $totalHeight);
        $white = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 15, 23, 42); // Deep Slate-900

        imagefilledrectangle($im, 0, 0, $totalWidth, $totalHeight, $white);

        $curX = $quietZoneModules * $barWidth;
        $isBar = true;

        for ($i = 0; $i < $patternLen; $i++) {
            $w = ((int) $pattern[$i]) * $barWidth;
            if ($isBar) {
                imagefilledrectangle($im, $curX, 4, $curX + $w - 1, 4 + $barHeight, $black);
            }
            $curX += $w;
            $isBar = ! $isBar;
        }

        if ($showText) {
            $font = 2; // Built-in GD font 2 (clean monospace)
            $fontWidth = imagefontwidth($font);
            $textWidth = strlen($text) * $fontWidth;
            $textX = (int) max(0, ($totalWidth - $textWidth) / 2);
            $textY = $barHeight + 6;
            imagestring($im, $font, $textX, $textY, $text, $black);
        }

        ob_start();
        imagepng($im);
        $pngData = ob_get_clean();
        imagedestroy($im);

        return 'data:image/png;base64,'.base64_encode($pngData);
    }
}
