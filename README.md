# ProjAppWeb-main – Web Application with CMS and Online Store

## Overview

AppWeb is a PHP-based web application that combines a content management system (CMS) with an integrated online store. It allows administrators to manage website content dynamically and gives users a fully functional e-commerce experience.

## Key Features

### Content Management System

- Dynamic subpages are stored and managed through a database
- Admin panel for creating, editing, and removing site pages
- Pages can be updated without changing the source code

### Online Store

- Hierarchical category system with support for subcategories
- Product management including creation and assignment to categories
- Full shopping cart functionality with quantity updates and removal
- Order summary with automatic calculation of totals (net and gross)

### User Interaction

- Customer registration and login system
- Separate login for administrators
- Password recovery functionality for users
- Contact form for reaching the site administrator
- Email notification system using SMTP

## Technical Stack

- PHP for server-side logic
- MySQL database for storing all site data including pages, users, categories, and products
- HTML/CSS for layout and styling
- PHPMailer for sending emails
- Composer for managing dependencies

## Example Functionalities

- Displaying categories and products dynamically from the database
- Managing and navigating the cart before checkout
- Admin interface to manage pages and store content
- Users can contact site admin or recover passwords via email

## How to Run the Project (with XAMPP)

### 1. Install XAMPP

- Download from: [https://www.apachefriends.org/](https://www.apachefriends.org/)
- Install and start Apache and MySQL using the control panel

### 2. Set Up the Database

- Go to `http://localhost/phpmyadmin`
- Create a new database (e.g., `moja_strona`)
- Import the provided SQL file into the newly created database

### 3. Configure the Project

- Place the project folder inside the `htdocs` directory (e.g., `C:/xampp/htdocs/ProjAppWeb`)
- Update the database connection configuration with your local settings (host, user, password, and database name)

### 4. Install Dependencies

- Open a terminal in the project directory
- Run `composer install` to download required libraries

### 5. Launch the Application

- Ensure Apache and MySQL are running
- Open a browser and visit `http://localhost/ProjAppWeb`

---

The application is now ready to use with full CMS and e-commerce functionality.
