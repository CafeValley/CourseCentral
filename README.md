# CourseCentral

A comprehensive course and student management system for educational institutions. CourseCentral provides a complete solution for managing students, courses, groups, payments, attendance, and academic records.

## 📋 Table of Contents

- [Features](#features)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Project Structure](#project-structure)
- [Security Notes](#security-notes)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### Student Management
- **Student Registration**: Complete student registration system with personal information tracking
- **Student Profiles**: Comprehensive student profiles with contact details, birth dates, and academic history
- **Student Search**: Quick search and filter students by ID or name
- **Student Reports**: Detailed reports for individual students including courses, payments, and marks

### Course & Level Management
- **Level Management**: Create and manage course levels with customizable fees and periods
- **Group Management**: Organize students into groups with specific teachers, schedules, and time slots
- **Course Scheduling**: Flexible time slot management for course groups
- **Books Management**: Track course materials and book usage across levels

### Payment & Financial Management
- **Registration Fees**: Handle initial registration payments with discount options
- **Installment Payments**: Support for multiple payment installments (2nd, 3rd, etc.)
- **Early Bird Discounts**: Automatic early registration fee discounts
- **Fee Settings**: Configurable fee structure (Registration, Student, Early Bird, Freeze, Unfreeze fees)
- **Payment Tracking**: Daily and period-based payment reports
- **Payment History**: Complete payment history for each student
- **Extra Payments**: Handle placement tests and other miscellaneous payments

### Academic Management
- **Mark Entry**: Record and manage student marks/grades
- **Attendance Management**: Generate and print attendance sheets
- **Grade Reports**: Comprehensive grade reports with pass/fail statistics
- **Success Rate Tracking**: Monitor overall student success rates

### Freeze/Unfreeze System
- **Freeze Studies**: Temporarily freeze student enrollment
- **Unfreeze Studies**: Resume frozen student enrollment
- **Freeze Reports**: Track all frozen students and their status

### Reports & Analytics
- **Group Reports**: List all groups with detailed statistics
- **Student Lists**: Comprehensive student listings ordered by ID or name
- **Payment Reports**: Daily and period-based financial reports
- **Level Reports**: Track books used across all courses
- **Teacher Reports**: List all teachers and their assigned groups
- **Attendance Reports**: Generate attendance sheets for groups

### System Administration
- **User Authentication**: Secure login system with session management
- **Admin Dashboard**: Overview dashboard with daily statistics
- **System Settings**: Configurable system-wide settings
- **Data Export**: Generate printable reports for various entities

### Additional Features
- **Gate Pass Management**: Handle student gate passes
- **Leave Management**: Student leave request system
- **Teacher Management**: Manage teacher profiles and assignments
- **Time Management**: Flexible course timing system
- **Discount Management**: Support for various discount types (25%, 50%, 90%, etc.)

## 🛠 Technology Stack

- **Backend**: PHP (with MySQLi)
- **Database**: MySQL
- **Frontend**: 
  - HTML5
  - CSS3 (Bootstrap 3)
  - JavaScript (jQuery)
  - Font Awesome icons
- **Additional Libraries**:
  - Bootstrap (responsive framework)
  - jQuery (JavaScript library)
  - Bootstrap Datepicker
  - Chart.js (for data visualization)

## 📦 Requirements

- **Server**: Apache or Nginx
- **PHP**: Version 7.4 or higher (PHP 8.x compatible)
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **PHP Extensions**:
  - mysqli
  - session
  - mbstring
  - json

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/CourseCentral.git
   cd CourseCentral
   ```

2. **Copy the code directory to your web server**
   ```bash
   cp -r code /path/to/your/webroot/CourseCentral
   ```

3. **Set proper permissions**
   ```bash
   chmod 755 /path/to/your/webroot/CourseCentral/code
   ```

4. **Import the database**
   - See [Database Setup](#database-setup) section below

5. **Configure the application**
   - See [Configuration](#configuration) section below

## ⚙️ Configuration

### Database Configuration

**⚠️ IMPORTANT: Update database credentials before deployment**

Edit the `code/config.php` file and update the following variables:

```php
$hostname = 'localhost';        // Your database host
$dbusername = 'your_username';  // Your database username
$dbpassword = 'your_password';  // Your database password
$dbname = 'your_database';      // Your database name
```

**Security Note**: 
- Never commit actual database credentials to version control
- Consider using environment variables or a `.env` file for production
- Use strong, unique passwords for production databases

### Timezone Configuration

The system is configured for `Africa/Khartoum` timezone by default. To change it, edit `code/config.php`:

```php
date_default_timezone_set("Your/Timezone");
```

### System Name

The system name can be customized in `code/config.php`:

```php
$SYSTEM_NAME = "CourseCentral";
```

## 🗄 Database Setup

1. **Create a new MySQL database**
   ```sql
   CREATE DATABASE concor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Import the database schema**
   - A database backup file is available at `code/backupdb/concor-main.sql`
   - Import it using phpMyAdmin or command line:
     ```bash
     mysql -u your_username -p your_database < code/backupdb/concor-main.sql
     ```

3. **Verify database connection**
   - Update database credentials in `config.php` (see Configuration section)
   - Test the connection by accessing the login page

### Database Tables

The system uses the following main tables:
- `student` - Student information
- `registration` - Course registrations
- `group` - Course groups
- `levels` - Course levels
- `paymenttwo` - Payment records
- `mark` - Student marks/grades
- `members` - System users
- `fees_change` - Fee configuration
- `teacher` - Teacher information
- And many more supporting tables

## 📁 Project Structure

```
CourseCentral/
├── code/                          # Main application code
│   ├── config.php                 # Main configuration file
│   ├── configspecial.php          # Special configuration
│   ├── helpers.php                # Helper functions
│   ├── index.php                  # Login page
│   ├── homepageAdmin.php          # Admin dashboard
│   ├── checklogin.php             # Login authentication
│   ├── Logout.php                 # Logout handler
│   │
│   ├── Student Management/
│   │   ├── student.php           # Student management
│   │   ├── RegisFrom.php         # Registration form
│   │   ├── Regis.php              # Registration handler
│   │   └── StudentDataMan.php    # Student data management
│   │
│   ├── Course Management/
│   │   ├── level.php              # Level management
│   │   ├── levelsform.php         # Level form
│   │   ├── groups.php             # Group management
│   │   └── groupsform.php         # Group form
│   │
│   ├── Payment Management/
│   │   ├── PaymentTTF.php         # Payment handling
│   │   ├── SecondPayment.php      # Installment payments
│   │   ├── feesset.php            # Fee settings
│   │   └── OtherPaymentStudent.php # Extra payments
│   │
│   ├── Reports/
│   │   ├── ReportlistOfGroup.php
│   │   ├── ReportlistofstudentsEandF.php
│   │   ├── ReportForaStudent.php
│   │   ├── ReportOfPaymentOfToday.php
│   │   └── [Many more report files]
│   │
│   ├── Academic/
│   │   ├── Markformcontrol.php   # Mark entry
│   │   └── attendformcontrol.php  # Attendance
│   │
│   ├── Freeze System/
│   │   ├── freezeform.php        # Freeze students
│   │   └── unfreezeform.php      # Unfreeze students
│   │
│   ├── css/                       # Stylesheets
│   ├── js/                        # JavaScript files
│   ├── bootstrap/                 # Bootstrap framework
│   ├── img/                       # Images and icons
│   └── backupdb/                  # Database backups
│
├── README.md                      # This file
├── IMPROVEMENTS_REPORT.md         # Code improvement report
└── SECURITY_FIXES_APPLIED.md      # Security fixes documentation
```

## 🔒 Security Notes

This project has undergone security improvements. Key security features include:

- ✅ Password hashing (using `password_hash()`)
- ✅ Prepared statements for SQL queries (in critical areas)
- ✅ Session security enhancements
- ✅ Database connection error handling
- ✅ Input validation improvements

**⚠️ Important Security Recommendations:**

1. **Before Production Deployment:**
   - Review and complete remaining security fixes (see `SECURITY_FIXES_APPLIED.md`)
   - Change all default passwords
   - Enable HTTPS/SSL
   - Move database credentials to environment variables
   - Implement CSRF protection for all forms
   - Add comprehensive input validation throughout

2. **Regular Maintenance:**
   - Keep PHP and MySQL updated
   - Regularly backup the database
   - Monitor error logs
   - Review and update security measures

For detailed security information, see:
- `SECURITY_FIXES_APPLIED.md` - Completed security fixes
- `IMPROVEMENTS_REPORT.md` - Comprehensive security audit report

## 💻 Usage

### Accessing the System

1. Navigate to the application URL in your web browser
2. Login with your administrator credentials
3. Use the admin dashboard to access various features

### Common Workflows

**Registering a New Student:**
1. Go to "Registration" from the dashboard
2. Fill in student information
3. Select course level and group
4. Process payment
5. Complete registration

**Recording Payments:**
1. Navigate to "2nd Installment" or relevant payment section
2. Select student and group
3. Enter payment amount
4. Save payment record

**Entering Marks:**
1. Go to "Mark Entry"
2. Select group and level
3. Enter marks for each student
4. Save marks

**Generating Reports:**
1. Navigate to "Reports & Analytics" section
2. Select desired report type
3. Apply filters if needed
4. Generate/print report

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

**Development Guidelines:**
- Follow existing code style
- Add comments for complex logic
- Test thoroughly before submitting
- Update documentation as needed
- Prioritize security in all changes

## 📝 License

This project is proprietary software. All rights reserved.

## 👥 Credits

- **System Name**: CourseCentral
- **Powered by**: Cafavalley
- **Framework**: Bootstrap Responsive Admin Template

## 📞 Support

For issues, questions, or contributions:
- Create an issue in the GitHub repository
- Review the documentation files (`IMPROVEMENTS_REPORT.md`, `SECURITY_FIXES_APPLIED.md`)

## 🔄 Version History

- **Current Version**: In development
- See `code/PatchNotes.txt` for detailed version history

---

**Note**: This system is designed for educational institutions to manage courses, students, payments, and academic records. Ensure proper backup procedures are in place before deploying to production.
