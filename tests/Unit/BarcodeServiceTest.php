<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class BarcodeServiceTest extends TestCase
{
    /**
     * Test QR code generates valid base64 PNG data.
     */
    public function test_generates_valid_qr_code_png_data_uri(): void
    {
        $dataUri = \App\Services\BarcodeService::generateQrCodePng('https://brandsacademy.ng/verify/BANF-CERT-2024-00108');

        $this->assertStringStartsWith('data:image/png;base64,', $dataUri);

        $base64 = substr($dataUri, strlen('data:image/png;base64,'));
        $binary = base64_decode($base64);

        $this->assertNotEmpty($binary);
        // PNG Magic bytes: \x89PNG\r\n\x1a\n
        $this->assertSame("\x89PNG\r\n\x1a\n", substr($binary, 0, 8));

        $size = getimagesizefromstring($binary);
        $this->assertIsArray($size);
        $this->assertGreaterThan(50, $size[0]); // width
        $this->assertGreaterThan(50, $size[1]); // height
    }

    /**
     * Test Code-128 linear barcode generates valid base64 PNG data.
     */
    public function test_generates_valid_code128_linear_barcode(): void
    {
        $code = 'BANF-CERT-2024-00108';
        $dataUri = \App\Services\BarcodeService::generateCode128Png($code);

        $this->assertStringStartsWith('data:image/png;base64,', $dataUri);

        $base64 = substr($dataUri, strlen('data:image/png;base64,'));
        $binary = base64_decode($base64);

        $this->assertNotEmpty($binary);
        $this->assertSame("\x89PNG\r\n\x1a\n", substr($binary, 0, 8));

        $size = getimagesizefromstring($binary);
        $this->assertIsArray($size);
        $this->assertGreaterThan(100, $size[0]); // width
        $this->assertGreaterThan(30, $size[1]);  // height
    }
}
