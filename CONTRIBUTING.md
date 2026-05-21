# 🤝 Contributing to QR Code Generator

Thank you for your interest in contributing to QR Code Generator! This document provides guidelines and instructions for contributing.

## 📋 Code of Conduct

- Be respectful and constructive in all interactions
- Provide helpful feedback and suggestions
- Report security issues privately to hamdy
- Follow best practices and coding standards

## 🚀 Getting Started

### Prerequisites
- Git installed on your system
- PHP 7.0 or higher
- XAMPP/WAMP/LAMP or compatible server
- Text editor or IDE

### Setup Development Environment

1. **Fork the Repository**
   ```bash
   # Click "Fork" on GitHub
   ```

2. **Clone Your Fork**
   ```bash
   git clone https://github.com/YOUR_USERNAME/QR-Code-Generator.git
   cd QR-Code-Generator
   ```

3. **Add Upstream Remote**
   ```bash
   git remote add upstream https://github.com/hamdyelbatal122/QR-Code-Generator.git
   ```

4. **Create Feature Branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

5. **Set Up Local Server**
   ```bash
   # Copy project to xampp/htdocs/
   cp -r QR-Code-Generator ~/xampp/htdocs/
   
   # Start Apache
   # Open http://localhost/QR-Code-Generator/
   ```

## 📝 Development Guidelines

### Code Style

#### PHP
```php
// Use modern PHP practices
- Follow PSR-12 coding standards
- Use type hints where possible
- Add meaningful comments
- Implement proper error handling
- Use meaningful variable names

// Example:
function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
```

#### JavaScript
```javascript
// Use ES6+ features
- Const/let over var
- Arrow functions where appropriate
- Template literals
- Comments for complex logic

// Example:
const validateForm = () => {
    const email = document.getElementById('mail').value;
    return email.length > 0;
};
```

#### CSS
```css
/* Use modern CSS practices */
- Use CSS custom properties (variables)
- Mobile-first responsive design
- Meaningful class names
- Proper indentation

/* Example */
:root {
    --primary-color: #007bff;
}

.button {
    background-color: var(--primary-color);
}
```

### Security Guidelines

1. **Input Validation**
   ```php
   // Always validate user input
   $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
   ```

2. **Output Escaping**
   ```php
   // Always escape output
   echo htmlspecialchars($user_input);
   ```

3. **CSRF Protection**
   ```php
   // Always use CSRF tokens
   // Verify token on form submission
   ```

4. **No Hardcoded Secrets**
   ```php
   // Never commit API keys or passwords
   // Use environment variables
   ```

### Testing

Before submitting a pull request, test:

- [ ] Form validation works correctly
- [ ] QR codes generate successfully
- [ ] Download functionality works
- [ ] Mobile responsiveness
- [ ] No JavaScript console errors
- [ ] No SQL errors (if applicable)
- [ ] CSRF protection active
- [ ] Input sanitization working

### Documentation

When adding features, update:

1. **README.md** - Add feature description
2. **FEATURES.md** - Document technical details
3. **CHANGELOG.md** - Add to unreleased section
4. **Code Comments** - Inline documentation

Example documentation:
```php
/**
 * Validates user email address
 * 
 * @param string $email The email address to validate
 * @return bool True if valid, false otherwise
 * 
 * @example
 * if (validateEmail('user@example.com')) {
 *     // Email is valid
 * }
 */
function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
```

## 🔧 Type of Contributions

### 🐛 Bug Reports

**Found a bug?** Create an issue with:

```markdown
**Description**: Clear description of the bug
**Steps to Reproduce**: 
1. Step one
2. Step two
3. Bug occurs

**Expected Behavior**: What should happen
**Actual Behavior**: What actually happens
**Screenshots**: If applicable
**Environment**: PHP version, OS, browser
```

### ✨ Feature Requests

**Have an idea?** Create an issue with:

```markdown
**Feature**: Clear feature title
**Description**: Detailed description
**Motivation**: Why is this needed?
**Proposed Solution**: How should it work?
**Alternatives**: Other approaches considered
```

### 📝 Documentation Improvements

- Fix typos
- Improve clarity
- Add examples
- Update outdated information

### 🔒 Security Improvements

- Submit security issues privately
- Don't disclose vulnerabilities publicly
- Email security details to maintainer
- Allow time for fix before disclosure

## 🔄 Pull Request Process

### Before Submitting

1. **Update from Main Branch**
   ```bash
   git fetch upstream
   git rebase upstream/master
   ```

2. **Test Your Changes**
   ```bash
   # Manual testing
   # Browser testing
   # Mobile testing
   ```

3. **Review Your Code**
   ```bash
   git diff
   git status
   ```

### Creating Pull Request

1. **Push to Your Fork**
   ```bash
   git push origin feature/your-feature-name
   ```

2. **Create Pull Request on GitHub**
   - Use descriptive title
   - Reference related issues
   - Describe changes clearly

### Pull Request Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Security improvement

## Related Issues
Fixes #(issue number)

## Testing Done
- [x] Feature works as intended
- [x] No breaking changes
- [x] Mobile responsive
- [x] No console errors

## Checklist
- [ ] Code follows style guide
- [ ] Comments added for complex logic
- [ ] Documentation updated
- [ ] No security vulnerabilities
- [ ] Tested in multiple browsers
- [ ] Mobile tested
```

## 📦 Branch Naming Convention

```
feature/description       - New features
bugfix/description        - Bug fixes
security/description      - Security fixes
docs/description          - Documentation
refactor/description      - Code refactoring
```

Example:
```bash
git checkout -b feature/add-qr-customization
git checkout -b bugfix/fix-csrf-token-validation
git checkout -b security/prevent-xss-injection
```

## 💻 Local Development Commands

```bash
# View changes
git status
git diff

# Stage changes
git add .
git add path/to/file.php

# Commit changes
git commit -m "feat: Add new feature"
git commit -m "fix: Resolve bug #123"
git commit -m "docs: Update README"
git commit -m "style: Fix code formatting"

# Create branch
git checkout -b feature/my-feature

# Switch branch
git checkout master
git checkout feature/my-feature

# Update from upstream
git fetch upstream
git rebase upstream/master

# Push to fork
git push origin feature/my-feature

# Clean up
git branch -d feature/completed
git clean -fd
```

## 🎯 Commit Message Format

Use conventional commits:

```
<type>: <description>

[optional body]

[optional footer]
```

### Types
- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation
- `style:` Code formatting
- `refactor:` Code refactoring
- `test:` Adding tests
- `security:` Security improvement
- `perf:` Performance improvement

### Examples
```
feat: Add dark mode toggle
fix: Resolve CSRF token validation issue
docs: Add API documentation
security: Prevent directory traversal attacks
```

## 🚫 What NOT to Do

- ❌ Don't commit node_modules or dependencies
- ❌ Don't add large binary files
- ❌ Don't hardcode secrets or API keys
- ❌ Don't make unrelated changes
- ❌ Don't rewrite project history
- ❌ Don't ignore failing tests
- ❌ Don't commit broken code
- ❌ Don't skip security checks

## ✅ Checklist Before Submitting

- [ ] Code follows project style guide
- [ ] All tests pass locally
- [ ] No console errors in browser
- [ ] Mobile responsive design works
- [ ] Security best practices followed
- [ ] Documentation is updated
- [ ] CHANGELOG.md is updated
- [ ] No conflicts with main branch
- [ ] Commit messages are descriptive
- [ ] PR description is clear

## 📚 Resources

### Learning Resources
- [PHP Best Practices](https://www.php.net/manual/en/)
- [Security Best Practices](https://owasp.org/www-project-top-ten/)
- [Git Guide](https://git-scm.com/doc)
- [Responsive Design](https://www.w3schools.com/css/css_rwd_intro.asp)

### Project Documentation
- [README.md](README.md) - Main documentation
- [FEATURES.md](FEATURES.md) - Feature documentation
- [CHANGELOG.md](CHANGELOG.md) - Version history

## 👥 Getting Help

### Questions?
- Check documentation first
- Review existing issues
- Ask in issue comments
- Email maintainer

### Need Support?
- Create an issue
- Provide detailed information
- Be patient for responses
- Follow up if needed

## 🎉 Recognition

Contributors will be:
- Added to this file
- Mentioned in CHANGELOG.md
- Credited in commits
- Recognized in release notes

## 📞 Contact

- **Maintainer**: hamdy
- **Email**: [Email contact if available]
- **Issues**: GitHub Issues
- **Security**: Use GitHub Security Advisory

## 📄 License

By contributing, you agree that your contributions will be licensed under the same license as the project (Free for educational and commercial use).

---

**Thank you for contributing! Your efforts help make QR Code Generator better for everyone.** 🙏

---

**Last Updated**: May 2026
