
# Notepad PHP

A simple PHP-based notepad application that allows users to create, edit, delete, and view notes. Users can also view the history of deleted notes.

## Features

- User registration and login system
- Add, edit, and delete notes
- View deleted notes history
- Secure password hashing
- Responsive design

## Prerequisites

Before running this project, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/index.html) or any LAMP/WAMP/MAMP stack
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Git (optional, for version control)

## Installation

 1. Clone the repository:
 ```
git clone https://github.com/Brbn-jpg/Notepad-php.git
```
2. Import the database:
- Open phpMyAdmin or any MySQL client.
- Create a database named notes_app.
- Import the database.sql file located in the project root.
3. Configure the database connection:
- Open connection.php.
- Update the database credentials if necessary:

        <?php
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "notes_app";
4. Start the server:
- Place the project folder in the htdocs directory of XAMPP.
- Start Apache and MySQL from the XAMPP control panel.
- Access the application in your browser at http://localhost/Notepad-php.

# Usage
1. Register a new user account.
2. Log in to access the notepad features.
3. Add, edit, delete, and view notes.
4. View the history of deleted notes.

## Authors
- [Brbn](https://github.com/Brbn-jpg)
- [Geratis](https://github.com/Geratis)
