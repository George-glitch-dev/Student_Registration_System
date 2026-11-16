Student Registration System

1. Introduction

The Student Registration System is a web-based application designed to make student registration and record management easier. It allows users to register new students, view student records, update information and delete records.

The system uses PHP and MySQL for backend processing and data storage, while HTML, CSS and JavaScript provide the user interface.

2. Objectives

- To simplify student registration.
- To store student information in a database.
- To allow users to view registered students.
- To update existing student records.
- To delete unwanted student records.
- To validate student information.

3. Technologies Used

- HTML: Creates the structure of the website.
- CSS: Styles the website.
- JavaScript: Provides interactive features and client-side validation.
- PHP: Handles backend processing.
- MySQL: Stores student information.
- PDO: Connects PHP to the MySQL database.
- XAMPP: Provides the local development environment.

4. Main Features

1. Student Registration: Allows users to enter student names, courses and ages.
2. View Students: Displays all registered students.
3. Edit Students: Allows users to update student information.
4. Delete Students: Allows users to remove student records.
5. Input Validation: Checks that the information entered is valid.
6. Responsive Design: Makes the website adaptable to different screen sizes.

5. Database Structure

Database: "school_db"

Table: "students"

Field| Data type
student_id| INT (Primary Key, Auto Increment)
name| VARCHAR(255)
course| VARCHAR(255)
age| INT

6. How the System Works

1. The user opens the registration page.
2. Enters the student's details.
3. PHP validates the information.
4. Student details are saved in MySQL.
5. Registered students can be viewed in a table.
6. Users can edit or delete student records.

7. Security and Validation

The system uses:

- Prepared statements to help prevent SQL injection.
- PHP validation to check user input.
- "htmlspecialchars()" to safely display student information.
- Input trimming to remove unnecessary spaces.
- Age validation to accept ages between 5 and 100.

8. Conclusion

The Student Registration System provides an easy and efficient way to manage student records. It demonstrates the integration of HTML, CSS, JavaScript, PHP and MySQL in developing a database-driven web application.