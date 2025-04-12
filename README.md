## 📬 Contact Form with Google reCAPTCHA v3

This project includes a simple HTML contact form that uses **Google reCAPTCHA v3** for spam protection and sends form submissions to an email address using **PHP**.

---
### ✅ Features

- reCAPTCHA v3 integration for spam prevention  
- PHP mail functionality  
- Input validation and sanitization  
- Redirect after successful submission

### 🚀 How to Use

1. **Get reCAPTCHA v3 Keys**  
   Go to [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin/create)  
   - Register your domain  
   - Choose reCAPTCHA v3  
   - Copy the **site key** and **secret key**

2. **Update Keys in Code**
   - In `index.html`, replace `YOUR_SITE_KEY` with your reCAPTCHA **site key**
   - In `send-email.php`, replace `YOUR_SECRET_KEY` with your **secret key**

3. **Configure Email Settings**
   - In `send-email.php`, update the following:
     ```php
     $to = "your@email.com";          // Where the form data will be sent
     $fromEmail = "no-reply@yourdomain.com"; // Email sender (should be on your domain)
     ```

4. **Upload to Your Server**
   - Upload `index.html` and `send-email.php` to your hosting environment (e.g., `/public_html/`)
   - Ensure your server supports PHP and has mail sending enabled

5. **Test the Form**
   - Visit the form in your browser
   - Fill it out and submit
   - You should receive an email and be redirected back to the homepage
