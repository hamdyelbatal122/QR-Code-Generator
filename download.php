<?php
/**
 * QR Code Download Handler
 * Safely handles the download of generated QR code images
 */

// Security: Prevent directory traversal attacks
if (!empty($_GET['file'])) {
    $fileName = basename($_GET['file']);
    $filePath = 'temp/' . $fileName;
    
    // Validate file path
    $realPath = realpath($filePath);
    $realTempDir = realpath('temp/');
    
    // Ensure the file is within the temp directory
    if ($realPath && $realTempDir && strpos($realPath, $realTempDir) === 0 && file_exists($realPath)) {
        // Get file size
        $fileSize = filesize($realPath);
        
        // Set security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('Content-Security-Policy: default-src \'none\'');
        
        // Set download headers
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
        header('Content-Length: ' . $fileSize);
        header('Pragma: public');
        header('Cache-Control: public, must-revalidate');
        header('Expires: 0');
        
        // Output file
        readfile($realPath);
        exit;
    }
}

// If we get here, the file is invalid or doesn't exist
http_response_code(404);
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error - File Not Found</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 400px;
        }
        .error-box h1 {
            color: #dc3545;
            margin: 0 0 15px 0;
            font-size: 28px;
        }
        .error-box p {
            color: #666;
            margin: 10px 0;
            font-size: 14px;
        }
        .error-box a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        .error-box a:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>❌ File Not Found</h1>
        <p>The requested QR code file could not be found or is no longer available.</p>
        <p>Files are stored temporarily and may be deleted after some time.</p>
        <a href="index.php">← Go Back to Generator</a>
    </div>
</body>
</html>
