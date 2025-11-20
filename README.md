# Event Registration Portal

This is a simple online event registration portal built with PHP (procedural style), MySQL (PDO), and Bootstrap 5+.

## Features

- Responsive registration form with client-side and server-side validation.
- Photo upload functionality.
- Stores registration data in a MySQL database.
- Generates unique registration tags (PDF generation with TCPDF to be integrated).
- Admin dashboard for viewing, searching, and filtering registrants.
- Simple password-protected admin login.

## Setup Instructions

### 1. Project Structure

Ensure your project has the following directory structure:

```
event_registration/
├── index.php                 # Registration form
├── process_registration.php  # Handles form submission and PDF generation
├── admin/
│   ├── index.php             # Admin login page
│   ├── view_registrations.php  # Admin dashboard
│   └── logout.php            # Admin logout
├── includes/
│   ├── db_connect.php        # PDO MySQL connection
│   └── config.php            # Application settings
├── tcpdf/                    # TCPDF library (manual installation required)
├── uploads/                  # Uploaded photos
└── tags/                     # Generated registration PDFs
```

### 2. Database Setup

1.  **Import SQL Schema:**
    Import the `event_registration.sql` file into your MySQL server to create the `event_registration_db` database and the `registrants` table. You can do this via phpMyAdmin or the MySQL command line:

    ```bash
    mysql -u your_username -p < event_registration.sql
    ```
    Replace `your_username` with your MySQL username. You will be prompted for your password.

### 3. Configure `includes/db_connect.php`

Open `event_registration/includes/db_connect.php` and update the `$user` and `$pass` variables with your MySQL database credentials.

```php
// ... existing code ...
$host = 'localhost';
$db   = 'event_registration_db';
$user = 'root'; // <-- Update with your MySQL username
$pass = '';     // <-- Update with your MySQL password
$charset = 'utf8mb4';
// ... existing code ...
```

### 4. Configure `includes/config.php`

Open `event_registration/includes/config.php` to set your event name and admin credentials. **For a production environment, use hashed passwords and a more secure authentication method.**

```php
// ... existing code ...
define('EVENT_NAME', 'Awesome Tech Conference 2025'); // Customize event name
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'password'); // CHANGE THIS IN PRODUCTION!
// ... existing code ...
```

### 5. Install TCPDF (Manual)

1.  Download the latest TCPDF library from the official website: [https://tcpdf.org/download/](https://tcpdf.org/download/)
2.  Extract the contents of the downloaded ZIP file directly into the `event_registration/tcpdf/` directory.
    Ensure that `tcpdf.php` is located directly under `event_registration/tcpdf/`.

### 6. Run the Application (XAMPP)

1.  Place the entire `event_registration` folder inside your XAMPP's `htdocs` directory.
2.  Start Apache and MySQL services from the XAMPP control panel.
3.  Open your web browser and navigate to `http://localhost/event_registration/` to access the registration form.

### 7. Admin Access

To access the admin dashboard, navigate to `http://localhost/event_registration/admin/`.
Use the `ADMIN_USERNAME` and `ADMIN_PASSWORD` defined in `includes/config.php` to log in.
