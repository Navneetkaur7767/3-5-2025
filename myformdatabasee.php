<?php
$servername = "localhost";
$username = "localhost"; // use your DB username
$password = "NAVneet345@";      // use your DB password
$dbname = "myForm";

$errors = [];

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// ✅ Create database if it doesn't exist
$db_sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($db_sql)) {
    die("Database creation failed: " . $conn->error);
}

// ✅ Select the database
$conn->select_db($dbname);
// Create table if not exists
$createTableQuery = "CREATE TABLE IF NOT EXISTS formDATA (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$conn->query($createTableQuery);

// Handle POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'register-form') {
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $cfpassword = trim($_POST['cfpassword'] ?? '');

    // Name validation
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $errors['name'] = "Only letters and white space allowed.";
    }

    // Email validation
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

  
    // Validate password
    if (empty($password)) {
        $errors["password"] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors["password"] = "Password must be at least 8 characters.";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $errors["password"] = "Password must include at least one number.";
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $errors["password"] = "Password must include at least one uppercase letter.";
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $errors["password"] = "Password must include at least one lowercase letter.";
    }

    // Confirm password
    if (empty($cfpassword)) {
        $errors["cfpassword"] = "Confirm password is required.";
    } elseif ($password !== $cfpassword) {
        $errors["cfpassword"] = "Passwords do not match.";
    }


    // If no errors, check if email exists and insert
    if (empty($errors)) {
        // Check if email already exists
        $checkEmailSql = "SELECT * FROM formDATA WHERE email = '$email' LIMIT 1";
        $result = $conn->query($checkEmailSql);

        if ($result && $result->num_rows > 0) {
            $errors['email'] = "Email already exists, try another.";
        } else {
            // Insert record
            $insertSql = "INSERT INTO formDATA (Name, email, password) VALUES ('$name', '$email', '$cfpassword')";
            if ($conn->query($insertSql) === TRUE) {
                echo "<p style='color:green;'>Registration successful!</p>";
                $_POST = []; // clear form
            } else {
                echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
            }
        }
    }
}
?>