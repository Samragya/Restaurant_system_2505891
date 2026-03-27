<!-- #  Restaurant Menu & Ordering System (PHP + MySQL)

A complete restaurant ordering web application built using PHP, MySQL, JavaScript (AJAX), HTML, and CSS.  
This project is designed for  demonstrating backend logic, session management, database normalization, AJAX-based UX, and secure coding practices.

---

##  Author Details

- **Name:** Samragya Raj Khadka  
- **Project Title:** Restaurant Menu & Ordering System  
- **Academic Year:** 2026  
- **Purpose:** Academic submission & viva examination  
- **Server:** Laragon (Localhost)

---

##  Project Objective

The goal of this project is to:
- Allow customers to view food items
- Add items to a cart dynamically
- Place orders without reloading the page
- Store orders securely in a database
- Allow admins to manage menu items securely

---

## My system flow

1. User opens the website (`index.php`)
2. Menu items are fetched from database
3. User searches items (AJAX)
4. User adds items to cart (AJAX → session)
5. Cart data stored in PHP session
6. User submits order
7. Order + order items stored in database
8. Cart cleared
9. Admin manages menu through login system

---

##  Where Website Flow Starts & Ends

### 🔹 Start:
- Entry point for users
- Displays menu
- Loads JavaScript
- Handles AJAX calls

### 🔹 End:
- Saves order into database
- Clears session cart
- Redirects user back to index

---

## Project Folder Structure

- Saves order into database
- Clears session cart
- Redirects user back to index

---

##  Project Folder Structure

restaurant_system/
│
├── admin/
│ ├── login.php
│ ├── dashboard.php
│ ├── add_menu.php
│ ├── delete_menu.php
│ └── logout.php
│
├── config/
│ └── db.php
│
├── public/
│ ├── index.php
│ ├── cart.php
│ ├── place_order.php
│ ├── search.php
│ └── ajax_search.php
│
├── assets/
│ └── css/style.css
│
├── includes/
│ └── functions.php
│
├── database.sql
└── README.md
 -->





<!-- ##  Admin Login Credentials


 Password is hashed using `password_hash()`  
 Verified using `password_verify()` -->

<!-- ---

##  Installation & Setup (Laragon)

### 1 Move Project
 -->


<!-- ### Create Database -->
<!-- ```sql -->
<!-- -- CREATE DATABASE restaurant_system;

-- $host = "localhost";
-- $dbname = "restaurant_system";
-- $user = "root";
-- $pass = "";
 -->





<!-- 															-- Features Implemented

-- Menu display from database

-- Live search (AJAX)

-- Session-based cart

-- Secure order placement

-- Admin CRUD operations

-- Prepared statements

-- Password hashing



														-- Known Limitations

-- No payment gateway

-- No customer login

-- Admin order status UI not added

-- Designed for academic use -->