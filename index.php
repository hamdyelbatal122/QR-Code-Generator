<?php
// ==========================================
// QR Code Generator - Professional Edition
// ==========================================

session_start();

// Initialize visit counter
$counterFile = "visit.php";
if (!file_exists($counterFile)) {
    touch($counterFile);
    file_put_contents($counterFile, "0");
}

// Include QR Code Library
require_once('libs/phpqrcode/qrlib.php');

// Generate CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validate and sanitize input
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function sanitizeInput($input) {
    return trim(strip_tags($input));
}

function getUsernameFromEmail($email) {
    $pos = strpos($email, '@');
    $username = substr($email, 0, $pos);
    return preg_replace('/[^a-zA-Z0-9_-]/', '', $username);
}

// Process form submission
$qrGenerated = false;
$filename = "author";
$errorMessage = "";
$successMessage = "";

if (isset($_POST['submit'])) {
    // Verify CSRF token
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errorMessage = "⚠️ Security token invalid. Please try again.";
    } else {
        // Get and validate inputs
        $email = sanitizeInput($_POST['mail'] ?? '');
        $subject = sanitizeInput($_POST['subject'] ?? '');
        $msg = sanitizeInput($_POST['msg'] ?? '');
        
        // Validate inputs
        if (empty($email) || !validateEmail($email)) {
            $errorMessage = "⚠️ Please enter a valid email address.";
        } elseif (empty($subject) || strlen($subject) < 3) {
            $errorMessage = "⚠️ Subject must be at least 3 characters long.";
        } elseif (empty($msg) || strlen($msg) < 5) {
            $errorMessage = "⚠️ Message must be at least 5 characters long.";
        } else {
            try {
                // Generate QR Code
                $tempDir = 'temp/';
                if (!is_dir($tempDir)) {
                    mkdir($tempDir, 0755, true);
                }
                
                $filename = getUsernameFromEmail($email) . '_' . time();
                $qrContent = 'mailto:' . $email . '?subject=' . urlencode($subject) . '&body=' . urlencode($msg);
                $qrPath = $tempDir . $filename . '.png';
                
                QRcode::png($qrContent, $qrPath, QR_ECLEVEL_H, 5);
                
                if (file_exists($qrPath)) {
                    $qrGenerated = true;
                    $successMessage = "✓ QR Code generated successfully!";
                } else {
                    $errorMessage = "⚠️ Failed to generate QR code. Please try again.";
                }
            } catch (Exception $e) {
                $errorMessage = "⚠️ Error: " . $e->getMessage();
            }
        }
    }
}

// Update visitor counter (only on page load, not on form submission)
if (!isset($_POST["submit"])) {
    $counter = (int)file_get_contents($counterFile);
    $counter++;
    file_put_contents($counterFile, $counter);
} else {
    $counter = (int)file_get_contents($counterFile);
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Professional QR Code Generator - Create QR codes for email sharing">
    <meta name="author" content="hamdy">
    
    <title>QR Code Generator - Professional Email QR Creator</title>
    
    <link rel="icon" href="img/favicon.ico" type="image/png">
    <link rel="stylesheet" href="libs/css/bootstrap.min.css">
    <link rel="stylesheet" href="libs/style.css">
    <script src="libs/navbarclock.js"></script>
    
    <style>
        :root {
            --primary-color: #007bff;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --dark-color: #343a40;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .navbar-inverse {
            background: linear-gradient(to right, var(--primary-color), #0056b3);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            padding: 15px 20px;
        }
        
        .hederimg {
            height: 50px;
            transition: transform 0.3s ease;
        }
        
        .hederimg:hover {
            transform: scale(1.05);
        }
        
        .myoutput {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin: 30px auto;
            max-width: 600px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        
        .myoutput h3 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 28px;
        }
        
        .input-field {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 5px solid var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            transition: border-color 0.3s ease;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
            outline: none;
        }
        
        .submitBtn {
            background: linear-gradient(to right, var(--primary-color), #0056b3);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            color: white;
            width: 100%;
        }
        
        .submitBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 123, 255, 0.4);
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .qr-field {
            text-align: center;
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-top: 25px;
            border-top: 5px solid var(--success-color);
        }
        
        .qr-field h2 {
            color: var(--dark-color);
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .qrframe {
            background: white;
            border: 3px solid var(--primary-color);
            border-radius: 10px;
            padding: 10px;
            display: inline-block;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin: 20px 0;
            transition: transform 0.3s ease;
        }
        
        .qrframe:hover {
            transform: scale(1.05);
        }
        
        .qrframe img {
            max-width: 200px;
            max-height: 200px;
            display: block;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .dllink {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            color: #666;
        }
        
        .dllink h4 {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .clockdate-wrapper {
            background: rgba(255,255,255,0.2);
            color: white !important;
            border-radius: 8px;
        }
        
        #clock {
            color: white !important;
            font-weight: 700;
        }
        
        #date {
            color: rgba(255,255,255,0.9);
        }
        
        .visitcount {
            color: white;
            font-weight: 600;
            padding: 10px 15px;
            background: rgba(0,0,0,0.2);
            border-radius: 8px;
            display: inline-block;
        }
        
        .feature-note {
            background: #e3f2fd;
            border-left: 4px solid var(--primary-color);
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            color: #1565c0;
            font-size: 13px;
        }
        
        @media (max-width: 600px) {
            .myoutput {
                padding: 20px;
                margin: 15px 10px;
            }
            
            .input-field {
                padding: 15px;
            }
            
            .myoutput h3 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body onload="startTime()">
    <!-- Header Navigation -->
    <nav class="navbar-inverse" role="navigation">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <a href="#" style="display: flex; align-items: center; text-decoration: none;">
                <img src="img/qr-logo.svg" class="hederimg" alt="QR Logo" title="QR Code Generator">
                <span style="color: white; font-weight: 700; margin-left: 10px; display: none;" class="hidden-xs">QR Generator</span>
            </a>
            
            <div id="clockdate" style="margin-right: 20px;">
                <div class="clockdate-wrapper">
                    <div id="clock"></div>
                    <div id="date"><?php echo date('l, F j, Y'); ?></div>
                </div>
            </div>
            
            <div class="pagevisit">
                <div class="visitcount">
                    👁️ Visitors: <?php echo $counter; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="myoutput">
        <h3>🔗 QR Code Generator</h3>
        
        <!-- Feature Note -->
        <div class="feature-note">
            💡 Generate secure QR codes for email sharing with professional design
        </div>

        <!-- Error Message -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Form Section -->
        <div class="input-field">
            <h3 style="color: var(--dark-color); font-size: 18px; margin-bottom: 20px;">📝 Enter Your Details</h3>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="qrForm">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <!-- Email Input -->
                <div class="form-group">
                    <label for="mail">📧 Email Address *</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="mail"
                        name="mail" 
                        placeholder="example@domain.com" 
                        value="<?php echo htmlspecialchars($_POST['mail'] ?? ''); ?>"
                        required 
                        maxlength="100">
                </div>

                <!-- Subject Input -->
                <div class="form-group">
                    <label for="subject">📌 Subject Line *</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="subject"
                        name="subject" 
                        placeholder="e.g., Meeting Schedule" 
                        value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>"
                        required 
                        minlength="3"
                        maxlength="100">
                </div>

                <!-- Message Input -->
                <div class="form-group">
                    <label for="msg">💬 Message *</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="msg"
                        name="msg" 
                        placeholder="Your message here..." 
                        value="<?php echo htmlspecialchars($_POST['msg'] ?? ''); ?>"
                        required 
                        minlength="5"
                        maxlength="500">
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" name="submit" class="submitBtn">
                        ✨ Generate QR Code
                    </button>
                </div>
            </form>
        </div>

        <!-- QR Code Result Section -->
        <?php if ($qrGenerated && file_exists('temp/' . $filename . '.png')): ?>
            <div class="qr-field">
                <h2>✅ Your QR Code</h2>
                <div class="qrframe">
                    <img src="temp/<?php echo htmlspecialchars($filename); ?>.png" 
                         alt="Generated QR Code" 
                         title="Scan this QR code to open email client">
                </div>
                
                <div class="btn-group">
                    <a class="btn btn-primary submitBtn" 
                       href="download.php?file=<?php echo urlencode($filename . '.png'); ?>" 
                       style="width: auto; padding: 12px 25px;">
                        📥 Download QR Code
                    </a>
                    <button class="btn-secondary" onclick="copyToClipboard()">
                        📋 Copy Link
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="dllink">
            <h4>🚀 QR Code Generator Pro</h4>
            <p style="font-size: 12px; margin: 8px 0 0 0;">
                Made with ❤️ by <strong>hamdy</strong> | 
                <span style="color: #999;">v2.0 Professional Edition</span>
            </p>
        </div>
    </div>

    <!-- Copy to Clipboard Script -->
    <script>
        function copyToClipboard() {
            const link = window.location.href;
            navigator.clipboard.writeText(link).then(() => {
                alert('✓ Link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }

        // Form validation on client side
        document.getElementById('qrForm').addEventListener('submit', function(e) {
            const email = document.getElementById('mail').value;
            const subject = document.getElementById('subject').value;
            const msg = document.getElementById('msg').value;

            if (!email || !subject || !msg) {
                e.preventDefault();
                alert('⚠️ Please fill in all fields!');
                return false;
            }

            if (subject.length < 3) {
                e.preventDefault();
                alert('⚠️ Subject must be at least 3 characters!');
                return false;
            }

            if (msg.length < 5) {
                e.preventDefault();
                alert('⚠️ Message must be at least 5 characters!');
                return false;
            }
        });
    </script>
</body>
</html>

