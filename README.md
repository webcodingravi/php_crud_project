A basic PHP & MySQL CRUD (Create, Read, Update, Delete) application built without a framework.
This project demonstrates how to build a real working web app using Core PHP, PDO, form validation, image upload, search, and pagination.

🧾 Features
Add users with name, age, email, mobile, address, status
Upload user image (optional validation)
View list of users
Search users
Pagination for large user lists
Edit user data

Delete user and their image

Server-side validation with error messages

🛠 Technologies Used

PHP (PDO)

MySQL / MariaDB

HTML

Tailwind CSS (or your preferred CSS)

JavaScript (optional for confirmation)

📦 Project Structure
php_crud_project/
│── public/
│   └── uploads/
│── config/
│   └── db.php
│── views/
│   └── ... .php templates
├── index.php         # List users + search + pagination
├── create.php        # Add user form
├── edit.php          # Edit user form
├── delete.php        # Delete handler
├── request.php       # Form handling logic
└── README.md         # Project documentation

📥 Installation

Clone the repository:

git clone https://github.com/webcodingravi/php_crud_project.git
cd php_crud_project


Move into your local server directory:

For XAMPP:

C:\xampp\htdocs\


For WAMP:

C:\wamp64\www\


Import database:

Open phpMyAdmin

Create a database (e.g., php_crud_project)

Import the SQL file provided (if included)
or run your own table creation script:

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    email VARCHAR(150),
    mobile VARCHAR(20),
    address TEXT,
    image VARCHAR(255),
    status VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


Configure database:

Edit config/db.php to include your MySQL credentials:

<?php
$host = "localhost";
$db   = "php_crud_project";
$user = "root";
$pass = "";

$conn = new PDO(
    "mysql:host=$host;dbname=$db;charset=utf8",
    $user,
    $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

🚀 Usage

Visit the project in your browser:

http://localhost/php_crud_project/


Use the navigation to Add User

Use search to filter users

Page through results using pagination

Edit or delete users from the list

📌 What You’ll Learn

This project teaches how to:

Structure a beginner PHP application

Use PDO for secure database interaction

Validate form inputs server side

Upload and manage files

Integrate search and pagination

Show success and error feedback

Securely delete records and files

🧠 Tips for Improvement

Add login/auth system

Add modal confirmation with JavaScript

Enhance UI with Tailwind or Bootstrap components

Add CSRF protection

Implement soft delete (status toggle)

