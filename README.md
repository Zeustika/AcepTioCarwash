# TIO CARWASH

Car Wash Booking and Management System

## Overview

TIO CARWASH is a web-based application designed to support car wash businesses in managing their services, bookings, payments, and operational workflows efficiently. The system provides an integrated platform for both customers and administrators, enabling seamless interaction and business process automation.

## Features

### Customer Features

* User registration and authentication
* Browse available car wash services with real-time availability
* Search and filter services
* Book services with date and duration selection
* Upload payment confirmations
* View booking history and transaction status
* Submit inquiries through a contact form
* Locate car wash points with distance calculation

### Administrator Features

* Dashboard with key performance indicators and statistics
* Full management of services (create, read, update, delete)
* Booking management and confirmation
* Payment verification and approval
* User account management and transaction monitoring
* Website content and contact information management
* Car wash location management via interactive maps
* Data export and report generation

### Technical Features

* Responsive design for both desktop and mobile devices
* Interactive map integration using Leaflet.js
* Real-time distance calculation based on user location
* Secure image upload with validation
* Session-based authentication system
* Role-based access control
* Use of prepared statements for database security

## Technology Stack

* Backend: PHP (Native)
* Database: MySQL
* Frontend: HTML5, CSS3, JavaScript
* Libraries and Frameworks:

  * Bootstrap 4
  * jQuery
  * Leaflet.js
  * Font Awesome
* External API:

  * OpenStreetMap Nominatim (Geocoding)

## System Requirements

* PHP version 7.4 or higher
* MySQL version 5.7 or higher
* Web server such as Apache or Nginx
* Modern web browser with JavaScript enabled

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Zeustika/AcepTioCarwash.git
cd tiocarwash
```

### 2. Database Configuration

* Create a new MySQL database
* Import the `database.sql` file from the `/database` directory
* Update database credentials in `koneksi/koneksi.php`

```php
$host = 'localhost';
$user = 'your_username';
$password = 'your_password';
$database = 'your_database_name';
```

### 3. Server Setup

* Place the project directory inside your web server root (e.g., `htdocs` or `www`)
* Ensure the `/assets/image` directory has write permissions

### 4. Default Administrator Account

* Username: admin
* Password: admin123

It is strongly recommended to change the default credentials after the first login.

## Database Structure

The system uses the following main tables:

* `login` – stores user accounts and roles
* `mobil` – stores car wash services data
* `booking` – records customer bookings
* `pembayaran` – stores payment confirmations
* `infoweb` – website configuration data
* `user_washing_points` – location data for car wash points

## Project Structure

```
tiocarwash/
├── admin/
│   ├── booking/
│   ├── mobil/
│   ├── peminjaman/
│   ├── user/
│   └── location.php
├── assets/
│   ├── css/
│   ├── js/
│   └── image/
├── koneksi/
├── header.php
├── footer.php
├── index.php
├── blog.php
├── booking.php
├── history.php
├── kontak.php
├── location.php
└── profil.php
```

## Usage

### For Customers

1. Register an account
2. Browse available services
3. Select a service and create a booking
4. Complete payment via the provided method
5. Upload payment confirmation
6. Monitor booking status through the history page

### For Administrators

1. Log in to the admin panel
2. Manage services and availability
3. Review and confirm bookings
4. Verify customer payments
5. Manage car wash locations
6. Update website settings and generate reports

## Security Considerations

* Passwords are currently hashed using MD5 (upgrade to bcrypt is recommended)
* SQL injection is mitigated using prepared statements
* Session-based authentication is implemented
* Input sanitization using `htmlspecialchars`
* File upload validation for type and size restrictions

## Example UI
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/b704632f-27e3-460d-86b2-044aa9f429ef" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/edde3ede-4088-490e-a4f4-5c7d9011e470" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/804d1a89-96b8-431f-af89-0b7f67c27534" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/3bb81dc6-c0f5-4c27-b862-f6e8b1983180" />


## Example Code

### Database Connection

```php
try {
    $koneksi = new PDO("mysql:host=localhost;dbname=database_name", "username", "password");
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
```

### Prepared Statement Example

```php
$sql = "SELECT * FROM mobil WHERE id_mobil = ?";
$stmt = $koneksi->prepare($sql);
$stmt->execute([$id]);
$result = $stmt->fetch();
```

## Contributing

1. Fork the repository
2. Create a new branch
3. Commit your changes
4. Push to your branch
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Version History

* Version 1.0.0 – Initial release
* Version 1.1.0 – Added map-based location feature
* Version 1.2.0 – Improved dashboard and reporting features

---

Developed as part of an academic project in the PABP course at Universitas Siliwangi.


