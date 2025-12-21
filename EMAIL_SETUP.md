# Email Configuration Setup

## Overview
The website now includes a complete email system for handling contact forms and project funding requests. The system sends professional HTML emails to the foundation administrators with a copy to the sender.

## What was integrated:

### 1. **Email Service Components** (in `/src/`)
- `EmailService.php` - Main email service handler
- `SMTPClient.php` - Low-level SMTP client (works without PHPMailer)
- `EmailTemplates.php` - Professional HTML email templates

### 2. **Features**
- ✅ **Contact Form** - Sends formatted emails from website visitors
- ✅ **Project Request Form** - Sends detailed funding applications
- ✅ **Professional HTML Templates** - Beautiful, branded email design
- ✅ **Auto CC** - Sender receives a copy of their submission
- ✅ **SMTP Support** - Works with IONOS, Gmail, and other SMTP providers
- ✅ **No Dependencies** - Works without PHPMailer (pure PHP implementation)

### 3. **Email Configuration**

#### Step 1: Create `.env` file
Copy `.env.example` to `.env` in the root directory:
```bash
cp .env.example .env
```

#### Step 2: Configure SMTP Settings
Edit `.env` with your email server details:

```env
# SMTP Email Configuration
SMTP_HOST=smtp.ionos.de
SMTP_PORT=587
SMTP_USERNAME=info@andreas-pareigis-stiftung.de
SMTP_PASSWORD=your-actual-password

# Email Addresses
FROM_EMAIL=info@andreas-pareigis-stiftung.de
FROM_NAME=Andreas Pareigis Stiftung
ADMIN_EMAIL=info@andreas-pareigis-stiftung.de
```

#### Common SMTP Settings:

**IONOS:**
```env
SMTP_HOST=smtp.ionos.de
SMTP_PORT=587
```

**Gmail:**
```env
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
# Note: Requires App Password (not regular password)
```

**Office 365:**
```env
SMTP_HOST=smtp.office365.com
SMTP_PORT=587
```

### 4. **Security Notes**
- ⚠️ **IMPORTANT**: Never commit `.env` file to version control
- ✅ `.env` is already in `.gitignore`
- ✅ Use strong passwords
- ✅ For Gmail, create an App Password in Google Account settings

### 5. **Testing**

1. Start the PHP server:
```bash
php -S localhost:8000 -t public
```

2. Navigate to:
- Contact Form: `http://localhost:8000/contact.php`
- Project Request: `http://localhost:8000/request.php`

3. Submit a test form and check:
   - Admin receives email
   - Sender receives CC copy
   - Email displays properly (HTML formatting)

### 6. **Troubleshooting**

#### Email not sending:
1. Check `.env` file exists and has correct credentials
2. Verify SMTP host and port are correct
3. Check server error logs: `tail -f /var/log/apache2/error.log`
4. Test SMTP connection manually

#### Common Issues:

**"Failed to connect to SMTP server"**
- Check firewall allows outbound port 587/465
- Verify SMTP host is correct
- Check if hosting provider blocks SMTP

**"Authentication failed"**
- Verify username/password are correct
- For Gmail, use App Password, not regular password
- Check if 2FA is enabled (requires App Password)

**"Email goes to spam"**
- Add SPF record to DNS
- Add DKIM signature (advanced)
- Use verified sender domain

### 7. **Email Templates**

#### Contact Form Email includes:
- Sender's name, email, phone (optional)
- Subject (if provided)
- Message content
- Timestamp
- Professional branding

#### Project Request Email includes:
- Applicant details (name, organization, contact info)
- Project details (title, category, target age group)
- Project description and goals
- Budget information (total budget, requested amount, breakdown)
- Additional information (experience, community need, sustainability)
- Professional branding

### 8. **Customization**

#### Change Email Branding:
Edit `/src/EmailTemplates.php` - Look for the header section:
```php
<td style="background: linear-gradient(135deg, #2563eb, #7c3aed); padding: 30px; text-align: center;">
    <h1>Andreas Pareigis Stiftung</h1>
</td>
```

#### Add Logo:
Add your logo to the email template header (base64 encoded or hosted URL).

### 9. **Files Modified**
- `/public/contact_submit.php` - Updated to use EmailService
- `/public/request_submit.php` - Updated to use EmailService with PDF generation

### 10. **Production Deployment**

1. Upload new files to server
2. Create `.env` file on server with production credentials
3. Set file permissions:
```bash
chmod 600 .env  # Only owner can read/write
```

4. Test thoroughly before going live

## Support

The email system is built from proven code (from Heidmark Imkerei project) and is production-ready. All components are self-contained and work without external dependencies beyond standard PHP.
