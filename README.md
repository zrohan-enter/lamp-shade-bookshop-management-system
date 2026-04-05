# Lamp Shade: Bookshop Management System



   

## Table of Contents
- About
- Built With
- Getting Started
- Usage
- Roadmap
- Contributing
- License
- Contact
- Acknowledgments

## About

"Lamp Shade Stories" is a full-featured online bookstore built with PHP, MySQL and XAMPP. It supports customer registration and login, live AJAX search suggestions, session-based shopping cart, atomic checkout transactions, admin dashboards for inventory, orders and analytics, and printable receipts.

Strong focus on security: password hashing (PASSWORD_DEFAULT), input sanitization, and transaction integrity.

### Features
- Customer registration & login (secure hashing)
- Live search suggestions (AJAX)
- Persistent shopping cart (sessions)
- Atomic checkout transactions (BEGIN/COMMIT/ROLLBACK)
- Admin dashboard: manage books, orders, analytics

## Built With




## Getting Started

### Prerequisites
- PHP >= 7.x
- MySQL
- XAMPP or LAMP stack
- Web browser

### Installation
1. Clone the repo:
bash git clone https://github.com/zrohan-enter/lamp-shade-bookshop-management-system.git 

2. Import the database schema:

bash mysql -u root -p bookshop_db < bookshop_db.sql 

3. Copy config.sample.php → config.php and set DB credentials. Do not commit real credentials. Make sure config.php is included in .gitignore.
4. Place project in htdocs/ (XAMPP) and open in your browser:

 http://localhost/lamp-shade-bookshop-management-system/ 

## Usage

### Home Page



### Live Search Suggestions



### Admin Login



### Customer Login



### Shopping Cart



### Order History



### Admin Analytics



### Manage Books



### Manage Orders



### Sales Receipt



## Roadmap

* [ ] Payment gateway integration
* [ ] Mobile app version
* [ ] Cloud deployment
* [ ] Supervisor review and report link

## Contributing

1. Fork the project
2. Create your feature branch (git checkout -b feature/AmazingFeature)
3. Commit your changes (git commit -m 'Add some AmazingFeature')
4. Push to the branch (git push origin feature/AmazingFeature)
5. Open a Pull Request



## License

Distributed under the MIT License. See LICENSE.txt for more information.

## Contact

Zawed Bin Tariq - zawed.tariq@northsouth.edu
Project Link: https://github.com/zrohan-enter/lamp-shade-bookshop-management-system


## Acknowledgments

* Supervisor: Dr. Rafiqul Islam
* University: North South University
* Inspired by Best-README-Template style
