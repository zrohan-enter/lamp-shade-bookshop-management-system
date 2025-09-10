````markdown
# Lamp Shade: Bookshop Management System

![Project Logo](images/screenshot1.png)

[![GitHub stars](https://img.shields.io/github/stars/your-github-username/lamp-shade-bookshop-management-system)](https://github.com/your-github-username/lamp-shade-bookshop-management-system/stargazers) [![GitHub forks](https://img.shields.io/github/forks/your-github-username/lamp-shade-bookshop-management-system)](https://github.com/your-github-username/lamp-shade-bookshop-management-system/network/members) [![GitHub issues](https://img.shields.io/github/issues/your-github-username/lamp-shade-bookshop-management-system)](https://github.com/your-github-username/lamp-shade-bookshop-management-system/issues) [![GitHub license](https://img.shields.io/github/license/your-github-username/lamp-shade-bookshop-management-system)](LICENSE.txt)

## Table of Contents
- [About](#about)
- [Built With](#built-with)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)
- [Acknowledgments](#acknowledgments)

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

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white) ![Apache](https://img.shields.io/badge/Apache-FCC624?style=for-the-badge&logo=apache&logoColor=white) ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black) ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

## Getting Started

### Prerequisites
- PHP >= 7.x
- MySQL
- XAMPP or LAMP stack
- Web browser

### Installation
1. Clone the repo:
```bash
git clone https://github.com/your-github-username/lamp-shade-bookshop-management-system.git
````

2. Import the database schema:

```bash
mysql -u root -p bookshop_db < schema.sql
```

3. Copy `config.sample.php` → `config.php` and set DB credentials. **Do not commit real credentials**. Make sure `config.php` is included in `.gitignore`.
4. Place project in `htdocs/` (XAMPP) and open in your browser:

```
http://localhost/lamp-shade-bookshop-management-system/
```

## Usage

### Home Page

![Home Page](images/screenshot1.png)

### Live Search Suggestions

![Live Search Suggestions](images/screenshot2.png)

### Admin Login

![Admin Login](images/screenshot3.png)

### Customer Login

![Customer Login](images/screenshot4.png)

### Shopping Cart

![Shopping Cart](images/screenshot5.png)

### Order History

![Order History](images/screenshot6.png)

### Admin Analytics

![Admin Analytics](images/screenshot7.png)

### Manage Books

![Manage Books](images/screenshot8.png)

### Manage Orders

![Manage Orders](images/screenshot9.png)

### Sales Receipt

![Sales Receipt](images/screenshot10.png)

## Roadmap

* [ ] Payment gateway integration
* [ ] Mobile app version
* [ ] Cloud deployment
* [ ] Supervisor review and report link

## Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

![Contributors](https://contrib.rocks/image?repo=https://github.com/your-github-username/lamp-shade-bookshop-management-system)

## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

## Contact

Zawed Bin Tariq - [zawed.tariq@northsouth.edu](mailto:zawed.tariq@northsouth.edu)
Project Link: [https://github.com/your-github-username/lamp-shade-bookshop-management-system](https://github.com/your-github-username/lamp-shade-bookshop-management-system)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-Zawed%20Tariq-blue?style=for-the-badge\&logo=linkedin\&logoColor=white)](https://www.linkedin.com/in/zawed-tariq)

## Acknowledgments

* Supervisor: Dr. Rafiqul Islam
* University: North South University
* Inspired by Best-README-Template style

```
```
