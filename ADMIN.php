<?php
// Start the session
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminName = $_POST['name'];
    $adminPassword = $_POST['password'];

    // Basic validation
    if (empty($adminName) || empty($adminPassword)) {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
    } else {
        // Escape special characters in inputs to prevent SQL injection
        $adminName = $conn->real_escape_string($adminName);
        $adminPassword = $conn->real_escape_string($adminPassword);

        // Query the database for admin credentials
        $query = "SELECT * FROM jobadmin WHERE name='$adminName' AND password='$adminPassword'";
        $result = $conn->query($query);

        // Check if the admin exists
        if ($result->num_rows == 1) {
            // Set session variables
            $_SESSION['name'] = $adminName;

            // Redirect to admin dashboard with alert message
            echo "<script>alert('Welcome Admin...HAR HAR MAHADEV'); window.location.href='Admin.html';</script>";
            exit();
        } else {
            // Invalid login attempt
            echo "<script>alert('Invalid credentials. Please try again.'); window.history.back();</script>";
        }
    }
}

// Close connection
$conn->close();
?>
