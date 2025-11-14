<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use SimpleSoftwareIO\QrCode\Facades\QrCode;

try {
    echo "Testing QR Code generation...\n\n";
    
    $testCode = 'TKT-TEST123456';
    
    // Generate SVG QR Code
    $qrCodeSvg = QrCode::format('svg')
        ->size(200)
        ->errorCorrection('H')
        ->generate($testCode);
    
    echo "✅ QR Code SVG generated successfully!\n";
    echo "Length: " . strlen($qrCodeSvg) . " bytes\n\n";
    
    // Encode to base64
    $qrCodeBase64 = base64_encode($qrCodeSvg);
    echo "✅ Base64 encoded successfully!\n";
    echo "Length: " . strlen($qrCodeBase64) . " bytes\n\n";
    
    // Create data URI
    $dataUri = 'data:image/svg+xml;base64,' . $qrCodeBase64;
    echo "✅ Data URI created!\n";
    echo "Preview (first 100 chars): " . substr($dataUri, 0, 100) . "...\n\n";
    
    // Save as HTML for testing
    $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>QR Code Test</title>
</head>
<body style="text-align: center; padding: 50px;">
    <h1>QR Code Test</h1>
    <p>Code: {$testCode}</p>
    <img src="{$dataUri}" alt="QR Code" style="max-width: 300px;">
</body>
</html>
HTML;
    
    file_put_contents('test-qr.html', $html);
    echo "✅ Test HTML saved to: test-qr.html\n";
    echo "Open this file in browser to see QR Code!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
