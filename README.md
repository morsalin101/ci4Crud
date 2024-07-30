CRUD Application with CodeIgniter 4
This project is a simple CRUD (Create, Read, Update, Delete) application built using CodeIgniter 4 (CI4). The application includes user authentication (signup and login) and a management system for student records.

Features
User Signup and Login: Secure user authentication system.
Student Management: Full CRUD operations for managing student records.
Pagination: Paginated student records display.
Responsive Design: User-friendly interface built with Bootstrap.
Prerequisites
Before you begin, ensure you have the following installed:

PHP 7.3 or higher
Composer
MySQL
Setup
1. Clone the Repository
bash
Copy code
git clone https://github.com/your-username/my-crud-app.git
cd my-crud-app
2. Install Dependencies
Install the required PHP dependencies using Composer:

bash
Copy code
composer install
3. Configure the Database
Create a new MySQL database and configure the database settings in the .env file:

plaintext
Copy code
database.default.hostname = localhost
database.default.database = my_crud_app
database.default.username = root
database.default.password = password
database.default.DBDriver = MySQLi
Run the following SQL script to create the necessary tables:

sql
Copy code
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    age INT NOT NULL,
    uid INT,
    FOREIGN KEY (uid) REFERENCES users(id)
);
4. Run the Application
Start the CodeIgniter development server:

bash
Copy code
php spark serve
The application will be available at http://localhost:8080.

Usage
User Authentication
Signup: Navigate to /signup to create a new account.
Login: Navigate to /login to log into the application.
Logout: Click the logout button to end the session.
Student Management
View Students: Navigate to /students to view all student records.
Add Student: Click the "Add Student" button to open the student form and add a new student.
Edit Student: Click the edit icon next to a student record to edit the student's details.
Delete Student: Click the delete icon next to a student record to remove the student from the database.
Pagination
The student records are displayed with pagination, showing 10 records per page. Use the "Previous" and "Next" buttons to navigate through pages.

Folder Structure
app/Controllers: Contains the controller files for handling user and student operations.
app/Models: Contains the model files for interacting with the database.
app/Views: Contains the view files for rendering the UI.
public: Contains public assets and the entry point for the application.
