# ⚙️ Configuration Guide

Complete configuration and customization options for QR Code Generator.

## 📁 File Structure Configuration

### Directories to Ensure Exist

```bash
# Ensure these directories exist with proper permissions
mkdir -p temp/
chmod 755 temp/

mkdir -p img/
mkdir -p libs/css/
mkdir -p libs/phpqrcode/
```

### Required Files

```
index.php          ✅ Must exist
download.php       ✅ Must exist
visit.php          ✅ Auto-created if missing
temp/              ✅ Must be writable
img/qr-logo.svg    ✅ Logo file
libs/css/          ✅ CSS directory
libs/phpqrcode/    ✅ QR library
```

## 🎨 UI Configuration

### Colors (in index.php)

```css
:root {
    --primary-color: #007bff;      /* Main blue */
    --success-color: #28a745;      /* Success green */
    --danger-color: #dc3545;       /* Error red */
    --warning-color: #ffc107;      /* Warning yellow */
    --dark-color: #343a40;         /* Text dark */
}
```

**Change Primary Color:**

Edit line in `index.php` within `<style>` tag:
```css
--primary-color: #FF5733;  /* Change to your color */
```

### Background Gradient

Edit the body background in `index.php`:
```css
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

**Customize:**
```css
body {
    background: linear-gradient(135deg, #YOUR_COLOR_1 0%, #YOUR_COLOR_2 100%);
}
```

### Font and Typography

Current configuration:
- **Font Family**: Arial, sans-serif
- **Primary Heading**: 28px, bold
- **Secondary Heading**: 18px, bold
- **Body Text**: 14px

To change:
```css
body, input, button {
    font-family: 'Your Font', sans-serif;
}
```

## 🔐 Security Configuration

### CSRF Token

Currently: **Enabled** ✅

Generated per session:
```php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
```

To disable (NOT recommended):
```php
// Remove or comment out CSRF validation
// if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
```

### Input Validation Rules

#### Email
- **Validation**: `filter_var($email, FILTER_VALIDATE_EMAIL)`
- **Max Length**: 100 characters
- **Type**: Must be valid email format

#### Subject
- **Validation**: Length check (min 3 chars)
- **Max Length**: 100 characters
- **Type**: String
- **Sanitization**: `strip_tags()` applied

#### Message
- **Validation**: Length check (min 5 chars)
- **Max Length**: 500 characters
- **Type**: String
- **Sanitization**: `strip_tags()` applied

**To change validation rules:**

Edit `index.php`:
```php
// Email validation
if (!validateEmail($email)) {
    $errorMessage = "⚠️ Invalid email format.";
}

// Subject validation
elseif (strlen($subject) < 5) {  // Change minimum length
    $errorMessage = "⚠️ Subject must be at least 5 characters.";
}

// Message validation
elseif (strlen($msg) < 10) {  // Change minimum length
    $errorMessage = "⚠️ Message must be at least 10 characters.";
}
```

### Security Headers

Headers sent with file downloads:
```php
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Content-Security-Policy: default-src \'none\'');
```

To modify:
Edit `download.php` headers section.

## 📊 QR Code Configuration

### Error Correction Level

Current: **QR_ECLEVEL_H** (30% error correction)

```php
QRcode::png($content, $path, QR_ECLEVEL_H, 5);
//                               ^^^^^^^^^^^^
```

**Options:**
- `QR_ECLEVEL_L` - 7% error correction (smallest file)
- `QR_ECLEVEL_M` - 15% error correction (medium)
- `QR_ECLEVEL_Q` - 25% error correction (larger)
- `QR_ECLEVEL_H` - 30% error correction (most robust) **[Current]**

**To change:**
```php
// More error correction
QRcode::png($content, $path, QR_ECLEVEL_Q, 5);

// Less error correction (smaller file)
QRcode::png($content, $path, QR_ECLEVEL_L, 5);
```

### QR Code Size

Current: **5** (scale factor)

```php
QRcode::png($content, $path, QR_ECLEVEL_H, 5);
//                                          ^
//                                     scale factor
```

**Size Options:**
- `1` - Minimum size (small QR code)
- `2-4` - Medium size
- `5` - Default (current)
- `8-10` - Large size
- `15+` - Very large

**To change size:**
```php
// For larger QR codes
QRcode::png($content, $path, QR_ECLEVEL_H, 8);

// For smaller QR codes
QRcode::png($content, $path, QR_ECLEVEL_H, 3);
```

### Filename Format

Current format:
```
{email_username}_{timestamp}.png
```

**Example:** `john_1621234567.png`

To change filename generation, edit `index.php`:
```php
// Current
$filename = getUsernameFromEmail($email) . '_' . time();

// Alternative 1: Add random suffix
$filename = getUsernameFromEmail($email) . '_' . uniqid();

// Alternative 2: Use date format
$filename = getUsernameFromEmail($email) . '_' . date('YmdHis');

// Alternative 3: Simple format
$filename = md5($email . time());
```

## 🌐 Internationalization (i18n)

### Languages

Currently: **English only**

To add multiple languages, create language files:

**Example: lang/en.php**
```php
return [
    'title' => 'QR Code Generator',
    'email_label' => 'Email Address',
    'subject_label' => 'Subject Line',
    'message_label' => 'Message',
    'submit' => 'Generate QR Code',
];
```

**Example: lang/ar.php**
```php
return [
    'title' => 'مولد رموز QR',
    'email_label' => 'عنوان البريد الإلكتروني',
    'subject_label' => 'سطر الموضوع',
    'message_label' => 'الرسالة',
    'submit' => 'إنشاء رمز QR',
];
```

**In index.php:**
```php
$lang = $_GET['lang'] ?? 'en';
$strings = require("lang/{$lang}.php");
```

## 📨 Email Configuration

Currently: **Not implemented**

To add email notification functionality:

```php
function sendNotification($email, $qrPath) {
    $to = $email;
    $subject = "Your QR Code is Ready";
    $message = "Your QR code has been generated and is ready for download.";
    
    mail($to, $subject, $message);
}

// In form processing
if ($qrGenerated) {
    sendNotification($email, $qrPath);
}
```

**Configure mail settings in php.ini:**
```ini
[mail function]
SMTP = "localhost"
smtp_port = 25
sendmail_from = "admin@example.com"
```

## 💾 Database Configuration (Optional)

### To Add Database Support

**1. Create Database:**
```sql
CREATE DATABASE qr_generator;

CREATE TABLE qr_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255),
    message TEXT,
    filename VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE visitors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    visit_count INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**2. Connection String:**
```php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'qr_generator';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
```

**3. Save QR Code:**
```php
$sql = "INSERT INTO qr_codes (email, subject, message, filename) 
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $email, $subject, $msg, $filename);
$stmt->execute();
```

## 🔄 Caching Configuration

### Disable Caching (Development)

```php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
```

### Enable Caching (Production)

```php
header('Cache-Control: public, max-age=3600');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
```

## 📱 Responsive Design Breakpoints

Current configuration:

```css
/* Mobile phones (max 600px) */
@media (max-width: 600px) {
    .myoutput {
        padding: 20px;
        margin: 15px 10px;
    }
}

/* Tablets (600px - 1024px) */
@media (max-width: 1024px) {
    /* Adjust for tablets */
}

/* Desktops (1024px+) */
/* Default styles */
```

To add tablet support:
```css
@media (min-width: 600px) and (max-width: 1024px) {
    .myoutput {
        max-width: 700px;
    }
}
```

## ⚡ Performance Configuration

### Visitor Counter Storage

Currently: **File-based**

Performance: ✅ Good for low traffic (< 1000 visitors/day)

To optimize for high traffic:
```php
// Use session storage instead of file
$_SESSION['visitor_count'] = ($_SESSION['visitor_count'] ?? 0) + 1;
```

### Session Configuration

In `index.php`:
```php
session_start();

// Optional: Configure session settings
ini_set('session.gc_maxlifetime', 3600);  // 1 hour
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
```

## 🔍 Logging Configuration

### Enable Error Logging

Add to top of `index.php`:
```php
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/errors.log');
```

### Log QR Generation

```php
if ($qrGenerated) {
    error_log("QR generated for: " . $email . " at " . date('Y-m-d H:i:s'));
}
```

## 📝 Advanced Configuration

### Custom Validation Rules

Add to `index.php`:
```php
function validateSubject($subject) {
    // No numbers allowed
    return !preg_match('/[0-9]/', $subject);
}

function validateMessage($msg) {
    // Minimum word count
    return str_word_count($msg) >= 3;
}
```

### Rate Limiting

```php
// Limit requests per IP
function checkRateLimit() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $limit_file = "limits/{$ip}.txt";
    $limit_count = 10;  // Max 10 QR codes per hour
    
    if (file_exists($limit_file)) {
        $data = json_decode(file_get_contents($limit_file), true);
        if (time() - $data['time'] < 3600) {
            if ($data['count'] >= $limit_count) {
                return false;  // Rate limit exceeded
            }
        }
    }
    return true;
}
```

## 🚀 Deployment Configuration

### Production Settings

```php
// php.ini settings
error_reporting = E_ALL & ~E_NOTICE
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

// Security
expose_php = Off
allow_url_fopen = Off
allow_url_include = Off
```

### Server Configuration

**.htaccess (Apache)**
```apache
<FilesMatch "\.(php|phtml|php3|php4|php5|php6|phps|pht|phar)$">
    Order allow,deny
    Allow from all
</FilesMatch>

# Disable directory listing
Options -Indexes

# Compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

---

## 📚 Quick Reference

| Setting | Current Value | Purpose |
|---------|---------------|---------|
| QR Error Correction | LEVEL_H | Robustness |
| QR Scale | 5 | Size |
| Max Email Length | 100 | Input limit |
| Max Subject Length | 100 | Input limit |
| Max Message Length | 500 | Input limit |
| Session Timeout | Default PHP | User session |
| Temp Directory | temp/ | QR storage |
| CSRF Protection | Enabled | Security |
| Input Sanitization | Enabled | Security |
| Output Escaping | Enabled | Security |

---

**Last Updated**: May 2026  
**Version**: 2.0  
**Status**: ✅ Production Ready
