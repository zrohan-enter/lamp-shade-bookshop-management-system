\# 📚 Lamp Shade: Bookshop Management System

A comprehensive full-stack online bookstore built with **PHP, MySQL, and XAMPP**. Features secure authentication, real-time search, persistent shopping cart, atomic transactions, and a powerful admin dashboard for inventory and order management.





---

\#\# 📑 Table of Contents

- [About](https://www.google.com/search?q=23about)
- [Features](https://www.google.com/search?q=23features)
- [Tech Stack](https://www.google.com/search?q=23tech-stack)
- [Project Structure](https://www.google.com/search?q=23project-structure)
- [Getting Started](https://www.google.com/search?q=23getting-started)
  - [Prerequisites](https://www.google.com/search?q=23prerequisites)
  - [Installation](https://www.google.com/search?q=23installation)
  - [Configuration](https://www.google.com/search?q=23configuration)
- [Usage](https://www.google.com/search?q=23usage)
- [Security](https://www.google.com/search?q=23security)
- [Roadmap](https://www.google.com/search?q=23roadmap)
- [Contributing](https://www.google.com/search?q=23contributing)
- [License](https://www.google.com/search?q=23license)
- [Contact](https://www.google.com/search?q=23contact)
- [Acknowledgments](https://www.google.com/search?q=23acknowledgments)

---

\#\# About

**Lamp Shade Stories** is a professional-grade e-commerce platform for online book retail. It demonstrates best practices in web development including secure authentication, database transactions, and user session management.

\#\#\# Key Highlights
- 🔒 **Enterprise-grade security** with password hashing (PASSWORD\_DEFAULT), input sanitization, and prepared statements
- 💳 **Atomic transactions** with BEGIN/COMMIT/ROLLBACK for data integrity
- 🔍 **Real-time search** with AJAX live suggestions
- 🛒 **Session-based shopping cart** with persistent state management
- 📊 **Admin analytics dashboard** for sales insights
- 📝 **Printable receipts** for orders

---

\#\# Features

\#\#\# Customer Features
✅ User registration & login with secure password hashing  
✅ Live product search with AJAX autocomplete suggestions  
✅ Browse and filter books by category  
✅ Add items to persistent shopping cart  
✅ Secure checkout with atomic transactions  
✅ Order history and tracking  
✅ Printable order receipts  
✅ User profile management  

\#\#\# Admin Features
✅ Secure admin registration & login  
✅ Complete inventory management (add, edit, delete books)  
✅ Order management and order status tracking  
✅ Sales analytics and reporting dashboard  
✅ Revenue and customer insights  
✅ Stock level monitoring  

---

\#\# Tech Stack

| Technology | Purpose |
|:---|:---|
| **PHP** (7.x+) | Backend server-side logic |
| **MySQL** (5.7+) | Relational database |
| **XAMPP** | Local development environment |
| **HTML5 & CSS3** | Frontend markup and styling |
| **JavaScript** | Client-side interactivity and AJAX |
| **jQuery** | AJAX and DOM manipulation |
| **Bootstrap** (optional) | Responsive UI framework |

---

\#\# Project Structure

`  lamp-shade-bookshop-management-system/ │ ├── index.php                        # Home page with product listing ├── login.php                        # Customer login ├── register.php                     # Customer registration ├── login_choice.php                 # Login type selector ├── logout.php                       # Session termination │ ├── cart.php                         # Shopping cart management ├── generate_receipt.php             # Receipt generation │ ├── profile.php                      # User profile page ├── order_history.php                # Customer order history │ ├── admin_login.php                  # Admin login ├── admin_register.php               # Admin registration ├── admin_dashboard.php              # Admin main dashboard ├── manage_books.php                 # Inventory management ├── manage_orders.php                # Order management ├── manage_inventory.php             # Stock management ├── admin_analytics.php              # Sales analytics & reports │ ├── search_suggest.php               # AJAX search suggestions ├── insert_books_script.php          # Book data seeding │ ├── bookshop_db.sql                  # Full database schema ├── schema.sql                       # Schema reference │ ├── css/                             # Stylesheets ├── images/                          # Product images ├── includes/                        # Shared PHP functions │ ├── config.sample.php                # Configuration template ├── .gitignore                       # Git ignore rules └── README.md                        # This file  `

---

\#\# Getting Started

\#\#\# Prerequisites

- **PHP** \>= 7.0
- **MySQL** \>= 5.7
- **XAMPP** or LAMP stack installed
- **Web browser** (Chrome, Firefox, Safari, Edge)
- **Git** for version control

\#\#\# Installation

\#\#\#\# 1. Clone the Repository
`bash git clone https://github.com/zrohan-enter/lamp-shade-bookshop-management-system.git cd lamp-shade-bookshop-management-system `

\#\#\#\# 2. Import the Database Schema
`bash mysql -u root -p < bookshop_db.sql `
When prompted, enter your MySQL root password (default is empty in XAMPP).

\#\#\#\# 3. Configure the Application

Copy the sample configuration file:
`bash cp config.sample.php config.php `

Edit `config.php` and update your database credentials:
`php <?php $servername = "localhost"; $username = "root"; $password = ""; // XAMPP default $dbname = "bookshop_db"; ?> `

**⚠️ Security Note:** Ensure `config.php` is in `.gitignore` to prevent committing real credentials.

\#\#\#\# 4. Place Project in Web Root
- Copy the entire project folder to `htdocs/` (XAMPP):
`bash C:\xampp\htdocs\lamp-shade-bookshop-management-system\ `
- Or your LAMP stack web root directory

\#\#\#\# 5. Start XAMPP/LAMP Services
- Start Apache and MySQL services via XAMPP Control Panel

\#\#\#\# 6. Access the Application
Open in your browser:
`  http://localhost/lamp-shade-bookshop-management-system/  `

---

\#\# Usage

\#\#\# 🏠 Customer Journey

| Page | Purpose |
|:---|:---|
| **index.php** | Browse all available books |
| **register.php** | Create new customer account |
| **login.php** | Customer login |
| **cart.php** | View and manage shopping cart |
| **checkout** | Secure payment checkout |
| **order\_history.php** | View past orders |
| **profile.php** | Manage user account details |
| **generate\_receipt.php** | Download/print order receipt |

\#\#\# 🔧 Admin Journey

| Page | Purpose |
|:---|:---|
| **admin\_login.php** | Admin authentication |
| **admin\_dashboard.php** | Main admin control center |
| **manage\_books.php** | Add, edit, delete books |
| **manage\_orders.php** | Process and track orders |
| **manage\_inventory.php** | Monitor stock levels |
| **admin\_analytics.php** | Sales analytics & reports |

---

\#\# Security

\#\#\# Implementation
✅ **Password Security**: `password_hash()` with PASSWORD\_DEFAULT algorithm  
✅ **Input Validation**: Sanitized user inputs using `mysqli_real_escape_string()`  
✅ **SQL Injection Prevention**: Prepared statements and parameterized queries  
✅ **Session Management**: Secure PHP sessions with unique identifiers  
✅ **Database Transactions**: ACID compliance with BEGIN/COMMIT/ROLLBACK  
✅ **Configuration**: Sensitive credentials in `.gitignore` files  

\#\#\# Best Practices
- Sensitive files (`config.php`) excluded from version control
- Admin credentials stored with bcrypt hashing
- Session validation on every page load
- CSRF tokens recommended for forms (TODO: implement)

---

\#\# Database Schema

\#\#\# Key Tables

**users**
`sql - user_id (PK) - username (UNIQUE) - password (hashed) - email - full_name - created_at `

**admins**
`sql - admin_id (PK) - admin_username (UNIQUE) - admin_password (hashed) - created_at `

**books**
`sql - book_id (PK) - title - author - genre - price - quantity_available - description - image_url `

**orders**
`sql - order_id (PK) - user_id (FK) - order_date - total_amount - status - delivery_address `

**order\_items**
`sql - item_id (PK) - order_id (FK) - book_id (FK) - quantity - price_at_purchase `

---

\#\# Roadmap

\#\#\# Planned Features
- [ ] 💳 **Payment Gateway Integration** (Stripe, PayPal)
- [ ] 📱 **Mobile App Version** (React Native or Flutter)
- [ ] ☁️ **Cloud Deployment** (AWS, Heroku, DigitalOcean)
- [ ] 🔍 **Advanced Search Filters** (by rating, price range, publication date)
- [ ] ⭐ **Product Reviews & Ratings** System
- [ ] 📧 **Email Notifications** (order confirmation, shipment tracking)
- [ ] 🔐 **CSRF Token Implementation**
- [ ] 🧪 **Unit & Integration Tests**
- [ ] 📖 **API Documentation** (REST endpoints)
- [ ] 🔔 **Admin Review & Report Features**

---

\#\# Contributing

We welcome contributions\! Please follow these steps:

1. **Fork the repository**
   ` bash    click "Fork" button on GitHub     `

2. **Create a feature branch**
   ` bash    git checkout -b feature/YourAmazingFeature     `

3. **Commit your changes**
   ` bash    git commit -m 'Add YourAmazingFeature with description'     `

4. **Push to your branch**
   ` bash    git push origin feature/YourAmazingFeature     `

5. **Open a Pull Request**
   - Provide clear description of changes
   - Link related issues
   - Include test results

\#\#\# Contribution Guidelines
- Follow PSR-12 PHP coding standards
- Ensure code is secure and well-documented
- Test all changes locally before submitting
- Keep commits atomic and descriptive

---

\#\# License

This project is distributed under the **MIT License**. You are free to:
- ✅ Use commercially
- ✅ Modify and distribute
- ✅ Include in private projects
- ✅ Sublicense

See [LICENSE.txt](https://www.google.com/search?q=LICENSE.txt) for detailed terms.

---

\#\# Contact

**Zawed Bin Tariq**
- 📧 Email: [zawed.tariq@northsouth.edu](mailto:zawed.tariq@northsouth.edu)
- 🔗 GitHub: [@zrohan-enter](https://github.com/zrohan-enter)
- 📂 Project: [lamp-shade-bookshop-management-system](https://github.com/zrohan-enter/lamp-shade-bookshop-management-system)

---

\#\# Acknowledgments

\#\#\# Supervisor & Institution
- 👨‍🏫 **Dr. Rafiqul Islam** - Faculty Supervisor
- 🎓 **North South University** - Academic Institution

\#\#\# Resources & Inspiration
- [PHP Official Documentation](https://www.php.net/docs.php)
- [MySQL Reference Manual](https://dev.mysql.com/doc/)
- [OWASP Security Guidelines](https://owasp.org/)
- [Best README Template](https://github.com/othneildrew/Best-README-Template) - README style inspiration
- [Bootstrap Framework](https://getbootstrap.com/) - UI components

\#\#\# Open Source Community
- Thanks to all contributors and testers
- Special thanks to the PHP/MySQL community for guidance

---

\<div align="center"\>

**Made with ❤️ by Zawed Bin Tariq**

⭐ **If you find this project helpful, please consider starring it\!** ⭐

[Back to Top](https://www.google.com/search?q=23-lamp-shade-bookshop-management-system)

\</div\>
