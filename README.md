# QR Code Generator

A simple and elegant QR Code Generator built with PHP, Bootstrap, and JavaScript.

## 📋 About Project

QR Code Generator is developed using PHP QR CODE Library with CSS, Bootstrap, and JavaScript. Users can generate QR codes easily by providing an email address, subject, and message. The generated QR codes can be downloaded for use. This QR code generator focuses on sharing email address details with embedded styling using Bootstrap 3.3.7.

## ✨ Features

- ✅ Generate QR Codes from email details
- 📥 Download generated QR Code images
- 🎨 Clean and intuitive user interface
- ⚡ Fast QR code generation
- 📱 Responsive design

## 🛠️ Tech Stack

- **Backend**: PHP 5.x+
- **Frontend**: HTML5, CSS3, Bootstrap 3.3.7, JavaScript
- **QR Library**: PHP QR Code Library
- **Server**: Apache (XAMPP/LAMP/LEMP)

## 📥 Installation & Setup

### Prerequisites
- XAMPP, WAMP, LAMP, or any Apache + PHP server
- PHP 5.x or higher

### Steps to Run

1. **Extract the project files**
   ```bash
   unzip QR-Code-Generator.zip
   ```

2. **Copy to server directory**
   ```bash
   cp -r QR-Code-Generator /path/to/xampp/htdocs/
   ```

3. **Start Apache & MySQL** (if using XAMPP)
   - Open XAMPP Control Panel
   - Click "Start" for Apache

4. **Access the application**
   ```
   http://localhost/QR-Code-Generator/
   ```
   
   *(URL may vary based on your folder name)*

## 📂 Project Structure

```
QR-Code-Generator/
├── index.php              # Main application page
├── download.php           # File download handler
├── visit.php              # QR code generation logic
├── README.md              # This file
├── img/                   # Images & icons
├── libs/                  # Libraries and dependencies
│   ├── phpqrcode/         # PHP QR Code library
│   ├── css/               # Stylesheets
│   └── navbarclock.js     # Clock JavaScript
└── temp/                  # Temporary QR code storage (ignored in git)
```

## 🚀 Usage

1. Open the application in your browser
2. Enter your email address
3. Add a subject line
4. Compose your message
5. Click "Generate QR Code"
6. Download the generated QR code image

## 📝 Notes

- Generated QR codes are temporary and stored in the `temp/` folder
- The application is designed for educational purposes
- All generated images can be downloaded as PNG files

## 📄 License

Free to use for educational purposes only.

## 👤 Author

Developed as a demonstration project for QR code generation in PHP.

---

**Last Updated**: May 2026
