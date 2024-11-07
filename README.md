```markdown
# DB-Project

This project is a PHP and MySQL-based application for managing products. Follow the instructions below to set it up and run it on your local machine using XAMPP.

## Getting Started

### Prerequisites

- **XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/index.html) to set up a local server with Apache and MySQL.

### Installation

1. **Clone the Repository**  
   Clone this repository to your local machine, or download it as a ZIP and extract the contents.
   
   ```bash
   git clone https://github.com/yourusername/DB-Project.git
   ```

2. **Move Project to XAMPP’s htdocs Folder**  
   After downloading or cloning the repository, move the entire `DB-Project` folder into XAMPP's `htdocs` directory:
   
   - **Windows**: `C:\xampp\htdocs\`
   - **Mac**: `/Applications/XAMPP/htdocs/`
   - **Linux**: `/opt/lampp/htdocs/`

### Setting Up XAMPP

1. **Start XAMPP**  
   Open XAMPP and start the **Apache** and **MySQL** services. On a Mac, you can start XAMPP from the terminal:
   
   ```bash
   sudo /Applications/XAMPP/xamppfiles/xampp start
   ```

2. **Access phpMyAdmin**  
   Open a browser and go to [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/), which will take you to phpMyAdmin, the web interface for managing your MySQL databases.

### Importing the Database

1. **Create a New Database**  
   In phpMyAdmin, create a new database with an appropriate name - in my files it is `Shopping_System`.

2. **Import Database**  
   With the new database selected, go to the **Import** tab and import the `create.SQL` file located in the sql_files folder. This will set up all necessary tables for the project.

### Configuration

1. **Update Database Connection**  
   Open the `db_connect.php` file located in the project folder, and update the database connection details if necessary:
   
   ```php
   $host = 'localhost'; // Database host
   $user = 'root';      // Database username (default in XAMPP)
   $pass = '';          // Database password (default in XAMPP is empty)
   $db = 'Shopping_System';  // Name of the database you created in phpMyAdmin
   ```

### Running the Project

1. **Open the Project in a Browser**  
   After starting Apache and MySQL in XAMPP, open a web browser and go to:
   
   ```plaintext
   http://localhost/DB-Project/
   ```
   You should now be able to view and interact with the application.

## Additional Notes

- **Error Handling**: If you encounter database connection errors, double-check the settings in `db_connect.php` and ensure your MySQL server is running.
- **PHP Version Compatibility**: Make sure you’re running a PHP version compatible with the functions used in this project (recommended: PHP 7.4+).
- **Project Directory Name**: Ensure the folder in `htdocs` is named `DB-Project`. If you rename it, adjust the URL accordingly.

---

If you have any questions or run into issues, feel free to reach out!
```
