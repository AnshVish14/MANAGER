<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job portal";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $age = trim($_POST['age']);
    $password = trim($_POST['password']);
    
    // Basic validation
    if (!empty($name) && !empty($email) && !empty($password) && !empty($age)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {  // Validate email format
            // Prepare the SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO job (name, email, age, password) VALUES (?, ?, ?, ?)");
            
            // Bind the parameters
            // 's' for string, 'i' for integer
            $stmt->bind_param("ssis", $name, $email, $age, $password);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Account created successfully! Redirecting to login page.'); window.location.href='Login.html';</script>";
            } else {
                echo "<script>alert('Error: Could not create account.'); window.location.href='Register.html';</script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Invalid email format.'); window.location.href='Register.html';</script>";
        }
    } else {
        echo "<script>alert('All fields are required!'); window.location.href='Register.html';</script>";
    }
}

// Close the connection
$conn->close();
?>
