# HireZone

HireZone is a simple academic job portal system developed using PHP and MySQL, built for demonstration purposes in a web development project.

## Project Structure

/hirezone
    ├── html/ # Main PHP/HTML pages (frontend)
    ├── css/ # Stylesheets (e.g., style.css)
    ├── js/ # JavaScript files (optional)
    ├── config/ # Configuration files (e.g., DB connection)
    ├── logs/ # Simulated logs (emails, login history, etc.)
    ├── composer.json # Composer project metadata
    ├── .gitignore # Git exclusion rules

    
## Requirements

- PHP 8.0 or higher
- MySQL (via XAMPP)
- Web browser (Chrome, Firefox, etc.)

## Installation

1. Clone the repository:
git clone https://github.com/VitorOliveiraTrindadeCCT/hirezone.git



2. Place the project in your local server directory:

C:\xampp\htdocs\hirezone


3. Start Apache and MySQL from XAMPP Control Panel.

4. Create a MySQL database named `hirezone` and a user with the following credentials:
- User: `hirezone_user`
- Password: `123456`

5. Set up the virtual host:
- Map `http://hirezone.local` to the project folder

6. Access the system in your browser:


## Testing

- Run `test-connection.php` to verify the database connection
- Run `send-mail-simulated.php` to simulate email logging

## Notes

- No external dependencies are required
- Email is simulated and recorded in `logs/email_log.txt`
- The system is designed for academic demonstration purposes only

## Author

Vitor Trindade  
Student ID: 2024336@student.cct.ie  
GitHub: [https://github.com/VitorOliveiraTrindadeCCT](https://github.com/VitorOliveiraTrindadeCCT)

