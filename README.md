# Notepad PHP

A simple PHP-based notepad application that allows users to create, edit, delete, and view notes. Users can also view the history of deleted notes.

## Features

- User registration and login system
- Add, edit, and delete notes
- View deleted notes history
- Secure password hashing
- Responsive design
- Multilingual support (English and Polish)
- Mobile-friendly navigation

## Prerequisites

Before running this project, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/index.html) or any LAMP/WAMP/MAMP stack
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Git (optional, for version control)
- Node.js and npm (for frontend development)

## Installation

### Backend Setup

1. Clone the repository:
   ```
   git clone https://github.com/Brbn-jpg/Notepad-php.git
   ```
2. Import the database:
   - Open phpMyAdmin or any MySQL client.
   - Create a database named `notes_app`.
   - Import the `database.sql` file located in the project root.
3. Configure the database connection:
   - Open `backend/connection.php`.
   - Update the database credentials if necessary:
     ```php
     <?php
     $dbhost = "localhost";
     $dbuser = "root";
     $dbpass = "";
     $dbname = "notes_app";
     ```
4. Place the project folder in the `htdocs` directory of XAMPP.
5. Start Apache and MySQL from the XAMPP control panel.

### Frontend Setup

1. Navigate to the `frontend` directory:
   ```
   cd frontend
   ```
2. Install dependencies:
   ```
   npm install
   ```
3. Start the development server:
   ```
   npm run serve
   ```
4. Access the application in your browser at `http://localhost:8080`.

## Usage

1. Register a new user account.
2. Log in to access the notepad features.
3. Add, edit, delete, and view notes.
4. View the history of deleted notes.
5. Switch between English and Polish using the language toggle in the navigation bar.

## Project Structure

- **Frontend**: Vue.js-based single-page application located in the `frontend` directory.
- **Backend**: PHP-based API located in the `backend` directory.
- **Database**: MySQL database schema defined in `database.sql`.

## Authors

- [Brbn](https://github.com/Brbn-jpg)
- [Geratis](https://github.com/Geratis)

## License

This project is licensed under the MIT License. See the LICENSE file for details.
