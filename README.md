# HireZone

**HireZone** is a complete academic job portal system developed using **PHP** and **MySQL**, designed for demonstration and learning purposes in a web development project. It includes secure login, job listings, application handling, and multi-role user dashboards.

---

## 🔧 Project Structure

```
/hirezone
├── html/           # Main PHP/HTML pages (frontend and logic)
├── css/            # Stylesheets (e.g., style.css)
├── images/         # Visual assets (logos, video, maps)
├── config/         # Configuration files (e.g., DB connection)
├── logs/           # Simulated logs (emails, login history, etc.)
├── tests/          # Development test scripts (e.g., DB, users)
├── composer.json   # Composer project metadata
├── favicon.ico     # Browser icon
├── README.md       # Project documentation
```

---

## ✅ Features

- Secure login system with **hashed passwords**
- Role-based dashboards:
  - 👤 **Candidate**: Register, login, view opportunities, apply for jobs
  - 🏢 **Company**: Post, edit, delete jobs; view applicants for each job
  - 👨‍💼 **Admin**: Manage users, including blocking and deleting accounts
- Job search and application tracking
- CAPTCHA-like validation for login forms
- Email simulation saved to log files
- Video and image support on homepage

---

## 💡 Technologies Used

### Backend
- **PHP**: Core application logic and server-side processing
- **MySQL**: Relational database to store users, jobs, and applications
- **Composer**: PHP dependency management (via `composer.json`)

### Frontend
- **HTML & CSS**: Page structure and visual styling
- **JavaScript** *(optional)*: For interactive components and validations

### Multimedia
- Images and logo assets
- Homepage video (`videorh.mp4`) displayed in loop

### Configuration & Testing
- `config/database_connection.php`: Secure DB connection file
- `tests/test-connection.php`, `tests/test-users.php`: Basic functionality tests

---

## 🚀 Installation

1. Clone the repository:
```bash
git clone https://github.com/VitorOliveiraTrindadeCCT/hirezone.git
```

2. Move the project to your local server directory:
```
C:\xampp\htdocs\hirezone
```

3. Start **Apache** and **MySQL** from the XAMPP Control Panel.

4. Create a MySQL database named `hirezone` and user:
- **Username:** `hirezone_user`
- **Password:** `123456`

5. [Optional] Set up a virtual host:
```
http://hirezone.local → C:\xampp\htdocs\hirezone
```

6. Access the system via your browser:
```
http://localhost/hirezone/html/index.php
```

---

## 🧪 Testing

- `test-connection.php`: Tests the MySQL database connection
- `send-mail-simulated.php`: Simulates email functionality by logging messages to `/logs/email_log.txt`

---

## 📝 Notes

- No external libraries are required
- All credentials and mail delivery are simulated for academic purposes
- The system can serve as a base for real-world applications with minimal adaptation

---

## 👨‍💻 Author

**Vitor Oliveira Trindade**  
Student ID: 2024336@student.cct.ie  
GitHub: [https://github.com/VitorOliveiraTrindadeCCT](https://github.com/VitorOliveiraTrindadeCCT)
