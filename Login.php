<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job portal";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    
    // Basic validation
    if (!empty($name) && !empty($password)) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM job WHERE name = ? LIMIT 1");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Compare the entered password with the stored password
            if ($password === $row['password']) {
                // Set session variables and redirect to homepage
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $name;
                echo "<script>alert('Login successful!'); window.location.href='a1.html';</script>";
                exit();
            } else {
                echo "<script>alert('Invalid password!'); window.location.href='Login.html';</script>";
            }
        } else {
            echo "<script>alert('Invalid name!'); window.location.href='Login.html';</script>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<script>alert('All fields are required!'); window.location.href='Login.html';</script>";
    }
}

// Close the connection
$con->close();
?>
